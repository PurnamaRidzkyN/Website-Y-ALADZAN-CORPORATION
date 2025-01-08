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

class PaymentController extends Controller
{
    // groups
    public function showPaymentGroups()
    {
        $groups = Groups::select('id', 'name', 'description', 'created_at')->get(); // Ambil kolom 'name' saja
        return view('pembayaran/pembayaran', ['title' => 'Transaksi Pembayaran', 'groups' => $groups]);
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
            'codes' => $codes
        ]);
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
            'payments' => $payments
        ]);
    }
}
