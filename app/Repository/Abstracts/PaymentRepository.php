<?php

namespace App\Repository\Abstracts;

use App\Models\Card;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Repository\Concrates\IPaymentRepository;

class PaymentRepository implements IPaymentRepository
{
    public function __construct(
        private Order $order,
        private User $user,
        private Wallet $wallet,
        private Card $card
    )
    {
        $this->order = $order;
        $this->user = $user;
        $this->wallet = $wallet;
        $this->card = $card;
    }
}
