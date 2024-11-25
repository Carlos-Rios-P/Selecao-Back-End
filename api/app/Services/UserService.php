<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);

        return $user;
    }

    public function updateMe(array $data): array
    {
        $user = Auth::user();
        $data['password'] = Hash::make($data['password']);
        $userUpdated = $this->userRepository->update($data, $user->id);

        return $userUpdated;
    }

    public function update(array $data, int $id): array
    {
        $user = $this->userRepository->show($id);

        if (empty($user)) {
            throw new Exception('User not Found', 400);
        }

        $data['password'] = Hash::make($data['password']);
        $userUpdated = $this->userRepository->update($data, $id);

        return $userUpdated;
    }

    public function getMe(): array
    {
        $user = Auth::user()->toArray();

        return $user;
    }
}
