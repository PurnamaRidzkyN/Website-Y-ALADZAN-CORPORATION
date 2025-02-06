<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <main class="min-h-screen bg-gray-800 text-gray-100 p-6">
        @if ($errors->has('location'))
            <div class="alert alert-danger">
                {{ $errors->first('location') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-lg mx-auto bg-gray-900 rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-center text-teal-400 mb-6">Absensi</h1>
            <form action="{{ route('recordAttendance') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Input Keterangan -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-100 mb-2">Keterangan</label>
                    <textarea id="description" name="description" rows="3"
                        class="block w-full text-sm text-gray-100 border border-gray-700 rounded-lg bg-gray-800 focus:ring-teal-400 focus:border-teal-400"
                        placeholder="Tulis keterangan..." required></textarea>
                </div>
                <div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">

                </div>
                <!-- Pilihan Masuk / Keluar -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-100 mb-2">Status</label>
                    <select id="status" name="status"
                        class="block w-full text-sm text-gray-100 border border-gray-700 rounded-lg bg-gray-800 focus:ring-teal-400 focus:border-teal-400"
                        required>
                        <option value="">-- Pilih Status --</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit"
                        class="px-6 py-2 text-sm font-medium text-white bg-teal-400 rounded-lg shadow-md hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                        Kirim Absensi
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Set nilai latitude dan longitude ke form
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                }, function(error) {
                    console.error("Error mendapatkan lokasi: ", error.message);
                });
            } else {
                console.error("Geolocation tidak didukung di browser ini.");
            }
        });
    </script>

</x-layouts>
