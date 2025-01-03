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
        $group = Groups::inRandomOrder()->first(); 
        $admin = Admin::inRandomOrder()->first(); 
        return [
            'group_id' => $group->id,
            'admin_id' => $admin->id,
        ];
    }
}
