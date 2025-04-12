<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PresonalAccessToken extends SanctumPersonalAccessToken
    {
        /**
         * Create a new personal access token for the user.
         *
         * @param  string  $name
         * @param  array  $abilities
         * @param  \DateTimeInterface|null  $expiresAt
         * @return \Laravel\Sanctum\NewAccessToken
         */
        public function createToken(string $name, array $abilities = ['*'], ?DateTimeInterface $expiresAt = null)
        {
            info('masuk sini');
            $plainTextToken = $this->generateTokenString();
    
            $token = $this->tokens()->create([
                'name' => $name,
                'token' => hash('sha256', $plainTextToken),
                'abilities' => $abilities,
                // 'expires_at' => $expiresAt,
            ]);
    
            return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
        }
}
