<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Services\CommentService;

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
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(UpdateRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $comment = $this->commentService->update($data, $id);

            return $this->json([
                'status'  => 'success',
                'message' => 'Comment updated successful',
                'comments' => $comment
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
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

    public function delete(int $id)
    {
        try {
            $this->commentService->delete($id);

            return $this->success('Comment deleted successful');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function deleteAll()
    {
        try {
            $this->commentService->deleteAll();

            return $this->success('All comments deleted successful');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}
