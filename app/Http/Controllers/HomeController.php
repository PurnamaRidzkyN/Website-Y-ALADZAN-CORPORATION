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
        $payments = Payment::selectRaw('
        EXTRACT(MONTH FROM payments.payment_date) as month,
        EXTRACT(YEAR FROM payments.payment_date) as year,
        SUM(payments.amount) as total_payment,
        groups.name as group_name
    ')
            ->join('loans', 'payments.loan_id', '=', 'loans.id')
            ->join('admin_groups', 'loans.admin_group_id', '=', 'admin_groups.id')
            ->join('groups', 'admin_groups.group_id', '=', 'groups.id') // Join ke tabel groups
            ->groupBy('year', 'month', 'groups.name')
            ->orderByRaw('year ASC, month ASC')
            ->get();


        $paymentData = $payments->groupBy('group_name')->map(function ($groupPayments) {
            return [
                'labels' => $groupPayments->map(fn($p) => sprintf('%02d', $p->month) . '-' . $p->year), // Format: MM-YYYY
                'totals' => $groupPayments->pluck('total_payment'),
            ];
        });




        $highPayments = Payment::selectRaw('EXTRACT(MONTH FROM payment_date) as month, EXTRACT(YEAR FROM payment_date) as year, SUM(amount) as total_payment')
            ->groupBy('year', 'month')
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
            ->with('user') // Relasi Eloquent
            ->get();

        $frequentVisitorWithUsernames = $frequentVisitor->map(function ($visitor) {
            $visitor->username = $visitor->user->username ?? null;
            return $visitor;
        });

        // User dengan durasi paling lama
        $longestDurationUser = Attendance::whereBetween('attendance_date', [$firstDayDecember, $lastDayDecember])
            ->selectRaw('user_id, SUM(duration) as total_duration')
            ->groupBy('user_id')
            ->orderByDesc('total_duration')
            ->with('user') // Relasi Eloquent
            ->get();

        $longestDurationUserWithUsernames = $longestDurationUser->map(function ($user) {
            $user->username = $user->user->username ?? null;
            return $user;
        });


        $paymentTotals = $payments->pluck('total_payment');

        $highPaymentDates = $highPayments->map(function ($payment) {
            return sprintf('%02d', $payment->month) . '-' . $payment->year; // Format Bulan-Tahun
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
            'paymentData' => $paymentData,
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
