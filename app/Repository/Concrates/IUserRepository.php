<?php

namespace App\Repository\Concrates;

interface IUserRepository
{
    public function getUserById(int $userId);
}
