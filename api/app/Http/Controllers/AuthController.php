<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $token = $this->authService->login($credentials);

        if (!$token) {
            return $this->error('Invalid credentials', 401);
        }

        return $this->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'token_type' => 'bearer',
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();

        $this->authService->logout($token);

        return $this->success('Successfully logged out');
    }
}
