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
        // Tabel Loans
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_group_id')->constrained('admin_groups'); // Menggunakan foreignId untuk relasi
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('loan_date');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('total_payment', 15, 2)->default(0);
            $table->decimal('outstanding_amount', 15, 2);
            $table->string('phone')->nullable();
            $table->foreignId('codes_id')->constrained('codes'); // Menggunakan foreignId untuk relasi ke tabel codes
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans'); // Menggunakan foreignId untuk relasi ke tabel loans
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->string('method');
            $table->text('description')->nullable();
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('message');
            $table->timestamp('time'); // Menggunakan timestamp untuk waktu yang lebih fleksibel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('messages');
    }
};
