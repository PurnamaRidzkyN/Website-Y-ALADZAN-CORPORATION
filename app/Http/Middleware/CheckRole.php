<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        // Pastikan pengguna sudah login dan memiliki peran yang sesuai
        $rolesArray = explode('-', $roles);
        // Pastikan pengguna sudah login
        if (Auth::check()) {
            // Cek apakah role pengguna ada dalam array roles
            if (!in_array(Auth::user()->role, $rolesArray)) {
                // Jika tidak sesuai, redirect ke halaman yang diinginkan
                return redirect('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
        }

        return $next($request);
    }
}
