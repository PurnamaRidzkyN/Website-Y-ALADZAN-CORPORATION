<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <header>
        <div class="sticky top-0 z-10 bg-gray-800">
            <nav class="flex justify-between items-center p-4">
                <!-- Navbar untuk tampilan mobile -->
                <div class="flex space-x-4 overflow-x-auto scrollbar-hidden lg:flex-row lg:space-x-6" id="navbar-links">
                    <button onclick="toggleSection('data-admin')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Data Admin</button>
                    @if (Auth::check() && Auth::user()->role == 0)
                        <button onclick="toggleSection('data-manajer')"
                            class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Data
                            Manajer</button>
                    @endif
                    <button onclick="toggleSection('pengaturan-pesan')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Pengaturan
                        Pesan</button>
                    @if (Auth::check() && Auth::user()->role == 0)
                        <button onclick="toggleSection('pengaturan-kode')"
                            class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Pengaturan
                            Kode</button>
                    @endif
                    <button onclick="toggleSection('backup-data')"
                        class="text-gray-300 py-2 px-4 rounded whitespace-nowrap hover:bg-gray-700">Backup
                        Data</button>

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
                @if (Auth::check() && Auth::user()->role == 1)
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
                @endif
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
                            placeholder="Cari Admin..." />
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
            @if ($admins->isEmpty() && empty(request('query')))
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Admin</h5>
                    <p class="mb-0">Anda saat ini belum memiliki admin. Silakan tambahkan admin.</p>
                </div>
            @endif
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

                        <button onclick="toggleAdminDetails('detailsAdmin-{{ $admin->id }}')"
                            class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#D84C2E] transition-all">
                            Lihat Detail
                        </button>

                        <!-- Hidden Details -->
                        <div id="detailsAdmin-{{ $admin->id }}" class="hidden mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $admin['phone'] }}</p>
                            <p><strong>Gaji:</strong> {{ number_format($admin['salary'], 0, ',', '.') }}</p>
                            <p><strong>Total Bonus:</strong>
                                {{ number_format($admin->bonuses->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Diambil:</strong>
                                {{ number_format($admin->bonuses->used_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Sisa:</strong>
                                {{ number_format($admin->bonuses->remaining_amount, 0, ',', '.') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $admin['updated_at'] }}</p>
                            <div class="mt-4 flex justify-between">
                                @if (Auth::check() && Auth::user()->role == 1)
                                <button
                                    class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600 edit-btn-admin"
                                    data-bs-toggle="modal" data-bs-target="#editModalAdmin"
                                    data-id="{{ $admin->id }}" data-name="{{ $admin->name }}"
                                    data-email="{{ $admin->user->email }}" data-phone="{{ $admin->phone }}"
                                    data-salary="{{ number_format($admin->salary, 0, ',', '.') }}">
                                    Edit
                                </button>

                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModalAdmin" data-id="{{ $admin->id }}"
                                    data-name="{{ $admin->name }}">
                                    Hapus
                                </button>
                                @endif
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
                            placeholder="Cari Manager..." />
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
                            <p class="text-sm">{{ $manager->user->email }}</p>
                            <p class="text-sm">{{ $manager->user->username }}</p>
                        </div>
                        <hr id="separator" class="border-2 rounded mb-0"
                            style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                        <button onclick="toggleManagerDetails('detailsManager-{{ $manager->id }}')"
                            class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#D84C2E] transition-all">
                            Lihat Detail
                        </button>
                        <div id="detailsManager-{{ $manager->id }}" class="hidden mt-4 text-sm text-gray-300">
                            <p><strong>Phone:</strong> {{ $manager['phone'] }}</p>
                            <p><strong>Gaji:</strong> {{ number_format($manager['salary'], 0, ',', '.') }}</p>
                            <p><strong>Total Bonus:</strong>
                                {{ number_format($manager->bonuses->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Diambil:</strong>
                                {{ number_format($manager->bonuses->used_amount, 0, ',', '.') }}</p>
                            <p><strong>Bonus Sisa:</strong>
                                {{ number_format($manager->bonuses->remaining_amount, 0, ',', '.') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $manager['updated_at'] }}</p>
                            <div class="mt-4 flex justify-between">
                                <button
                                    class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600 edit-btn-manager"
                                    data-bs-toggle="modal" data-bs-target="#editModalManager"
                                    data-id="{{ $manager->id }}" data-name="{{ $manager->name }}"
                                    data-email="{{ $manager->user->email }}" data-phone="{{ $manager->phone }}"
                                    data-salary="{{ number_format($manager->salary, 0, ',', '.') }}">
                                    Edit
                                </button>

                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModalManager" data-id="{{ $manager->id }}"
                                    data-name="{{ $manager->name }}">
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
                    <div class="ml-2">
                        <ul id="payment-details">
                            <li><strong>Pembayaran:</strong></li>
                            <li>Tanggal Awal : 2025-04-01</li>
                            <li>Total : Rp7.000.000</li>
                            <li>Sudah Dibayar : Rp5.000.000</li>
                            <li>Sisa : Rp2.000.000</li>
                        </ul>
                    </div>

                    <div class="flex mb-2">
                        <div class="ml-2">
                            <ul id="payment-breakdown">
                                <li><strong>Rincian Pembayaran</strong></li>
                                <li>Tanggal Pembayaran: 2025-05-09 | Jumlah: Rp2.000.000</li>
                                <li>Tanggal Pembayaran: 2025-06-24 | Jumlah: Rp3.000.000</li>
                            </ul>
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
        </div>
        <!-- Data code Section -->
        <div id="pengaturan-kode" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-300">Data Kode</h1>
            </div>
            <!-- Search and Add Data -->
            <div
                class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                <!-- Add Data Button -->
                <button type="button"
                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                    data-bs-toggle="modal" data-bs-target="#addDataCode">
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
                    <label for="search-code" class="sr-only">Search Kode</label>
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="search-code" name="search_code"
                            value="{{ request()->search_code }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari code..." />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search Kode</span>
                    </button>
                    <a href="{{ route('Manajemen Data') }}"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Card Container -->
            @if ($codes->isEmpty() && empty(request('query')))
                <div class="alert alert-warning text-center mt-4 mx-auto" role="alert" style="max-width: 400px;">
                    <h5 class="alert-heading">Belum Ada Kode</h5>
                    <p class="mb-0">Anda saat ini belum memiliki Kode. Silakan tambahkan kode.</p>
                </div>
            @endif
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($codes as $code)
                    <div class="bg-gray-700 rounded-lg shadow-md p-4 flex flex-col justify-between">

                        <div class="text-gray-300">
                            <h2 class="text-lg font-bold">{{ $code->code }}</h2>
                            <div class="flex text-sm"><span class="w-32">Bonus
                                    Admin</span><span>: {{ $code->admin_bonuses }}</span></div>
                            <div class="flex text-sm"><span class="w-32">Bonus
                                    Manajer</span><span>: {{ $code->manager_bonuses }}</span></div>
                            <div class="flex text-sm"><span class="w-32">Modal
                                    Awal</span><span>: {{ $code->capital }}</span></div>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <button class="bg-green-500 text-white py-1 px-4 rounded hover:bg-green-600 edit-btn-code"
                                data-bs-toggle="modal" data-bs-target="#editModalCode" data-id="{{ $code->id }}"
                                data-code="{{ $code->code }}"
                                data-admin-bonuses="{{ number_format($code->admin_bonuses, 0, ',', '.') }}"
                                data-manager-bonuses="{{ number_format($code->manager_bonuses, 0, ',', '.') }}"
                                data-capital="{{ number_format($code->capital, 0, ',', '.') }}">
                                Edit
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalCode"
                                data-id="{{ $code->id }}" data-code="{{ $code->code }}">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="backup-data" class="section hidden">
            <div class="container text-center mt-1">
                <h2 class="text-white mb-4">Backup Database</h2>

                <!-- Backup Button -->
                <form action="{{ Route('backupDatabase') }}" method="get" enctype="multipart/form-data"
                    class="text-white">
                    <button type="submit" id="backupButton" class="btn btn-primary btn-lg">
                        Backup Database
                    </button>
                </form>
                <p id="backupMessage" class="text-white mt-3"></p>
            </div>


            <!-- Restore Section -->
            <div class="container mt-5">
                <h2 class="text-white mb-4">Restore Backup</h2>
                <form action="{{ route('restoreDatabase') }}" method="POST" enctype="multipart/form-data"
                    class="text-white">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="backup_file" class="text-white font-semibold">Upload Backup File:</label>
                        <input type="file" id="backup_file" name="backup_file" accept=".sql"
                            class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Restore Backup
                    </button>
                </form>
            </div>
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
                                    value="{{ $message->message_header ?? '' }}
"
                                    class="w-full p-2 mt-1 rounded-md bg-gray-600 text-white"
                                    placeholder="Masukkan header pesan">
                            </div>

                            <div class="mb-4">
                                <label for="footer" class="block text-gray-300">Footer Pesan</label>
                                <input type="text" id="message_footer" name="message_footer"
                                    value="{{ $message->message_footer ?? '' }}"
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
                    <form action="{{ route('Manajemen Data.adminStore') }}" method="POST">
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
                                <input type="text" class="form-control" id="salary" name="salary"
                                    oninput="formatMoney(this)" onblur="removeFormatting(this)"
                                    onfocus="addFormatting(this)">
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
    <div class="modal fade" id="editModalAdmin" tabindex="-1" aria-labelledby="editDataAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="background-color: #2D3748;">
                    <!-- Form inside the modal -->
                    <form action="{{ route('Manajemen Data.adminUpdate') }}" method="POST"
                        onsubmit="removeFormattingBeforeSubmit()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">No HP</label>
                            <input type="number" class="form-control" id="edit_phone" name="phone" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_salary" class="form-label">Gaji</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control money-input" id="edit_salary"
                                    name="salary" required oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>

                        <div class="modal-footer" style="background-color: #1A2634;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn"
                                style="background-color: #4CAF50; color: white;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- hapus admin --}}
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModalAdmin" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus admin "<strong id="deleteAdminName"></strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <form id="deleteForm" action="{{ route('Manajemen Data.adminDestroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="admin_id" id="deleteAdminId">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="mb-3">
                            <label for="salary" class="form-label">Gaji</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="salary" name="salary"
                                    oninput="formatMoney(this)" onblur="removeFormatting(this)"
                                    onfocus="addFormatting(this)">
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
    {{-- edit manager --}}
    <div class="modal fade" id="editModalManager" tabindex="-1" aria-labelledby="editDataManagerLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('Manajemen Data.managerUpdate') }}" method="POST"
                        onsubmit="removeFormattingBeforeSubmit()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">No HP</label>
                            <input type="number" class="form-control" id="edit_phone" name="phone" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_salary" class="form-label">Gaji</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control money-input" id="edit_salary"
                                    name="salary" required oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>

                        <div class="modal-footer" style="background-color: #1A2634;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn"
                                style="background-color: #4CAF50; color: white;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- hapus manager --}}
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModalManager" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus manager "<strong id="deleteManagerName"></strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <form id="deleteForm" action="{{ route('Manajemen Data.managerDestroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="manager_id" id="deleteManagerId">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal code --}}
    <div class="modal fade" id="addDataCode" tabindex="-1" aria-labelledby="addDataCodeLabel" aria-hidden="true">
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
                    <form action="{{ route('Manajemen Data.codeStore') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin_bonuses" class="form-label">Bonus Admin</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="admin_bonuses" name="admin_bonuses"
                                    oninput="formatMoney(this)" onblur="removeFormatting(this)"
                                    onfocus="addFormatting(this)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="manager_bonuses" class="form-label">Bonus Manajer</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="manager_bonuses"
                                    name="manager_bonuses" oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="capital" class="form-label">Modal Awal</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="capital" name="capital"
                                    oninput="formatMoney(this)" onblur="removeFormatting(this)"
                                    onfocus="addFormatting(this)">
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
    <div class="modal fade" id="editModalCode" tabindex="-1" aria-labelledby="editDataCodeLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <div class="modal-header" style="background-color: #1A2634;">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('Manajemen Data.codeUpdate') }}" method="POST"
                        onsubmit="removeFormattingBeforeSubmit()">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_code" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="edit_code" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_admin_bonuses" class="form-label">Bonus Admin</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control money-input" id="edit_admin_bonuses"
                                    name="admin_bonuses" required oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_manager_bonuses" class="form-label">Bonus Manager</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control money-input" id="edit_manager_bonuses"
                                    name="manager_bonuses" required oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_capital" class="form-label">Modal Awal</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control money-input" id="edit_capital"
                                    name="capital" required oninput="formatMoney(this)"
                                    onblur="removeFormatting(this)" onfocus="addFormatting(this)">
                            </div>
                        </div>

                        <div class="modal-footer" style="background-color: #1A2634;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn"
                                style="background-color: #4CAF50; color: white;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModalCode" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus code "<strong id="deleteCode"></strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <form id="deleteForm" action="{{ route('Manajemen Data.codeDestroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="code_id" id="deleteCodeId">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
        function toggleAdminDetails(detailsAdminId) {
            const details = document.getElementById(detailsAdminId);
            details.classList.toggle('hidden');
        }

        function toggleManagerDetails(detailsManagerId) {
            const details = document.getElementById(detailsManagerId);
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

        function formatMoney(input) {
            let value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter selain angka
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambah titik setiap 3 digit
        }

        // Fungsi untuk menghapus titik sebelum kirim form
        function removeFormatting(input) {
            input.value = input.value.replace(/\./g, ''); // Hapus titik
        }

        function removeFormattingBeforeSubmit() {
            const salaryInputs = document.querySelectorAll(
                '.money-input'); // Pilih semua elemen dengan kelas 'money-input'

            salaryInputs.forEach(function(input) {
                // Menghapus titik (pemformatan ribuan) sebelum dikirim
                input.value = input.value.replace(/[^\d]/g, '');
            });
        }

        // Fungsi untuk menambahkan titik ketika input difokuskan
        function addFormatting(input) {
            let value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter selain angka
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambah titik setiap 3 digit
        }
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Edit
            const editButtons = document.querySelectorAll(".edit-btn-manager");

            // Loop setiap tombol Edit
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil modal
                    const modal = document.getElementById("editModalManager");

                    // Masukkan data ke dalam modal
                    modal.querySelector("#edit_id").value = this.getAttribute("data-id");
                    modal.querySelector("#edit_name").value = this.getAttribute("data-name");
                    modal.querySelector("#edit_email").value = this.getAttribute("data-email");
                    modal.querySelector("#edit_phone").value = this.getAttribute("data-phone");
                    modal.querySelector("#edit_salary").value = this.getAttribute("data-salary");
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Hapus
            const deleteButtons = document.querySelectorAll(
                "[data-bs-toggle='modal'][data-bs-target='#deleteModalManager']");

            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil data dari tombol
                    const managerId = this.getAttribute("data-id");
                    const managerName = this.getAttribute("data-name");

                    // Masukkan data ke dalam modal
                    document.getElementById("deleteManagerName").textContent = managerName;
                    document.getElementById("deleteManagerId").value = managerId;
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Edit
            const editButtons = document.querySelectorAll(".edit-btn-admin");

            // Loop setiap tombol Edit
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil modal
                    const modal = document.getElementById("editModalAdmin");

                    // Masukkan data ke dalam modal
                    modal.querySelector("#edit_id").value = this.getAttribute("data-id");
                    modal.querySelector("#edit_name").value = this.getAttribute("data-name");
                    modal.querySelector("#edit_email").value = this.getAttribute("data-email");
                    modal.querySelector("#edit_phone").value = this.getAttribute("data-phone");
                    modal.querySelector("#edit_salary").value = this.getAttribute("data-salary");
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Hapus
            const deleteButtons = document.querySelectorAll(
                "[data-bs-toggle='modal'][data-bs-target='#deleteModalAdmin']");

            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil data dari tombol
                    const adminId = this.getAttribute("data-id");
                    const adminName = this.getAttribute("data-name");

                    // Masukkan data ke dalam modal
                    document.getElementById("deleteAdminName").textContent = adminName;
                    document.getElementById("deleteAdminId").value = adminId;
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Edit
            const editButtons = document.querySelectorAll(".edit-btn-code");

            // Loop setiap tombol Edit
            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil modal
                    const modal = document.getElementById("editModalCode");

                    // Masukkan data ke dalam modal
                    modal.querySelector("#edit_id").value = this.getAttribute("data-id");
                    modal.querySelector("#edit_code").value = this.getAttribute("data-code");
                    modal.querySelector("#edit_admin_bonuses").value = this.getAttribute(
                        "data-admin-bonuses");
                    modal.querySelector("#edit_manager_bonuses").value = this.getAttribute(
                        "data-manager-bonuses");
                    modal.querySelector("#edit_capital").value = this.getAttribute("data-capital");
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Pilih semua tombol Hapus
            const deleteButtons = document.querySelectorAll(
                "[data-bs-toggle='modal'][data-bs-target='#deleteModalCode']");

            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // Ambil data dari tombol
                    const codeId = this.getAttribute("data-id");
                    const code = this.getAttribute("data-code");

                    // Masukkan data ke dalam modal
                    document.getElementById("deleteCode").textContent = code;
                    document.getElementById("deleteCodeId").value = codeId;
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-layouts>
