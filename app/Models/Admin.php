<?php

namespace App\Models;

use App\Models\User;
use App\Models\AdminGroups;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\UsersFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'foto',
        'salary',
        'phone',
        'bonus_id'
    ];

    public function user():BelongsTo{
    return $this->belongsTo( User::class);
    }
    public function admin_group():HasMany{
        return $this->hasMany(AdminGroups::class);
    }
    public function bonuses():BelongsTo{
        return $this->belongsTo(Bonuses::class,'bonus_id');
    }
    public function expenses() : HasMany {
        return $this->hasMany(Expense::class);
    }
}
