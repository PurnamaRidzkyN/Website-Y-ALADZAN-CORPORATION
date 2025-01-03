<?php

namespace Database\Factories;

use App\Models\Bonuses;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdminFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

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
            'salary' => $this->faker->numberBetween(5000000, 10000000),
            'bonus_id' => Bonuses::factory(),
            'phone' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
   
}
