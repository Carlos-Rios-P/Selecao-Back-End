<?php

namespace App\Interfaces;

use App\Models\Instances\User;

interface CommentRepositoryInterface extends BaseInterface
{
    public function deleteAll(): void;
}
