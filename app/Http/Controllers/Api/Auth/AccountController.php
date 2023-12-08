<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Method to Login Api
    public function login(LoginRequest $request)
    {
        $credentials = $request->only("email", "password");
        $user = User::where("email", $credentials["email"])->first();
        if ($user) {
            if (Hash::check($credentials["password"], $user->password)) {
                $token = $user->createToken($user->role)->plainTextToken;
                Auth::login($user);
                return response()->json(['login' => $user, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'incorrect password'], 200);
            }
        } else {
            return response()->json(['error' => 'account not found'], 200);
        }
    }
    public function register(RegisterRequest $request)
    {
        $user = $request->only('name', 'email', 'password', 'gender', 'address', 'phone_number');
        $user['password'] = Hash::make($user['password']);
        $user['avatar'] = 'avatar/default.jpg';
        $userSaved = User::create($user);
        $token = $userSaved->createToken('Member')->plainTextToken;

        return response()->json(['login' => $user, 'token' => $token], 201);
    }
}
