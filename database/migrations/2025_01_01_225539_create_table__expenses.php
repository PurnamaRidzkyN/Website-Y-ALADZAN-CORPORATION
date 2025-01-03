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
        // Tabel Category Expense
        Schema::create('category_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Expense
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('admins'); // Menggunakan foreignId untuk relasi ke admins
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->foreignId('id_category')->constrained('category_expenses'); // Menggunakan foreignId untuk relasi ke category_expenses
            $table->text('description')->nullable();
            $table->string('method');
            $table->string('image_url')->nullable();
            $table->timestamps(); // Menambahkan kolom timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('category_expenses');
    }
};
