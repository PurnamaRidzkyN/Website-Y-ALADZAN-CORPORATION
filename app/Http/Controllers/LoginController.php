<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Menangani permintaan autentikasi.
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'identifier' => ['required', 'string'], // Bisa username atau email
            'password' => ['required', 'string'],
        ]);

        // Periksa apakah input adalah email atau username
        $loginType = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Gunakan kolom yang sesuai (email atau username)
        $loginCredentials = [
            $loginType => $credentials['identifier'],
            'password' => $credentials['password'],
        ];

        // Periksa apakah "remember me" dicentang
        $remember = $request->filled('remember');

        // Lakukan autentikasi
        if (Auth::attempt($loginCredentials, $remember)) {
            // Regenerasi sesi setelah login berhasil
            $request->session()->regenerate();

            return redirect()->intended('home'); // Redirect ke halaman tujuan
        }

        // Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'identifier' => 'Username atau email dan password tidak cocok.',
        ])->onlyInput('identifier');
    }
}
