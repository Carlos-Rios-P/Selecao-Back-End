<?php

namespace App\Interfaces;

use App\Models\Instances\User;

interface UserRepositoryInterface extends BaseInterface
{
    public function login(array $credentials): ?string;
    public function logout(string $token): void;
}
