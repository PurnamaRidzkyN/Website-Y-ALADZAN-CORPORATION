<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <div class="min-h-screen bg-gray-800 flex items-start justify-center py-10 h-full">


        <div class="bg-gray-900 shadow-lg rounded-lg p-6 w-full max-w-4xl h-full">
            <div class="flex flex-col lg:flex-row items-start">
                <!-- Foto Profil -->
                <div class="lg:w-1/4 w-full flex justify-center mb-6 lg:mb-0">
                    <img class="w-32 h-32 rounded-full shadow-md"
                        src="{{ $user['foto'] ? asset('storage/' . $user['foto']) : asset('Default_pfp.jpg') }}"
                        alt="Foto Profil">
                </div>


                <!-- Informasi Pengguna -->
                <div class="lg:w-3/4 w-full lg:ml-6">
                    <h2 class="text-xl font-semibold text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-300">{{ $users->email }}</p>
                    <p class="text-sm text-gray-400 mt-1">Username: <span
                            class="font-medium text-white">{{ $users->username }}</span></p>
                    <p class="text-sm text-gray-400 mt-1">No. Telpon: <span
                            class="font-medium text-white">{{ $user->phone }}</span></p>

                    @if ($users->role == 2)
                        <p class="text-sm text-gray-400 mt-1">Gaji: <span
                                class="font-medium text-white">{{ $user->salary }}</span></p>
                    @endif
                    <p class="text-sm text-gray-400 mt-1">Diperbarui pada: <span
                            class="font-medium text-white">{{ $user->updated_at }}</span></p>
                    <!-- Tombol Aksi -->
                    <div class="mt-6 flex space-x-4">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                            data-bs-toggle="modal" data-bs-target="#editUsersModal-{{ $user->id }}">
                            Edit Profil
                        </button>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded"
                            data-bs-toggle="modal" data-bs-target="#changePasswordModal">Ganti Kata
                            Sandi</button>
                    </div>
                </div>
            </div>
            <!-- Modal Ganti Kata Sandi -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                        <!-- Header Modal -->
                        <div class="modal-header" style="background-color: #1A2634;">
                            <h5 class="modal-title font-bold" id="changePasswordModalLabel">Ganti Kata Sandi</h5>
                            <button type="button" class="btn-close bg-[#A0AEC0] hover:bg-[#F7FAFC]"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Body Modal -->
                        <div class="modal-body bg-[#2D3748]">
                            <form action="{{ route('changePassword') }}" method="POST">
                                @csrf
                                <!-- Password Lama -->
                                <div class="mb-4">
                                    <label for="currentPassword"
                                        class="block mb-2 text-sm font-medium text-[#F7FAFC]">Password Lama</label>
                                    <div class="relative">
                                        <input type="password" name="currentPassword"
                                            class="password-field bg-[#1A2634] border border-[#A0AEC0] text-[#F7FAFC] rounded-lg focus:ring-[#00B5D8] focus:border-[#00B5D8] block w-full p-2.5"
                                            placeholder="••••••••" required>
                                        <button type="button"
                                            class="toggle-password absolute inset-y-0 right-3 text-[#A0AEC0] hover:text-[#F7FAFC]">
                                            Lihat
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Baru -->
                                <div class="mb-4">
                                    <label for="newPassword"
                                        class="block mb-2 text-sm font-medium text-[#F7FAFC]">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" name="newPassword"
                                            class="password-field bg-[#1A2634] border border-[#A0AEC0] text-[#F7FAFC] rounded-lg focus:ring-[#00B5D8] focus:border-[#00B5D8] block w-full p-2.5"
                                            placeholder="••••••••" required>
                                        <button type="button"
                                            class="toggle-password absolute inset-y-0 right-3 text-[#A0AEC0] hover:text-[#F7FAFC]">
                                            Lihat
                                        </button>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password Baru -->
                                <div class="mb-4">
                                    <label for="confirmNewPassword"
                                        class="block mb-2 text-sm font-medium text-[#F7FAFC]">Konfirmasi Password
                                        Baru</label>
                                    <div class="relative">
                                        <input type="password" name="confirmNewPassword"
                                            class="password-field bg-[#1A2634] border border-[#A0AEC0] text-[#F7FAFC] rounded-lg focus:ring-[#00B5D8] focus:border-[#00B5D8] block w-full p-2.5"
                                            placeholder="••••••••" required>
                                        <button type="button"
                                            class="toggle-password absolute inset-y-0 right-3 text-[#A0AEC0] hover:text-[#F7FAFC]">
                                            Lihat
                                        </button>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full text-[#F7FAFC] bg-[#3182CE] hover:bg-[#00B5D8] focus:ring-4 focus:outline-none focus:ring-[#00B5D8] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Pengguna -->
            <div class="modal fade" id="editUsersModal-{{ $user->id }}" tabindex="-1"
                aria-labelledby="editUsersModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                        <div class="modal-header" style="background-color: #1A2634;">
                            <h5 class="modal-title" id="editUsersModalLabel{{ $user->id }}">Edit Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #2D3748;">
                            <!-- Form Edit -->
                            <form action="{{ route('updateUser', ['username' => $users->username]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Menggunakan method PUT untuk update -->
                                <div class="mb-4">
                                    <label for="photo" class="block text-sm text-gray-600"
                                        style="color: #fff;">Foto
                                        Profil</label>

                                    <!-- Menampilkan foto yang sudah ada -->
                                    @if ($user->foto)
                                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                            class="w-32 h-32 rounded-full mb-4">
                                    @endif

                                    <!-- Input untuk mengganti foto -->
                                    <input type="file" id="photo" name="photo"
                                        class="w-full mt-2 p-2 border rounded"
                                        style="background-color: #1A2634; color: #F7FAFC;">
                                </div>
                                <div class="mb-4">
                                    <label for="name"
                                        class="block text-sm text-gray-600"style=" color: #fff;">Nama</label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                                        class="w-full mt-2 p-2 border rounded"
                                        style="background-color: #1A2634; color: #F7FAFC;" required>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-sm text-gray-600"
                                        style="color: #fff;">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $users->email }}"
                                        class="w-full mt-2 p-2 border rounded"
                                        style="background-color: #1A2634; color: #F7FAFC;" required>
                                </div>

                                <div class="mb-4">
                                    <label for="username"
                                        class="block text-sm text-gray-600"style="color: #fff;">Username</label>
                                    <input type="text" id="username" name="username"
                                        value="{{ $users->username }}" class="w-full mt-2 p-2 border rounded"
                                        style="background-color: #1A2634; color: #F7FAFC;" required>
                                </div>

                                <div class="mb-4">
                                    <label for="phone" class="block text-sm text-gray-600"style="color: #fff;">No.
                                        Telpon</label>
                                    <input type="number" id="phone" name="phone" value="{{ $user->phone }}"
                                        class="w-full mt-2 p-2 border rounded"
                                        style="background-color: #1A2634; color: #F7FAFC;" required>
                                </div>

                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            @if ($users->role == 2)
                <div class="mt-8 flex flex-col lg:flex-row gap-6">
                    <!-- Grafik Total Bonus yang Diambil -->
                    <div class="p-6 bg-[#2D3748] mt-8 rounded-lg flex-1">
                        <h4 class="text-lg font-semibold text-white">Grafik Bonus Diambil</h4>
                        <!-- Batasan lebar dan tinggi untuk canvas -->
                        <canvas id="bonusChart" class="mt-4 w-full max-h-[200px]"></canvas>
                        <p class="text-sm text-gray-300 mt-4">Total Bonus: Rp
                            {{ number_format($user->bonuses->total_amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-300">Bonus Diambil: Rp
                            {{ number_format($user->bonuses->used_amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Kontainer untuk Total Payments dan Total Amount + Progress Bar -->
                    <div class="lg:w-1/2 flex-1 flex flex-col gap-6">
                        <!-- Pembayaran Total -->
                        <h4 class="text-lg font-semibold text-white">Pembayaran Total</h4>
                        <div class="flex lg:flex-row flex-col gap-6">
                            <!-- Total Payments -->
                            <div class="bg-[#FF6347] p-6 rounded-lg flex-1">
                                <h4 class="text-lg font-semibold text-white">Dibayar</h4>
                                <p class="text-xl text-white">Rp
                                    {{ number_format($totalLoans->total_payments, 0, ',', '.') }}</p>
                            </div>

                            <!-- Total Amount -->
                            <div class="bg-[#00B5D8] p-6 rounded-lg flex-1">
                                <h4 class="text-lg font-semibold text-white">Total</h4>
                                <p class="text-xl text-white">Rp
                                    {{ number_format($totalLoans->total_amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Progress Bar untuk Pembayaran -->
                        <div class="p-6 bg-[#2D3748] mt-8 rounded-lg flex-1">
                            <canvas id="paymentChart" class="mt-4"></canvas>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    @if ($users->role == 2)
        <!-- Tambahkan Script untuk Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const bonusCtx = document.getElementById('bonusChart').getContext('2d');
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');

            const bonusChart = new Chart(bonusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Bonus Diambil', 'Sisa Bonus'],
                    datasets: [{
                        label: 'Bonus',
                        data: [
                            {{ $user->bonuses->used_amount }},
                            {{ $user->bonuses->total_amount - $user->bonuses->used_amount }}
                        ],
                        backgroundColor: ['#FF6347', '#2D3748'],
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            });

            const paymentChart = new Chart(paymentCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($groups->pluck('name')) !!}, // Menampilkan group_id sebagai label
                    datasets: [{
                        label: 'Dibayar',
                        data: {!! json_encode($loan->pluck('total_payments')) !!}, // Menampilkan total_payments per group_id
                        backgroundColor: '#FF6347',
                        borderWidth: 1,
                    }, {
                        label: 'Total',
                        data: {!! json_encode($loan->pluck('total_amount')) !!}, // Menampilkan total_amount per group_id
                        backgroundColor: '#00B5D8',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#FFFFFF',
                            },
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Rp ' + tooltipItem.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#FFFFFF'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#FFFFFF'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
    <script>
        const togglePasswordButtons = document.querySelectorAll(".toggle-password");

        togglePasswordButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const passwordField = this.previousElementSibling;

                // Toggle password visibility
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);

                // Change button text
                this.textContent = type === "password" ? "Lihat" : "Sembunyi";
            });
        });
    </script>

</x-layouts>
