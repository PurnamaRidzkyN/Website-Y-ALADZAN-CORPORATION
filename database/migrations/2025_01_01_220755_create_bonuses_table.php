<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Bonuses
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('admins'); // Menggunakan foreignId yang lebih jelas
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('used_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->timestamps(); // Tambahkan kolom timestamps jika diperlukan
        });

        // Tabel Codes
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Menggunakan unique constraint untuk code
            $table->decimal('bonus', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
        Schema::dropIfExists('codes');
    }
};
