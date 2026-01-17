<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin has full access
        if ($user->role === 'admin') {
            return $next($request);
        }

        // User role access rules
        if ($user->role === 'user') {
            // Modules allowed for Read-Only access
            $readOnlyModules = ['santri', 'kelas', 'jurusan', 'obat', 'sakit', 'laporan'];

            // Get module name from prefix admin/...
            $pathParts = explode('/', $request->path());
            $module = $pathParts[1] ?? '';

            if (in_array($module, $readOnlyModules)) {
                // Allow only GET requests for restricted modules
                if ($request->isMethod('get')) {
                    return $next($request);
                }

                // Allow POST for specific sickness reporting if needed, but per specs it's Read-Only for these
                // Wait, specs says: Santri Sakit (CRUD: All Users)
                if ($module === 'sakit' || $module === 'obat') {
                    return $next($request);
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Unauthorized. Access restricted.'], 403);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki hak akses ke fitur tersebut.');
    }
}
