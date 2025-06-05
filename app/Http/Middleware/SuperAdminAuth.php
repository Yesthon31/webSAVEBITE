<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SuperAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('token')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (Session::get('role') !== 'super_admin') {
            return back()->with('error', 'Hanya super admin yang dapat mengakses fitur ini');
        }

        return $next($request);
    }
} 