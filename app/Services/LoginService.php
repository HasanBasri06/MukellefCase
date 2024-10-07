<?php

namespace App\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Repository\Concrates\ILoginRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class LoginService {
    public function __construct(
        private ILoginRepository $loginRepository
    ) {
        $this->loginRepository = $loginRepository;
    }

    public function isAlreadyExistUser(RegisterDTO|LoginDTO $user) {
        return $this->loginRepository->getActiveUserByEmail($user->find('email'));
    }

    public function createUser(RegisterDTO $user) {
        $hashingPassword = bcrypt($user->find('password'));

        return $this
            ->loginRepository
            ->createUser($user->find('email'), $user->find('name'), $hashingPassword);
    }

    public function confirmUserPassword(LoginDTO $userDTO, Collection|Model|array $user) {
        return Hash::check($userDTO->find('password'), $user->password);
    }
}
