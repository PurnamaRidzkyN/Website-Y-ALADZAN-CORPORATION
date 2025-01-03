<?php

namespace App\Models;

use App\Models\Admin;
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
        return $this->belongsTo(CategoryExpense::class, 'id_category');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'id_user'); // Assuming Admin model is used for 'admins' table
    }
}
