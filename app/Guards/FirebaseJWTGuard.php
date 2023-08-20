<?php

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

    /**
     * @throws InvalidToken
     * @throws TokenNotProvided
     */
    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (! is_null($this->user)) {
            return $this->user;
        }
        try {
            $token = $this->decodeToken($this->getTokenForRequest());
            return $this->provider->retrieveByCredentials((array) $token);
        } catch (\Exception $e) {
            throw new InvalidToken($e->getMessage());
        }
    }

    /**
     * @throws InvalidToken
     * @throws TokenNotProvided
     */
    public function validate(array $credentials = []): bool|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        if (! isset($credentials['token'])) {
            return false;
        }
        try {
            $token = $this->decodeToken($this->getTokenForRequest());
            if ($this->provider->retrieveByCredentials(['uuid' => $token->user_uuid])) {
                return true;
            }
        }catch (\Exception $e) {
            return false;
        }

        return false;

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

    /**
     * @throws InvalidToken
     * @throws TokenNotProvided
     */
    public function logout()
    {
        $this->user()->jwtTokens()->delete();

    }
}
