<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Groups;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Models\AdminLoanView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->first();

        // Jika pengguna tidak ditemukan, lemparkan error 404
        if (!$user) {
            abort(404, 'User not found');
        }
        if ($user->role == 2) {
            $admin = Admin::where('user_id', $user->id)->first();
            $loan = AdminLoanView::where('admin_id', $admin->id)
                ->selectRaw('group_id, SUM(total_payments) as total_payments, SUM(total_amount) as total_amount')
                ->groupBy('group_id')
                ->get();
            $loans = AdminLoanView::where('admin_id', $admin->id)
                ->selectRaw('SUM(total_payments) as total_payments, SUM(total_amount) as total_amount')
                ->first();
            $group = DB::table('admin_groups as ag')
                ->join('groups as g', 'ag.group_id', '=', 'g.id')
                ->join('admins as a', 'ag.admin_id', '=', 'a.id')
                ->where('a.id', $admin->id)
                ->select('g.id', 'g.name', 'g.description', 'g.updated_at')
                ->get();
            return view('profils', ["title" => "Profils " . $user->username, "users" => $user, "user" => $admin, "loan" => $loan, "totalLoans" => $loans, "groups" => $group]);
        }
        $manager = Manager::where('user_id', $user->id)->first();
        // Pass category_expenses and expenses to the view
        return view('profils', ["title" => "Profils " . $user->username, "users" => $user, "user" => $manager]);
    }

    public function update(Request $req, $username)
    {
        // Ambil data user berdasarkan username
        $user = User::where('username', $username)->first();
        // Validasi input
        $validatedData = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'required|numeric|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);
        if ($user->role == 2) {
            $admin = Admin::where('user_id', $user->id)->first();
            // Periksa apakah ada file gambar baru yang di-upload
            if ($req->hasFile('photo')) {
                // Hapus gambar lama dari penyimpanan
                if ($user->foto) {
                    Storage::disk('public')->delete($admin->foto);
                }
                // Simpan gambar baru dan ambil path-nya
                $imagePath = $req->file('photo')->store('fotoProfils', 'public');
                $validatedData['photo'] = $imagePath; // Simpan path gambar baru
            }

            // Update hanya kolom yang diperlukan di tabel 'users'
            $user->update([
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
            ]);

            // Ambil data admin terkait user ini
            if ($admin) {
                // Update hanya kolom yang diperlukan di tabel 'admin'
                $admin->update([
                    'name' => $validatedData['name'],
                    'phone' => $validatedData['phone'],
                    'foto' => $validatedData['photo'] ?? $admin->foto, // Jika tidak ada foto baru, gunakan foto lama
                ]);
            }
        } elseif ($user->role == 1) {
            $manager = Manager::where('user_id', $user->id)->first();
            // Periksa apakah ada file gambar baru yang di-upload
            if ($req->hasFile('photo')) {
                // Hapus gambar lama dari penyimpanan
                if ($user->foto) {
                    Storage::disk('public')->delete($manager->foto);
                }
                // Simpan gambar baru dan ambil path-nya
                $imagePath = $req->file('photo')->store('fotoProfils', 'public');
                $validatedData['photo'] = $imagePath; // Simpan path gambar baru
            }

            // Update hanya kolom yang diperlukan di tabel 'users'
            $user->update([
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
            ]);

            // Ambil data admin terkait user ini
            if ($manager) {
                // Update hanya kolom yang diperlukan di tabel 'admin'
                $manager->update([
                    'name' => $validatedData['name'],
                    'phone' => $validatedData['phone'],
                    'foto' => $validatedData['photo'] ?? $manager->foto, // Jika tidak ada foto baru, gunakan foto lama
                ]);
            }
        }

        // Kembalikan atau redirect sesuai kebutuhan
        return redirect()->route('indexProfils', ['username' => $validatedData['username']])->with('success', 'Profil berhasil diperbarui');
    }
}
