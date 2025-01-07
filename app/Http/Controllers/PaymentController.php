<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Admin;
use App\Models\Groups;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\AdminLoanView;

class PaymentController extends Controller
{
    public function showPaymentGroups()
    {
        $groups = Groups::select('name', 'description', 'created_at')->get(); // Ambil kolom 'name' saja
        return view('pembayaran/pembayaran', ['title' => 'Transaksi Pembayaran', 'groups' => $groups]);
    }
    public function showListAdminLoans(Groups $group)
    {
        // Ambil data admin berdasarkan group_id
        $admins = AdminLoanView::where('group_id', $group->id)->get();

        // Kirim data grup dan admins ke view
        return view('pembayaran/listAdmin', [
            'title' => 'List Admin - ' . $group->name,
            'admins' => $admins,
            'group' => $group,
            'adminAll' => Admin::all()  
        ]);
    }

    public function showListLoans($group, $admin)
    {
        // Ambil grup berdasarkan nama
        $group = Groups::where('name', $group)->first(); // Menggunakan first() untuk mendapatkan satu entitas grup

        // Ambil admin berdasarkan nama
        $admin = Admin::where('name', $admin)->first(); // Menggunakan first() untuk mendapatkan satu entitas admin

        // Ambil data pinjaman (loans) berdasarkan admin_id
        $loans = Loan::where('admin_id', $admin->id)->get();

        // Kirim data grup, admin, dan pinjaman ke view
        return view('pembayaran/listPembayar', [
            'title' => 'Daftar Pembayaran - ' . $group->name . ' - ' . $admin->name,
            'loans' => $loans,
            'group' => $group,
            'admin' => $admin
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
