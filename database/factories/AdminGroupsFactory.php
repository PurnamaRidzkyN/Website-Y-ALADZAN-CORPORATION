<?php

namespace Database\Factories;

use App\Models\AdminGroups;
use App\Models\Groups;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class AdminGroupsFactory extends Factory
{
    protected $model = AdminGroups::class;

    public function definition()
    {
        $faker = \Faker\Factory::create(); // Menggunakan Faker

        // Mendefinisikan rentang ID
        $groups = [1, 2, 3]; // Group ID dari 1 sampai 3
        $admins = range(1, 10); // Admin ID dari 1 sampai 10

        // Menyimpan pasangan yang sudah digunakan
        static $usedCombinations = [];

        // Pilih kombinasi group_id dan admin_id yang belum digunakan
        do {
            $group_id = $faker->randomElement($groups); // Pilih group_id acak dari rentang
            $admin_id = $faker->randomElement($admins); // Pilih admin_id acak dari rentang
        } while (in_array([$group_id, $admin_id], $usedCombinations));

        // Tandai kombinasi yang sudah digunakan
        $usedCombinations[] = [$group_id, $admin_id];

        return [
            'group_id' => $group_id,
            'admin_id' => $admin_id,
        ];
    }
}
