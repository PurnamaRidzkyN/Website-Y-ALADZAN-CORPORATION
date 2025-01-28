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
            $table->foreignId('admin_group_id')->constrained('admin_groups')->onDelete('cascade');; // Menggunakan foreignId untuk relasi
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('loan_date');
            $table->integer('total_amount');
            $table->integer('total_payment')->default(0);
            $table->integer('outstanding_amount');
            $table->string('phone')->nullable();
            $table->foreignId('codes_id')->constrained('codes')->onDelete('cascade');; // Menggunakan foreignId untuk relasi ke tabel codes
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');; // Menggunakan foreignId untuk relasi ke tabel loans
            $table->integer('amount');
            $table->date('payment_date');
            $table->string('method');
            $table->text('description')->nullable();
            $table->timestamps(); // Menambahkan kolom timestamps
        });

        // Tabel Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message_header');
            $table->text('message_footer');
            $table->timestamps(); // Menggunakan timestamp untuk waktu yang lebih fleksibel
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
