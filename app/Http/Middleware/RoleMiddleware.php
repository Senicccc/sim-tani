<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $role = $request->user()->role;

        if (empty($roles) || ! in_array($role, $roles, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Insufficient role permissions.',
            ], 403);
        }

        return $next($request);
    }
}
