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
                <!-- Search Form -->
                <input type="text" id="search-admin" name="search_admin"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari admin..." onkeyup="filterAdmins()" />

            </div>

            <!-- Card Container -->
            @if ($admins->isEmpty() && empty(request('query')))
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Admin</h5>
                    <p class="mb-0">Manajer ini belum memiliki Admin.</p>
                </div>
            @endif
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($admins as $admin)
                    <div class="bg-gray-800 rounded-lg shadow-md p-4 flex flex-col justify-between admin-item">
                        <div class="flex justify-center items-center mb-4">
                            <img src="{{ $admin['foto'] ? asset('storage/' . $admin['foto']) : asset('images/Default_pfp.jpg') }}"
                                alt="admin Photo" class="w-16 h-16 mx-auto rounded-full mb-4">
                        </div>

                        <hr id="separator" class="border-2 rounded mb-10"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div class="text-center text-gray-300">
                            <h2 class="text-lg font-bold ">{{ $admin['name'] }}</h2>
                        </div>
                        <hr id="separator" class="border-2 rounded mb-0"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div id="detailsadmin-{{ $admin->id }}" class="mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $admin['phone'] }}</p>
                            <p><strong>Gaji:</strong> {{ number_format($admin['salary'], 0, ',', '.') }}</p>
                            <p><strong>Total Bonus:</strong>
                                {{ number_format($admin->bonuses->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Diambil:</strong>
                                {{ number_format($admin->bonuses->used_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Sisa:</strong>
                                {{ number_format($admin->bonuses->remaining_amount, 0, ',', '.') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $admin['updated_at'] }}</p>
                        </div>

                        <div class="mt-4">
                            <!-- Tombol Lihat Laporan -->
                            <button
                                class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600 w-full mb-4 edit-btn-code"
                                data-bs-toggle="modal" data-bs-target="#editModaladmin" data-id="{{ $admin->id }}">
                                Lihat laporan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal untuk Lihat Laporan -->
    <div class="modal fade" id="editModaladmin" tabindex="-1" aria-labelledby="editDataadminLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reports.bonuses.admin') }}" method="POST"
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
        // Set the data admin id and details when the modal is triggered
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Edit
            const editButtons = document.querySelectorAll(".edit-btn-code");

            // Loop setiap tombol Edit
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil modal
                    const modal = document.getElementById("editModaladmin");

                    // Masukkan data ke dalam modal
                    const adminId = this.getAttribute("data-id"); // Get the data-id value
                    modal.querySelector("#data_id").value =
                        adminId; // Set the hidden input with the data-id
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search-admin");
            const adminItems = document.querySelectorAll(".admin-item");

            searchInput.addEventListener("keyup", function() {
                const searchText = searchInput.value.toLowerCase();

                adminItems.forEach(function(admin) {
                    const adminName = admin.querySelector("h2").textContent.toLowerCase();

                    if (adminName.includes(searchText)) {
                        admin.style.display = "block"; // Tampilkan jika cocok
                    } else {
                        admin.style.display = "none"; // Sembunyikan jika tidak cocok
                    }
                });
            });
        });
    </script>


</x-layouts>
