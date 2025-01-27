<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        $user = User::inRandomOrder()->first();
        $entryTime = Carbon::createFromFormat('H:i:s', $this->faker->time('H:i:s'));
        $exitTime = Carbon::createFromFormat('H:i:s', $this->faker->time('H:i:s'));

        return [
            'user_id' => $user->id,
            'image_url' => $this->faker->imageUrl(), // URL gambar palsu
            'description' => $this->faker->sentence(),
            'entry_time' => $entryTime->format('H:i:s'), // Waktu masuk
            'duration' => $exitTime->diffInMinutes($entryTime), // Durasi dalam menit
            'exit_time' => $exitTime->format('H:i:s'),  // Waktu keluar
            'attendance_date' => Carbon::now()->subMonths(rand(1, 6))->format('Y-m-d'),  // Tanggal absensi 6 bulan kebelakang
        ];
    }
}
