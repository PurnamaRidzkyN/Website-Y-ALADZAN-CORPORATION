<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Groups;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminGroups extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'group_id'       
    ];

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Groups::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
