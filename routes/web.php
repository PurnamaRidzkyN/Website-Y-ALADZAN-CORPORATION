<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home',["title"=>"Home Page"]);
});
Route::get('/pembayaran', function () {
    return view('pembayaran',["title"=>"Pembayaran"]);
});
Route::get('/admin', function () {
    return view('admin',["title"=>"Admin"]);
});
Route::get('/peminjaman', function () {
    return view('peminjaman',["title"=>"Peminjaman"]);
});
Route::get('/detail-peminjaman', function () {
    return view('detailPeminjaman',["title"=>"Detail Peminjaman"]);
});
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
