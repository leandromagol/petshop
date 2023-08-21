<?php

namespace Tests\UseCases\Auth;

use App\UseCases\Auth\GenerateTokenUseCase;
use Illuminate\Auth\AuthenticationException;
use App\Models\JwtToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tests\TestCase;

class GenerateTokenUseCaseTest extends TestCase
{
    use RefreshDatabase;


    public function test_generate_token_successfully()
    {
        $user = User::factory()->create();

        Auth::shouldReceive('attempt')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $tokenUseCase = new GenerateTokenUseCase();

        $token = $tokenUseCase($user->email, 'password');

        $this->assertNotNull($token);
        $this->assertIsString($token);
    }

    public function test_generate_token_authentication_exception()
    {
        Auth::shouldReceive('attempt')->once()->andReturn(false);

        $tokenUseCase = new GenerateTokenUseCase();

        $this->expectException(AuthenticationException::class);
        $tokenUseCase('invalid@example.com', 'invalidpassword');
    }

    public function test_generated_token_is_stored_in_database()
    {
        $user = User::factory()->create();

        Auth::shouldReceive('attempt')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $tokenUseCase = new GenerateTokenUseCase();
        $token = $tokenUseCase($user->email, 'password');

        $this->assertDatabaseHas('jwt_tokens', [
            'user_id' => $user->uuid,
            'unique_id' => JwtToken::where('user_id', $user->uuid)->first()->unique_id,
            'token_title' => 'authorization',
        ]);
    }
}
