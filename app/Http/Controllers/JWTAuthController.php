<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => 1,
        ]);
        $accessToken = JWTAuth::claims(['role' => $user->role, 'exp' => now()->addMinutes(30)->timestamp])->fromUser($user);
        $refreshToken = JWTAuth::claims(['exp' => now()->addDays(7)->timestamp])->fromUser($user);

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = Auth::user();

            $accessToken = JWTAuth::claims(['role' => $user->role->title, 'exp' => now()->addMinutes(30)->timestamp])->fromUser($user);
            $refreshToken = JWTAuth::claims(['exp' => now()->addDays(7)->timestamp])->fromUser($user);

            return response()->json([
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'user' => $user,
            ]);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function getUser()
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            Log::debug('Authenticated User: ', ['user' => $user]);
        } catch (JWTException $e) {
            Log::error('JWT Error: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid token'], 400);
        }
        return new UserResource($user);
    }

    public function refresh(RefreshTokenRequest $request)
    {
        $refreshToken = $request->input('refresh_token');
        try {
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();
            return response()->json(['access_token' => $newAccessToken]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
