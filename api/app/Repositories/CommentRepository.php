<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentRepositoryInterface
{

    public function create(array $data): array
    {
        $comment = Comment::create([
            'content'   => $data['content'],
            'user_id'   => Auth::user()->id
        ])->toArray();

        return $comment;
    }

    public function update(array $data, int $id): array
    {
        return [];
    }

    public function delete(): array
    {
        return [];
    }

    public function list(int $per_page = 15, string $order = 'ASC', string $search = ''): array
    {
        $comments = Comment::with(['user:id,name,created_at'])
                    ->orderBy('id', $order)
                    ->paginate($per_page);

        return $comments->toArray();
    }

    public function show(int $id): ?object
    {
        $user = User::find($id);

        return $user;
    }
}
