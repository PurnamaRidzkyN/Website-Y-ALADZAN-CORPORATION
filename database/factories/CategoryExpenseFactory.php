<?php

namespace Database\Factories;

use App\Models\CategoryExpense;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryExpenseFactory extends Factory
{
    protected $model = CategoryExpense::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Generates a random name for category
        ];
    }
}
