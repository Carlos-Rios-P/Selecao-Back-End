<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Instances\Role;
use Exception;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials): ?string
    {
        $token = $this->userRepository->login($credentials);

        return $token;
    }

    public function logout(string $token): void
    {
        $this->userRepository->logout($token);
    }
}
