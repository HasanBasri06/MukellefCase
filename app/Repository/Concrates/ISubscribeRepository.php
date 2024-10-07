<?php

namespace App\Repository\Concrates;

use App\DTOs\SavedCardDTO;

interface ISubscribeRepository {
    public function getUserById(int $userId);
    public function getCardByNumber(string $number);
    public function addCard(SavedCardDTO $savedCardDTO);
    public function addMoneyToWallet(int $cardId, int $price);
    public function getCardById(int $cardId);
    public function getWalletById(int $cardId);
    public function changeSubscribeRenewal(string $type, int $userId);
    public function changeSubscribe(int $userId);
    public function getCardByUserId(int $userId);
}
