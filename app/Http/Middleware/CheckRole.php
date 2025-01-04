<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan pengguna sudah login dan memiliki peran yang sesuai
        if (Auth::check() && Auth::user()->role != (int)$role) {
            // Redirect jika role tidak sesuai
            return redirect('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
