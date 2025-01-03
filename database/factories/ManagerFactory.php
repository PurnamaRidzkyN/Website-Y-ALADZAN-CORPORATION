<?php

namespace Database\Factories;

use App\Models\User;
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
            'foto' => $this->faker->imageUrl(200, 200, 'people'),
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
