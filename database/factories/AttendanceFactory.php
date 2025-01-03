<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
     public function definition(): array
    {
        $user = User::inRandomOrder()->first(); 
        return [
            'user_id' => $user->id,
            'image_url' => $this->faker->imageUrl(200, 200, 'people'),
            'location' => $this->faker->address
        ];
    }
}
