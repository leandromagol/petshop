<?php

namespace Tests\Http\Controllers\Api\V1;

use App\Models\User;
use App\UseCases\Auth\GenerateTokenUseCase;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login.
     */
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
        ]);
    }

    /**
     * Test user logout.
     * @throws AuthenticationException
     */
    public function testUserLogout()
    {
        $user = User::factory()->create();
        $tokenUseCase = new GenerateTokenUseCase();

        $token = $tokenUseCase($user->email, 'password');

        $response = $this->json('GET', '/api/v1/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully logged out',
        ]);

        $this->assertCount(0, $user->jwtTokens);
    }
}
