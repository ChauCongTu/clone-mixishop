<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if ($token) {
            $personalToken = PersonalAccessToken::findToken($token);
            $role = $personalToken->name;
            if ($role && $role === 'Admin') {
                return $next($request);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
