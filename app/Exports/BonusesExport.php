<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class BonusesExport implements FromCollection, WithHeadings
{
    protected $group_id;
    protected $manager_id;
    protected $month;
    protected $year;

    public function __construct($group_id, $manager_id, $month, $year)
    {
        $this->group_id = $group_id;
        $this->manager_id = $manager_id;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $query = DB::table('loans')
            ->join('admin_groups', 'loans.admin_group_id', '=', 'admin_groups.id')
            ->join('codes', 'loans.codes_id', '=', 'codes.id')
            ->join('admins', 'admin_groups.admin_id', '=', 'admins.id')
            ->select('loans.name', 'codes.code', 'codes.manager_bonuses', 'admins.name as manager_name', 'loans.created_at');

        // Apply filters if set
        if ($this->group_id) {
            $query->where('admin_groups.group_id', $this->group_id);
        }
        if ($this->manager_id) {
            $query->where('admins.manager_id', $this->manager_id);
        }
        if ($this->month) {
            // Format month as 'YYYY-MM' and filter using to_char function in PostgreSQL
            $query->whereRaw("to_char(loans.created_at, 'YYYY-MM') = ?", [$this->month]);
        }
        if ($this->year) {
            $query->whereYear('loans.created_at', $this->year);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Name', 'Code', 'Manager Bonus', 'Manager Name', 'Date'];
    }
}
