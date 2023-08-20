<?php

declare(strict_types=1);

namespace App\Guards;

use App\Exceptions\InvalidToken;
use App\Exceptions\TokenNotProvided;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class FirebaseJWTGuard implements Guard
{
    use GuardHelpers;

    protected Request $request;
    protected $provider;
    protected mixed $jwt_algo;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->jwt_algo = config('app.jwt_algo');
    }

    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        try {
            return $this->provider->retrieveByCredentials(
                (array) $this->decodeToken($this->getTokenForRequest())
            );
        } catch (\Exception $e) {
            throw new InvalidToken($e->getMessage());
        }
    }

    public function validate(array $credentials = []): bool|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        $token = $credentials['token'] ?? null;

        try {
            $tokenData = $this->decodeToken($this->getTokenForRequest());
            return $this->provider->retrieveByCredentials(['uuid' => $tokenData->user_uuid]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function logout(): void
    {
        $this->user()->jwtTokens()->delete();
    }

    protected function decodeToken(string $token): object
    {
        $publicKey = config('app.jwt_public_key');
        return JWT::decode($token, new Key($publicKey, $this->jwt_algo));
    }

    /**
     * @throws TokenNotProvided
     */
    protected function getTokenForRequest(): string
    {
        $token = $this->request->bearerToken();

        if ($token === null) {
            throw new TokenNotProvided();
        }

        return $token;
    }
}
