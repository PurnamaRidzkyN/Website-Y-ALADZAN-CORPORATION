<?php

use Illuminate\Support\Carbon;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\reportController;

// auth
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'authenticate']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgotPassword');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');



Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/home', [HomeController::class, 'showHome'])->middleware('auth')->name('home');

// transaksi-pembayaran

Route::get('/transaksi-pembayaran', [PaymentController::class, 'showPaymentGroups'])->middleware('auth')->name('Transaksi Pembayaran');
Route::delete('/transaksi-pembayaran/destroy', [PaymentController::class, 'destroyGroup'])->middleware('auth')->name('group.destroy');
Route::post('/transaksi-pembayaran/store', [PaymentController::class, 'storeGroup'])->middleware('auth')->name('group.store');
Route::put('/transaksi-pembayaran/{group}', [PaymentController::class, 'updateGroup'])->middleware('auth')->name('group.update');

// Groups
Route::get('/transaksi-pembayaran/{group:name}', [PaymentController::class, 'showListAdminLoans'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('List Admin');
Route::delete('/transaksi-pembayaran/{group:name}/destroy', [PaymentController::class, 'destroyAdmin'])->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('admin.destroy');
Route::post('/transaksi-pembayaran/{group:name}/store', [PaymentController::class, 'storeAdmin'])->middleware(['auth', CheckRole::class . ':' . '1-0'])
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
Route::get('/loans/print/{id}', [PaymentController::class, 'print'])->name('loans.print');

Route::get('/pengeluaran', [ExpensesController::class, 'index'])->middleware('auth')->name('expenses.index');
Route::post('/pengeluaran/store', [ExpensesController::class, 'store'])->middleware('auth')->name('expenses.store');
Route::put('/pengeluaran/update/{id}', [ExpensesController::class, 'update'])->middleware('auth')->name('expenses.update');
Route::get('/pengeluaran/edit/{id}', [ExpensesController::class, 'edit'])->middleware('auth')->name('expenses.edit');
Route::delete('/pengeluaran/delete/{id}', [ExpensesController::class, 'destroy'])->middleware('auth')->name('expenses.destroy');

Route::post('/pengeluaran/category-store', [ExpensesController::class, 'categoryStore'])->middleware(['auth', CheckRole::class . ':' . '1-0'])->name('category.store');
Route::put('/pengeluaran/category-update/{id}', [ExpensesController::class, 'categoryUpdate'])->middleware(['auth', CheckRole::class . ':' . '1-0'])->name('category.update');
Route::delete('/pengeluaran/category-destroy/{id}', [ExpensesController::class, 'categoryDestroy'])->middleware(['auth', CheckRole::class . ':' . '1-0'])->name('category.destroy');

// manajemen data
Route::get('/manajemen-data', [DataController::class, 'index'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data');

Route::post('/manajemen-data/store-admin', [DataController::class, 'adminStore'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.adminStore');

Route::put('/manajemen-data/update-admin', [DataController::class, 'adminUpdate'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.adminUpdate');

Route::delete('/manajemen-data/destroy-admin', [DataController::class, 'adminDestroy'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.adminDestroy');

Route::post('/manajemen-data/store-manager', [DataController::class, 'managerStore'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.managerStore');

Route::put('/manajemen-data/update-manager', [DataController::class, 'managerUpdate'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.managerUpdate');

Route::delete('/manajemen-data/destroy-manager', [DataController::class, 'managerDestroy'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.managerDestroy');

Route::put('/manajemen-data/update-message', [DataController::class, 'messageUpdate'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('Manajemen Data.messageUpdate');
Route::post('/manajemen-data/store-code', [DataController::class, 'codeStore'])
    ->middleware(['auth', CheckRole::class . ':' . '0'])
    ->name('Manajemen Data.codeStore');
Route::put('/manajemen-data/update-code', [DataController::class, 'codeUpdate'])
    ->middleware(['auth', CheckRole::class . ':' . '0'])
    ->name('Manajemen Data.codeUpdate');
Route::delete('/manajemen-data/destroy-code', [DataController::class, 'codeDestroy'])
    ->middleware(['auth', CheckRole::class . ':' . '0'])
    ->name('Manajemen Data.codeDestroy');
Route::get('/manajemen-data/backup-database', [BackupController::class, 'backupDatabase'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('backupDatabase');;
Route::post('/manajemen-data/restore-database', [BackupController::class, 'restoreDatabase'])
    ->middleware(['auth', CheckRole::class . ':' . '1-0'])
    ->name('restoreDatabase');

Route::get('/profil/{username}', [ProfilController::class, 'index'])->middleware('auth')->name('indexProfils');
Route::put('/profil/{username}/update', [ProfilController::class, 'update'])->middleware('auth')->name('updateUser');




Route::get('/absensi', [AttendanceController::class, 'showAttendance'])->middleware('auth')->name('attendance');
Route::post('/absensi', [AttendanceController::class, 'recordAttendance'])->middleware('auth')->name('recordAttendance');

Route::get('/laporan', [reportController::class, 'showReports'])->middleware(['auth', CheckRole::class . ':' . '0-1'])->name('reports');
Route::get('/laporan/bonuses', [ReportController::class, 'showBonuses'])->middleware(['auth', CheckRole::class . ':' . '0'])->name('reports.bonuses');
Route::post('/laporan/bonuses/manajer', [ReportController::class, 'checkReportBonusesManager'])->middleware('auth')->name('reports.bonuses.manager');
Route::get('/laporan/bonuses/manajer/{id}', [ReportController::class, 'showBonusesAdmin'])->middleware(['auth', CheckRole::class . ':' . '0-1'])->name('reports.bonuses.admins');
Route::post('/laporan/bonuses/admin', [ReportController::class, 'checkReportBonusesAdmin'])->middleware('auth')->name('reports.bonuses.admin');

Route::get('/laporan/absensi', [ReportController::class, 'showAttendances'])->middleware(['auth', CheckRole::class . ':' . '0-1'])->name('reports.attendances');


Route::get('/laporan/pembayaran', [ReportController::class, 'showPayment'])->middleware(['auth', CheckRole::class . ':' . '0'])->name('reports.payment');
