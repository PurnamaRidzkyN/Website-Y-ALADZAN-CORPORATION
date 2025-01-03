<?php

namespace App\Models;

use App\Models\User;
use App\Models\AdminGroups;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\UsersFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'image_url'
    ];

    public function user():BelongsTo{
    return $this->belongsTo( User::class);
    }
 
    
}
