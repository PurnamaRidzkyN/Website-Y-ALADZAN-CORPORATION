<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8">
                <!-- Tombol Kembali dan Tambah Data -->
                <div class="flex justify-between items-center mb-4">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('List Admin', ['group' => $group->name]) }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>


                    <!-- Tombol Tambah Data -->
                    <button type="button"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                        data-bs-toggle="modal" data-bs-target="#addDataModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path
                                d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                        </svg>
                        Tambah Data
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                            <!-- Modal Header -->
                            <div class="modal-header" style="background-color: #1A2634;">
                                <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body" style="background-color: #2D3748;">
                                <!-- Form inside the modal -->
                                <form
                                    action="{{ route('loan.store', ['group' => $group->name, 'admin' => $admin->name]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="total_payment" class="form-label">Total Pembayaran</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="total_amount"
                                                name="total_amount"required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                                        <input type="date" class="form-control" id="loan_date" name="loan_date"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No HP</label>
                                        <input type="number" class="form-control" id="phone" name="phone"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control" id="admin_group_id"
                                            name="admin_group_id" value="{{ $adminGroup->id }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="code_id" class="form-label">Pilih Kode</label>
                                        <select class="form-select" name="code_id" id="code_id">
                                            @foreach ($codes as $code)
                                                <option value="{{ $code->id }}">
                                                    {{ $code->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer" style="background-color: #1A2634;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn"
                                    style="background-color: #4CAF50; color: white;">Kirim</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    const nominalInput = document.getElementById('total_amount');

                    nominalInput.addEventListener('input', function(e) {
                        // Remove non-numeric characters except comma and dot
                        let value = this.value.replace(/[^\d]/g, '');

                        // Format to Rupiah
                        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                        // Set formatted value back to input
                        this.value = value;
                    });

                    // Add event listener for form submission
                    const form = document.querySelector('form');
                    form.addEventListener('submit', function(e) {
                        // Remove the dots before sending the value to the server
                        const valueWithoutDot = nominalInput.value.replace(/\./g, '');
                        nominalInput.value = valueWithoutDot;
                    });
                </script>


                <script>
                    const totalPaymentInput = document.getElementById('total_payment');

                    // Function to format number as Rupiah
                    function formatRupiah(value) {
                        let number_string = value.replace(/[^,\d]/g, '').toString();
                        let split = number_string.split(',');
                        let rest = split[0].length % 3;
                        let rupiah = split[0].substr(0, rest);
                        let thousands = split[0].substr(rest).match(/\d{3}/gi);

                        if (thousands) {
                            separator = rest ? '.' : '';
                            rupiah += separator + thousands.join('.');
                        }

                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                        return rupiah;
                    }

                    totalPaymentInput.addEventListener('input', function(e) {
                        let value = e.target.value;
                        e.target.value = formatRupiah(value);
                    });
                </script>


                <form class="flex items-center w-full"
                    action="{{ route('Daftar Pembayaran', ['group' => $group->name, 'admin' => $admin->name]) }}"
                    method="GET">
                    <label for="loan-search" class="sr-only">Cari Loan</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="admin-search" name="query"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari berdasarkan nama atau nomor HP..." value="{{ request('query') }}" />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Cari</span>
                    </button>
                    <a href="{{ route('Daftar Pembayaran', ['group' => $group->name, 'admin' => $admin->name]) }}"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        Reset
                    </a>
                </form>
            </div>
        </div>





        <!-- Tabs Navigation -->
        <div class="mb-6">
            <!-- Tabs Navigation -->
            @if (request('query'))
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-2 my-2 rounded-sm shadow-sm">
                    <p class="text-sm font-medium">Menampilkan hasil untuk pencarian "<span
                            class="font-semibold">{{ request('query') }}</span>"
                        ({{ $loans->count() }} hasil ditemukan)</p>
                </div>
            @endif
            <div class="mb-6">
                <ul class="nav nav-tabs" id="loanTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="not-fully-paid-tab" data-bs-toggle="tab"
                            data-bs-target="#not-fully-paid" type="button" role="tab"
                            aria-controls="not-fully-paid" aria-selected="true"
                            style="background-color: #FF6347; color: white;"
                            onmouseover="this.style.backgroundColor='#FF4500'"
                            onmouseout="this.style.backgroundColor='#FF6347'">Belum Lunas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fully-paid-tab" data-bs-toggle="tab"
                            data-bs-target="#fully-paid" type="button" role="tab" aria-controls="fully-paid"
                            aria-selected="false" style="background-color: #3182CE; color: white;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#3182CE'">Sudah Lunas</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="loanTabsContent">
            <!-- Belum Lunas -->
            @if ($loans->isEmpty())
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Pembayar</h5>
                    <p class="mb-0">Anda saat ini belum memiliki Pembayar. Silakan tambahkan Pembayara.</p>
                </div>
            @endif
            <div class="tab-pane fade show active px-4 sm:px-6 lg:px-8" id="not-fully-paid" role="tabpanel"
                aria-labelledby="not-fully-paid-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">

                    @foreach ($loans as $loan)
                        @if ($loan->total_payment < $loan->total_amount)
                            <div
                                class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                                <div class="p-6 text-[#F7FAFC]">
                                    <h3 class="text-xl font-semibold">{{ $loan->name }}</h3>
                                    <p class="text-sm mb-2">No HP: {{ $loan->phone }}</p>
                                    <p class="text-sm mb-2">Kode: {{ $loan->code->code }}</p>
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
                                                {{ number_format($loan->total_amount, 0, ',', '.') }}
                                            </p>
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
                                    <div class="progress custom-progress">
                                        <div class="progress-bar custom-progress-bar" role="progressbar"
                                            style="width: {{ ($loan->total_payment / $loan->total_amount) * 100 }}%"
                                            aria-valuenow="{{ ($loan->total_payment / $loan->total_amount) * 100 }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <span
                                                class="progress-text">{{ number_format(($loan->total_payment / $loan->total_amount) * 100, 2) }}%</span>
                                        </div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <a href="{{ route('Loan Detail', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loan->name]) }}"
                                            class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#D84C2E] transition-all no-underline">
                                            Lihat
                                            Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Sudah Lunas -->
            <div class="tab-pane fade px-4 sm:px-6 lg:px-8" id="fully-paid" role="tabpanel"
                aria-labelledby="fully-paid-tab">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach ($loans as $loan)
                        @if ($loan->total_payment >= $loan->total_amount)
                            <div
                                class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                                <div class="p-6 text-[#F7FAFC]">
                                    <h3 class="text-xl font-semibold">{{ $loan->name }}</h3>
                                    <p class="text-sm mb-2">No HP: {{ $loan->phone }}</p>
                                    <p class="text-sm mb-2">Kode: {{ $loan->code->code }}</p>
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
                                    <div class="progress custom-progress">
                                        <div class="progress-bar custom-progress-bar" role="progressbar"
                                            style="width: {{ ($loan->total_payment / $loan->total_amount) * 100 }}%"
                                            aria-valuenow="{{ ($loan->total_payment / $loan->total_amount) * 100 }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <span
                                                class="progress-text">{{ number_format(($loan->total_payment / $loan->total_amount) * 100, 2) }}%</span>
                                        </div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <a href="{{ route('Loan Detail', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loan->name]) }}"
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
