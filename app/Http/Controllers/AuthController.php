<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $payload = $request->validated();

        if ($payload['password'] !== $payload['confirmPassword']) {
            return response()->json([
                "message" => "Invalid Password!"
            ], 400);
        }

        $checkEmail = User::firstWhere("email", $payload['email']);

        if ($checkEmail) {
            return response()->json([
                "messsage" => "Email already registered!"
            ], 400);
        }

        $user = User::create([
            "name" => $payload['name'],
            "email" => $payload['email'],
            "password" => $payload['password']
        ]);

        return new RegisterResource($user);
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->validated();

        $user = User::firstWhere("email", $payload['email']);

        if (!$user || !Hash::check($payload['password'], $user->password)) {
            return response()->json([
                "message" => "Invalid Credentials!"
            ], 401);
        }

        $token = $user->createToken("daily_notes")->plainTextToken;

        return response()->json([
            "token" => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
