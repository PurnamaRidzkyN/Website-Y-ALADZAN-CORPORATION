<?php

namespace App\Models;

use App\Models\User;
use App\Models\CategoryExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'date',
        'amount',
        'category_id',
        'description',
        'method',
        'image_url',
    ];

    public function categoryExpense(): BelongsTo
    {
        return $this->belongsTo(CategoryExpense::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming Admin model is used for 'admins' table
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id'); // Assuming Admin model is used for 'admins' table
    }
}
