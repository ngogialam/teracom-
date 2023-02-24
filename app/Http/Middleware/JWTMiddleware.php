<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = JWTAuth::getToken();
        $payload = JWTAuth::getPayload($token)->toArray();
        $user = new User($payload);
        auth()->setUser($user);
        return $next($request);
    }
}
