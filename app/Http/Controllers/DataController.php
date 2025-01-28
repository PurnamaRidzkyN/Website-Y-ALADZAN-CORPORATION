<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Bonuses;
use App\Models\Manager;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian untuk Admin
        $adminsQuery = Admin::with('user', 'bonuses');
        if ($request->has('search_admin') && $request->search_admin != '') {
            $adminsQuery->whereRaw('LOWER(name) like ?', ['%' . strtolower($request->search_admin) . '%'])
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->whereRaw('LOWER(email) like ?', ['%' . strtolower($request->search_admin) . '%'])
                        ->orWhereRaw('LOWER(username) like ?', ['%' . strtolower($request->search_admin) . '%']);
                });
        }
        $admins = $adminsQuery->get();

        // Pencarian untuk Manager
        $managersQuery = Manager::with('user');
        if ($request->has('search_manager') && $request->search_manager != '') {
            $managersQuery->whereHas('user', function ($query) use ($request) {
                $query->whereRaw('LOWER(email) like ?', ['%' . strtolower($request->search_manager) . '%'])
                    ->orWhereRaw('LOWER(username) like ?', ['%' . strtolower($request->search_manager) . '%']);
            });
        }
        $managers = $managersQuery->get();

        $message = Message::first();

        return view('manajemenData', [
            'title' => 'Manajemen Data',
            'admins' => $admins,
            'managers' => $managers,
            'message' => $message
        ]);
    }
    public function adminStore(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // Sesuaikan dengan tabel yang digunakan
            'phone' => 'required|numeric',
            'salary' => 'required|numeric',
        ]);
        $username = strtolower(str_replace(' ', '_', $validated['name']));
        // Menyimpan data ke dalam tabel 'admins'
        $bonus = Bonuses::create([
            'total_amount' => 0,
            'used_amount' => 0
        ]);
        $user = User::create([
            'username' => $username,
            'email' => $validated['email'],
            'role' => 2,
            'password' => $username
        ]);
        Admin::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'salary' => $validated['salary'],
            'foto' => null,
            'bonus_id' => $bonus->id
        ]);

        // Redirect atau respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function adminUpdate(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',  // Sesuaikan dengan tabel yang digunakan
            'phone' => 'required|numeric',
            'salary' => 'required|numeric',
        ]);
        $admin = Admin::find($request->id);
        $admin->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'salary' => $validated['salary']
        ]);
        $admin->user->update([
            'email' => $validated['email']
        ]);
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
    public function adminDestroy(Request $request)
    {

        try {
            // Cari pengeluaran berdasarkan ID
            $admin = Admin::findOrFail($request->admin_id);

            // Hapus gambar dari penyimpanan jika ada
            if ($admin->image_url) {
                // Menghapus gambar yang disimpan di folder 'public/admin'
                Storage::disk('public')->delete($admin->foto);
            }

            // Hapus pengeluaran dari database
            $admin->user->delete();
            $admin->delete();


            // Redirect dengan pesan sukses
            return redirect()->route('Manajemen Data')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->route('Manajemen Data')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
    public function managerStore(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // Sesuaikan dengan tabel yang digunakan
            'phone' => 'required|numeric',
        ]);
        $username = strtolower(str_replace(' ', '_', $validated['name']));
        // Menyimpan data ke dalam tabel 'admins'

        $user = User::create([
            'username' => $username,
            'email' => $validated['email'],
            'role' => 1,
            'password' => $username
        ]);
        Manager::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'foto' => null,

        ]);

        // Redirect atau respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function managerUpdate(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',  // Sesuaikan dengan tabel yang digunakan
            'phone' => 'required|numeric',
        ]);
        $admin = Manager::find($request->id);
        $admin->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);
        $admin->user->update([
            'email' => $validated['email']
        ]);
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
    public function managerDestroy(Request $request)
    {

        try {
            // Cari pengeluaran berdasarkan ID
            $manager = Manager::findOrFail($request->admin_id);

            // Hapus gambar dari penyimpanan jika ada
            if ($manager->image_url) {
                // Menghapus gambar yang disimpan di folder 'public/admin'
                Storage::disk('public')->delete($manager->foto);
            }

            // Hapus pengeluaran dari database
            $manager->user->delete();
            $manager->delete();


            // Redirect dengan pesan sukses
            return redirect()->route('Manajemen Data')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->route('Manajemen Data')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
    public function messageUpdate(Request $req)
    {
        // Validasi inputan
        $validatedData = $req->validate([
            'message_header' => 'required|string|max:255',
            'message_footer' => 'nullable|string|max:255',
        ]);

        // Ambil data message dengan ID 1
        $message = Message::findOrFail(1);

        // Update data message
        $message->update($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('Manajemen Data')
            ->with('status', 'success')
            ->with('message', 'Pesan berhasil diperbarui');
    }
}
