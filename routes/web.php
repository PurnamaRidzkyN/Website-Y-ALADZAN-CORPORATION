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

Route::get('/transaksi-pembayaran', [PaymentController::class,'showPaymentGroups'])->middleware('auth')->name('Transaksi Pembayaran');

Route::get('/transaksi-pembayaran/{group:name}', [PaymentController::class, 'showListAdminLoans'])
    ->middleware(['auth', CheckRole::class.':'. 1])
    ->name('List Admin');

Route::get('/transaksi-pembayaran/{group:name}/{admin:name}', [PaymentController::class, 'showListLoans'])
    ->middleware(['auth'])
    ->name('Daftar Pembayaran');

Route::get('/transaksi-pembayaran/{group:name}/{admin:name}/{loan:name}', [PaymentController::class, 'showLoanDetail'])->middleware('auth')->name('Loan Detail');
Route::get('/manajemen-data', function () {
    return view('manajemenData',["title"=>"Manajemen Data"]);
});
Route::get('/tambah-peminjam', function () {
    return view('tambahPeminjam',["title"=>"Peminjam baru"]);
});
Route::get('/absensi', function () {
    return view('absensi',["title"=>"Absensi"]);
});
Route::get('/pengeluaran', function () {
    return view('pengeluaran',["title"=>"pengeluaran"]);
});
Route::get('/pengeluaran-detail', function () {
    return view('pengeluaranDetail',["title"=>"pengeluaran"]);
});
