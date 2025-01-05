<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-[#2D3748] py-16 sm:py-20">
       
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <!-- Tombol Kembali dan Tambah Data -->
                <div class="flex space-x-4">
                    <!-- Tombol Kembali -->
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                            <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                        </svg>
                        Kembali
                    </button>
        
                    <!-- Tombol Tambah Data -->
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Tambah Data
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </button>
                </div>
        
                <!-- Form Pencarian -->
                <form class="flex items-center max-w-sm mx-auto">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                            </svg>
                        </div>
                        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search branch name..." required />
                    </div>
                    <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
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
                    <div class="tab-pane fade show active px-4 sm:px-6 lg:px-8" id="fully-paid" role="tabpanel" aria-labelledby="fully-paid-tab">
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
                                            <div class="bg-[#FF6347] p-0 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_payment, 0, ',', '.') }}</p>

                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Total</h4>
                                            <div class="bg-[#00B5D8] p-0 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Outstanding Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Sisa</h4>
                                            <div class="bg-[#38A169] p-0 rounded-lg text-center">
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
                <div class="tab-pane fade show active px-4 sm:px-6 lg:px-8" id="fully-paid" role="tabpanel" aria-labelledby="fully-paid-tab">
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
                                            <div class="bg-[#FF6347] p-0 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_payment, 0, ',', '.') }}</p>

                                            </div>
                                        </div>

                                        <!-- Total Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Total</h4>
                                            <div class="bg-[#00B5D8] p-0 rounded-lg text-center">
                                                <p class="text-xl">Rp
                                                    {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Outstanding Amount -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-[#F7FAFC] mb-2">Sisa</h4>
                                            <div class="bg-[#38A169] p-0 rounded-lg text-center">
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
