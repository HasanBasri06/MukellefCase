<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserWithOrderAndSubscribeRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUserWithOrderAndSubscribe(UserWithOrderAndSubscribeRequest $request) {
        return $this->userService->getUserWithOrderAndSubscribe($request->user_id);
    }
}
