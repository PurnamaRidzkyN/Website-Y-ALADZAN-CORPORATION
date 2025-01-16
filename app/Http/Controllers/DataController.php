<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Manager;
use Illuminate\Http\Request;

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

        return view('manajemenData', [
            'title' => 'Manajemen Data',
            'admins' => $admins,
            'managers' => $managers,
        ]);
    }
    public function Adminstore(Request $request)
    {
        // Validasi input form
        dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',  // Sesuaikan dengan tabel yang digunakan
            'phone' => 'required|numeric',
            'salary' => 'required|numeric',
        ]);
        $username = strtolower(str_replace(' ', '_', $validated['name']));
        // Menyimpan data ke dalam tabel 'admins'
        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'salary' => $validated['salary'],
            'username' => $username,
        ]);

        // Redirect atau respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }
}
