<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bonuses extends Model
{
    use HasFactory;
    protected $fillable=['total_amount','used_amount'];

    public function admin():HasOne{
        return $this->hasOne( Admin::class);
        }

}
