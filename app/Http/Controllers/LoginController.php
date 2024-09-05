<?php

namespace App\Http\Controllers;

use App\Repositories\impl\UserRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    protected $jwt;
    protected $userRepo;

    public function __construct(JWTAuth $jwt, UserRepositoryImpl $userRepo)
    {
        $this->jwt = $jwt;
        $this->userRepo = $userRepo;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('username', 'password');
        Log::debug('Attempting to authenticate with credentials: ', $credentials);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            Log::error('Authentication failed for credentials: ', $credentials);
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        $user = $this->userRepo->findByUsername($credentials['username']);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'jwt' => $token,
            'role' => $user->role
        ], 200);
    }
}
