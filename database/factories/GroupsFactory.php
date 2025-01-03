<?php

namespace Database\Factories;

use App\Models\Groups;
use App\Models\AdminGroups;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupsFactory extends Factory
{
    protected $model = Groups::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }

    /**
     * Define the relationship with AdminGroups.
     */
    public function withAdminGroups($count = 1)
    {
        return $this->has(AdminGroups::factory()->count($count), 'admin_group');
    }
}
