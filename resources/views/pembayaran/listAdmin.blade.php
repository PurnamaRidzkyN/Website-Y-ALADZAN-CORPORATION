<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 d-flex justify-content-between">
                <!-- Tombol Kembali dengan Logo -->
                <a href="{{ url()->previous() }}"
                    class="px-6 py-3 bg-[#3182CE] text-white rounded-lg transition-all hover:bg-[#003366] d-flex items-center">
                    <!-- Ikon SVG untuk Kembali -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>

                <!-- Tombol Search di Samping -->
                <div class="d-flex">
                    <input type="text" class="form-control mr-3" id="searchInput" placeholder="Cari..."
                        aria-label="Search" onkeyup="searchFunction()">
                    <button class="px-6 py-3 bg-green-500 text-white rounded-lg transition-all hover:bg-green-700">
                        <!-- Ikon SVG untuk Search -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Daftar Admin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($admins as $admin)
                    <div
                        class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                        <div class="p-6 flex items-center">
                            <!-- Foto Profil Admin -->
                            <div class="flex-shrink-0">
                                <img src="{{ $admin->foto }}" alt="Foto Profil"
                                    class="w-16 h-16 rounded-full border-2 border-[#F7FAFC]">
                            </div>

                            <!-- Info Admin -->
                            <div class="ml-4 text-[#F7FAFC]">
                                <!-- Nama Admin -->
                                <h3 class="text-xl font-semibold  admin-name">{{ $admin->name }}</h3>
                                <!-- Nomor HP Admin -->
                                <p class="text-sm mb-2">No HP: {{ $admin->phone }}</p>
                            </div>
                        </div>

                        <!-- Total Payments dan Total Amount -->
                        <div class="p-6 bg-[#2D3748] grid grid-cols-2 gap-4">
                            <div class="bg-[#FF6347] p-4 rounded-lg text-center">
                                <h4 class="text-lg font-semibold">Dibayar</h4>
                                <p class="text-xl">Rp {{ number_format($admin->total_payments, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-[#00B5D8] p-4 rounded-lg text-center">
                                <h4 class="text-lg font-semibold">Total </h4>
                                <p class="text-xl">Rp {{ number_format($admin->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="p-6 bg-[#2D3748]">
                            <div class="progress custom-progress">
                                <div class="progress-bar custom-progress-bar" role="progressbar"
                                    style="width: {{ ($admin->total_payments / $admin->total_amount) * 100 }}%"
                                    aria-valuenow="{{ ($admin->total_payments / $admin->total_amount) * 100 }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <span
                                        class="progress-text">{{ number_format(($admin->total_payments / $admin->total_amount) * 100, 2) }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Link ke halaman admin -->
                        <div class="p-6 bg-[#2D3748] text-right">
                            <a href="{{ route('Daftar Pembayaran', ['group' => $group->name, 'admin' => $admin->name]) }}"
                                class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#003366] transition-all">Lihat
                                Daftar Pembayar</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <style>
        .custom-progress {
            height: 20px;
            /* Tinggi progress bar */
            border-radius: 10px;
            /* Sudut progress bar */
            background-color: #4B5563;
            /* Warna latar belakang progress */
        }

        .custom-progress-bar {
            background-color: #FF6347;
            /* Warna progress bar (tomato red) */
            border-radius: 10px;
            /* Sudut lebih halus */
            transition: width 0.4s ease;
            /* Transisi halus untuk perubahan lebar */
            position: relative;
        }

        .progress-text {
            color: #F7FAFC;
            /* Warna teks untuk persentase */
            font-weight: bold;
            font-size: 14px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            /* Menempatkan teks di tengah progress bar */
        }

        .card-profile {
            width: 16rem;
            height: 10rem;
            border-radius: 12px;
            background-color: #1A2634;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-profile-header {
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        .card-profile-header img {
            border-radius: 50%;
            width: 60px;
            height: 60px;
        }

        .card-profile-header .details {
            margin-left: 1rem;
        }

        .card-profile-header h3 {
            font-size: 1.25rem;
            color: #F7FAFC;
        }

        .card-profile-header p {
            font-size: 0.875rem;
            color: #F7FAFC;
        }

        .card-profile-body {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
        }

        .card-profile-body .stats {
            background-color: #FF6347;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .card-profile-body .stats p {
            color: #F7FAFC;
            font-size: 1.25rem;
        }

        .card-profile-footer {
            padding: 1rem;
            background-color: #2D3748;
            text-align: center;
        }

        .card-profile-footer a {
            background-color: #FF6347;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .card-profile-footer a:hover {
            background-color: #003366;
        }
    </style>
    <script>
       function searchFunction() {
    // Ambil input dari kolom pencarian
    let input = document.getElementById('searchInput').value.toLowerCase();

    // Ambil semua elemen yang ingin dicari (nama admin)
    let admins = document.querySelectorAll('.admin-card'); // Gunakan kelas untuk elemen admin

    // Iterasi melalui semua elemen admin
    admins.forEach(function(admin) {
        let name = admin.querySelector('.admin-name').innerText.toLowerCase();
        if (name.includes(input)) {
            admin.style.display = 'block'; // Tampilkan admin yang cocok
        } else {
            admin.style.display = 'none'; // Sembunyikan admin yang tidak cocok
        }
    });
}

    </script>
</x-layouts>
