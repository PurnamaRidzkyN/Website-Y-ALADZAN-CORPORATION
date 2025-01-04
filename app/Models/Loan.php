<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_admin',
        'name',
        'description',
        'loan_date',
        'total_amount',
        'total_payment',
        'outstanding_amount',
        'phone',
        'codes_id',
    ];

    /**
     * Relationship: Loan belongs to an Admin.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relationship: Loan has many payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'loan_id');
    }

    /**
     * Relationship: Loan belongs to a Code.
     */
    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'codes_id');
    }
}
