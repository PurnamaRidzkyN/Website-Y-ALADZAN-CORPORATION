<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\user; // Assuming Admin model is used for 'admins' table
use App\Models\CategoryExpense;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        $user = user::inRandomOrder()->first(); 

        return [
            'user_id' => $user->id, // Generates a random Admin ID
            'admin_id' => null, // Generates a random Admin ID
            'date' => $this->faker->date, // Generates a random date
            'amount' => $this->faker->numberBetween( 10000, 100000),
            'category_id' => CategoryExpense::factory(), // Generates a random CategoryExpense ID
            'description' => $this->faker->text, // Generates a random description
            'method' => $this->faker->word, // Generates a random payment method
            'image_url' => $this->faker->imageUrl, // Generates a random image URL
        ];
    }
}
