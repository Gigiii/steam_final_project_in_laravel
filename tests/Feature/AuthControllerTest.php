<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_it_can_register_a_user()
    {
        $data = [
            'username' => 'asdf',
            'email' => 'testers@example.com',
            'password' => 'Test123!',
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
            ]);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function test_it_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('Test123!'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'Test123!',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
                'user',
            ]);
    }

    public function test_it_fails_to_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'wronguser@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Invalid credentials',
            ]);
    }

    public function test_it_can_get_authenticated_user()
    {
        $user = User::factory()->user()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->getJson('/api/auth/user');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                ],
            ]);
    }

    public function test_it_returns_error_for_invalid_token()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer invalidtoken"])
            ->getJson('/api/auth/user');

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Token not valid',
            ]);
    }

    public function test_it_can_refresh_a_token()
    {
        $user = User::factory()->create();
        $refreshToken = JWTAuth::claims(['exp' => now()->addDays(7)->timestamp])->fromUser($user);

        $response = $this->postJson('/api/auth/refresh', [
            'refresh_token' => $refreshToken,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    public function test_it_returns_error_for_invalid_refresh_token()
    {
        $response = $this->postJson('/api/auth/refresh', [
            'refresh_token' => 'invalidtoken',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Invalid refresh token',
            ]);
    }

    public function test_it_can_logout_a_user()
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}
