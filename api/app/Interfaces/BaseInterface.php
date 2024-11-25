<?php

namespace App\Interfaces;

use App\Models\Instances\User;

interface BaseInterface
{
    public function create(array $data): array;
    public function update(array $data, int $id): array;
    public function show(int $id): ?object;
    public function list(int $per_page = 15, string $order = 'ASC', string $search = ''): array;
    public function delete(): array;
}
