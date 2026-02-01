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

        // Petugas role access rules
        if ($user->role === 'petugas') {
            // Modules allowed for Read-Only access
            $readOnlyModules = ['kelas', 'jurusan', 'users', 'activity'];
            $fullAccessModules = ['santri', 'sakit', 'obat', 'laporan', 'akademik'];

            // Get module name from prefix admin/...
            $pathParts = explode('/', $request->path());
            $module = $pathParts[1] ?? '';

            if (in_array($module, $fullAccessModules)) {
                return $next($request);
            }

            if (in_array($module, $readOnlyModules)) {
                // Allow only GET requests for master data/system modules
                if ($request->isMethod('get')) {
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
