<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_loan',
        'amount',
        'payment_date',
        'method',
        'description',
        'image_url',
    ];

    /**
     * Relationship: Payment belongs to a Loan.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'id_loan');
    }
}
