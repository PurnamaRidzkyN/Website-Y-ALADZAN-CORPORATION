<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Bonuses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Relasi ke User
            'name' => $this->faker->name,
            'salary' => $this->faker->numberBetween(5000000, 10000000),
            'bonus_id' => Bonuses::factory(),
            'foto' => 'https://randomuser.me/api/portraits/men/' . $this->faker->numberBetween(1, 100) . '.jpg',
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
