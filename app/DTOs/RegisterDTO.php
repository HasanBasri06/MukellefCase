<?php 

namespace App\DTOs;

final class RegisterDTO extends Base {
    public function __construct(
        protected string $email,
        protected string $name,
        protected string $password,
        protected string $passwordConfirm,
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;
    }
}