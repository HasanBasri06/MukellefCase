<?php

namespace App\Http\Middleware;

use App\Enums\IsActiveEnum;
use App\Models\User;
use App\Traits\HttpResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class IsSubscribe
{
    use HttpResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isSubscribe = User::where('id', $request->input('user_id'))->first();
        if (!is_null($isSubscribe) && $isSubscribe->is_subscribe !== IsActiveEnum::ACTIVE->value) {
            return $this->error(null, 'Kullanıcı abone değil', 400);
        }

        return $next($request);
    }

    public function getUser(int $userId) {
        return User::find($userId);
    }
}
