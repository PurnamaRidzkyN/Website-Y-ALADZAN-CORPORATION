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
    COALESCE(SUM(l.total_payment), 0) AS total_payments,
    COALESCE(SUM(l.total_amount), 0) AS total_amount,
    COALESCE(SUM(l.total_payment) / NULLIF(SUM(l.total_amount), 0), 0) AS payment_to_amount_ratio
FROM 
    admin_groups ag
JOIN 
    admins a ON ag.admin_id = a.id
LEFT JOIN 
    loans l ON ag.id = l.admin_group_id
GROUP BY 
    ag.group_id, ag.admin_id, a.name, a.phone, a.foto;
 ");
    }

    public function down()
    {
        // Drop view jika migration dirollback
        DB::statement("DROP VIEW IF EXISTS admin_loan_view");
    }
};
