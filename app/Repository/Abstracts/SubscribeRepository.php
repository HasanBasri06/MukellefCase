<?php

namespace App\Repository\Abstracts;
use App\DTOs\SavedCardDTO;
use App\Enums\IsActiveEnum;
use App\Models\Card;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Repository\Concrates\ISubscribeRepository;

class SubscribeRepository implements ISubscribeRepository {
    public function __construct(
        private User $user,
        private Card $card,
        private Wallet $wallet
    )
    {
        $this->user = $user;
        $this->card = $card;
        $this->wallet = $wallet;
    }
    public function getUserById(int $userId) {
        return $this
            ->user
            ->where('status', IsActiveEnum::ACTIVE->value)
            ->find($userId);
    }

    public function getCardByNumber(string $number)
    {
        return $this
            ->card
            ->where('status', IsActiveEnum::ACTIVE->value)
            ->where('card_number', $number)
            ->first();
    }

    public function addCard(SavedCardDTO $savedCardDTO)
    {
        return $this->card
            ->create($savedCardDTO->toArray(IsActiveEnum::ACTIVE->value));
    }

    public function addMoneyToWallet(int $cardId, int $price)
    {
        $this->wallet
            ->create([
                'card_id' => $cardId,
                'price' => $price
            ]);
    }

    public function getCardById(int $cardId)
    {
        return $this->card->where('status', IsActiveEnum::ACTIVE->value)->find($cardId);
    }

    public function getWalletById(int $cardId)
    {
        return $this->wallet
            ->where('card_id', $cardId)
            ->first();
    }

    public function changeSubscribeRenewal(string $type, int $userId)
    {
        return $this->user
            ->where('id', $userId)
            ->update([
                'subscription_renewal' => $type
            ]);
    }

    public function changeSubscribe(int $userId)
    {
        $user = $this->user
            ->where('id', $userId)
            ->first();

        if ($user->is_subscribe == IsActiveEnum::ACTIVE->value) {
            return $this->user
                ->where('id', $userId)
                ->update(['is_subscribe' => IsActiveEnum::INACTIVE->value]);
        }

        return $this->user
            ->where('id', $userId)
            ->update(['is_subscribe' => IsActiveEnum::ACTIVE->value]);
    }

    public function getCardByUserId(int $userId)
    {
        return $this->card
            ->where('user_id', $userId)
            ->first();
    }
}
