<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('login');
    }
    public function showForgotPassword()
    {
        return view('forgotPassword');
    }
    public function showChangePassword()
    {
        return view('changePassword');
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

            return redirect()->intended('/home'); // Redirect ke halaman tujuan
        }

        // Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'identifier' => 'Username atau email dan password tidak cocok.',
        ])->onlyInput('identifier');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function resetPassword(Request $req)
    {
        // Debugging untuk melihat input yang diterima
        // Validasi input: email dan phone harus diisi
        $req->validate([
            'email' => ['required', 'email'], // Wajib email yang valid
        ]);

        // Cek apakah email sudah ada di database
        $user = User::where('email', $req->email)->first(); // Cari pengguna berdasarkan email
        if (!$user) {
            return response()->json([
                'message' => 'Pengguna dengan email tersebut tidak ditemukan.',
            ], 404);
        }
        $newPassword = Str::random(8);
        $data = [
            'subject' => 'Password Baru Anda',
            'title' => 'Password Baru Untuk Akun Anda',
            'body' => 'Hai, Anda baru saja mengklik "Lupa Kata Sandi". Berikut adalah password baru Anda: ' . $newPassword . "\n\n" .
                'Harap segera login dan ubah password Anda di bagian profil agar lebih aman.' . "\n\n" .
                'Jika Anda membutuhkan bantuan lebih lanjut, Anda dapat menghubungi kami di: y.aladzan.92@gmail.com' . "\n\n" .
                'Terima kasih, ' . "\n" .
                'Y-Aladzan'
        ];

        $userEmail = 'himadatsuki@gmail.com';
        Mail::raw($data['body'], function ($message) use ($userEmail, $data) {
            $message->to($userEmail)
                ->subject($data['subject']);
        });
        // Proses reset password di sini jika email ditemukan
        // Misalnya, kirimkan email reset password atau lakukan perubahan password

        return response()->json([
            'message' => 'Silakan cek email Anda untuk instruksi reset password.',
        ], 200);
    }


    public function changePassword(Request $req)
    {
        // Validasi input
        $req->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required|same:newPassword',
        ], [
            'currentPassword.required' => 'Password lama harus diisi.',
            'newPassword.required' => 'Password baru harus diisi.',
            'newPassword.min' => 'Password baru minimal 8 karakter.',
            'confirmNewPassword.required' => 'Konfirmasi password baru harus diisi.',
            'confirmNewPassword.same' => 'Password baru dan konfirmasi password tidak cocok.',
        ]);

        // Periksa apakah password lama benar
        if (!Hash::check($req->currentPassword, Auth::user()->password)) {
            return back()->withErrors(['currentPassword' => 'Password lama salah.']);
        }

        // Update password user
        $user = Auth::user();
        $user->password = Hash::make($req->newPassword);  // Pastikan password di-hash
        $user->save();  // Menyimpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}
