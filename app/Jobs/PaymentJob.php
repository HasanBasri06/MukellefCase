<?php

namespace App\Jobs;

use App\Enums\IsActiveEnum;
use App\Mail\SendEmailForPaymentConfirm;
use App\Models\Card;
use App\Models\Order;
use App\Models\SubscribeUser;
use App\Models\User;
use App\Models\Wallet;
use App\Services\Strategy\PaymentStrategyContext;
use App\Traits\HttpResponseTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentJob implements ShouldQueue
{
    use Queueable, SerializesModels, HttpResponseTrait;

    private User $user;
    private Card $card;
    private int $subscribePrice = 100;

    public function __construct(
        Card $card,
        User $user,
    )
    {
        $this->user = $user;
        $this->card = $card;
    }

    public function handle(): void
    {
        $getWallet = $this->getWallet();
        $orderCode = random_int(0000, 9999);
        $paymentStrategy = new PaymentStrategyContext('iyzico');

        if ($getWallet->price > $this->subscribePrice) {
            $createOrder = $this->createOrder($paymentStrategy->pay(), $orderCode);
            $this->createSubscribed($this->user->id, $createOrder->order_code);
            $decreaseBalance = $getWallet->price - $this->subscribePrice;
            Wallet::where('card_id', $this->card->id)->update(['price' => $decreaseBalance]);

            if ($this->user->subscription_renewal == IsActiveEnum::ACTIVE->value) {
                PaymentJob::dispatch($this->card, $this->user)
                    ->onQueue('payment')
                    ->delay(now()->addMonth());
            }

            Mail::to($this->user->email)->send(new SendEmailForPaymentConfirm($this->user));
        }
    }

    public function createOrder($transaction, $orderCode) {
        $order = Order::query()
            ->where('user_id', $this->user->id)
            ->where('card_id', $this->card->id)
            ->get();

        foreach ($order as $o) {
            if ($o && $o->status == IsActiveEnum::ACTIVE->value) {
                Order::where('user_id', $this->user->id)
                    ->where('card_id', $this->card->id)
                    ->update([
                        'status' => IsActiveEnum::INACTIVE->value
                    ]);
            }
        }

        return Order::create([
            'user_id' => $this->user->id,
            'card_id' => $this->card->id,
            'transaction' => $transaction,
            'order_code' => $orderCode,
            'status' => IsActiveEnum::ACTIVE->value
        ]);
    }

    public function createSubscribed(int $userId, string $orderCode)
    {
        $subscribed = SubscribeUser::query()
            ->where('user_id', $this->user->id)
            ->get();

        foreach ($subscribed as $s) {
            if ($s && $s->status == IsActiveEnum::ACTIVE->value) {
                SubscribeUser::where('user_id', $this->user->id)
                    ->update([
                        'status' => IsActiveEnum::INACTIVE->value
                    ]);
            }
        }

        return SubscribeUser::create([
            'user_id' => $userId,
            'order_code' => $orderCode,
            'start_time' => Carbon::now(),
            'next_payment_date' => Carbon::now()->addMonth(),
            'status' => IsActiveEnum::ACTIVE->value
        ]);
    }

    public function getWallet() {
        return Wallet::where('card_id', $this->card->id)->first();
    }
}
