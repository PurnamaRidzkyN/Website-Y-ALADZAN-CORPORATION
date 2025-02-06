<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bonus_id',
        'salary',
        'foto',
        'phone'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function bonuses(): BelongsTo
    {
        return $this->belongsTo(Bonuses::class, 'bonus_id');
    }
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
