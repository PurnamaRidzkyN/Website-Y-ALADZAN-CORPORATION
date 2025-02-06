<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Bonuses;
use App\Models\Groups;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class reportController extends Controller
{
    public function showReports()
    {

        return view('reports', ['title' => 'Laporan']);
    }
    public function showBonuses(Request $request)
    {
        $searchQuery = $request->input('search_manager');

        $managers = Manager::query()
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhereHas('user', function ($q) use ($searchQuery) {
                        $q->where('email', 'like', "%{$searchQuery}%")
                            ->orWhere('username', 'like', "%{$searchQuery}%");
                    });
            })
            ->orderBy('name', 'asc') // Mengurutkan berdasarkan nama dari A ke Z
            ->get();
        $title = 'Laporan Bonus';

        // Return view with data
        return view('reportBonuses', compact('title', 'managers'));
    }
    public function checkReportBonusesManager(Request $request)
    {


        $monthYear = $request->input('month'); // "2025-02"
        $managerId = $request->input('id'); // "1" (manager_id)

        // Pisahkan tahun dan bulan dari format YYYY-MM
        $month = Carbon::parse($monthYear)->month;  // Ambil bulan (02)
        $year = Carbon::parse($monthYear)->year;    // Ambil tahun (2025)

        // Cek apakah ada pengeluaran untuk manajer dan bulan/tahun yang dipilih
        $expense = Expense::where('manager_id', $managerId)
            ->where('category_id', 1)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->first();
        $expenseB = Expense::where('manager_id', $managerId)
            ->where('category_id', 2)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->first();

        $loanDate = $monthYear . '-01';
        $newBonus = DB::table('loans as l')
            ->join('admin_groups as ag', 'l.admin_group_id', '=', 'ag.id')
            ->join('codes as c', 'l.codes_id', '=', 'c.id')
            ->join('admins as a', 'ag.admin_id', '=', 'a.id')
            ->where('a.manager_id', $managerId)
            ->whereRaw("DATE_TRUNC('month', l.loan_date) = ?", [$loanDate])
            ->sum('c.manager_bonuses');

        $previousMonth = Carbon::createFromFormat('Y-m', $monthYear)->subMonth()->format('Y-m');
        $endDate = \Carbon\Carbon::createFromFormat('Y-m', $previousMonth)->endOfMonth()->toDateString();
        $totalBonusPrev = DB::table('loans as l')
            ->join('admin_groups as ag', 'l.admin_group_id', '=', 'ag.id')
            ->join('codes as c', 'l.codes_id', '=', 'c.id')
            ->join('admins as a', 'ag.admin_id', '=', 'a.id')
            ->where('a.manager_id', $managerId)
            ->where('l.loan_date', '<=', $endDate) // Filter sampai tanggal tertentu
            ->sum('c.manager_bonuses');
        Carbon::setLocale('id');
        $monthName = Carbon::parse($monthYear)
            ->isoFormat('MMMM');  // isoFormat dengan 'MMMM' untuk nama bulan penuh
        // Ambil nama bulan
        $bonuses = Bonuses::find(Manager::find($managerId)->bonus_id);

        if ($expense) {
            // Jika ada laporan, arahkan ke halaman lain
            return view('reportBonusesPrint', compact('totalBonusPrev', 'newBonus', 'bonuses', 'expense', 'monthName', 'year', 'expenseB'));
        } else {
            // Jika tidak ada laporan
            return redirect()->route('reports.bonuses')->with([
                'status' => 'danger',
                'message' => 'Laporan tidak ada atau Gaji belum dibayar!',
            ]);
        }
    }


    public function showPayment(Request $request)
    {
        // Ambil parameter dari request
        $admin_id = $request->input('admin_id', null);
        $manager_id = $request->input('manager_id', null);
        $month = $request->input('month', null);
        $year = $request->input('year', null);
        $group = $request->input('group_id', null);
        // Ambil data admin, manager, bulan, dan tahun untuk dropdown
        $admins = DB::table('admins')->orderBy('name')->pluck('name', 'id');
        $managers = DB::table('managers')->orderBy('name')->pluck('name', 'id');
        $groups = DB::table('groups')->orderBy('name')->pluck('name', 'id');
        $months = DB::table('loans')
            ->select(DB::raw("TO_CHAR(loan_date, 'MM') as month"))
            ->distinct()
            ->orderBy(DB::raw("TO_CHAR(loan_date, 'MM')"))
            ->pluck('month');

        $years = DB::table('loans')
            ->select(DB::raw("TO_CHAR(loan_date, 'YYYY') as year"))
            ->distinct()
            ->orderBy(DB::raw("TO_CHAR(loan_date, 'YYYY')"))
            ->pluck('year');

        // Query data berdasarkan filter
        $query = DB::table('loans')
            ->join('codes', 'loans.codes_id', '=', 'codes.id')
            ->join('admin_groups', 'loans.admin_group_id', '=', 'admin_groups.id')
            ->join('groups', 'admin_groups.group_id', '=', 'groups.id')
            ->join('admins', 'admin_groups.admin_id', '=', 'admins.id')
            ->join('managers', 'admins.manager_id', '=', 'managers.id')
            ->select(
                'loans.name as pembayar',
                'groups.name as group_name',
                'admins.name as admin',
                'managers.name as manajer',
                'loans.total_amount as total_harus_dibayar',
                'loans.total_payment as total_dibayar',
                'codes.admin_bonuses',
                'codes.manager_bonuses',
                'codes.capital as modal',
                DB::raw('loans.total_payment - (codes.capital + codes.admin_bonuses + codes.manager_bonuses) as bersih'),
                'loans.loan_date as loan_date'
            )
            ->when($admin_id, function ($query) use ($admin_id) {
                return $query->where('admins.id', $admin_id);
            })
            ->when($manager_id, function ($query) use ($manager_id) {
                return $query->where('managers.id', $manager_id);
            })
            ->when($month, function ($query) use ($month) {
                return $query->whereRaw("TO_CHAR(loans.loan_date, 'MM') = ?", [$month]);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('loans.loan_date', $year);
            })
            ->when($group, function ($query) use ($group) {
                return $query->where('groups.id', $group);
            })
            ->orderByRaw("TO_CHAR(loans.loan_date, 'YYYY-MM') ASC")
            ->get();

        // Total row query
        $totalQuery = DB::table('loans')
            ->join('codes', 'loans.codes_id', '=', 'codes.id')
            ->join('admin_groups', 'loans.admin_group_id', '=', 'admin_groups.id')
            ->join('groups', 'admin_groups.group_id', '=', 'groups.id')
            ->join('admins', 'admin_groups.admin_id', '=', 'admins.id')
            ->join('managers', 'admins.manager_id', '=', 'managers.id')
            ->select(
                DB::raw("'TOTAL' as pembayar"),
                DB::raw("NULL as group_name"),
                DB::raw("NULL as admin"),
                DB::raw("NULL as manajer"),
                DB::raw("SUM(loans.total_amount) as total_harus_dibayar"),
                DB::raw("SUM(loans.total_payment) as total_dibayar"),
                DB::raw("SUM(codes.admin_bonuses) as admin_bonuses"),
                DB::raw("SUM(codes.manager_bonuses) as manager_bonuses"),
                DB::raw("SUM(codes.capital) as modal"),
                DB::raw("SUM(loans.total_payment - (codes.capital + codes.admin_bonuses + codes.manager_bonuses)) as bersih"),
                DB::raw("NULL as loan_date")
            )
            ->when($admin_id, function ($query) use ($admin_id) {
                return $query->where('admins.id', $admin_id);
            })
            ->when($manager_id, function ($query) use ($manager_id) {
                return $query->where('managers.id', $manager_id);
            })
            ->when($month, function ($query) use ($month) {
                return $query->whereRaw("TO_CHAR(loans.loan_date, 'MM') = ?", [$month]);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('loans.loan_date', $year);
            })
            ->when($group, function ($query) use ($group) {
                return $query->where('groups.id', $group);
            })
            ->first();

        // Gabungkan data dan totalnya
        $data = $query->push($totalQuery);

        $title = 'Laporan Pembayaran';
        $groupData = [];
        $adminData = [];
        $managerData = [];
        $date = [];

        // Loop pertama: Ambil semua bulan unik
        foreach ($data as $row) {
            $bulanTahun = date('m-Y', strtotime($row->loan_date)); // Format "MM-YYYY"
            if (!in_array($bulanTahun, $date)) {
                $date[] = $bulanTahun;
            }
        }

        // Loop kedua: Inisialisasi semua data dengan 0
        $groupNames = array_unique(array_map(fn($row) => $row->group_name, $data->toArray()));
        $adminNames = array_unique(array_map(fn($row) => $row->admin, $data->toArray()));
        $managerNames = array_unique(array_map(fn($row) => $row->manajer, $data->toArray()));

        foreach ($groupNames as $group) {
            foreach ($date as $bulan) {
                $groupData[$group][$bulan] = 0;
            }
        }
        foreach ($adminNames as $admin) {
            foreach ($date as $bulan) {
                $adminData[$admin][$bulan] = 0;
            }
        }
        foreach ($managerNames as $manager) {
            foreach ($date as $bulan) {
                $managerData[$manager][$bulan] = 0;
            }
        }

        // Loop ketiga: Isi data sesuai loan_date
        foreach ($data as $row) {
            if ($row->pembayar == 'TOTAL') {
                continue;
            }

            $bulanTahun = date('m-Y', strtotime($row->loan_date));

            // Isi data sesuai bulan-tahun yang ada
            $groupData[$row->group_name][$bulanTahun] += $row->total_dibayar;
            $adminData[$row->admin][$bulanTahun] += $row->total_dibayar;
            $managerData[$row->manajer][$bulanTahun] += $row->total_dibayar;
        }

        // Fungsi untuk mengonversi data ke format Chart.js
        function formatChartData($dataArray)
        {
            $chartData = [];
            foreach ($dataArray as $label => $values) {
                $chartData[] = [
                    'label' => $label,
                    'borderColor' => sprintf('rgb(%d, %d, %d)', rand(0, 255), rand(0, 255), rand(0, 255)),
                    'fill' => false,
                    'data' => array_values($values), // Ambil data dengan bulan yang sudah terurut
                ];
            }
            return $chartData;
        }

        // Konversi data ke format Chart.js
        $groupChartData = formatChartData($groupData);
        $adminChartData = formatChartData($adminData);
        $managerChartData = formatChartData($managerData);
        // Konversi data ke format Chart.js
        // dd($data);
        // Data untuk grafik: Group, Admin, Manager

        return view('reportPembayaran', compact('date', 'adminChartData', 'managerChartData', 'groupChartData', 'data', 'admins', 'managers', 'months', 'years', 'title', 'groups'));
    }
}
