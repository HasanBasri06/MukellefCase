<?php

namespace App\Repository\Concrates;

interface ILoginRepository {
    public function getActiveUserByEmail(string $email);
    public function createUser(string $email, string $name, string $password);
}