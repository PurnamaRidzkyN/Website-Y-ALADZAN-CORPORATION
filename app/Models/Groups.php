<?php

namespace App\Models;

use App\Models\AdminGroups;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groups extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
    
    public function admin_group():HasMany{
        return $this->hasMany(AdminGroups::class);
    }
    
}
