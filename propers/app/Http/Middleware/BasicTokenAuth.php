<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class BasicTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (! $authHeader || ! str_starts_with($authHeader, 'Basic ')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $base64Credentials = substr($authHeader, 6);
        $decoded = base64_decode($base64Credentials);
        if (! $decoded || ! str_contains($decoded, ':')) {
            return response()->json(['error' => 'Invalid credentials format'], 403);
        }
        [$email, $password] = explode(':', $decoded, 2);

        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 403);
        }   

        return $next($request);
    }
}
