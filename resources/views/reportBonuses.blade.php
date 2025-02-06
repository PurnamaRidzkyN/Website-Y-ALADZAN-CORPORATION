<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (termasuk popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="bg-gray-900 min-h-screen p-6 text-white">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div id="data-manajer">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-300">Data Manajer</h1>
            </div>
            <!-- Search and Add Data -->
            <div
                class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                <!-- Add Data Button -->
                <button type="button"
                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                    data-bs-toggle="modal" data-bs-target="#addDataManajer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 mr-2 w-5 h-5">
                        <path
                            d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                    </svg>
                    Tambah Data
                </button>
                <!-- Search Form -->
                <form action="{{ route('reports.bonuses') }}" method="GET" class="flex items-center w-full md:w-auto">
                    <label for="search-manager" class="sr-only">Search Manager</label>
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="search-manager" name="search_manager"
                            value="{{ request()->search_manager }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari Manager..." />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search Manager</span>
                    </button>
                    <a href="{{ route('reports.bonuses') }}"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Card Container -->
            @if ($managers->isEmpty() && empty(request('query')))
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Manajer</h5>
                    <p class="mb-0">Anda saat ini belum memiliki Manajer. Silakan tambahkan Manajer.</p>
                </div>
            @endif
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($managers as $manager)
                    <div class="bg-gray-700 rounded-lg shadow-md p-4 flex flex-col justify-between">
                        <div class="flex justify-center items-center mb-4">
                            <img src="{{ $manager['foto'] ? asset('storage/' . $manager['foto']) : asset('images/Default_pfp.jpg') }}"
                                alt="Manager Photo" class="w-16 h-16 mx-auto rounded-full mb-4">
                        </div>

                        <hr id="separator" class="border-2 rounded mb-10"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div class="text-center text-gray-300">
                            <h2 class="text-lg font-bold">{{ $manager['name'] }}</h2>
                        </div>
                        <hr id="separator" class="border-2 rounded mb-0"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div id="detailsManager-{{ $manager->id }}" class="mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $manager['phone'] }}</p>
                            <p><strong>Gaji:</strong> {{ number_format($manager['salary'], 0, ',', '.') }}</p>
                            <p><strong>Total Bonus:</strong>
                                {{ number_format($manager->bonuses->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Diambil:</strong>
                                {{ number_format($manager->bonuses->used_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Sisa:</strong>
                                {{ number_format($manager->bonuses->remaining_amount, 0, ',', '.') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $manager['updated_at'] }}</p>
                        </div>

                        <div class="mt-4">
                            <!-- Tombol Lihat Laporan -->
                            <button
                                class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600 w-full mb-4 edit-btn-code"
                                data-bs-toggle="modal" data-bs-target="#editModalManager"
                                data-id="{{ $manager->id }}">
                                Lihat laporan
                            </button>

                            <!-- Lihat admin button -->
                            <button class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-600 w-full"
                                data-bs-toggle="modal" data-bs-target="#deleteModalManager"
                                data-id="{{ $manager->id }}" data-name="{{ $manager->name }}">
                                Lihat admin
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal untuk Lihat Laporan -->
    <div class="modal fade" id="editModalManager" tabindex="-1" aria-labelledby="editDataManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reports.bonuses.manager') }}" method="POST"
                        onsubmit="removeFormattingBeforeSubmit()">
                        @csrf
                        <input type="hidden" id="data_id" name="id">

                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan</label>
                            <input type="month" class="form-control" id="month" name="month" required>
                        </div>

                        <div class="modal-footer" style="background-color: #1A2634;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Cek Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set the data manager id and details when the modal is triggered
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Edit
            const editButtons = document.querySelectorAll(".edit-btn-code");

            // Loop setiap tombol Edit
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil modal
                    const modal = document.getElementById("editModalManager");

                    // Masukkan data ke dalam modal
                    const managerId = this.getAttribute("data-id"); // Get the data-id value
                    modal.querySelector("#data_id").value =
                        managerId; // Set the hidden input with the data-id
                });
            });
        });


        // Handle form submission
        $('#reportForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting the default way

            var formData = $(this).serialize(); // Collect form data

            // Clear previous error message
            $('#error-message').hide().text('');

            // Send the data to the server using Ajax
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Jika laporan ada, arahkan ke halaman lain
                        window.location.href = response.redirect_url;
                    } else {
                        // Jika tidak ada laporan, tampilkan pesan error
                        $('#error-message').text(
                                'Gaji belum dibayar atau tidak ada laporan untuk bulan tersebut.')
                            .show();
                    }
                },
                error: function(xhr, status, error) {
                    // Jika terjadi error
                    $('#error-message').text('Terjadi kesalahan. Silakan coba lagi.').show();
                }
            });
        });
    </script>
</x-layouts>
