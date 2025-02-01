<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reportController extends Controller
{
    //use Illuminate\Support\Facades\DB;

    public function getBonuses($group_id, $manager_id)
    {
        $data = DB::select("
        SELECT 
            l.name, 
            c.code, 
            c.manager_bonuses, 
            a.name
        FROM loans l 
        JOIN admin_groups ag ON l.admin_group_id = ag.id
        JOIN codes c ON l.codes_id = c.id 
        JOIN admins a ON ag.admin_id = a.id 
        WHERE ag.group_id = ? AND a.manager_id = ?

        UNION ALL

        SELECT 
            'TOTAL', 
            NULL, 
            SUM(c.manager_bonuses), 
            NULL
        FROM loans l 
        JOIN admin_groups ag ON l.admin_group_id = ag.id
        JOIN codes c ON l.codes_id = c.id 
        JOIN admins a ON ag.admin_id = a.id
        WHERE ag.group_id = ? AND a.manager_id = ?
    ", [$group_id, $manager_id, $group_id, $manager_id]);

        return response()->json($data);
    }
}
