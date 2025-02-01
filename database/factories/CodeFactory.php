<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bonuses>
 */
class CodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique->word(),
            'admin_bonuses' => $this->faker->numberBetween( 10000, 100000), 
            'manager_bonuses' => $this->faker->numberBetween( 10000, 100000), 
            'capital' => $this->faker->numberBetween( 10000, 100000), 
        ];
    }
}
