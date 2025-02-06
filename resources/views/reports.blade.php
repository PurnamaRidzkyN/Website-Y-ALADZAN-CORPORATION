<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1&display=swap">

    <div class="bg-gray-900 min-h-screen p-6 text-white">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <!-- Absensi -->
            <a href="{{ route('reports.attendances') }}" style="text-decoration: none; color: inherit;"
                class="bg-gray-800 p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl font-semibold">Absensi</h2>
            </a>

            <!-- Bonus -->
            @if (Auth::user()->role == 1)
                <a href="{{ route('reports.bonuses.admins', ['id' => App\Models\Manager::where('user_id', Auth::id())->value('id')]) }}"
                    style="text-decoration: none; color: inherit;"
                    class="bg-gray-800 p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl">money_bag</span>
                    <h2 class="text-xl font-semibold">Bonus</h2>
                </a>
            @elseif (Auth::user()->role == 0)
                <a href="{{ route('reports.bonuses') }}" style="text-decoration: none; color: inherit;"
                    class="bg-gray-800 p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl">money_bag</span>
                    <h2 class="text-xl font-semibold">Bonus</h2>
                </a>
            @endif
            @if (Auth::user()->role == 0)
                <!-- Pembayaran -->
                <a href="{{ route('reports.payment') }}" style="text-decoration: none; color: inherit;"
                    class="bg-gray-800 p-4 rounded-lg shadow-lg hover:bg-gray-700 cursor-pointer flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl">payments</span>
                    <h2 class="text-xl font-semibold">Pembayaran</h2>
                </a>
            @endif
        </div>
    </div>
</x-layouts>
