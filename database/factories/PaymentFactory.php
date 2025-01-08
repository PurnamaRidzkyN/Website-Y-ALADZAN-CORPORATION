<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        $loan = Loan::inRandomOrder()->first(); 

        return [
            'loan_id' => $loan->id,  // Link to the Loan model
            'amount' => $this->faker->randomFloat(2, 1000000, 5000000),
            'payment_date' => $this->faker->date,
            'method' => $this->faker->word,
            'description' => $this->faker->text,
            'image_url' => $this->faker->imageUrl,
        ];
    }
}
