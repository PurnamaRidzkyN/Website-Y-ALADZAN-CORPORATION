<?php
// app/Models/Code.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'bonus',
        'code'
    ];

    // Relasi satu code memiliki banyak loan
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
