<?php

namespace App\DTOs;

use App\Enums\IsActiveEnum;

final class SavedCardDTO extends Base
{
    public function __construct(
        protected int $userId,
        protected string $name,
        protected string $cardNumber,
        protected string $expireDate,
        protected string $cvv
    )
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->cardNumber = $cardNumber;
        $this->expireDate = $expireDate;
        $this->cvv = $cvv;
    }

    public function toArray(string $status)
    {
        return [
            'card_number' => $this->cardNumber,
            'name' => $this->name,
            'cvv' => $this->cvv,
            'expire_date' => $this->expireDate,
            'status' => $status,
            'user_id' => $this->userId
        ];
    }
}
