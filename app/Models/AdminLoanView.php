<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLoanView extends Model
{
    // file: app/Models/AdminGroupSummary.php

    protected $table = 'admin_loan_view'; // Nama view
    public $timestamps = false; // karena view tidak memerlukan timestamp

}
