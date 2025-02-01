<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        <div class="container mx-auto px-6 lg:px-8 w-full">

            <div class="mb-8 d-flex justify-content-between">

                <!-- Tombol Kembali dan Tambah Data -->
                <div class="flex justify-between items-center mb-4">
                    <!-- Tombol Kembali -->
                    <a href=" {{ route('Daftar Pembayaran', ['group' => $group->name, 'admin' => $admin->name]) }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>

                    <!-- Tombol Tambah Data, di ujung kanan -->
                    <button type="button"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                        data-bs-toggle="modal" data-bs-target="#addDataModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2 w-5 h-5">
                            <path
                                d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                        </svg>
                        Pembayaran Baru
                    </button>
                </div>
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
                                action="{{ route('payment.store', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loans->name]) }}"
                                method="POST">
                                @csrf

                                <!-- Input for Nominal -->
                                <div class="mb-3">
                                    <label for="nominal" class="form-label" style="color: #fff;">Nominal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="nominal" name="nominal"
                                            required>
                                    </div>
                                </div>

                                <!-- Input for Tanggal -->
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label" style="color: #fff;">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>

                                <!-- Input for Cara Bayar -->
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label" style="color: #fff;">Cara
                                        Bayar</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="payment_method"
                                            name="payment_method" required>
                                    </div>
                                </div>

                                <!-- Input for Deskripsi -->
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label" style="color: #fff;">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="loan_id" name="loan_id"
                                        value="{{ $loans->id }}" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3 text-center">
                                    <button type="submit"
                                        class="btn btn-success d-flex align-items-center justify-content-center">
                                        Kirim Pembayaran
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pembayaran -->
            <h5 class="text-2xl font-bold text-[#F7FAFC] mb-4">Informasi Pembayaran</h5>
            <div class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg p-6 mb-6">
                <ul class="list-none text-[#E2E8F0]">
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Nama:</strong> {{ $loans->name }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Deskripsi:</strong> {{ $loans->description }}
                    </li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Kode:</strong>
                        {{ $loans->code ? $loans->code->code : 'Kode tidak tersedia' }}
                    </li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Total Pembayaran:</strong>
                        Rp{{ number_format($loans->total_amount, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Dibayar:</strong>
                        Rp{{ number_format($loans->total_payment, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Sisa Pembayaran:</strong>
                        Rp{{ number_format($loans->outstanding_amount, 0, ',', '.') }}</li>
                    <li class="detail-item text-[#F7FAFC] mb-4"><strong>Tanggal Awal :</strong>
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
                        <ul class="space-y-4 text-[#F7FAFC] mb-4">
                            <li><strong>Nominal:</strong>
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}
                            </li>
                            <li><strong>Tanggal:</strong>
                                {{ \Carbon\Carbon::parse($payment->payment_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </li>
                            <li><strong>Cara Bayar:</strong>
                                {{ $payment->method }}
                            </li>
                            <li><strong>Deskripsi:</strong>
                                {{ $payment->description }}
                            </li>
                        </ul>
                        <div class="flex justify-between items-center">
                            <!-- Edit Button -->
                            <button
                                class="btn btn-warning btn-sm rounded-pill shadow-lg flex items-center px-4 py-2 text-sm font-medium text-[#F7FAFC] bg-blue-600 hover:bg-blue-700 rounded-lg"
                                data-bs-toggle="modal" data-bs-target="#editPaymentModal-{{ $payment->id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>

                            <!-- Delete Button -->
                            <button
                                class="btn btn-danger btn-sm rounded-pill shadow-lg flex items-center px-4 py-2 text-sm font-medium text-[#F7FAFC] bg-red-600 hover:bg-red-700 rounded-lg"
                                data-bs-toggle="modal" data-bs-target="#deletePaymentModal-{{ $payment->id }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editPaymentModal-{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $payment->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                                <div class="modal-header" style="background-color: #1A2634;">
                                    <h5 class="modal-title" id="editModalLabel{{ $payment->id }}">Edit Pembayaran
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="background-color: #2D3748;">
                                    <!-- Form untuk Edit -->
                                    <form
                                        action="{{ route('payment.update', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loans->name]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Input Nominal Pembayaran -->
                                        <div class="mb-3">
                                            <label for="amount" class="form-label"
                                                style="color: #fff;">Nominal</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control formattedNominal"
                                                    value="{{ number_format(floor($payment->amount), 0, ',', '.') }}"
                                                    required>
                                                <input type="hidden" class="form-control nominal" name="nominal"
                                                    required>
                                                <input type="hidden" class="form-control payment_amount"
                                                    name="payment_id" value="{{ $payment->id }}" required>
                                                <input type="hidden" class="form-control"
                                                    id="payment_amount{{ $payment->id }}" name="payment_id"
                                                    value="{{ $payment->id }}" required>
                                            </div>
                                        </div>


                                        <!-- Input Tanggal Pembayaran -->
                                        <div class="mb-3">
                                            <label for="payment_date{{ $payment->id }}" class="form-label"
                                                style="color: #fff;">Tanggal</label>
                                            <input type="date" class="form-control"
                                                id="payment_date{{ $payment->id }}" name="payment_date"
                                                value="{{ \Carbon\Carbon::parse($payment->payment_date)->toDateString() }}"
                                                required>
                                        </div>

                                        <!-- Input Metode Pembayaran -->
                                        <div class="mb-3">
                                            <label for="payment_method{{ $payment->id }}" class="form-label"
                                                style="color: #fff;">Metode Bayar</label>
                                            <input type="text" class="form-control"
                                                id="payment_method{{ $payment->id }}" name="method"
                                                value="{{ $payment->method }}" required>
                                        </div>

                                        <!-- Input Deskripsi -->
                                        <div class="mb-3">
                                            <label for="payment_description{{ $payment->id }}" class="form-label"
                                                style="color: #fff;">Deskripsi</label>
                                            <textarea class="form-control" id="payment_description{{ $payment->id }}" name="description" rows="3"
                                                required>{{ $payment->description }}</textarea>
                                        </div>

                                        <!-- Tombol Submit -->
                                        <div class="mb-3 text-center">
                                            <button type="submit" class="btn btn-success">Update Pembayaran</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deletePaymentModal-{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="deletePaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deletePaymentModalLabel{{ $payment->id }}">
                                        Konfirmasi Hapus</h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus pembayaran dengan nominal
                                    <strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <!-- Tombol Batal -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>

                                    <!-- Form untuk menghapus pembayaran -->
                                    <form
                                        action="{{ route('payment.destroy', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loans->name]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>




            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-center mt-8 space-x-4">
                <!-- Button Cetak Laporan -->
                <button class="px-6 py-3 bg-[#FF6347] text-white rounded-lg hover:bg-[#FF4500] transition-all">
                    <a href="{{ route('loans.print', ['id' => $loans->id]) }}" class="text-white">
                        Cetak Laporan
                    </a>
                </button>


                <!-- Button Kirim Pemberitahuan WA -->
                <button class="px-6 py-3 bg-[#3182CE] text-white rounded-lg hover:bg-[#1E40AF] transition-all"
                    onclick="sendWhatsapp()">Kirim Pemberitahuan WA</button>
                <script>
                    function sendWhatsapp() {
                        try {
                            // Mendapatkan data pinjaman pertama dari array loans
                            const loan = @json($loans); // Ambil data pinjaman pertama (index 0)
                            const payments = @json($payments);
                            const messages = @json($message);
                            console.log(payments)
                            // Cek apakah loan ada (tidak null atau undefined)
                            if (loan && loan.name) {
                                // Menyusun pesan WhatsApp
                                let message = `${messages.message_header} \n
*Pembayaran:* 
Tanggal Awal\t\t: ${loan.loan_date} 
Total \t\t\t: Rp${loan.total_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")} 
Sudah Dibayar\t\t: Rp${loan.total_payment.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")} 
Sisa\t\t\t: Rp${loan.outstanding_amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")} \n
*Rincian Pembayaran*`;

                                let paymentDetails = payments.map(payment => {
                                    return `Tanggal Pembayaran: ${payment.payment_date} | Jumlah: Rp${payment.amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
                                }).join("\n");

                                message += `\n${paymentDetails}\n\n${messages.message_footer}`;
                                // Nomor WhatsApp tujuan
                                const phoneNumber = @json($loans->phone); // Ambil nomor telepon dari server

                                // Jika nomor telepon dimulai dengan '0', ganti dengan '62'
                                const formattedPhoneNumber = phoneNumber.startsWith('0') ? '62' + phoneNumber.slice(1) : phoneNumber;
                                // Ganti dengan nomor yang diinginkan
                                const url =
                                    `https://api.whatsapp.com/send?phone=${formattedPhoneNumber}&text=${encodeURIComponent(message)}`;

                                // Buka URL untuk mengirim pesan
                                window.open(url, '_blank');
                            } else {
                                console.error("Data pinjaman tidak ditemukan atau tidak valid.");
                            }
                        } catch (error) {
                            console.error("Error in sendWhatsapp:", error); // Debug: Cek error yang terjadi
                        }
                    }
                </script>



                <!-- Button Edit Data -->
                <button
                    class="btn btn-warning px-6 py-3 text-white rounded-lg hover:bg-[#D97706] transition-all"data-bs-toggle="modal"
                    data-bs-target="#editDataModal">
                    <i class="bi bi-pencil"></i> Edit Data
                </button>

                <!-- Button Delete Data -->
                <button type="button"
                    class="btn btn-danger px-6 py-3 text-white rounded-lg hover:bg-[#9B2C2C] transition-all"
                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Hapus
                </button>

                <!-- Modal Edit Data -->
                <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                            <!-- Modal Header -->
                            <div class="modal-header" style="background-color: #1A2634;">
                                <h5 class="modal-title" id="editDataModalLabel">Edit Data Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body" style="background-color: #2D3748;">
                                <!-- Form inside the modal -->
                                <form id="editForm"
                                    action="{{ route('loans.update', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loans->name]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Nama -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label" style="color: #fff;">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $loans->name }}" required>
                                    </div>


                                    {{-- deskripsi --}}
                                    <div class="mb-3">
                                        <label for="description" class="form-label"
                                            style="color: #fff;">Deskripsi</label>
                                        <input type="text" class="form-control" id="description"
                                            name="description" value="{{ $loans->description }}" required>
                                    </div>
                                    <!-- Total Pembayaran -->
                                    <div class="mb-3">
                                        <label for="nominal" class="form-label" style="color: #fff;">Total
                                            Pembayaran</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control formattedNominal"
                                                value="{{ number_format(floor($loans->total_amount), 0, ',', '.') }}"
                                                required>
                                            <input type="hidden" class="form-control nominal" name="total_amount"
                                                value="{{ number_format(floor($loans->total_amount), 0, '', '') }}"
                                                required>
                                        </div>
                                    </div>


                                    <!-- Kode -->
                                    <div class="mb-3">
                                        <label for="codes_id" class="form-label" style="color: #fff;">Kode</label>
                                        <select class="form-control" id="code" name="codes_id" required>
                                            <option value="">Pilih Kode</option>
                                            @foreach ($codes as $code)
                                                <option value="{{ $code->id }}"
                                                    {{ $loans->code_id == $code->id ? 'selected' : '' }}>
                                                    {{ $code->code }} <!-- Menampilkan kode -->
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- No HP -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label" style="color: #fff;">No
                                            HP</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $loans->phone }}" required>
                                        <input type="hidden" name="loan_id" value="{{ $loans->id }}">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mb-3 text-center">
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pembayar "<strong>{{ $loans->name }}</strong>"?
                            </div>
                            <div class="modal-footer">
                                <!-- Tombol Batal dengan Ikon -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>

                                <!-- Form untuk menghapus group -->
                                <form id="deleteForm{{ $loans->name }}"
                                    action="{{ route('loan.destroy', ['group' => $group->name, 'admin' => $admin->name, 'loan' => $loans->name]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="loans_id" value="{{ $loans->id }}">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <style>

    </style>

    <!-- JavaScript for Formatting -->
    <script>
        const nominalInput = document.getElementById('nominal');

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
        document.addEventListener("DOMContentLoaded", function() {
            const formattedNominals = document.querySelectorAll(".formattedNominal");
            const nominals = document.querySelectorAll(".nominal");

            formattedNominals.forEach((formattedNominal, index) => {
                const nominal = nominals[
                    index]; // Mendapatkan input hidden yang sesuai dengan formattedNominal

                // Event listener untuk input
                formattedNominal.addEventListener("input", function() {
                    let value = formattedNominal.value.replace(/\D/g,
                        ""); // Hapus karakter non-numerik

                    // Update tampilan formattedNominal (misalnya format dengan titik)
                    formattedNominal.value = formatCurrency(value);

                    // Simpan nilai asli ke input hidden
                    nominal.value = value;
                });
            });

            // Fungsi untuk memformat angka
            function formatCurrency(value) {
                return new Intl.NumberFormat("id-ID").format(value); // Format sesuai lokal Indonesia
            }
        });
    </script>

</x-layouts>
