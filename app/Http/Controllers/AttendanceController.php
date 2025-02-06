<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showAttendance()
    {
        return view('absensi', ['title' => 'Absensi']);
    }
    public function recordAttendance(Request $request)
    {
        try {
            $request->validate([
                'description' => 'required|string',
                'status' => 'required|in:masuk,keluar',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            // Lokasi tujuan
            $targetLatitude = -7.100906;
            $targetLongitude = 107.4625217;

            $userLatitude = $request->latitude;
            $userLongitude = $request->longitude;

            $distance = $this->calculateDistance($userLatitude, $userLongitude, $targetLatitude, $targetLongitude);

            if ($distance > 0.05) {
                return redirect()->route('attendance')->withErrors([
                    'location' => 'Lokasi Anda terlalu jauh dari tujuan. Jarak: ' . round($distance, 2) . ' km',
                ]);
            }

            $userId = Auth::id();
            $attendanceDate = now()->toDateString();

            if ($request->status === 'masuk') {
                $existingAttendance = Attendance::where('user_id', $userId)
                    ->where('attendance_date', $attendanceDate)
                    ->first();

                if ($existingAttendance) {
                    return redirect()->route('attendance')->withErrors([
                        'status' => 'Anda sudah melakukan absensi masuk hari ini.',
                    ]);
                }

                $attendance = new Attendance();
                $attendance->user_id = $userId;
                $attendance->description = $request->description;
                $attendance->attendance_date = $attendanceDate;
                $attendance->entry_time = now()->toTimeString();
                $attendance->exit_time = null;
                $attendance->duration = null; // Kosongkan lama masuk
                $attendance->save();

                return redirect()->route('attendance')->with('success', 'Absensi masuk berhasil disimpan.');
            } elseif ($request->status === 'keluar') {
                $attendance = Attendance::where('user_id', $userId)
                    ->where('attendance_date', $attendanceDate)
                    ->first();

                if (!$attendance) {
                    return redirect()->route('attendance')->withErrors([
                        'status' => 'Anda bahkan belum melakukan absensi masuk hari ini.',
                    ]);
                }

                if ($attendance->exit_time) {
                    return redirect()->route('attendance')->withErrors([
                        'status' => 'Anda sudah melakukan absensi keluar hari ini.',
                    ]);
                }

                $exitTime = now();
                $entryTime = Carbon::createFromTimeString($attendance->entry_time);

                // Hitung lama masuk dalam menit
                $duration = $entryTime->diffInMinutes($exitTime);

                $attendance->exit_time = $exitTime->toTimeString();
                $attendance->image_url = $request->file('photo')->store('attendance_photos', 'public');
                $attendance->duration = $duration;
                $attendance->save();

                return redirect()->route('attendance')->with('success', 'Absensi keluar berhasil disimpan.');
            }

            return redirect()->route('attendance')->withErrors(['status' => 'Status absensi tidak valid.']);
        } catch (\Exception $e) {
            // Tangani jika terjadi danger
            return redirect()->back()->withInput()->with([
                'status' => 'danger',
                'message' => 'Gagal menambahkan Absensi. Silakan coba lagi.' ,
            ]);
        }
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
