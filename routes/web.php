<?php

use App\Http\Controllers\DataController;
use Illuminate\Support\Carbon;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PaymentController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/', [LoginController::class, 'authenticate']);

Route::get('/home', [HomeController::class, 'showHome'])->middleware('auth')->name('home');

// transaksi-pembayaran

Route::get('/transaksi-pembayaran', [PaymentController::class, 'showPaymentGroups'])->middleware('auth')->name('Transaksi Pembayaran');
Route::delete('/transaksi-pembayaran/destroy', [PaymentController::class, 'destroyGroup'])->middleware('auth')->name('group.destroy');
Route::post('/transaksi-pembayaran/store', [PaymentController::class, 'storeGroup'])->middleware('auth')->name('group.store');
Route::put('/transaksi-pembayaran/{group}', [PaymentController::class, 'updateGroup'])->middleware('auth')->name('group.update');

// Groups
Route::get('/transaksi-pembayaran/{group:name}', [PaymentController::class, 'showListAdminLoans'])
    ->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('List Admin');
Route::delete('/transaksi-pembayaran/{group:name}/destroy', [PaymentController::class, 'destroyAdmin'])->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('admin.destroy');
Route::post('/transaksi-pembayaran/{group:name}/store', [PaymentController::class, 'storeAdmin'])->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('admin.store');

// Admins
Route::get('/transaksi-pembayaran/{group:name}/{admin:name}', [PaymentController::class, 'showListLoans'])
    ->middleware(['auth'])
    ->name('Daftar Pembayaran');
Route::post('/transaksi-pembayaran/{group:name}/{admin:name}/store', [PaymentController::class, 'storeLoan'])->middleware('auth')->name('loan.store');

// loans

Route::get('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}', [PaymentController::class, 'showLoanDetail'])->middleware('auth')->name('Loan Detail');
Route::post('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/store', [PaymentController::class, 'storePayment'])->middleware('auth')->name('payment.store');
Route::put('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/update/', [PaymentController::class, 'updateLoan'])->middleware('auth')->name('loans.update');
Route::delete('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/destroy', [PaymentController::class, 'destroyLoan'])->middleware('auth')->name('loan.destroy');
Route::put('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/payment/update/', [PaymentController::class, 'updatePayment'])->middleware('auth')->name('payment.update');
Route::delete('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/payment/destroy', [PaymentController::class, 'destroyPayment'])->middleware('auth')->name('payment.destroy');

Route::get('/pengeluaran', [ExpensesController::class, 'index'])->middleware('auth')->name('expenses.index');
Route::post('/pengeluaran/store', [ExpensesController::class, 'store'])->middleware('auth')->name('expenses.store');
Route::put('/pengeluaran/update/{id}', [ExpensesController::class, 'update'])->middleware('auth')->name('expenses.update');
Route::get('/pengeluaran/edit/{id}', [ExpensesController::class, 'edit'])->middleware('auth')->name('expenses.edit');
Route::delete('/pengeluaran/delete/{id}', [ExpensesController::class, 'destroy'])->middleware('auth')->name('expenses.destroy');



Route::get('/manajemen-data', [DataController::class, 'index'])
    ->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('Manajemen Data');

Route::post('/manajemen-data/store', [DataController::class, 'Adminstore'])
    ->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('Manajemen Data.store');

Route::get('/tambah-peminjam', function () {
    return view('tambahPeminjam', ["title" => "Peminjam baru"]);
});
Route::get('/absensi', function () {
    return view('absensi', ["title" => "Absensi"]);
});

Route::get('/pengeluaran-detail', function () {
    return view('pengeluaran/pengeluaranDetail', ["title" => "pengeluaran"]);
});
