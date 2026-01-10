<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has any of the required roles
        if (!in_array($user->role, $roles)) {
            // Also check is_admin for backwards compatibility
            if (in_array('admin', $roles) && $user->is_admin) {
                return $next($request);
            }
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. You do not have permission to access this resource.'], 403);
            }
            
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
