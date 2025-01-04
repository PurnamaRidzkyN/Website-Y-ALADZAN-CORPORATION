<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 d-flex justify-content-between">
                <!-- Tombol Kembali dengan Logo -->
                <a href="{{ url()->previous() }}" class="px-6 py-3 bg-[#3182CE] text-white rounded-lg transition-all hover:bg-[#003366] d-flex items-center">
                    <!-- Ikon SVG untuk Kembali -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
                        <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                </a>
            
                <!-- Tombol Tambah Pembayar -->
                <a href="#tambahPembayar" class="px-6 py-3 bg-[#48BB78] text-white rounded-lg transition-all hover:bg-[#2F855A] d-flex items-center">
                    <!-- Ikon SVG untuk Tambah Pembayar -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2">
                        <path fill-rule="evenodd" d="M12 2a1 1 0 0 1 1 1v7h7a1 1 0 1 1 0 2h-7v7a1 1 0 1 1-2 0v-7h-7a1 1 0 1 1 0-2h7V3a1 1 0 0 1 1-1Z" clip-rule="evenodd" />
                    </svg>
                    Tambah Pembayar
                </a>
            
                <!-- Tombol Search di Samping -->
                <div class="d-flex">
                    <input type="text" class="form-control mr-3" id="searchInput" placeholder="Cari..." aria-label="Search" onkeyup="searchFunction()">
                    <button class="px-6 py-3 bg-green-500 text-white rounded-lg transition-all hover:bg-green-700">
                        <!-- Ikon SVG untuk Search -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="loanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="fully-paid-tab" data-bs-toggle="tab"
                        data-bs-target="#fully-paid" type="button" role="tab" aria-controls="fully-paid"
                        aria-selected="true" style="background-color: #FF6347; color: white;">Sudah Lunas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="not-fully-paid-tab" data-bs-toggle="tab"
                        data-bs-target="#not-fully-paid" type="button" role="tab" aria-controls="not-fully-paid"
                        aria-selected="false" style="background-color: #3182CE; color: white;"
                        onmouseover="this.style.backgroundColor='#003366'"
                        onmouseout="this.style.backgroundColor='#3182CE'">Belum Lunas</button>
                </li>
            </ul>


            <!-- Tabs Content -->
            <div class="tab-content" id="loanTabsContent">
                <!-- Sudah Lunas -->
                <div class="tab-pane fade show active" id="fully-paid" role="tabpanel" aria-labelledby="fully-paid-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($loans as $loan)
                            @if ($loan->total_payment >= $loan->total_amount)
                                <div
                                    class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                                    <div class="p-6 text-[#F7FAFC]">
                                        <h3 class="text-xl font-semibold">{{ $loan->name }}</h3>
                                        <p class="text-sm mb-2">No HP: {{ $loan->phone }}</p>
                                        <p class="text-sm">Tanggal Pembayaran: {{ $loan->loan_date }}</p>
                                        <p class="text-sm">Terakhir Diperbarui: {{ $loan->updated_at }}</p>
                                    </div>

                                    <div class="p-6 bg-[#2D3748] grid grid-cols-3 gap-2">
                                        <!-- Total Payment -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Dibayar</h4>
                                            <div class="bg-[#FF6347] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_payment, 0, ',', '.') }}</p>

                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Total</h4>
                                            <div class="bg-[#00B5D8] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Outstanding Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Sisa</h4>
                                            <div class="bg-[#38A169] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->outstanding_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="p-6 bg-[#2D3748]">
                                        <div class="p-6 bg-[#2D3748]">
                                            <div class="progress custom-progress">
                                                <div class="progress-bar custom-progress-bar" role="progressbar"
                                                    style="width: {{ ($loan->total_payment / $loan->total_amount) * 100 }}%"
                                                    aria-valuenow="{{ ($loan->total_payment / $loan->total_amount) * 100 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    <span
                                                        class="progress-text">{{ number_format(($loan->total_payment / $loan->total_amount) * 100, 2) }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('Loan Detail', [
                                                'group' => $group->name,
                                                'admin' => $admin->name,
                                                'loan' => $loan->name,
                                            ]) }}"
                                                class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#003366] transition-all">Lihat
                                                Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Belum Lunas -->
                <div class="tab-pane fade" id="not-fully-paid" role="tabpanel" aria-labelledby="not-fully-paid-tab">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($loans as $loan)
                            @if ($loan->total_payment < $loan->total_amount)
                                <div
                                    class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                                    <div class="p-6 text-[#F7FAFC]">
                                        <h3 class="text-xl font-semibold">{{ $loan->name }}</h3>
                                        <p class="text-sm mb-2">No HP: {{ $loan->phone }}</p>
                                        <p class="text-sm">Tanggal Pembayaran: {{ $loan->loan_date }}</p>
                                        <p class="text-sm">Terakhir Diperbarui: {{ $loan->updated_at }}</p>
                                    </div>


                                    <div class="p-6 bg-[#2D3748] grid grid-cols-3 gap-2">
                                        <!-- Total Payment -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Dibayar</h4>
                                            <div class="bg-[#FF6347] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_payment, 0, ',', '.') }}</p>

                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Total</h4>
                                            <div class="bg-[#00B5D8] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Outstanding Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Sisa</h4>
                                            <div class="bg-[#38A169] p-1 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->outstanding_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-6 bg-[#2D3748]">
                                        <!-- Progres Pembayaran di dalam card -->
                                        <div class="p-6 bg-[#2D3748]">
                                            <div class="progress custom-progress">
                                                <div class="progress-bar custom-progress-bar" role="progressbar"
                                                    style="width: {{ ($loan->total_payment / $loan->total_amount) * 100 }}%"
                                                    aria-valuenow="{{ ($loan->total_payment / $loan->total_amount) * 100 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    <span
                                                        class="progress-text">{{ number_format(($loan->total_payment / $loan->total_amount) * 100, 2) }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('Loan Detail', [
                                                'group' => $group->name,
                                                'admin' => $admin->name,
                                                'loan' => $loan->name,
                                            ]) }}"
                                                class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#003366] transition-all">Lihat
                                                Detail</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
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

        .card-inner {
            display: flex;
            flex-direction: column;
            /* Menyusun elemen secara vertikal */
            justify-content: center;
            /* Menjaga elemen tetap di tengah secara vertikal */
            align-items: center;
            /* Menjaga elemen tetap di tengah secara horizontal */
            height: 100%;
            /* Membuat card kecil mengisi seluruh ruang vertikal */
        }

        .card-inner {
            min-height: 150px;
            /* Sesuaikan tinggi minimal card kecil */
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

        .card-title {
            font-size: 1.25rem;
        }

        .card-body {
            font-size: 1rem;
        }

        .card-text {
            color: #F7FAFC;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>
