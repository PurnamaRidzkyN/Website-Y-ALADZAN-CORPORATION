<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="bg-gray-900 min-h-screen p-6">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Header -->
        @if (auth()->user()->role == 1 || auth()->user()->role == 0)
            <button type="button"
                class="text-right mb-8 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                data-bs-toggle="modal" data-bs-target="#category_expensesModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-6 mr-2 w-5 h-5">
                    <path
                        d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                </svg>
                Edit Kategori Pengeluaran
            </button>
        @endif
        <!-- Modal Daftar category_expenses (Modal Pertama) -->
        <div class="modal fade" id="category_expensesModal" tabindex="-1" aria-labelledby="category_expensesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <div class="modal-header" style="border-bottom: 1px solid #003366;">
                        <h5 class="modal-title" id="category_expensesModalLabel" style="color: #F7FAFC;">Kategori
                            Pengeluaran </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Tabel dengan latar belakang gelap dan teks terang -->
                        <table class="table table-striped table-bordered table-hover"
                            style="background-color: #2D3748; color: #F7FAFC !important;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th style="color: #F7FAFC !important;">Nama</th>
                                    <th style="color: #F7FAFC !important;">Akses</th>
                                    <th style="color: #F7FAFC !important;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #1A2634; color: #F7FAFC !important;">
                                @foreach ($category_expenses as $category)
                                    <tr id="category_expenses-row-{{ $category->id }}">
                                        <td style="color: #F7FAFC !important;">{{ $category->name }}</td>
                                        <td style="color: #F7FAFC !important;">
                                            {{ $category->role == 1 ? 'Hanya untuk manajer' : 'Semua bisa akses' }}</td>
                                        <td style="color: #F7FAFC !important;">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm rounded-pill shadow-lg"
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}"
                                                data-name="{{ $category->name }}" data-role="{{ $category->role }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form style="display: inline-block;">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm rounded-pill shadow-lg"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $category->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>





                        <!-- Tombol untuk membuka modal tambah category_expenses baru -->
                        <button type="button" class="btn" style="background-color: #38A169; color: white;"
                            data-bs-toggle="modal" data-bs-target="#addcategory_expensesModal">
                            Tambah Kategori Pengeluaran Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($category_expenses as $category)
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1"
                aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                        <div class="modal-header" style="background-color: #1A2634;">
                            <h5 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Kategori Pengeluaran
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #2D3748;">
                            <!-- Form untuk Edit -->

                            <form action="{{ route('category.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="category_expenses_name{{ $category->id }}" class="form-label"
                                        style="color: #fff;">Nama</label>
                                    <input type="text" class="form-control"
                                        id="category_expenses_name{{ $category->id }}" name="name"
                                        value="{{ $category->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="category_expenses_role{{ $category->id }}" class="form-label"
                                        style="color: #fff;">Akses</label>
                                    <select class="form-control" id="category_expenses_role{{ $category->id }}"
                                        name="role" required>
                                        <option value="0" {{ $category->role == 0 ? 'selected' : '' }}>Semua bisa
                                            akses</option>
                                        <option value="1" {{ $category->role == 1 ? 'selected' : '' }}>Hanya
                                            untuk Manajer</option>
                                    </select>
                                </div>


                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-success">Update kategori
                                        Pengeluaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Modal Konfirmasi Hapus -->
        @foreach ($category_expenses as $category)
            <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus Kategori pengeluaran
                            "<strong>{{ $category->name }}</strong>"?
                        </div>
                        <div class="modal-footer">
                            <!-- Tombol Batal dengan Ikon -->
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Batal
                            </button>

                            <!-- Form untuk menghapus category_expenses -->
                            {{-- <form id="deleteForm{{ $category->id }}" action="{{ route('category.destroy') }}" --}}
                            <form id="deleteForm{{ $category->id }}"
                                action="{{ route('category.destroy', $category->id) }} " method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="category_expenses_id" value="{{ $category->id }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <!-- Modal Tambah category_expenses Baru -->
        <div class="modal fade" id="addcategory_expensesModal" tabindex="-1"
            aria-labelledby="addcategory_expensesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <div class="modal-header" style="border-bottom: 1px solid #003366;">
                        <h5 class="modal-title" id="addcategory_expensesModalLabel">Tambah Kategori Pengeluaran Baru
                            Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('category.store') }}" method="POST">
                            @csrf
                            <!-- Input untuk nama category_expenses -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama category_expenses</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    style="background-color: #1A2634; color: #F7FAFC; border: 1px solid #3182CE;">
                            </div>

                            <!-- Input untuk deskripsi category_expenses -->
                            <div class="mb-3">
                                <label for="category_expenses_role" class="form-label"
                                    style="color: #fff;">Akses</label>
                                <select class="form-control" id="category_expenses_role" name="role" required>
                                    <option value="0">Semua bisa
                                        akses</option>
                                    <option value="1">Hanya
                                        untuk Manajer</option>
                                </select>
                            </div>

                            <!-- Tombol untuk menambah category_expenses, berwarna hijau -->
                            <button type="submit" class="btn"
                                style="background-color: #38A169; color: white;">Tambah
                                Kategori Pengeluaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach ($category_expenses as $category)
                <div class="bg-gray-800 text-white p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer"
                    onclick="showExpenses({{ json_encode($category) }})">
                    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                </div>
            @endforeach
        </div>

        <!-- Expenses Table -->
        <div id="expenses-table" class="hidden">
            <h2 class="text-2xl text-white mb-4">Expenses</h2>
            <div
                class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                <button id="add-expense-button"
                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hidden">
                    Tambah pengeluaran
                </button>
                <!-- Search Form -->
                <form class="flex items-center w-full md:w-auto">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari..." required />
                    </div>

                </form>
            </div>


            <div class="overflow-x-auto mt-4">
                <table class="w-full text-white bg-gray-800 rounded-lg">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-xs sm:text-sm">Nama</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Tanggal</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Total</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Deskripsi</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Metode</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Image</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="expenses-body">
                        <!-- Rows will be populated dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="exception-table" class="hidden">
            <h2 class="text-2xl text-white mb-4">Expenses</h2>
            <div
                class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                <button id="add-expense-button-exception"
                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 hidden ">
                    Tambah pengeluaran
                </button>
                <!-- Search Form -->
                <form class="flex items-center w-full md:w-auto">
                    <label for="simple-search-exception" class="sr-only">Search</label>
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search-exception"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari..." required />
                    </div>

                </form>
            </div>


            <div class="overflow-x-auto mt-4">
                <table class="w-full text-white bg-gray-800 rounded-lg">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-xs sm:text-sm">Nama</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Tanggal</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Total</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Deskripsi</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Metode</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Penerima</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Role</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Image</th>
                            <th class="px-4 py-2 text-xs sm:text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="exception-body">
                        <!-- Rows will be populated dynamically -->
                    </tbody>
                </table>
            </div>
        </div>

        {{-- modal tambah data  --}}
        <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #1A2634;">
                        <h5 class="modal-title" id="addDataModalLabel">Tambah Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #2D3748;">
                        <!-- Form inside the modal -->
                        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Input for Tanggal -->
                            <div class="mb-3">
                                <label for="tanggal" class="form-label" style="color: #fff;">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            <!-- Input for Nominal -->
                            <div class="mb-3">
                                <label for="nominal" class="form-label" style="color: #fff;">Total</label>
                                <div class="input-category_expenses">
                                    <span class="input-category_expenses-text">Rp</span>
                                    <input type="text" class="form-control" id="nominal" name="nominal"
                                        required>
                                </div>
                            </div>

                            <!-- Input for Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label" style="color: #fff;">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="hidden" id="Select-admin">
                                <select class="form-select" name="recipient" id="recipient">
                                    @if (auth()->user()->role == 0)
                                        @foreach ($managers as $manager)
                                            <option value="{{ $manager->id }}"
                                                data-profile="{{ $manager->profile_picture }}">
                                                {{ $manager->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}"
                                                data-profile="{{ $admin->profile_picture }}">
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <!-- Input for Cara Bayar -->
                            <div class="mb-3">
                                <label for="payment_method" class="form-label" style="color: #fff;">Cara
                                    Bayar</label>
                                <div class="input-category_expenses">
                                    <input type="text" class="form-control" id="payment_method"
                                        name="payment_method" required>
                                </div>
                            </div>

                            <!-- Input for Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label" style="color: #fff;">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <!-- Input untuk Category ID (hidden) -->
                                <input type="hidden" id="category_id" name="category_id" value="">
                                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">

                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3 text-center">
                                <button type="submit"
                                    class="btn btn-success d-flex align-items-center justify-content-center">
                                    Tambah Pengeluaran
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit Data -->
        <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #1A2634;">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #2D3748;">
                        <!-- Form inside the modal -->
                        <form action="{{ route('expenses.update', ':id') }}" method="POST"
                            enctype="multipart/form-data" id="editExpenseForm">
                            @csrf
                            @method('PUT')

                            <!-- Input for Tanggal -->
                            <div class="mb-3">
                                <label for="tanggal" class="form-label" style="color: #fff;">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            <!-- Input for Nominal -->
                            <div class="mb-3">
                                <label for="nominal" class="form-label" style="color: #fff;">Total</label>
                                <div class="input-category_expenses">
                                    <span class="input-category_expenses-text">Rp</span>
                                    <input type="text" class="form-control" id="nominal" name="nominal"
                                        required>
                                </div>
                            </div>

                            <!-- Input for Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label" style="color: #fff;">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="hidden" id="Select-recipient-edit">
                                <select class="form-select" name="edit_recipient" id="edit_recipient">
                                    @if (auth()->user()->role == 0)
                                        @foreach ($managers as $manager)
                                            <option value="{{ $manager->id }}"
                                                data-profile="{{ $manager->profile_picture }}">
                                                {{ $manager->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}"
                                                data-profile="{{ $admin->profile_picture }}">
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <!-- Input for Cara Bayar -->
                            <div class="mb-3">
                                <label for="payment_method" class="form-label" style="color: #fff;">Cara
                                    Bayar</label>
                                <div class="input-category_expenses">
                                    <input type="text" class="form-control" id="payment_method"
                                        name="payment_method" required>
                                </div>
                            </div>

                            <!-- Input for Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label" style="color: #fff;">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                                <img src="" alt="Existing Image"
                                    style="width: 100px; height: 100px; display: none;">
                            </div>

                            <div class="mb-3">
                                <!-- Input untuk Category ID (hidden) -->
                                <input type="hidden" id="category_id" name="category_id">
                                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3 text-center">
                                <button type="submit"
                                    class="btn btn-success d-flex align-items-center justify-content-center">
                                    Update Pengeluaran
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
                        Apakah Anda yakin ingin menghapus pengeluaran ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="expense_id" id="expenseIdInput" value="">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal for displaying large image -->
        <div id="imageModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg relative">
                <span class="absolute top-2 right-2 text-2xl cursor-pointer" onclick="closeModal()">&times;</span>
                <img id="modalImage" src="" alt="Expense Image" class="max-w-lg h-auto">
            </div>
        </div>
        <!-- Tambahkan jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- JavaScript for Formatting -->
        <script>
            // Menambahkan CSRF Token ke setiap AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
        </script>
        <script>
            let allExpenses = @json($expensesArray); // Simulating fetching expenses from the backend
            const userRole = @json(Auth::user()->role); // Get the user's role in JavaScript
            let selectedCategoryId = null; // Variable to store selected category
            let filteredExpenses = allExpenses; // Initially, no filter is applied
            // Function to display expenses based on category
            function showExpenses(category) {
                selectedCategoryId = category.id;

                // Filter expenses by selected category
                filteredExpenses = allExpenses.filter(expense => expense.category_id === category.id);

                const isGajiOrBonus = category.name === 'Gaji' || category.name === 'Bonus';
                const tbody = isGajiOrBonus ? document.getElementById('exception-body') : document.getElementById(
                    'expenses-body');
                // Show Gaji table and hide general table for Gaji or Bonus category
                if (isGajiOrBonus) {
                    document.getElementById('exception-table').classList.remove('hidden');
                    document.getElementById('expenses-table').classList.add('hidden');
                } else {
                    document.getElementById('expenses-table').classList.remove('hidden');
                    document.getElementById('exception-table').classList.add('hidden');
                }
                tbody.innerHTML = buildExpenseRows(filteredExpenses, category.role, category.name);
                const addExpenseButtonException = document.getElementById('add-expense-button-exception');
                const addExpenseButton = document.getElementById('add-expense-button');
                // Populate the rows for the selected category

                if (isGajiOrBonus) {
                    // Show "Add Expense" button if user has proper role or category role is 0
                    if (userRole == category.role || category.role == 0 || userRole == 0) {
                        addExpenseButtonException.classList.remove('hidden');
                        addExpenseButtonException.setAttribute('onclick', `addExpense(${selectedCategoryId})`);
                    } else {
                        addExpenseButtonException.classList.add('hidden');
                    }
                } else {
                    if (userRole == category.role || category.role == 0 || userRole == 0) {
                        addExpenseButton.classList.remove('hidden');
                        addExpenseButton.setAttribute('onclick', `addExpense(${selectedCategoryId})`);
                    } else {
                        addExpenseButton.classList.add('hidden');
                    }
                }
            }

            // Function to build table rows for expenses
            function buildExpenseRows(expenses, role, category) {
                
                
                return expenses.map(expense => {
                    const adminOrManagerName = expense.user.username;
                    
                    return `
        <tr class="bg-gray-800 hover:bg-gray-700">
            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(adminOrManagerName)}</td>
            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.date)}</td>
            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(formatCurrency(expense.amount))}</td>
            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.description)}</td>
            <td class="px-4 py-2 text-xs sm:text-sm">${sanitize(expense.method)}</td>
            ${category === 'Gaji' || category === 'Bonus' ? `
                                                            <td class="px-4 py-2 text-xs sm:text-sm">
            ${sanitize(expense.admin?.name || expense.manager?.name)}
        </td>
        <td class="px-4 py-2 text-xs sm:text-sm">
            ${sanitize(expense.admin?.name ? expense.admin.role : (expense.manager?.role || ''))}
        </td>
        <!-- Admin Name for Gaji/Bonus -->` : ''}
            <td class="px-4 py-2 text-xs sm:text-sm">
                <a href="#" onclick="openModal('{{ asset('storage/${sanitize(expense.image_url)}') }}')">
                    <img src="{{ asset('storage/${sanitize(expense.image_url)}') }}" alt="Expense Image" class="h-16 w-16 object-cover rounded">
                </a>
            </td>
            <td class="px-4 py-2 flex space-x-2 text-xs sm:text-sm">
                ${ (userRole == role || role == 0 ||userRole == 0) ? `
            <button class="px-2 py-1 bg-yellow-500 rounded text-white" onclick="editExpense(${expense.id})">Edit</button>
            <button class="px-2 py-1 bg-red-500 rounded text-white" onclick="deleteExpense(${expense.id})">Delete</button>
        ` : '<p> Hanya untuk Manajer</p>' }
            </td>
        </tr>
    `;
                }).join('');
            }


            function formatCurrency(amount) {
                // Pastikan amount adalah angka
                amount = parseFloat(amount);

                // Periksa jika amount adalah angka yang valid
                if (isNaN(amount)) {
                    return "Rp 0";
                }

                // Menghapus bagian desimal .00 jika ada
                amount = amount.toFixed(0); // Menghilangkan desimal
                // Menambahkan "Rp" di depan dan format ribuan dengan titik
                return amount.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Function to sanitize input to avoid XSS
            function sanitize(input) {
                const div = document.createElement('div');
                div.innerText = input;
                return div.innerHTML;
            }

            // Listen for input in the search bar
            document.getElementById('simple-search').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                // Filter the expenses based on the search term for multiple fields
                filteredExpenses = allExpenses.filter(expense => {
                    return expense.description.toLowerCase().includes(searchTerm) ||
                        expense.amount.toString().includes(searchTerm) ||
                        expense.method.toLowerCase().includes(searchTerm) ||
                        expense.user.username.toLowerCase().includes(searchTerm) ||
                        new Intl.DateTimeFormat('id-ID').format(new Date(expense.date)).toLowerCase().includes(
                            searchTerm);
                });

                // Filter the expenses by the selected category if a category is selected
                if (selectedCategoryId) {
                    filteredExpenses = filteredExpenses.filter(expense => expense.category_id === selectedCategoryId);
                }

                // Populate the table with the filtered expenses
                const tbody = document.getElementById('expenses-body');
                tbody.innerHTML = buildExpenseRows(filteredExpenses, 0); // Pass the appropriate role if needed
            });
            document.getElementById('simple-search-exception').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                // Filter the expenses based on the search term for multiple fields
                filteredExpenses = allExpenses.filter(expense => {
                    return expense.description.toLowerCase().includes(searchTerm) ||
                        expense.amount.toString().includes(searchTerm) ||
                        expense.method.toLowerCase().includes(searchTerm) ||
                        expense.user.username.toLowerCase().includes(searchTerm) ||
                        new Intl.DateTimeFormat('id-ID').format(new Date(expense.date)).toLowerCase().includes(
                            searchTerm);
                });

                // Filter the expenses by the selected category if a category is selected
                if (selectedCategoryId) {
                    filteredExpenses = filteredExpenses.filter(expense => expense.category_id === selectedCategoryId);
                }

                // Populate the table with the filtered expenses
                const tbody = document.getElementById('exception-body');
                tbody.innerHTML = buildExpenseRows(filteredExpenses, 0); // Pass the appropriate role if needed
            });

            function addExpense(categoryId) {
                // Set nilai categoryId di input hidden di modal
                document.getElementById('category_id').value = categoryId;
                if (categoryId === 1 || categoryId === 2) {
                    // Tampilkan elemen Select-admin jika categoryId 1 atau 2
                    document.getElementById('Select-admin').style.display = 'block';
                } else {
                    // Sembunyikan elemen Select-admin jika categoryId bukan 1 atau 2
                    document.getElementById('Select-admin').style.display = 'none';
                }
                // Tampilkan modal
                var myModal = new bootstrap.Modal(document.getElementById('addDataModal'));
                myModal.show();
            }



            function editExpense(expenseId) {
                console.log(expenseId);
                
                $.ajax({
                    url: `/pengeluaran/edit/${expenseId}`, // Menyertakan ID expense dalam URL
                    method: 'GET',
                    success: function(data) {

                        // Jika data ditemukan, masukkan data ke dalam form modal
                        $('#editDataModal #tanggal').val(data.date);
                        $('#editDataModal #nominal').val(data.amount);
                        $('#editDataModal #deskripsi').val(data.description);
                        $('#editDataModal #payment_method').val(data.method);
                        $('#editDataModal #category_id').val(data.category_id);
                        // Jika ada gambar, tampilkan gambar yang sudah ada
                        if (data.image_url) {
                            $('#editDataModal img').attr('src', '/storage/' + data.image_url).show();
                        }
                        if (data.category_id == 1 || data.category_id == 2) {
                            // Tampilkan elemen Select-admin jika categoryId 1 atau 2
                            document.getElementById('Select-recipient-edit').style.display = 'block';
                            if (data.admin_id == null) {
                                $('#editDataModal #edit_recipient_id').val(data.manager_id).trigger('change');

                            } else {
                                $('#editDataModal #edit_recipient_id').val(data.admin_id).trigger('change');

                            }
                        } else {
                            // Sembunyikan elemen Select-admin jika categoryId bukan 1 atau 2
                            document.getElementById('Select-admin-edit').style.display = 'none';
                        }

                        // Mengarahkan form ke route yang sesuai dengan ID
                        $('#editExpenseForm').attr('action', '/pengeluaran/update/' + expenseId);

                        // Tampilkan modal edit
                        $('#editDataModal').modal('show');
                    },
                    error: function() {
                        alert('Data tidak ditemukan!');
                    }
                });
            }

            function deleteExpense(expenseId) {
                // Set the form action URL dynamically (ganti `route` sesuai dengan route Anda)
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/pengeluaran/delete/${expenseId}`;

                // Set the hidden input value for the expense ID
                const expenseIdInput = document.getElementById('expenseIdInput');
                expenseIdInput.value = expenseId;

                // Tampilkan modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            }


            // Open modal to show large image
            function openModal(imageUrl) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modal.classList.remove('hidden');
                modalImage.src = imageUrl;
            }

            // Pastikan modal tertutup jika klik di area gelap
            document.getElementById('imageModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });

            // Close modal
            function closeModal() {
                document.getElementById('imageModal').classList.add('hidden');
            }
        </script>
    </div>
</x-layouts>
