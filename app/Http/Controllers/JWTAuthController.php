<?php

namespace App\Http\Controllers;

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
    // User registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $accessToken = JWTAuth::claims(['exp' => now()->addMinutes(15)->timestamp])->fromUser($user);
        $refreshToken = JWTAuth::claims(['exp' => now()->addDays(7)->timestamp])->fromUser($user);

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = Auth::user();

            // // (optional) Attach the role to the token.
            // $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            $accessToken = JWTAuth::claims(['exp' => now()->addMinutes(15)->timestamp])->fromUser($user);
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

    // Get authenticated user
    public function getUser()
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            Log::debug('Authenticated User: ', ['user' => $user]);
        } catch (JWTException $e) {
            Log::error('JWT Error: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid token'], 400);
        }
        return response()->json(compact('user'));
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        try {
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();
            return response()->json(['access_token' => $newAccessToken]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}
