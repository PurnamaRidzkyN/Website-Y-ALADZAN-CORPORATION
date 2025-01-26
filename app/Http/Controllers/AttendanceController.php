<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function recordAttendance(Request $request)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Lokasi tujuan (contoh koordinat lat-long)
        $targetLatitude = -7.123456;  // Ganti dengan latitude tujuan
        $targetLongitude = 112.123456;  // Ganti dengan longitude tujuan

        // Ambil data latitude dan longitude dari request
        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        // Hitung jarak antara lokasi pengguna dan lokasi tujuan menggunakan Haversine Formula
        $distance = $this->calculateDistance($userLatitude, $userLongitude, $targetLatitude, $targetLongitude);

        // Misalkan batas toleransi jarak 300 meter (0.3 km)
        if ($distance > 0.3) {  // 0.3 km = 300 meter
            return response()->json(['message' => 'Lokasi Anda terlalu jauh dari tujuan.'], 400);
        }

        // Jika lokasi valid, simpan absensi
        $attendance = new Attendance();
        $attendance->user_id = Auth::id();
        $attendance->location = 'Nama Lokasi';  // Bisa diambil dari lokasi tertentu
        $attendance->attendance_date = now()->toDateString();
        $attendance->entry_time = now()->toTimeString();
        $attendance->save();

        return response()->json(['message' => 'Absensi berhasil!']);
    }

    // Fungsi untuk menghitung jarak menggunakan Haversine Formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Jari-jari bumi dalam kilometer

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;  // Mengembalikan jarak dalam kilometer
    }
}
