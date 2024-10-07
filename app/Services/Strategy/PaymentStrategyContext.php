<?php

namespace App\Services\Strategy;

use App\Services\Strategy\Abstracts\IyzicoStrategy;
use App\Services\Strategy\Abstracts\StripeStrategy;
use App\Services\Strategy\Concrates\IPayment;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentStrategyContext
{
    use HttpResponseTrait;
    private IPayment $strategy;
    public function __construct(
        string $paymentMethod,
    )
    {
        $this->strategy = match ($paymentMethod) {
            'iyzico' => new IyzicoStrategy(),
            'stripe' => new StripeStrategy(),
            default => throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Ödeme planı başarısız'], 500))
        };
    }

    public function pay() {
        return $this->strategy->pay();
    }
}
