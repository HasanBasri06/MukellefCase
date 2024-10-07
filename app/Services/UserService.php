<?php

namespace App\Services;

use App\Repository\Concrates\IUserRepository;

class UserService
{
    public function __construct(
        private IUserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function getUserWithOrderAndSubscribe(int $userId) {
        return $this
            ->userRepository
            ->getUserById($userId)
            ->with([
                'order:order_code,transaction,status,created_at,id,user_id',
                'subscribe:id,user_id,order_code,start_time,next_payment_date,status'
            ])
            ->first();
    }
}
