<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Create user
        $user = User::create($data);

        // Return user data except password
        return response()->json($user, 201);
    }
}
