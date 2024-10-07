<?php

namespace App\Repository\Abstracts;

use App\Enums\IsActiveEnum;
use App\Models\User;
use App\Repository\Concrates\ILoginRepository;

class LoginRepository implements ILoginRepository {
    public function __construct(
        private User $user
    ) {
        $this->user = $user;
    }

    public function getActiveUserByEmail(string $email) {
        return $this
            ->user
            ->where('status', IsActiveEnum::ACTIVE->value)
            ->where('email', $email)
            ->first();
    }

    public function createUser(string $email, string $name, string $password) {
        return $this->user
            ->create([
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'status' => IsActiveEnum::ACTIVE->value
            ]);
    }
}