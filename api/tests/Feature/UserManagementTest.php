<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste de cadastro de usuário.
     */
    public function test_user_can_be_created()
    {
        $role = $this->createRole();

        $response = $this->postJson('/api/user/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'role_id' => $role->id,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [
                        'status',
                        'message',
                        'user',
                    ]
                 ]);
    }

    public function test_user_can_be_updated()
    {
        $user = $this->createUser();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->putJson("/api/user/update/me", [
                            'name' => 'Updated User',
                            'email' => $user->email,
                            'password' => 'passwordupdated'
                        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'status',
                        'message',
                        'user',
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated User',
        ]);
    }

    public function createRole(): Role
    {
        $role = Role::create([
            'id' => Role::ID_ADMIN,
            'name' => 'Admin',
        ]);

        return $role;
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
