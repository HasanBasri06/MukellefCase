<?php

namespace App\Services\Strategy\Abstracts;

use App\Services\Strategy\Concrates\IPayment;
use Illuminate\Support\Str;

class StripeStrategy implements IPayment
{
    public function pay()
    {
        return Str::upper(Str::random(10));
    }
}
