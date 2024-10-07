<?php

namespace App\DTOs;

class SubscribeOrderDTO extends Base
{
    public function __construct(
        protected int $userId,
        protected int $cardId,
        protected string $orderCode,
        protected string $transaction,
        protected string $expireDate,
    )
    {
        $this->userId = $userId;
        $this->cardId = $cardId;
        $this->orderCode = $orderCode;
        $this->transaction = $transaction;
        $this->expireDate = $expireDate;
    }
}
