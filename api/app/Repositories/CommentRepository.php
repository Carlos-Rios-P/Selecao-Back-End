<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $userLogged = Auth::user()->id;

        $comment = Comment::where([
            'id' => $id,
            'user_id' => $userLogged
        ])->first();

        if(!$comment){
            throw new Exception('Unauthorized', 401);
        }

        $comment->update($data);

        return $comment->toArray();
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

    public function delete(int $id): void
    {
        $userLogged = Auth::user();

        $comment = Comment::where('id', $id);

        if($userLogged->role->name == Role::ADMIN){
            $comment = $comment->first();
        } else {
            $comment = $comment->where('user_id', $userLogged->id)->first();
        }

        if(!$comment){
            throw new Exception('Comment Not Found', 401);
        }

        $comment->delete();
    }

    public function deleteAll(): void
    {
        $userLogged = Auth::user();

        if($userLogged->role->name != Role::ADMIN){
            throw new Exception('Unauthorized', 401);
        }

        Comment::query()->delete();
    }
}
