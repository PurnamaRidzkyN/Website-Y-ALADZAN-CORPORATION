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
        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->tinyInteger('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken(); // Hanya untuk tabel users
            $table->timestamps();
        });

        // Tabel Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel Sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('used_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->timestamps(); // Tambahkan kolom timestamps jika diperlukan
        });
    
        
            // Create the trigger function to calculate remaining_amount
            DB::unprepared('
                CREATE OR REPLACE FUNCTION calculate_remaining_amount()
                RETURNS TRIGGER AS $$
                BEGIN
                    NEW.remaining_amount := NEW.total_amount - NEW.used_amount;
                    RETURN NEW;
                END;
                $$ LANGUAGE plpgsql;
            ');
        
            // Attach the trigger to bonuses table
            DB::unprepared('
                CREATE TRIGGER trigger_calculate_remaining_amount
                BEFORE INSERT OR UPDATE ON bonuses
                FOR EACH ROW
                EXECUTE FUNCTION calculate_remaining_amount();
            ');
        

        // Tabel Admins
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->string('name');
            $table->string('foto')->nullable();
            $table->integer('salary');
            $table->foreignId('bonus_id')->constrained('bonuses')->onDelete('cascade'); // Relasi ke bonuses
            $table->string('phone');
            $table->timestamps();
        });

        // Tabel Managers
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->string('name');
            $table->string('phone');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Tabel Attendance
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->string('location');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Tabel Groups
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps(); // Tambahkan timestamps
        });

        // Tabel AdminGroups
        Schema::create('admin_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_calculate_remaining_amount ON bonuses');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_remaining_amount');
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
