<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bonuses>
 */
class BonusesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_amount' => $this->faker->randomFloat(2, 100, 10000), 
            'used_amount' => $this->faker->randomFloat(2, 0, 10000)
        ];
    }
}
