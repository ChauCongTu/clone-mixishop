<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Method to Login Api
    public function login (LoginRequest $request) {
        $credentials = $request->only("email", "password");
        $user = User::where("email", $credentials["email"])->first();
        if ($user) {
            if (Hash::check($credentials["password"], $user->password)) {
                $token = $user->createToken("")->plainTextToken;
                return response()->json(['login' => $user, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'incorrect password'], 200);
            }
        } else {
            return response()->json(['error' => 'account not found'], 200);
        }
    }
}
