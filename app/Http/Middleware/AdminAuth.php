<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    protected $adminRoles = [
        'super_admin',
        'admin_inventori',
        'admin_resep',
        'admin_user'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('token')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $role = Session::get('role');
        if (!in_array($role, $this->adminRoles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini');
        }

        // Add role information to view
        view()->share('userRole', $role);
        
        return $next($request);
    }
} 