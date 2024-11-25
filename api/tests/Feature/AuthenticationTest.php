<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/auth', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                        'status',
                        'message',
                        'token_type',
                        'token',
                        'user',
                     ]
                 ]);
    }

    public function test_user_can_logout_with_jwt()
    {
        $user = $this->createUser();

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->deleteJson('/api/logout');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Successfully logged out',
                ]);
    }

    public function createUser(): User
    {
        $role = Role::create([
            'id' => Role::ID_ADMIN,
            'name' => 'Admin',
        ]);

        $user = User::create([
            'name' => 'userTest',
            'email' => 'test@example.com',
            'role_id' => $role->id,
            'password' => Hash::make('password123'),
        ]);

        return $user;
    }
}
