<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <style>
        input[type="date"] {
            color: white;
            /* Warna teks input */
            background-color: #374151;
            /* Warna latar belakang */
            border: 1px solid #4B5563;
            /* Warna border */
            padding: 8px;
            border-radius: 6px;
        }

        /* Ubah ikon kalender jadi putih */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery dan jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <div class="mx-auto mt-8 bg-gray-900 min-h-screen p-6">
        <h2 class="text-2xl font-bold text-white">Report Filter</h2>

        <form method="GET" action="{{ route('reports.attendances') }}" class="mb-6 flex space-x-4 items-center">
            <!-- Input Username -->
            <input type="text" id="username" name="username" value="{{ request('username') }}"
                placeholder="Cari nama pengguna..."
                class="p-2 rounded bg-gray-700 text-white border border-gray-500 placeholder-white">

            <!-- Input Tanggal dengan Ikon -->
            <div class="relative">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="p-2 pl-10 rounded bg-gray-700 text-white border border-gray-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <!-- Tombol Filter -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Filter
            </button>

            <!-- Tombol Reset -->
            <a href="{{ route('reports.attendances') }}"
                class="bg-red-500 text-white p-2 rounded hover:bg-red-600 text-center">
                Reset
            </a>
        </form>



        <hr class="my-6 border-gray-600">

        <h3 class="text-xl font-semibold text-white">Data</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-gray-800 text-white rounded-lg shadow-md">
                <thead>
                    <tr class="text-left">
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Jam Masuk</th>
                        <th class="px-4 py-2">Jam Keluar</th>
                        <th class="px-4 py-2">Lama Tinggal</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr class="border-t border-gray-700">
                            <td class="px-4 py-2">{{ $row->user->username }}</td>
                            <td class="px-4 py-2">{{ $row->entry_time }}</td>
                            <td class="px-4 py-2">{{ $row->exit_time }}</td>
                            <td class="px-4 py-2"> {{ floor($row->duration / 60) }} jam {{ $row->duration % 60 }} menit
                            </td>
                            <td class="px-4 py-2">{{ $row->description }}</td>
                            <td class="px-4 py-2">
                                {{ $row->attendance_date ? \Carbon\Carbon::parse($row->attendance_date)->format('d M Y') : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr class="my-6 border-gray-600">
    <script>
        $(document).ready(function() {
            var usernames = @json($usernames); // Ambil data dari Blade ke JavaScript

            $("#username").autocomplete({
                source: usernames, // Pakai array dari backend langsung
                minLength: 1
            });
        });
    </script>

</x-layouts>
