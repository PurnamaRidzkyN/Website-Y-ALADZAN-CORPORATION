<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome()
    {
        // Ambil data pembayaran, total per tanggal
        $payments = Payment::selectRaw('payment_date, SUM(amount) as total_payment')
            // ->where('payment_date', '>=', Carbon::now()->subDays(30))  // Filter berdasarkan 30 hari terakhir
            ->groupBy('payment_date')
            ->orderByRaw('payment_date')  // Mengurutkan berdasarkan total pembayaran terbesar
            ->get();

        $highPayments = Payment::selectRaw('payment_date, SUM(amount) as total_payment')
            ->groupBy('payment_date')
            ->orderByRaw('SUM(amount) DESC')
            ->take(5)   // Mengurutkan berdasarkan total_payment secara DESC
            ->get();

        // Kirim data pembayaran ke view
        return view('home', [
            'title' => 'Home Page', 
            'payments' => $payments,
            'highPayments' => $highPayments
        ]);
    }
}
