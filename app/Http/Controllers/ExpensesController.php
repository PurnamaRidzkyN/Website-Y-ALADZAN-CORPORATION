<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;
use Illuminate\Support\Facades\Storage;

class ExpensesController extends Controller
{
    public function index()
    {
        $category_expenses = CategoryExpense::all();
        $expenses = Expense::with('user.admin', 'user.manager')->get();
        return view('pengeluaran/pengeluaran', compact('category_expenses', 'expenses'), ["title" => "pengeluaran"]);
    }
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:500',
            'payment_method' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
            'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
        ]);

        try {
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
                'date' => $validatedData['tanggal'],
                'amount' => $validatedData['nominal'],
                'category_id' => $validatedData['category_id'],
                'description' => $validatedData['deskripsi'],
                'method' => $validatedData['payment_method'],
                'image_url' => $validatedData['image_url'] ?? null,  // Jika tidak ada gambar, set ke null
            ]);
            // Redirect dengan pesan sukses
            return redirect()->route('expenses.index')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil ditambahkan!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:500',
            'payment_method' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
            'category_id' => 'required|exists:category_expenses,id', // Pastikan ada kategori terkait
        ]);
        try {
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
                'date' => $validatedData['tanggal'],
                'amount' => $validatedData['nominal'],
                'category_id' => $validatedData['category_id'],
                'description' => $validatedData['deskripsi'],
                'method' => $validatedData['payment_method'],
                'image_url' => $validatedData['image_url'] ?? $expense->image_url, // Jika tidak ada gambar baru, gunakan gambar lama
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('expenses.index')->with([
                'status' => 'success',
                'message' => 'Pengeluaran berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->back()->withInput()->with([
                'status' => 'error',
                'message' => 'Gagal memperbarui pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
    // ExpenseController.php

    public function edit($id)
    {
        $expense = Expense::findOrFail($id); // Mengambil data berdasarkan ID
        // Mengembalikan data dalam format JSON
        return response()->json($expense);
    }

    public function destroy($id)
    {
        try {
            // Cari pengeluaran berdasarkan ID
            $expense = Expense::findOrFail($id);

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
            // Tangani jika terjadi error
            return redirect()->route('expenses.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus pengeluaran. Silakan coba lagi.',
            ]);
        }
    }
}
