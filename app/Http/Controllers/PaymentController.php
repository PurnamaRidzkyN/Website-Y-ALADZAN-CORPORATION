<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Loan;
use App\Models\Admin;
use App\Models\Groups;
use App\Models\Payment;
use App\Models\AdminGroups;
use Illuminate\Http\Request;
use App\Models\AdminLoanView;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // groups
    public function showPaymentGroups()
    {
        $groups = Groups::select('id', 'name', 'description', 'created_at')->get();
        if (Auth::user()->role == 2) {
            $admin = Admin::where('user_id', Auth::user()->id)->first();
            return view('pembayaran/pembayaran', ['title' => 'Transaksi Pembayaran', 'groups' => $groups, 'admin' => $admin],);
        } else {
            return view('pembayaran/pembayaran', ['title' => 'Transaksi Pembayaran', 'groups' => $groups],);
        }
    }
    // Menambahkan group baru
    public function storeGroup(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Cek apakah grup sudah ada dengan nama yang sama
        $existingGroup = Groups::where('name', $validatedData['name'])->first();

        if ($existingGroup) {
            // Jika grup sudah ada, berikan pesan error
            return redirect()->route('Transaksi Pembayaran')
                ->with('status', 'danger')
                ->with('message', 'Grup dengan nama tersebut sudah ada!');
        } else {
            // Jika grup belum ada, simpan grup baru
            Groups::create($validatedData);

            return redirect()->route('Transaksi Pembayaran')
                ->with('status', 'success')
                ->with('message', 'Grup berhasil ditambahkan!');
        }
    }


    public function destroyGroup(Request $request)
    {
        $groupId = $request->input('group_id');  // Ambil ID grup dari form yang dikirimkan

        // Temukan grup berdasarkan ID
        $group = Groups::find($groupId);

        if ($group) {
            // Hapus grup
            $group->delete();

            return redirect()->route('Transaksi Pembayaran')  // Pastikan rute ini benar
                ->with('status', 'success')
                ->with('message', 'Grup berhasil dihapus!');
        } else {
            return redirect()->route('Transaksi Pembayaran')  // Pastikan rute ini benar
                ->with('status', 'danger')
                ->with('message', 'Grup tidak ditemukan!');
        }
    }



    // admin
    public function showListAdminLoans(Groups $group)
    {
        // Ambil data admin berdasarkan group_id
        $admins = AdminLoanView::where('group_id', $group->id)->get();

        // Ambil semua admin yang belum ada di dalam $admins berdasarkan id
        $adminIds = $admins->pluck('admin_id')->toArray(); // Ambil semua admin_id dari $admins

        $adminAll = Admin::whereNotIn('id', $adminIds)->get(); // Ambil admin yang id-nya tidak ada di dalam $adminIds

        // Kirim data grup dan admins ke view
        return view('pembayaran/listAdmin', [
            'title' => 'List Admin - ' . $group->name,
            'admins' => $admins,
            'group' => $group,
            'adminAll' => $adminAll
        ]);
    }


    public function destroyAdmin(Request $request)
    {

        $adminId = $request->input('admin_id');  // Ambil ID grup dari form yang dikirimkan
        $groupId = $request->input('group_id');
        $group = Groups::find($groupId);

        // Temukan admin berdasarkan ID
        $admin = Admin::find($adminId);
        // Temukan grup berdasarkan ID
        $adminGroup = AdminGroups::where('admin_id', $adminId)->where('group_id', $groupId);
        if ($adminGroup) {
            // Hapus grup
            $adminGroup->delete();

            return redirect()->route('List Admin', [
                'group' => $group->name,
                'admin' => $admin->name
            ])  // Pastikan rute ini benar
                ->with('status', 'success')
                ->with('message', 'Admin berhasil dihapus!');
        } else {
            return redirect()->route('List Admin', [
                'group' => $group->name,
                'admin' => $admin->name
            ])  // Pastikan rute ini benar
                ->with('status', 'danger')
                ->with('message', 'Admin tidak ditemukan!');
        }
    }
    public function storeAdmin(Request $request, $groupName)
    {


        // Temukan grup berdasarkan nama
        $group = Groups::where('name', $groupName)->first();

        // Temukan admin berdasarkan ID
        $admin = Admin::find($request->admin_id);


        if ($group && $admin) {
            // Menambahkan admin ke grup dengan cara membuat entri baru di admin_groups
            AdminGroups::create([
                'admin_id' => $admin->id,
                'group_id' => $group->id
            ]);
            return redirect()->route('List Admin', [
                'group' => $group->name,
                'admin' => $admin->name
            ])->with('status', 'success')->with('message', 'Admin berhasil ditambahkan ke grup!');
        }
        // Jika grup dan admin ditemukan, tambahkan admin ke grup


        return back()->with('status', 'danger')->with('message', 'Grup atau admin tidak ditemukan!');
    }
    //loans
    public function showListLoans($group, $admin)
    {

        // Ambil grup berdasarkan nama
        $group = Groups::where('name', $group)->first(); // Menggunakan first() untuk mendapatkan satu entitas grup

        // Ambil admin berdasarkan nama
        $admin = Admin::where('name', $admin)->first(); // Menggunakan first() untuk mendapatkan satu entitas admin

        $adminGroup = AdminGroups::where('group_id', $group->id)->where('admin_id', $admin->id)->first();
        // Ambil data pinjaman (loans) berdasarkan admin_id
        $loans = Loan::where('admin_group_id', $adminGroup->id)->get();
        $codes = Code::all();

        // Kirim data grup, admin, dan pinjaman ke view
        return view('pembayaran/listPembayar', [
            'title' => 'Daftar Pembayaran - ' . $group->name . ' - ' . $admin->name,
            'loans' => $loans,
            'group' => $group,
            'admin' => $admin,
            'codes' => $codes,
            'adminGroup' => $adminGroup
        ]);
    }

    public function storeLoan(Request $request, $group, $admin)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'admin_group_id' => 'required|exists:admin_groups,id', // Harus ada di tabel admin_groups
            'name' => 'required|string|max:255', // Nama wajib, berupa string, max 255 karakter
            'description' => 'nullable|string|max:500', // Deskripsi opsional, max 500 karakter
            'loan_date' => 'required|date', // Tanggal wajib, format tanggal valid
            'total_amount' => 'required|numeric|min:0', // Total harus angka, minimal 0
            'phone' => 'required|string|max:15', // Telepon wajib, max 15 karakter
            'code_id' => 'required|exists:codes,id', // Harus ada di tabel codes
        ]);

        // Temukan grup admin berdasarkan ID
        $groups = AdminGroups::find($validatedData['admin_group_id']);

        if ($groups) {
            // Buat entri baru di tabel loans
            Loan::create([
                'admin_group_id' => $groups->id,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'loan_date' => $validatedData['loan_date'],
                'total_amount' => $validatedData['total_amount'],
                'outstanding_amount' => $validatedData['total_amount'], // Outstanding sama dengan total saat awal
                'phone' => $validatedData['phone'],
                'codes_id' => $validatedData['code_id'],
            ]);

            // Redirect ke rute 'Daftar Pembayaran' dengan pesan sukses
            return redirect()->route('Daftar Pembayaran', [
                'group' => $group,
                'admin' => $admin,
            ])->with('status', 'success')
                ->with('message', 'Loan berhasil ditambahkan!');
        }

        // Jika grup admin tidak ditemukan
        return back()->with('status', 'error')
            ->with('message', 'Admin group tidak ditemukan.');
    }


    public function showLoanDetail($group, $admin, $loan)
    {
        // Ambil grup berdasarkan nama
        $group = Groups::where('name', $group)->firstOrFail();

        // Ambil admin berdasarkan nama
        $admin = Admin::where('name', $admin)->firstOrFail();

        // Ambil pinjaman berdasarkan nama
        $loan = Loan::where('name', $loan)->firstOrFail();

        // Ambil semua pembayaran terkait pinjaman
        $payments = Payment::where('loan_id', $loan->id)->get();

        // Kirim data ke view
        return view('pembayaran/detailPembayar', [
            'title' => 'Daftar Pembayaran - ' . $group->name . ' - ' . $admin->name . ' - ' . $loan->name,
            'loans' => $loan, // Data pinjaman tunggal
            'group' => $group,
            'admin' => $admin,
            'payments' => $payments,
        ]);
    }

    public function storePayment(Request $request, $group, $admin, $loan)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'loan_id' => 'required|exists:loans,id', // loan_id harus ada di tabel loans
            'nominal' => 'required|numeric|min:0', // nominal harus angka, minimal 0
            'tanggal' => 'required|date', // tanggal harus format tanggal yang valid
            'payment_method' => 'required|string|max:100', // metode pembayaran wajib, max 100 karakter
            'deskripsi' => 'nullable|string|max:500', // deskripsi opsional, max 500 karakter
        ]);

        // Temukan pinjaman berdasarkan ID
        $loans = Loan::find($validatedData['loan_id']);

        if ($loans) {
            // Buat entri baru di tabel payments
            Payment::create([
                'loan_id' => $loans->id,
                'amount' => $validatedData['nominal'],
                'payment_date' => $validatedData['tanggal'],
                'method' => $validatedData['payment_method'],
                'description' => $validatedData['deskripsi'],
            ]);

            // Redirect setelah berhasil
            return redirect()->route('Loan Detail', [
                'group' => $group,
                'admin' => $admin,
                'loan' => $loan,
            ])->with('status', 'success')
                ->with('message', 'Pembayaran berhasil ditambahkan!');
        }

        // Jika pinjaman tidak ditemukan
        return back()->with('status', 'error')->with('message', 'Pinjaman tidak ditemukan.');
    }
}
