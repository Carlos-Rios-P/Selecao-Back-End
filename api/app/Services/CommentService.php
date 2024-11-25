<?php

namespace App\Services;

use App\Interfaces\CommentRepositoryInterface;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function create(array $data): array
    {
        $comment = $this->commentRepository->create($data);

        return $comment;
    }

    public function index(): array
    {
        $comments = $this->commentRepository->list();

        return $comments;
    }
}