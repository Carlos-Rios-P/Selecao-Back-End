<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated($request);
            $user = $this->userService->create($data);

            return $this->json([
                'status'  => 'success',
                'message' => 'User created successful',
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }

    }

    public function updateMe(UpdateRequest $request)
    {
        try {
            $data = $request->validated($request);
            $user = $this->userService->updateMe($data);

            return $this->json([
                'status'  => 'success',
                'message' => 'User updated successful',
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }

    }

    public function update(UpdateRequest $request, int $id)
    {
        try {
            if(Auth::user()->role->name == Role::ADMIN){
                $data = $request->validated($request);
                $user = $this->userService->update($data, $id);

                return $this->json([
                    'status'  => 'success',
                    'message' => 'User updated successful',
                    'user' => $user
                ]);
            } else {
                return $this->error('Unauthorized.', 401);
            }
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function me()
    {
        $user = $this->userService->getMe();

        return $this->json([
            'status'  => 'success',
            'user' => $user
        ]);
    }
}
