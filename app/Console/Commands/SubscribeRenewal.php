<?php

namespace App\Console\Commands;

use App\DTOs\SavedCardDTO;
use App\Enums\IsActiveEnum;
use App\Jobs\PaymentJob;
use App\Models\User;
use App\Services\SubscribeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SubscribeRenewal extends Command
{
    private int $subscribePrice = 100;
    public function __construct(
        private SubscribeService $subscribeService
    )
    {
        parent::__construct();
        $this->subscribeService = $subscribeService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribe:renewal {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Abone yenileme işlemi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = $this->subscribeService->isAlreadyExistUser($this->argument('user'));
        $card = $this->subscribeService->getCardByUserId($this->argument('user'));

        if (is_null($user)) {
            return $this->error("Kullanıcı bulunamadı");
        }

        if ($user->is_subscribe !== IsActiveEnum::ACTIVE->value) {
            return $this->error("Kullanıcı abone değil");
        }

        if (is_null($card)) {
            return $this->error("Kart bilgisi bulunmamaktadır");
        }

        $this->subscribeService->addMoneyToWallet($card->id);
        $getWallet = $this->subscribeService->getWallet($card->id);

        if ($getWallet->price > $this->subscribePrice) {
            dispatch(new PaymentJob($card, $user))
                ->onQueue('payment');

            return $this->info('Abonelik tarihi güncellendi');
        }
    }
}
