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
        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->tinyInteger('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken(); // hanya untuk tabel users
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Tabel Admins
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan relasi ke tabel users
            $table->string('name');
            $table->string('foto')->nullable();
            $table->integer('salary');
            $table->integer('bonus')->default(0);
            $table->string('phone');
        });

        // Tabel Managers
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan relasi ke tabel users
            $table->string('name');
            $table->string('phone');
            $table->string('foto')->nullable();
            $table->timestamps();


        });

        // Tabel Attendance
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan relasi ke tabel users
            $table->string('location');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Tabel Groups
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });

        // Tabel AdminGroups
        Schema::create('admin_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_groups');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('managers');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
