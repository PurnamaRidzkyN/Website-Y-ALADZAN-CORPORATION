<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckRole;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/', [LoginController::class, 'authenticate']);

Route::get('/home', [HomeController::class, 'showHome'])->middleware('auth')->name('home');

// transaksi-pembayaran
// Groups
Route::get('/transaksi-pembayaran', [PaymentController::class, 'showPaymentGroups'])->middleware('auth')->name('Transaksi Pembayaran');
Route::delete('/transaksi-pembayaran/destroy', [PaymentController::class, 'destroyGroup'])->name('group.destroy');
Route::post('/transaksi-pembayaran/store', [PaymentController::class, 'storeGroup'])->name('group.store');


Route::get('/transaksi-pembayaran/{group:name}', [PaymentController::class, 'showListAdminLoans'])
    ->middleware(['auth', CheckRole::class . ':' . 1])
    ->name('List Admin');
Route::delete('/transaksi-pembayaran/{group:name}/destroy', [PaymentController::class, 'destroyAdmin'])->name('admin.destroy');
Route::post('/transaksi-pembayaran/{group:name}/store', [PaymentController::class, 'storeAdmin'])->name('admin.store');

// Admins
Route::get('/transaksi-pembayaran/{group:name}/{admin:name}', [PaymentController::class, 'showListLoans'])
    ->middleware(['auth'])
    ->name('Daftar Pembayaran');
Route::delete('/transaksi-pembayaran/{group:name}/{admin:name}/destroy', [PaymentController::class, 'destroyLoan'])->name('loan.destroy');
Route::post('/transaksi-pembayaran/{group:name}/{admin:name}/store', [PaymentController::class, 'storeLoan'])->name('loan.store');

// loans
Route::get('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}', [PaymentController::class, 'showLoanDetail'])->middleware('auth')->name('Loan Detail');


Route::get('/manajemen-data', function () {
    return view('manajemenData', ["title" => "Manajemen Data"]);
});

Route::get('/tambah-peminjam', function () {
    return view('tambahPeminjam', ["title" => "Peminjam baru"]);
});
Route::get('/absensi', function () {
    return view('absensi', ["title" => "Absensi"]);
});
Route::get('/pengeluaran', function () {
    return view('pengeluaran', ["title" => "pengeluaran"]);
});
Route::get('/pengeluaran-detail', function () {
    return view('pengeluaranDetail', ["title" => "pengeluaran"]);
});
