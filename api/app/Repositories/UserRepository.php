<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserRepositoryInterface
{
    public function login(array $credentials): ?string
    {
        if(Auth::attempt($credentials)) {
            $token = JWTAuth::fromUser(Auth::user(), [
                'exp' => now()->addDay()->timestamp
            ]);

            return $token;
        }

        return null;
    }

    public function logout(string $token): void
    {
        JWTAuth::invalidate($token);
    }

    public function create(array $data): array
    {
        if (JWTAuth::getToken()) {
            $userLogged = JWTAuth::parseToken()->authenticate();
        }

        if(!isset($userLogged) || ($data['role_id'] == Role::ID_ADMIN && $userLogged->role->name != Role::ADMIN)){
            throw new Exception('Unauthorized', 401);
        }

        $user = User::create($data)->toArray();

        return $user;
    }

    public function update(array $data, int $id): array
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user->toArray();
    }

    public function delete(int $id): void
    {
    }

    public function list(int $per_page = 15, string $order = 'ASC', string $search = ''): array
    {
        return [];
    }

    public function show(int $id): ?object
    {
        $user = User::find($id);

        return $user;
    }
}
