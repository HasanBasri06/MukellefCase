<?php

namespace App\Providers;

use App\Repository\Abstracts\LoginRepository;
use App\Repository\Abstracts\PaymentRepository;
use App\Repository\Abstracts\SubscribeRepository;
use App\Repository\Abstracts\UserRepository;
use App\Repository\Concrates\ILoginRepository;
use App\Repository\Concrates\IPaymentRepository;
use App\Repository\Concrates\ISubscribeRepository;
use App\Repository\Concrates\IUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ILoginRepository::class, LoginRepository::class);
        $this->app->bind(ISubscribeRepository::class, SubscribeRepository::class);
        $this->app->bind(IPaymentRepository::class, PaymentRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
