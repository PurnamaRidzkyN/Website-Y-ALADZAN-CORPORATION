<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-gray-800" x-data="{ isOpen: false }">

    @if (Auth::user()->role == 1)
        <!-- Jika role adalah 1, cari data manajer -->
        @php
            $user = App\Models\Manager::where('user_id', Auth::user()->id)->first();
        @endphp
    @elseif (Auth::user()->role == 2)
        <!-- Jika role adalah 2, cari data admin -->
        @php
            $user = App\Models\Admin::where('user_id', Auth::user()->id)->first();
        @endphp
    @endif

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-10" src="{{ asset('icon.png') }}" alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-links href="/home">Home</x-nav-links>
                        <x-nav-links href="/transaksi-pembayaran">Transaksi Pembayaran</x-nav-links>
                        <x-nav-links href="/pengeluaran">Pencatatan Pengeluaran</x-nav-links>
                        <x-nav-links href="/absensi">Absensi</x-nav-links>

                        @if (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                            <!-- Menampilkan Manajemen Data Hanya untuk Role 1 -->
                            <x-nav-links href="/manajemen-data">Manajemen Data</x-nav-links>
                        @endif
                        @if (Auth::check() &&  Auth::user()->role == 0)
                            <!-- Menampilkan Manajemen Data Hanya untuk Role 1 -->
                            <x-nav-links href="/laporan">Laporan</x-nav-links>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    @if (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2))
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="size-8 rounded-full"
                                        src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('Default_pfp.jpg') }}"
                                        alt="">
                                </button>
                            </div>

                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <!-- Active: "bg-gray-100 outline-none", Not Active: "" -->
                                <a href="{{ route('indexProfils', ['username' => Auth::user()->username]) }}"
                                    class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="user-menu-item-0">Lihat Profil</a>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700"
                                    role="menuitem" tabindex="-1" id="user-menu-item-2">Log out</a>
                            </div>
                        </div>
                    @else
                        <x-nav-links href="{{ route('logout') }}">Log out</x-nav-links>
                    @endif
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'hidden': !isOpen, 'block': isOpen }"class="hidden size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <x-nav-links href="/home">Home</x-nav-links>
            <x-nav-links href="/transaksi-pembayaran">Pembayaran</x-nav-links>
            <x-nav-links href="/pengeluaran">Pengeluaran</x-nav-links>
            <x-nav-links href="/absensi">Absensi</x-nav-links>
            @if (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 0))
                <x-nav-links href="/manajemen-data">Manajemen Data</x-nav-links>
            @endif
            @if (Auth::check() && Auth::user()->role == 0)
                <x-nav-links href="/laporan">Laporan</x-nav-links>
            @endif
            @if (Auth::check() && Auth::user()->role == 0)
                <x-nav-links href="{{ route('logout') }}">Log out</x-nav-links>
            @endif
        </div>
        @if (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2))
            <div class="border-t border-gray-700 pb-3 pt-4">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full"
                            src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('Default_pfp.jpg') }}"
                            alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">
                            {{ $user->name }}
                        </div>
                        <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                    </div>

                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('indexProfils', ['username' => Auth::user()->username]) }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Lihat
                        Profil</a>

                    <a href="{{ route('logout') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Log
                        out</a>
                </div>
            </div>
        @endif
    </div>
</nav>
