<?php


namespace App\UseCases\Auth;

use App\Models\JwtToken;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 *
 */
class GenerateTokenUseCase
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(string $email, string $password): ?string
    {
        $credentials = ['email' => $email, 'password' => $password];
        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            if ($user instanceof User){
                $privateKey = config('app.jwt_private_key');
                $token = JWT::encode([
                    'sub' => $user->id,
                    'user_uuid' => $user->uuid,
                    'iat' => time(),
                    'exp' => time() + (60 * 60), // Token expiration time (1 hour)
                    'iss' => URL::to('/'),
                ], $privateKey, config('app.jwt_algo'));
                $this->storeJwt($user);
                return $token;
            }
        }
        throw new AuthenticationException();
    }


    /**
     * @param User $user
     * @return void
     */
    private function storeJwt(User $user): void
    {
        JwtToken::create([
            'user_id' => $user->uuid,
            'unique_id' => Str::uuid()->toString(),
            'token_title' => 'authorization',
            'last_used_at' => now(),
        ]);
    }
}
