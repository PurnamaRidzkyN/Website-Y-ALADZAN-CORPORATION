<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\admin;
use App\Models\AdminGroups;
use App\Models\Attendance;
use App\Models\Bonuses;
use App\Models\CategoryExpense;
use App\Models\Code;
use App\Models\Expense;
use App\Models\Groups;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $gwh =User::create([
            'name' => 'Purnama',
            'username' => 'PurnamaManajer',
            'email' => 'purnamaA@gmail.com',
            'password' => Hash::make('purnama'),
            'role' => 1 
        ]);
        Manager::factory(2)->recycle([
            $gwh,
            User::factory(2)->create()
        ])->create();

        $gwh =User::create([
            'name' => 'Purnama',
            'username' => 'PurnamaAdmin',
            'email' => 'purnamaM@gmail.com',
            'password' => Hash::make('purnama'),
            'role' => 1 
        ]);
        Admin::factory(10)->recycle([
            $gwh,
            User::factory(10)->create(),
            Bonuses::factory(10)->create()
        ])->create();
        Attendance::factory(100)->create();
        Groups::factory(3)->create();
        AdminGroups::factory(40)->create();
        Code::factory(4)->create();
        Expense::factory(6)->recycle([
            CategoryExpense::factory(3)->create()
        ]);
        Loan::factory(30)->create();
        Payment::factory(50)->create();


    }
}
