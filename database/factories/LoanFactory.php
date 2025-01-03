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
        return [
            'id_admin' => Admin::factory(),  // Assuming Admin factory is defined
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'loan_date' => $this->faker->date,
            'total_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'total_payment' => 0,
            'outstanding_amount' => $this->faker->randomFloat(2, 1000, 10000),
            'phone' => $this->faker->phoneNumber,
            'codes_id' => Code::factory(),  // Assuming Code factory is defined
        ];
    }
}
