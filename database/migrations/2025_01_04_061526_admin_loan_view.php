<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        // Query untuk membuat view
        DB::statement("
            CREATE VIEW admin_loan_view AS
            SELECT 
                ag.group_id,
                ag.admin_id,
                a.name,
                a.phone,
                a.foto,
                SUM(l.total_payment) AS total_payments,
                SUM(l.total_amount) AS total_amount,
                SUM(l.outstanding_amount) AS outstanding_amount
            FROM 
                admin_groups ag
            JOIN 
                admins a ON ag.admin_id = a.id
            JOIN 
                loans l ON a.id = l.admin_id
            GROUP BY 
                ag.group_id, ag.admin_id, a.name, a.phone,a.foto;
        ");
    }

    public function down()
    {
        // Drop view jika migration dirollback
        DB::statement("DROP VIEW IF EXISTS admin_loan_view");
    }
};
