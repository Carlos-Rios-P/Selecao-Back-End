<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CommentManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_create_comment()
    {
        $user = $this->createUser();
        $token = auth('api')->login($user);

        $data = [
            'content' => 'Este é um comentário de teste.',
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->postJson('/api/comments', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'content' => 'Este é um comentário de teste.',
            'user_id' => $user->id,
        ]);
    }

    public function test_update_comment()
    {
        $user = $this->createUser();
        $token = auth('api')->login($user);
        $comment = $this->createComment($user->id);

        $data = ['content' => 'Comentário atualizado'];

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->putJson("/api/comments/update/{$comment->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'content' => 'Comentário atualizado',
            'user_id' => $user->id,
        ]);
    }

    public function test_delete_comment()
    {
        $user = $this->createUser();
        $token = auth('api')->login($user);
        $comment = $this->createComment($user->id);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
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

    public function createComment(int $id): Comment
    {
        $comment = Comment::create([
            'user_id' => $id,
            'content' => 'novo comentário'
        ]);

        return $comment;
    }
}
