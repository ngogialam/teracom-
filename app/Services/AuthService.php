<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use JWTFactory;
use JWTAuth;

class AuthService
{
    /**
     * @param LoginRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function generateAccessToken(LoginRequest $request): mixed
    {
        $data = $request->only('expired_in', 'payload');

        $factory = JWTFactory::customClaims($data['payload']);
        $payload = $factory->setTTL($data['expired_in'])->make();
        return JWTAuth::encode($payload); // @phpstan-ignore-line
    }
}
