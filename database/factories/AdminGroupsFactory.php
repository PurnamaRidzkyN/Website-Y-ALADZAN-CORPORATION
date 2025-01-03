<?php

namespace Database\Factories;

use App\Models\AdminGroups;
use App\Models\Groups;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminGroupsFactory extends Factory
{
    protected $model = AdminGroups::class;

    public function definition()
    {
        return [
            'group_id' => Groups::factory(),
            'admin_id' => Admin::factory(),
        ];
    }
}
