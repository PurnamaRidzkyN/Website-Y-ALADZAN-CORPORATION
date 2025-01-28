<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <header>
        <div class="sticky top-0 z-10 bg-gray-800">
            <nav class="flex justify-between items-center p-4">
                <!-- Navbar untuk tampilan mobile -->
                <div class="flex space-x-4 overflow-x-auto scrollbar-hidden lg:flex-row lg:space-x-6" id="navbar-links">
                    <button onclick="toggleSection('data-admin')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Data Admin</button>
                    <button onclick="toggleSection('data-manajer')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Data
                        Manajer</button>
                    <button onclick="toggleSection('pengaturan-pesan')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Pengaturan
                        Pesan</button>
                    <button onclick="toggleSection('backup-data')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Backup Data</button>

                </div>
            </nav>
        </div>

    </header>


    <main class="p-6 bg-[#2D3748] py-16 sm:py-20">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Data Admin Section -->
        <div id="data-admin" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-300">Data Admin</h1>
            </div>
            <!-- Search and Add Data -->
            <div
                class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                <!-- Add Data Button -->
                <button type="button"
                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                    data-bs-toggle="modal" data-bs-target="#addDataAdmin">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 mr-2 w-5 h-5">
                        <path
                            d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                    </svg>
                    Tambah Data
                </button>
                <!-- Search Form -->
                <form action="{{ route('Manajemen Data') }}" method="GET" class="flex items-center w-full md:w-auto">
                    <label for="search-admin" class="sr-only">Search Admin</label>
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="search-admin" name="search_admin"
                            value="{{ request()->search_admin }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search Admin..." />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search Admin</span>
                    </button>
                    <a href="{{ route('Manajemen Data') }}"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Card Container -->
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($admins as $admin)
                    <div class="bg-gray-700 rounded-lg shadow-md p-4 flex flex-col justify-between">
                        <div class="flex justify-center items-center mb-4">
                            <img src="{{ $admin['foto'] ? asset('storage/' . $admin['foto']) : asset('Default_pfp.jpg') }}"
                                alt="Admin Photo" class="w-16 h-16 mx-auto rounded-full mb-4">
                        </div>

                        <hr id="separator" class="border-2 rounded mb-10"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div class="text-center text-gray-300">
                            <h2 class="text-lg font-bold">
                                <a href="{{ route('indexProfils', ['username' => $admin->user->username]) }}"
                                    class="text-white no-underline hover:underline">
                                    {{ $admin['name'] }}
                                </a>
                            </h2>
                            <p class="text-sm">{{ $admin->user->email }}</p>
                            <p class="text-sm">{{ $admin->user->username }}</p>
                        </div>

                        <button onclick="toggleDetails('details-{{ $loop->index }}')"
                            class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#D84C2E] transition-all">
                            Lihat Detail
                        </button>

                        <!-- Hidden Details -->
                        <div id="details-{{ $loop->index }}" class="hidden mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $admin['phone'] }}</p>
                            <p><strong>Gaji:</strong> {{ $admin['salary'] }}</p>
                            <p><strong>Total Bonus:</strong> {{ $admin->bonuses->total_amount }}</p>
                            <p><strong>Bonus Diambil:</strong> {{ $admin->bonuses->used_amount }}</p>
                            <p><strong>Bonus Sisa:</strong> {{ $admin->bonuses->remaining_amount }}</p>
                            <p><strong>Updated At:</strong> {{ $admin['updated_at'] }}</p>
                            <div class="mt-4 flex justify-between">
                                <button id="editDataAdmin"
                                    class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600"
                                    data-bs-toggle="modal" data-bs-target="#editModalAdmin{{ $admin->id }}">
                                    Edit
                                </button>
                                <button class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-600"
                                    data-bs-toggle="modal" data-bs-target="#deleteModalAdmin{{ $admin->id }}">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Data Managers Section -->
        <div id="data-manajer" class="section hidden">
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
                <form action="{{ route('Manajemen Data') }}" method="GET"
                    class="flex items-center w-full md:w-auto">
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
                            placeholder="Search Manager..." />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search Manager</span>
                    </button>
                    <a href="{{ route('Manajemen Data') }}"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Card Container -->
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
                            <p class="text-sm">{{ $manager->user->email }}</p>
                            <p class="text-sm">{{ $manager->user->username }}</p>
                        </div>
                        <hr id="separator" class="border-2 rounded mb-0"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <div id="details-{{ $loop->iteration }}" class=" mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $manager['phone'] }}</p>
                            <p><strong>Updated At:</strong> {{ $manager['updated_at'] }}</p>
                            <div class="mt-4 flex justify-between">
                                <button class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600"
                                    data-bs-toggle="modal" data-bs-target="#editModalManager{{ $manager->id }}">
                                    Edit
                                </button>
                                <button class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-600"
                                    data-bs-toggle="modal" data-bs-target="#deleteModalManager{{ $manager->id }}">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Pengaturan Pesan Section -->
        <div id="pengaturan-pesan" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-300">Pengaturan Pesan</h1>
            </div>

            <!-- Card Pesan -->
            <div class="bg-gray-700 rounded-lg shadow-md p-6 mb-4">



                <!-- Header Pesan -->
                <div class="text-gray-300 mb-4">
                    <p><strong>Header Pesan:</strong></p>
                    <p id="message-header">{{ $message->message_header ?? 'Belum ada message header' }}
                    </p>
                </div>
                <hr class="border-2 rounded mb-4" style="border-width: 1px; border-color: #FF6347;">
                <div class="text-gray-300 mb-4" id="message-header">
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Nama</strong></div>
                        <div class="ml-2">: Rizki Radika Mahendra</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Deskripsi</strong></div>
                        <div class="ml-2">: Quia ab autem quo. Perferendis esse ipsam culpa. Aut eius inventore autem
                            ut. Dolores sint pariatur consequatur aut veniam assumenda.</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Kode</strong></div>
                        <div class="ml-2">: quisquam</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Total Pembayaran</strong></div>
                        <div class="ml-2">: Rp180.327</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Dibayar</strong></div>
                        <div class="ml-2">: Rp9.737.798</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Sisa Pembayaran</strong></div>
                        <div class="ml-2">: Rp-9.557.471</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>Tanggal Awal</strong></div>
                        <div class="ml-2">: 2016-09-19</div>
                    </div>
                    <div class="flex mb-2">
                        <div class="flex-shrink-0 w-40"><strong>No HP</strong></div>
                        <div class="ml-2">: 0282 1909 910</div>
                    </div>
                </div>

                <hr class="border-2 rounded mb-4" style="border-width: 1px; border-color: #FF6347;">
                <!-- Footer Pesan -->
                <div class="text-gray-300 mb-4">
                    <p><strong>Footer Pesan:</strong></p>
                    <p id="message-footer">{{ $message->message_footer ?? 'Belum ada message footer' }}
                    </p>
                </div>

                <!-- Tombol Edit Pesan -->
                <div class="text-center">
                    <button class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600"
                        data-bs-toggle="modal" data-bs-target="#editModal">
                        Edit Pesan
                    </button>
                </div>
            </div>
        </div>
        <div id="backup-data" class="section hidden">
            <h1 class="text-xl font-bold mb-4">Backup and Restore</h1>

            <!-- Backup Button -->
            <form action="" method="POST" class="mb-4">
                @csrf
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Backup Data
                </button>
            </form>

            <!-- Restore Button -->
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="backup_file" class="block text-gray-700 font-semibold mb-2">Upload Backup File:</label>
                <input type="file" id="backup_file" name="backup_file" accept=".sql"
                    class="block w-full mb-4 border rounded p-2" required>

                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                    Restore Backup
                </button>
            </form>

            <!-- Notification Section -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-3 rounded mt-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Modal untuk Edit Pesan -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Pesan Pengaturan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('Manajemen Data.messageUpdate') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="header" class="block text-gray-300">Header Pesan</label>
                                <input type="text" id="message_header" name="message_header"
                                    value="{{ $message->message_header }}"
                                    class="w-full p-2 mt-1 rounded-md bg-gray-600 text-white"
                                    placeholder="Masukkan header pesan">
                            </div>

                            <div class="mb-4">
                                <label for="footer" class="block text-gray-300">Footer Pesan</label>
                                <input type="text" id="message_footer" name="message_footer"
                                    value="{{ $message->message_footer }}"
                                    class="w-full p-2 mt-1 rounded-md bg-gray-600 text-white"
                                    placeholder="Masukkan footer pesan">
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="addDataAdmin" tabindex="-1" aria-labelledby="addDataAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="background-color: #2D3748;">
                    <!-- Form inside the modal -->
                    <form action="{{ route('Manajemen Data.AdminStore') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No HP</label>
                            <input type="number" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Gaji</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="salary" name="salary" required>
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
    </div>
    {{-- edit admin --}}
    @foreach ($admins as $admin)
        <div class="modal fade" id="editModalAdmin{{ $admin->id }}" tabindex="-1"
            aria-labelledby="editDataAdminLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #1A2634;">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #2D3748;">
                        <!-- Form inside the modal -->
                        <form action="{{ route('Manajemen Data.AdminUpdate') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit_name" name="name"
                                    value="{{ $admin->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email"
                                    value="{{ $admin->user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">No HP</label>
                                <input type="number" class="form-control" id="edit_phone" name="phone"
                                    value="{{ $admin->phone }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_salary" class="form-label">Gaji</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="edit_salary" name="salary"
                                        value="{{ $admin->salary }}" required>
                                </div>
                            </div>


                            <!-- Hidden Input for ID -->
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="edit_id" name="id"
                                    value="{{ $admin->id }}">
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer" style="background-color: #1A2634;">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn"
                                    style="background-color: #4CAF50; color: white;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- hapus admin --}}
    <!-- Modal Konfirmasi Hapus -->
    @foreach ($admins as $admin)
        <div class="modal fade" id="deleteModalAdmin{{ $admin->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $admin->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $admin->id }}">Konfirmasi Hapus</h5>
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
                        <form id="deleteForm{{ $admin->id }}" action="{{ route('Manajemen Data.AdminDestroy') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- manajer modal --}}
    <div class="modal fade" id="addDataManajer" tabindex="-1" aria-labelledby="addDataManajerLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="background-color: #2D3748;">
                    <!-- Form inside the modal -->
                    <form action="{{ route('Manajemen Data.managerStore') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No HP</label>
                            <input type="number" class="form-control" id="phone" name="phone" required>
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
    </div>
    {{-- edit manager --}}
    @foreach ($managers as $manager)
        <div class="modal fade" id="editModalManager{{ $manager->id }}" tabindex="-1"
            aria-labelledby="editDataManagerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #1A2634;">
                        <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #2D3748;">
                        <!-- Form inside the modal -->
                        <form action="{{ route('Manajemen Data.managerUpdate') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit_name" name="name"
                                    value="{{ $manager->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email"
                                    value="{{ $manager->user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">No HP</label>
                                <input type="number" class="form-control" id="edit_phone" name="phone"
                                    value="{{ $manager->phone }}" required>
                            </div>

                            <!-- Hidden Input for ID -->
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="edit_id" name="id"
                                    value="{{ $manager->id }}">
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer" style="background-color: #1A2634;">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn"
                                    style="background-color: #4CAF50; color: white;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- hapus manager --}}
    <!-- Modal Konfirmasi Hapus -->
    @foreach ($managers as $manager)
        <div class="modal fade" id="deleteModalManager{{ $manager->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $manager->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $manager->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus manager "<strong>{{ $manager->name }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <!-- Tombol Batal dengan Ikon -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>

                        <!-- Form untuk menghapus manager -->
                        <form id="deleteForm{{ $manager->id }}"
                            action="{{ route('Manajemen Data.managerDestroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="manager_id" value="{{ $manager->id }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <script>
        // Toggle Section
        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);

            // Menyembunyikan semua konten
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(sec) {
                sec.classList.add('hidden');
            });

            // Menampilkan konten yang sesuai
            section.classList.remove('hidden');

            // Menyimpan ID section yang sedang ditampilkan ke localStorage
            localStorage.setItem('active-section', sectionId);
        }

        // Memeriksa status section yang sedang ditampilkan setelah halaman dimuat
        window.addEventListener('load', function() {
            const activeSectionId = localStorage.getItem('active-section');

            if (activeSectionId) {
                var section = document.getElementById(activeSectionId);
                if (section) {
                    // Menampilkan section yang disimpan sebelumnya
                    section.classList.remove('hidden');
                }
            }
        });

        // Toggle Details (untuk bagian lain yang perlu di-toggle)
        function toggleDetails(detailsId) {
            const details = document.getElementById(detailsId);
            details.classList.toggle('hidden');
        }


        function toggleMobileMenu() {
            const navbarLinks = document.getElementById('navbar-links');

            // Jika ukuran layar kurang dari atau sama dengan 1024px (mobile), toggle navbar
            if (window.innerWidth <= 1024) {
                navbarLinks.classList.toggle('hidden'); // Toggle antara hidden dan tampil
                navbarLinks.classList.toggle('flex'); // Menambahkan class flex agar itemnya tampil vertikal
                navbarLinks.classList.toggle('flex-col'); // Mengubah menu agar berjejer ke bawah
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-layouts>
