<?php

namespace App\Services;

use App\DTOs\SavedCardDTO;
use App\Enums\IsActiveEnum;
use App\Repository\Concrates\ISubscribeRepository;

class SubscribeService {
    public function __construct(
        private ISubscribeRepository $subscribeRepository
    ) {
        $this->subscribeRepository = $subscribeRepository;
    }

    public function isAlreadyExistUser(int $userId) {
        return $this->subscribeRepository->getUserById($userId);
    }

    public function getUserCardByNumber(string $number)
    {
        return $this->subscribeRepository->getCardByNumber($number);
    }

    public function addMoneyToWallet(int $cardId) {
        $card = $this->subscribeRepository->getWalletById($cardId);

        if (is_null($card)) {
            $price = rand(200, 999);
            $this->subscribeRepository->addMoneyToWallet($cardId, $price);
        }
    }

    public function addCard(SavedCardDTO $savedCardDTO)
    {
        $card = $this->getUserCardByNumber($savedCardDTO->find('cardNumber'));
        if (is_null($card)) {
            $addCard = $this->subscribeRepository->addCard($savedCardDTO);
            $this->addMoneyToWallet($addCard->id);

            return $addCard;
        }

        return $card;
    }
    public function getWallet(int $cardId)
    {
        return $this->subscribeRepository->getWalletById($cardId);
    }

    public function changeRenewal(string $type, int $userId)
    {
        return $this->subscribeRepository->changeSubscribeRenewal(IsActiveEnum::typeGenerate($type), $userId);
    }

    public function changeSubscribe(int $userId)
    {
        $this->subscribeRepository->changeSubscribe($userId);

        return $this->subscribeRepository->getUserById($userId);
    }

    public function getCardByUserId(int $userId)
    {
        return $this->subscribeRepository->getCardByUserId($userId);
    }
}
