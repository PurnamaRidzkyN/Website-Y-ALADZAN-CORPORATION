<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container mx-auto px-6 lg:px-8">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="mb-8">
                    <!-- Tombol Kembali, Tambah Admin, dan Search -->
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4 gap-4">
                        <!-- Tombol Kembali -->
                        <a href="{{ route('Transaksi Pembayaran') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6 mr-2 w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kembali
                        </a>

                        <!-- Tombol Tambah Admin -->
                        <button type="button"
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                            data-bs-toggle="modal" data-bs-target="#adminModal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6 mr-2 w-5 h-5">
                                <path
                                    d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                            </svg>
                            Edit Admin
                        </button>
                    </div>

                    <!-- Modal Daftar Admin (Modal Pertama) -->
                    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                                <div class="modal-header" style="background-color: #3182CE;">
                                    <h5 class="modal-title" id="adminModalLabel">Daftar Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered" style="background-color: #1A2634;">
                                        <thead>
                                            <tr>
                                                <th class="text-white">Nama</th>
                                                <th class="text-white">Foto Profil</th>
                                                <th class="text-white">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $admin)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $admin->foto }}" alt="foto"
                                                            class="rounded-circle" width="50" height="50">
                                                    </td>
                                                    <td class="text-white">{{ $admin->name }}</td>
                                                    <td>
                                                        <!-- Form untuk menghapus group -->
                                                        <form style="display: inline-block;">
                                                            <!-- Tombol untuk memicu modal konfirmasi hapus -->
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm rounded-pill shadow-lg"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $admin->admin_id }}">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Tombol untuk membuka modal tambah admin baru -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addAdminModal">
                                        Tambah Admin Baru
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($admins as $admin)
                        <div class="modal fade" id="deleteModal{{ $admin->admin_id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $admin->admin_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $admin->admin_id }}">Konfirmasi
                                            Hapus
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus admin "<strong>{{ $admin->name }}</strong>"?
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Tombol Batal dengan Ikon -->
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </button>

                                        <!-- Form untuk menghapus admin -->
                                        @dump($group->id);
                                        <form id="deleteForm{{ $admin->id }}"
                                            action="{{ route('admin.destroy', ['group' => $group->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="admin_id" value="{{ $admin->admin_id }}">
                                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Modal Menambah Admin Baru (Modal Kedua) -->
                    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                                <div class="modal-header" style="background-color: #3182CE;">
                                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Admin Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Pilih admin yang mau ditambahkan</p>
                                    <form action="{{ route('admin.store', ['group' => $group->name]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="admin_id" class="form-label">Pilih Admin</label>
                                            @if ($adminAll->isEmpty())
                                                <p class="text-danger">Tidak ada admin yang bisa ditambahkan.</p>
                                            @else
                                                <select class="form-select" name="admin_id" id="admin_id">
                                                    @foreach ($adminAll as $admin)
                                                        <option value="{{ $admin->id }}"
                                                            data-profile="{{ $admin->profile_picture }}">
                                                            {{ $admin->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>

                                        @if (!$adminAll->isEmpty())
                                            <button type="submit" class="btn btn-success">Tambah Admin</button>
                                        @endif
                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>





                    <form class="flex items-center w-full"
                        action="{{ route('List Admin', ['group' => $group->name]) }}" method="GET">
                        <label for="admin-search" class="sr-only">Cari Admin</label>
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
                                placeholder="Cari admin berdasarkan nama atau nomor HP..."
                                value="{{ request('query') }}" />
                        </div>
                        <button type="submit"
                            class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Cari</span>
                        </button>
                        <a href="{{ route('List Admin', ['group' => $group->name]) }}"
                            class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                            Reset
                        </a>
                    </form>
                </div>
            </div>
            <!-- Tampilkan Hasil Pencarian -->
            @if (!empty(request('query')))
                <p class="text-[#F7FAFC] mb-6">Hasil pencarian untuk: <strong>{{ request('query') }}</strong></p>
            @endif
            @if ($admins->isEmpty() && empty(request('query')))
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Admin</h5>
                    <p class="mb-0">Grup ini saat ini belum memiliki admin. Silakan tambahkan admin.</p>
                </div>
            @endif

            <!-- Daftar Admin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($admins->isEmpty())
                    <!-- Jika Tidak Ada Admin yang Ditemukan -->
                    <div class="col-span-full text-center text-[#FF6347] text-lg">
                        Tidak ada admin yang ditemukan.
                    </div>
                @else
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
                                    <h3 class="text-xl font-semibold admin-name">{{ $admin->name }}</h3>
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
                                    @php
                                        // Cek apakah total_amount tidak nol
                                        $percentage =
                                            $admin->total_amount != 0
                                                ? ($admin->total_payments / $admin->total_amount) * 100
                                                : 0;
                                    @endphp
                                    <div class="progress-bar custom-progress-bar" role="progressbar"
                                        style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="progress-text">{{ number_format($percentage, 2) }}%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Link ke halaman admin -->
                            <div class="p-6 bg-[#2D3748] text-right">
                                <a href="{{ route('Daftar Pembayaran', ['group' => $group->name, 'admin' => $admin->name]) }}"
                                    class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#D84C2E] transition-all no-underline">
                                    Lihat
                                    Daftar Pembayar</a>
                            </div>
                        </div>
                    @endforeach
                @endif
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

</x-layouts>
