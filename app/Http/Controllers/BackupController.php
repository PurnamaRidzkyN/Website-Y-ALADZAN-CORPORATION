<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Debugbar\Twig\Extension\Dump;

class BackupController extends Controller
{
    public function backupDatabase()
    {
        try {
            // Konfigurasi database dari .env
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');
            $port = env('DB_PORT');

            // Nama file backup
            $backupFileName = "backup_" . date('Y-m-d_H-i-s') . ".sql";
            $backupFilePath = storage_path('app/public/backup/' . $backupFileName);

            // Pastikan direktori backup ada, buat jika tidak ada
            if (!file_exists(storage_path('app/public/backup/'))) {
                mkdir(storage_path('app/public/backup/'), 0777, true); // Membuat folder jika belum ada
            }

            // Path ke pg_dump yang didefinisikan di .env
            $pathPg_dump = env('PG_DUMP_PATH');

            // Perintah pg_dump untuk backup database
            $command = "set PGPASSWORD={$password} && pg_dump -h {$host} -p {$port} -U {$username} -d {$database} --clean -F p -f \"{$backupFilePath}\"";

            // Debug output
            Log::debug("Executing command: " . $command); // Cek command yang sebenarnya dieksekusi

            // Eksekusi perintah
            exec($command, $output, $returnVar);
            // Log hasil eksekusi
            Log::debug('Return Code: ' . $returnVar);
            Log::debug('Output: ' . implode("\n", $output));

            if ($returnVar != 0) {
                Log::error('Backup failed: ' . implode("\n", $output));
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat backup database.']);
            }

            // Kirim file sebagai unduhan dan hapus setelah dikirim
            return response()->download($backupFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Tangani jika ada error dalam proses backup
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function restoreDatabase(Request $request)
    {
        try {
            // Ambil file dari request
            $file = $request->file('backup_file');

            // Memeriksa apakah file ada dan valid
            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File backup tidak valid.',
                ], 400);
            }

            // Ambil ekstensi file
            $extension = $file->getClientOriginalExtension();

            // Cek apakah file memiliki ekstensi .sql atau .dump (untuk file format pg_dump)
            if (!in_array($extension, ['sql', 'dump'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'File harus memiliki ekstensi .sql atau .dump.',
                ], 400);
            }

            // Menyimpan file di direktori sementara
            $tempPath = storage_path('app/temp_backup/' . $file->getClientOriginalName());

            // Pastikan direktori tujuan ada
            if (!file_exists(storage_path('app/temp_backup'))) {
                mkdir(storage_path('app/temp_backup'), 0777, true);
            }

            // Pindahkan file yang diupload ke direktori sementara
            $file->move(storage_path('app/temp_backup'), $file->getClientOriginalName());

            // Ambil path file yang sudah dipindahkan
            $filePath = $tempPath;

            // Memastikan file dapat ditemukan
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File backup tidak ditemukan.',
                ], 400);
            }

            // Konfigurasi database dari .env
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '5432');

            // Escape path file untuk menangani spasi dan karakter khusus
            $escapedFilePath = escapeshellarg($filePath);

            // Command untuk restore menggunakan pg_restore
            $command = "set PGPASSWORD={$password} && psql -h {$host} -p {$port} -U {$username} -d {$database} -f {$escapedFilePath}";

            // Eksekusi command
            exec($command, $output, $returnVar);

            // Cek hasil eksekusi command
            if ($returnVar !== 0) {


                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat restore database.',
                    'output' => implode("\n", $output),  // Menyertakan output untuk debugging
                ], 500);
            }

            // Hapus file backup setelah berhasil
            unlink($filePath);

            return redirect()->back()->with('success', 'Data berhasil direstore');
        } catch (\Exception $e) {
            // Menangkap dan mengembalikan error
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
