<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome()
    {
        // Pembayaran
        $payments = Payment::selectRaw('payment_date, SUM(amount) as total_payment')
            ->groupBy('payment_date')
            ->orderBy('payment_date')
            ->get();

        $highPayments = Payment::selectRaw('payment_date, SUM(amount) as total_payment')
            ->groupBy('payment_date')
            ->orderByRaw('SUM(amount) DESC')
            ->take(5)
            ->get();

        // User paling sering datang
        $firstDayDecember = Carbon::create(2024, 12, 1);
        $lastDayDecember = Carbon::create(2024, 12, 31);

        $frequentVisitor = Attendance::whereBetween('attendance_date', [$firstDayDecember, $lastDayDecember])
            ->selectRaw('user_id, COUNT(*) as visit_count')
            ->groupBy('user_id')
            ->orderByDesc('visit_count')
            ->get();

        // Mengambil username dari tabel User untuk frequentVisitor
        $frequentVisitorWithUsernames = $frequentVisitor->map(function ($visitor) {
            $user = User::find($visitor->user_id);
            $visitor->username = $user ? $user->username : null; // Menambahkan username ke setiap data visitor
            return $visitor;
        });

        // User dengan durasi paling lama
        $longestDurationUser = Attendance::whereBetween('attendance_date', [$firstDayDecember, $lastDayDecember])
            ->selectRaw('user_id, SUM(duration) as total_duration')
            ->groupBy('user_id')
            ->orderByDesc('total_duration')
            ->get();

        // Mengambil username dari tabel User untuk longestDurationUser
        $longestDurationUserWithUsernames = $longestDurationUser->map(function ($user) {
            $userData = User::find($user->user_id);
            $user->username = $userData ? $userData->username : null; // Menambahkan username ke setiap data user
            return $user;
        });

        // Menyiapkan data untuk grafik
        $paymentDates = $payments->pluck('payment_date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        });

        $paymentTotals = $payments->pluck('total_payment');
        $highPaymentDates = $highPayments->pluck('payment_date')->map(function ($date) {
            return Carbon::parse($date)->format('d-m-Y');
        });
        $highPaymentTotals = $highPayments->pluck('total_payment');

        // Menyiapkan data user untuk grafik
        $visitorUsernames = $frequentVisitorWithUsernames->pluck('username');
        $visitCounts = $frequentVisitorWithUsernames->pluck('visit_count');
        $durationUsernames = $longestDurationUserWithUsernames->pluck('username');
        $totalDurations = $longestDurationUserWithUsernames->pluck('total_duration');

        return view('home', [
            'title' => 'Beranda',
            'payments' => $payments,
            'highPayments' => $highPayments,
            'paymentDates' => $paymentDates,
            'paymentTotals' => $paymentTotals,
            'highPaymentDates' => $highPaymentDates,
            'highPaymentTotals' => $highPaymentTotals,
            'visitorUsernames' => $visitorUsernames,
            'visitCounts' => $visitCounts,
            'durationUsernames' => $durationUsernames,
            'totalDurations' => $totalDurations
        ]);
    }
}
