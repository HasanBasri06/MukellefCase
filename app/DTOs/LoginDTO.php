<?php

namespace App\DTOs;

final class LoginDTO extends Base {
    public function __construct(
        protected string $email,
        protected string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }
}
