<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\LoginService;
use App\Traits\HttpResponseTrait;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        private LoginService $loginService
    ) {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request) {
        $userDTO = new LoginDTO(
            $request->email,
            $request->password
        );
        $user = $this->loginService->isAlreadyExistUser($userDTO);

        if (is_null($user)) {
            return $this->error(null, 'Bu maile ait bir kullanıcı bulunamadı', 404);
        }

        $hasUserPassword = $this->loginService->confirmUserPassword($userDTO, $user);

        if (!$hasUserPassword) {
            return $this->error(null, 'Girilen bilgiler hatalıdır', 401);
        }

        $token = $user->createToken('token', ['*'], now()->addHour(3))->plainTextToken;
        $data = ['user' => $user, 'token' => $token];

        return $this->success($data, 'Kullanıcı bilgileri doğru. Giriş yapıldı', 200);
    }

    public function register(RegisterRequest $request) {
        $userDTO = new RegisterDTO(
            $request->email,
            $request->name,
            $request->password,
            $request->passwordConfirm
        );

        $isAlreadyExistUser = $this->loginService->isAlreadyExistUser($userDTO);
        if (!is_null($isAlreadyExistUser)) {
            return $this->error(null, 'Bu maile ait bir kullanıcı bulundu', 422);
        }

        $user = $this->loginService->createUser($userDTO);

        return $this->success($user, 'Kullanıcı başarılı bir şekilde kayıt oldu', 201);
    }
}
