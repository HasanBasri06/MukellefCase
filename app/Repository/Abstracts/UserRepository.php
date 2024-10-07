<?php

namespace App\Repository\Abstracts;

use App\Models\User;
use App\Repository\Concrates\IUserRepository;

class UserRepository implements IUserRepository
{
    public function __construct(private User $user)
    {
        $this->user = $user;
    }

    public function getUserById(int $userId)
    {
        return $this
            ->user
            ->where('id', $userId)
            ->firstOrFail();
    }
}
