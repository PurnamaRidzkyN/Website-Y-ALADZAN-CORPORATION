<?php

namespace App\Models;

use App\Models\User;
use App\Models\CategoryExpense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'date',
        'amount',
        'id_category',
        'description',
        'method',
        'image_url',
    ];

    public function categoryExpense()
    {
        return $this->belongsTo(CategoryExpense::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming Admin model is used for 'admins' table
    }
}
