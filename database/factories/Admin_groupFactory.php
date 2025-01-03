<?php

namespace Database\Factories;

use App\Models\admin;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class Admin_groupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id'=> Admin::class,
            'groups_id' => Groups::class 
        ];
    }
}
