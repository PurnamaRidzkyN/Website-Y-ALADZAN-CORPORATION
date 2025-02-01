<?php

namespace Database\Factories;

use App\Models\Bonuses;
use App\Models\Manager;
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
        $manager = Manager::inRandomOrder()->first(); 
        return [
            'user_id' => User::factory(), // Relasi ke User
            'manager_id' =>$manager->id,
            'name' => $this->faker->name,
            'foto' => 'https://randomuser.me/api/portraits/men/' . $this->faker->numberBetween(1, 100) . '.jpg',
            'salary' => $this->faker->numberBetween(5000000, 10000000),
            'bonus_id' => Bonuses::factory(),
            'phone' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
   
}
