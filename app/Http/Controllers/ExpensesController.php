<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Bonuses;
use App\Models\Expense;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpensesController extends Controller
{
    public function index()
    {
        // Fetch category expenses and expenses with related users (admin, manager)
        $category_expenses = CategoryExpense::orderBy('id', 'asc')->get();
        $admins = Admin::get();
        if (Auth::user()->role == 1) {
            $admins = Admin::get()->where('manager_id', Auth::user()->id);
        }
        $managers = Manager::get();
        $expenses = Expense::with('user.admin', 'user.manager')
            ->orderBy('date', 'desc')  // 'asc' untuk urutan menaik, 'desc' untuk urutan menurun
            ->get();
        // dd($expenses);
        // Convert expenses to an array to pass to JavaScript
        $expensesArray = $expenses->map(function ($expense) {
            return [
                'id' => $expense->id,
                'amount' => $expense->amount,
                'description' => $expense->description,

                'method' => $expense->method,
                'date' => $expense->date,
                'image_url' => $expense->image_url,
                'category_id' => $expense->category_id,
                'user' => [
                    'username' => $expense->user->username, // Ensure you have 'username' or adjust based on your user model
                ],
                'admin' => [
                    'name' => $expense->admin ? $expense->admin->name : null,
                    'role' => 'Admin'
                ],
                'manager' => [
                    'name' => $expense->manager ? $expense->manager->name : 'tidak ada penerima',
                    'role' => 'Manajer'
                ],
            ];
        });

        // Pass category_expenses and expenses to the view
        return view('pengeluaran/pengeluaran', compact('managers', 'admins', 'category_expenses', 'expensesArray'), ["title" => "Pencatatan Pengeluaran"]);
    }

    public function store(Request $request)
    {
        if ($request->category_id == 1 || $request->category_id == 2) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'recipient' => 'required|string|max:100',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric|min:0',
                'deskripsi' => 'required|string|max:500',
                'payment_method' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
            ]);
        } else {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric|min:0',
                'deskripsi' => 'required|string|max:500',
                'payment_method' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
            ]);
        }

        try {
            $validatedData['nominal'] =  str_replace('.', '', $validatedData['nominal']);

            // Cek apakah ada file gambar yang diunggah
            if ($request->hasFile('image')) {
                // Simpan gambar dan ambil path-nya
                $imagePath = $request->file('image')->store('expenses', 'public');
                // Simpan path gambar ke dalam validatedData
                $validatedData['image_url'] = $imagePath;  // Ganti 'image_url' jika sesuai dengan nama kolom di database
            }

            // Simpan data pengeluaran ke database
            Expense::create([
                'user_id' => $validatedData['user_id'],
                'admin_id' => (Auth::user()->role == 0) ? $validatedData['recipient'] : null,
                'manager_id' => (Auth::user()->role == 1) ? $validatedData['recipient'] : null,
                'date' => $validatedData['tanggal'],
                'amount' => $validatedData['nominal'],
                'category_id' => $validatedData['category_id'],
                'description' => $validatedData['deskripsi'],
                'method' => $validatedData['payment_method'],
                'image_url' => $validatedData['image_url'] ?? null,  // Jika tidak ada gambar, set ke null
            ]);


            if ($validatedData['category_id'] == 2) {
                $admin = Admin::find($validatedData['recipient']);
                $bonus = Bonuses::find($admin["bonus_id"]);
                $bonus->used_amount += $validatedData['nominal'];
                $bonus->save();
            }
            // Redirect dengan pesan sukses
            return redirect()->route('expenses.index')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil ditambahkan!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi danger
            return redirect()->back()->withInput()->with([
                'status' => 'danger',
                'message' => 'Gagal menambahkan pengeluaran. Silakan coba lagi.' .$e,
            ]);
        }
    }
    public function update(Request $request, $id)
    {
 
        // Validasi input
        if ($request->category_id == 1 || $request->category_id == 2) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'edit_recipient' => 'required|string|max:100',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric|min:0',
                'deskripsi' => 'required|string|max:500',
                'payment_method' => 'required|string|max:100',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
            ]);
        } else {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'nominal' => 'required|numeric|min:0',
                'deskripsi' => 'required|string|max:500',
                'payment_method' => 'required|string|max:100',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
            ]);
        }
        try {
            $validatedData['nominal'] =  str_replace('.', '', $validatedData['nominal']);

            // Cari pengeluaran berdasarkan ID
            $expense = Expense::findOrFail($id);

            // Cek apakah ada file gambar yang diunggah
            if ($request->hasFile('image')) {
                // Hapus gambar lama dari penyimpanan
                if ($expense->image_url) {
                    Storage::disk('public')->delete($expense->image_url);
                }
                // Simpan gambar baru dan ambil path-nya
                $imagePath = $request->file('image')->store('expenses', 'public');
                $validatedData['image_url'] = $imagePath; // Simpan path gambar baru
            }

            // Perbarui data pengeluaran
            $expense->update([
                'user_id' => $validatedData['user_id'],
                'admin_id' => (($request->category_id == 1 || $request->category_id == 2) && (Auth::user()->role == 1)) ? $validatedData['edit_recipient'] : null,
                'manager_id' => (($request->category_id == 1 || $request->category_id == 2) && (Auth::user()->role == 0)) ? $validatedData['edit_recipient'] : null,
                'date' => $validatedData['tanggal'],
                'amount' => $validatedData['nominal'],
                'category_id' => $validatedData['category_id'],
                'description' => $validatedData['deskripsi'],
                'method' => $validatedData['payment_method'],
                'image_url' => $validatedData['image_url'] ?? $expense->image_url, // Jika tidak ada gambar baru, gunakan gambar lama
            ]);

            if ($validatedData['category_id'] == 2) {
                // Temukan admin berdasarkan admin_id yang diubah
                $admin = Admin::find($validatedData['edit_admin_id']);

                // Temukan bonus berdasarkan bonus_id yang terkait dengan admin
                $bonus = Bonuses::find($admin->bonus_id);

                // Ambil nilai used_amount yang lama
                $oldUsedAmount = $bonus->used_amount;

                // Kurangi nilai lama dari used_amount
                $bonus->used_amount -= $oldUsedAmount;

                // Tambahkan nominal baru ke used_amount
                $bonus->used_amount += $validatedData['nominal'];

                // Simpan perubahan
                $bonus->save();
            }


            // Redirect dengan pesan sukses
            return redirect()->route('expenses.index')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi danger
            return redirect()->back()->withInput()->with([
                'status' => 'danger',
                'message' => 'Gagal memperbarui pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
    // ExpenseController.php

    public function edit($id)
    {
        $expense = Expense::findOrFail($id); 
        return response()->json($expense);
    }

    public function destroy($id)
    {

        try {
            // Cari pengeluaran berdasarkan ID
            $expense = Expense::findOrFail($id);
            if ($expense['category_id'] == 2) {
                // Temukan admin berdasarkan admin_id yang diubah
                $admin = Admin::find($expense['admin_id']);

                // Temukan bonus berdasarkan bonus_id yang terkait dengan admin
                $bonus = Bonuses::find($admin->bonus_id);

                // Ambil nilai used_amount yang lama
                $oldUsedAmount = $bonus->used_amount;

                // Kurangi nilai lama dari used_amount
                $bonus->used_amount -= $oldUsedAmount;

                // Simpan perubahan
                $bonus->save();
            }

            // Hapus gambar dari penyimpanan jika ada
            if ($expense->image_url) {
                // Menghapus gambar yang disimpan di folder 'public/expenses'
                Storage::disk('public')->delete($expense->image_url);
            }

            // Hapus pengeluaran dari database
            $expense->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('expenses.index')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi danger
            return redirect()->route('expenses.index')->with([
                'status' => 'danger',
                'message' => 'Gagal menghapus pengeluaran. Silakan coba lagi.',
            ]);
        }
    }

    public function categoryStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        CategoryExpense::create([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
        ]);
        return redirect()->route('expenses.index')->with([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan !',
        ]);
    }
    public function categoryUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $category = CategoryExpense::findOrFail($id);
        $category->update([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
        ]);
        return redirect()->route('expenses.index')->with([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan !',
        ]);
    }
    public function categoryDestroy($id)
    {
        $category = CategoryExpense::findOrFail($id);
        $category->delete();
        return redirect()->route('expenses.index')->with([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus!',
        ]);
    }
}
