<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Admin;
use App\Models\Code;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        $admin = Admin::inRandomOrder()->first(); 
        $code = Code::inRandomOrder()->first(); 

        return [
            'admin_id' => $admin->id,  // Assuming Admin factory is defined
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'loan_date' => $this->faker->date,
            'total_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'total_payment' => 0,
            'outstanding_amount' => 0,
            'phone' => $this->faker->phoneNumber,
            'codes_id' => $code->id,  // Assuming Code factory is defined
        ];
    }
}
