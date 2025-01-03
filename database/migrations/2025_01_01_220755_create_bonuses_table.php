<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Bonuses
       
        
        
        // Tabel Codes
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Menggunakan unique constraint untuk code
            $table->decimal('bonus', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
