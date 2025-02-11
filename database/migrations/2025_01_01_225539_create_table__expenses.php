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
            $table->string('role');
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Expense
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Menggunakan foreignId untuk relasi ke admins
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade'); // Menggunakan foreignId untuk relasi ke admins
            $table->foreignId('manager_id')->nullable()->constrained('managers')->onDelete('cascade'); // Menggunakan foreignId untuk relasi ke admins
            $table->date('date');
            $table->integer('amount');
            $table->foreignId('category_id')->constrained('category_expenses')->onDelete('cascade');; // Menggunakan foreignId untuk relasi ke category_expenses
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
