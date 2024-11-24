<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'token_type' => 'bearer',
            'token' => JWTAuth::fromUser(Auth::user(), [
                'exp' => now()->addDay()->timestamp
            ]),
            'user' => Auth::user()
        ]);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();

        JWTAuth::invalidate($token);

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully logged out'
        ]);
    }
}
