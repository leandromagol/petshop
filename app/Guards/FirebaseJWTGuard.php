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
use stdClass;

/**
 *
 */
class FirebaseJWTGuard implements Guard
{
    use GuardHelpers;

    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var UserProvider
     */
    protected $provider;
    /**
     * @var mixed|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application
     */
    protected mixed $jwt_algo;

    /**
     * @param UserProvider $provider
     * @param Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->jwt_algo = config('app.jwt_algo');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     *
     * @throws InvalidToken
     */
    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        try {
            $token = $this->decodeToken($this->getTokenForRequest());
            return $this->provider->retrieveByCredentials(['uuid' => $token->user_uuid]);
        } catch (\Exception $e) {
            throw new InvalidToken($e->getMessage());
        }
    }

    /**
     * @param array<string> $credentials
     *
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function validate(array $credentials = ['token']): bool|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        if (empty($credentials['token'])) {
            return false;
        }
        try {
            $tokenData = $this->decodeToken($credentials['token']);
            return $this->provider->retrieveByCredentials(['uuid' => $tokenData->user_uuid]);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $token
     *
     * @return stdClass
     */
    protected function decodeToken(string $token): stdClass
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
