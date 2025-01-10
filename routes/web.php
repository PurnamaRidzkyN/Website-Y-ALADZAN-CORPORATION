<?php

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
// Groups
Route::get('/transaksi-pembayaran', [PaymentController::class, 'showPaymentGroups'])->middleware('auth')->name('Transaksi Pembayaran');
Route::delete('/transaksi-pembayaran/destroy', [PaymentController::class, 'destroyGroup'])->middleware('auth')->name('group.destroy');
Route::post('/transaksi-pembayaran/store', [PaymentController::class, 'storeGroup'])->middleware('auth')->name('group.store');


Route::get('/transaksi-pembayaran/{group:name}', [PaymentController::class, 'showListAdminLoans'])
    ->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('List Admin');
Route::delete('/transaksi-pembayaran/{group:name}/destroy', [PaymentController::class, 'destroyAdmin'])->middleware('auth')->name('admin.destroy');
Route::post('/transaksi-pembayaran/{group:name}/store', [PaymentController::class, 'storeAdmin'])->middleware('auth')->name('admin.store');

// Admins
Route::get('/transaksi-pembayaran/{group:name}/{admin:name}', [PaymentController::class, 'showListLoans'])
    ->middleware(['auth'])
    ->name('Daftar Pembayaran');
Route::delete('/transaksi-pembayaran/{group:name}/{admin:name}/destroy', [PaymentController::class, 'destroyLoan'])->middleware('auth')->name('loan.destroy');
Route::post('/transaksi-pembayaran/{group:name}/{admin:name}/store', [PaymentController::class, 'storeLoan'])->middleware('auth')->name('loan.store');

// loans
Route::get('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}', [PaymentController::class, 'showLoanDetail'])->middleware('auth')->name('Loan Detail');
Route::post('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}/store', [PaymentController::class, 'storePayment'])->middleware('auth')->name('payment.store');

Route::get('/pengeluaran', [ExpensesController::class, 'index'])->name('expenses.index');

Route::get('/manajemen-data', function () {
    return view('manajemenData', ["title" => "Manajemen Data"]);
});

Route::get('/tambah-peminjam', function () {
    return view('tambahPeminjam', ["title" => "Peminjam baru"]);
});
Route::get('/absensi', function () {
    return view('absensi', ["title" => "Absensi"]);
});

Route::get('/pengeluaran-detail', function () {
    return view('pengeluaran/pengeluaranDetail', ["title" => "pengeluaran"]);
});
