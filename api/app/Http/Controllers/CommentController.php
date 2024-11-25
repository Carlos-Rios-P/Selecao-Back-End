<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();
            $comment = $this->commentService->create($data);

            return $this->json([
                'status'  => 'success',
                'message' => 'Comment created successful',
                'content' => $comment
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function index()
    {
        $comments = $this->commentService->index();

        return $this->json([
            'status'  => 'success',
            'comments' => $comments
        ]);
    }
}
