<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Manager::factory(2)->recycle([
            User::factory(2)->create()
        ])->create();
        
        Admin::factory(10)->recycle([
            User::factory(10)->create()
        ])->create();
        
    }
}
