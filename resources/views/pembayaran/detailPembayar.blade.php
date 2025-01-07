<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        <div class="container mx-auto px-6 lg:px-8 w-full">

            <div class="mb-8 d-flex justify-content-between">

                <!-- Tombol Kembali dan Tambah Data -->
                <div class="flex justify-between items-center mb-4">
                    <!-- Tombol Kembali, di ujung kiri -->
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </button>

                    <!-- Tombol Tambah Data, di ujung kanan -->
                    <button type="button"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path
                                d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                        </svg>
                        Tambah Data
                    </button>
                </div>



            </div>
            <!-- Detail Pembayaran -->
            <div class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg p-6 mb-6">
                <h5 class="text-2xl font-bold text-[#F7FAFC] mb-4">Informasi Pembayaran</h5>
                <ul class="list-none text-[#E2E8F0]">
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Nama:</strong> {{ $loans->name }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Total Pembayaran:</strong>
                        Rp{{ number_format($loans->total_amount, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Dibayar:</strong>
                        Rp{{ number_format($loans->total_payment, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Sisa Pembayaran:</strong>
                        Rp{{ number_format($loans->outstanding_amount, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Tanggal Terakhir Pembayaran:</strong>
                        {{ $loans->loan_date }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Terakhir Dirubah:</strong>
                        {{ $loans->created_at->diffForHumans() }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>No HP:</strong> {{ $loans->phone }}</li>
                </ul>
            </div>

            <!-- Riwayat Pembayaran -->
            <h5 class="text-[#F7FAFC] mb-3">Riwayat Pembayaran</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($payments as $payment)
                    <div
                        class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all p-6">
                        <ul class="space-y-4 text-[#F7FAFC]">
                            <li><strong>Nominal:</strong>
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}
                            </li>
                            <li><strong>Tanggal:</strong>
                                {{ $payment->payment_date }}
                            </li>
                            <li><strong>Cara Bayar:</strong>
                                {{ $payment->method }}
                            </li>
                            <li><strong>Deskripsi:</strong>
                                {{ $payment->description }}
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>


            <!-- Tombol Aksi -->
            <<div class="d-flex justify-content-center mt-8 space-x-4">
                <!-- Button Cetak Laporan -->
                <button class="px-6 py-3 bg-[#FF6347] text-white rounded-lg hover:bg-[#FF4500] transition-all"
                    onclick="printReport()">Cetak Laporan</button>

                <!-- Button Kirim Pemberitahuan WA -->
                <button class="px-6 py-3 bg-[#3182CE] text-white rounded-lg hover:bg-[#1E40AF] transition-all"
                    onclick="sendWhatsapp()">Kirim Pemberitahuan WA</button>

                <!-- Button Edit Data -->
                <button class="px-6 py-3 bg-[#48BB78] text-white rounded-lg hover:bg-[#2F855A] transition-all"
                    onclick="sendWhatsapp()">Edit Data</button>
        </div>

    </div>
    </div>

    <script></script>
</x-layouts>
