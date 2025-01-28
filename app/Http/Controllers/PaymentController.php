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
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // groups
    public function showPaymentGroups()
    {
        $groups = Groups::select('id', 'name', 'description', 'updated_at')->get();
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
    public function updateGroup(Request $request, $id)
    {
        $group = Groups::findOrFail($id);
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect()->route('Transaksi Pembayaran')->with('status', 'success')->with('message', 'Group Berhasil Di Update');
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
    public function showListAdminLoans(Groups $group, Request $request)
    {
        // Ambil kata kunci pencarian dari parameter query
        $query = $request->input('query');

        // Ambil data admin berdasarkan group_id dengan filter pencarian
        $admins = AdminLoanView::where('group_id', $group->id)
            ->when($query, function ($q) use ($query) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%']) // Case-insensitive untuk nama
                    ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($query) . '%']); // Case-insensitive untuk nomor HP
            })
            ->get();
        // Ambil semua admin yang belum ada di dalam $admins berdasarkan id dengan filter pencarian
        $adminIds = $admins->pluck('admin_id')->toArray(); // Ambil semua admin_id dari $admins

        $adminAll = Admin::whereNotIn('id', $adminIds)
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%");
            })
            ->get();

        // Kirim data grup, admins, dan adminAll ke view
        return view('pembayaran/listAdmin', [
            'title' => 'List Admin - ' . $group->name,
            'admins' => $admins,
            'group' => $group,
            'adminAll' => $adminAll,
            'query' => $query // Kirim query ke view untuk menampilkan hasil pencarian
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

        // Filter pinjaman berdasarkan query pencarian
        $loans = Loan::where('admin_group_id', $adminGroup->id)
            ->when(request('query'), function ($query) {
                // Pencarian berdasarkan nama (case-insensitive)
                $query->where(function ($q) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . strtolower(request('query')) . '%'])
                        ->orWhere('phone', 'like', '%' . request('query') . '%');
                });
            })
            ->get();


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
        $codes = Code::all();          // Ambil semua pembayaran terkait pinjaman
        $payments = Payment::where('loan_id', $loan->id)->get();
        $message = Message::first();
        // Kirim data ke view
        return view('pembayaran/detailPembayar', [
            'title' => 'Daftar Pembayaran - ' . $group->name . ' - ' . $admin->name . ' - ' . $loan->name,
            'loans' => $loan, // Data pinjaman tunggal
            'group' => $group,
            'admin' => $admin,
            'payments' => $payments,
            'codes' => $codes,
            'message' => $message
        ]);
    }
    public function updateLoan(Request $request, $group, $admin, $loan)
    {
        $loan = Loan::findOrFail($request->loan_id);

        // Update data loan, pastikan untuk memasukkan 'code_id' atau parameter lainnya sesuai
        $loan->update([
            'name' => $request->name,
            'description' => $request->description,
            'total_amount' => $request->total_amount,
            'codes_id' => $request->codes_id,
            'phone' => $request->phone,
        ]);

        // Redirect setelah sukses
        return redirect()->route('Loan Detail', [
            'group' => $group,
            'admin' => $admin,
            'loan' => $loan
        ])->with('status', 'success')
            ->with('message', 'Group Berhasil Di Update');
    }
    public function destroyLoan(Request $request, $group, $admin,)
    {
        $loansId = $request->input('loans_id');  // Ambil ID grup dari form yang dikirimkan

        // Temukan grup berdasarkan ID
        $loans = loan::find($loansId);
        if ($loans) {
            // Hapus grup
            $loans->delete();

            return redirect()->route('Daftar Pembayaran', [
                'group' => $group,
                'admin' => $admin
            ])  // Pastikan rute ini benar
                ->with('status', 'success')
                ->with('message', 'Pembayar  berhasil dihapus!');
        } else {
            return redirect()->route('Daftar Pembayaran', [
                'group' => $group,
                'admin' => $admin
            ]) // Pastikan rute ini benar
                ->with('status', 'danger')
                ->with('message', 'Pembayar tidak ditemukan!');
        }
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
        return back()->with('status', 'error')->with('message', 'Pembayaran tidak ditemukan.');
    }
    public function updatePayment(Request $request, $group, $admin, $loan)
    {

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0', // nominal harus angka, minimal 0
            'payment_date' => 'required|date', // tanggal harus format tanggal yang valid
            'payment_method' => 'required|string|max:100', // metode pembayaran wajib, max 100 karakter
            'deskripsi' => 'nullable|string|max:500', // deskripsi opsional, max 500 karakter
        ]);
        $loan = Loan::findOrFail($validatedData['loan_id']);

        // Update data loan, pastikan untuk memasukkan 'code_id' atau parameter lainnya sesuai
        $loan->update([
            'loan_id' => $validatedData['loan_id'],
            'amount' => $validatedData['nominal'],
            'payment_date' => $validatedData['tanggal'],
            'method' => $validatedData['payment_method'],
            'description' => $validatedData['deskripsi'],

        ]);

        // Redirect setelah sukses
        return redirect()->route('Loan Detail', [
            'group' => $group,
            'admin' => $admin,
            'loan' => $loan
        ])->with('status', 'success')
            ->with('message', ' pembayaran  Berhasil Di Update');
    }
    public function destroyPayment(Request $request, $group, $admin, $loan)
    {

        $paymentId = $request->input('payment_id');  // Ambil ID grup dari form yang dikirimkan

        // Temukan grup berdasarkan ID
        $payment = Payment::find($paymentId);
        if ($payment) {
            // Hapus grup
            $payment->delete();

            return redirect()->route('Loan Detail', [
                'group' => $group,
                'admin' => $admin,
                'loan' => $loan
            ])  // Pastikan rute ini benar
                ->with('status', 'success')
                ->with('message', 'Pembayar  berhasil dihapus!');
        } else {
            return redirect()->route('Loan Detail', [
                'group' => $group,
                'admin' => $admin,
                'loan' => $loan
            ]) // Pastikan rute ini benar
                ->with('status', 'danger')
                ->with('message', 'Pembayar tidak ditemukan!');
        }
    }
    public function print($id)
    {
        $loan = Loan::findOrFail($id); // Ambil data berdasarkan ID

        return view('pembayaran/laporan', compact('loan')); // Tampilkan view khusus untuk cetak
    }
}
