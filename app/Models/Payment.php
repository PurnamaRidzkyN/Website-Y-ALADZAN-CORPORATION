<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'method',
        'description',
    ];

    protected static function booted()
    {
        static::created(function ($payment) {
            // Update total_payment dan outstanding_amount pada Loan setelah Payment ditambahkan
            $loan = $payment->loan;
            $totalPayment = $loan->payments->sum('amount');
            $loan->update([
                'total_payment' => $totalPayment,
                'outstanding_amount' => $loan->total_amount - $totalPayment,
            ]);
        });
    }
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
