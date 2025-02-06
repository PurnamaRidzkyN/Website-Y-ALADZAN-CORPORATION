<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="bg-gray-900 min-h-screen p-6 mx-auto mt-8">
        <h2 class="text-2xl font-bold text-white">Report Filter</h2>
        <form action="{{ route('reports.payment') }}" method="GET" class="space-y-4 mt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="w-full">
                    <label for="admin_id" class="block text-white">Admin</label>
                    <select class="form-select block w-full mt-2 text-gray-700" name="admin_id" id="admin_id">
                        <option value="">Pilih Admin</option>
                        @foreach ($admins as $id => $name)
                            <option value="{{ $id }}" {{ request('admin_id') == $id ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="manager_id" class="block text-white">Manager</label>
                    <select class="form-select block w-full mt-2 text-gray-700" name="manager_id" id="manager_id">
                        <option value="">Pilih Manager</option>
                        @foreach ($managers as $id => $name)
                            <option value="{{ $id }}" {{ request('manager_id') == $id ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="group_id" class="block text-white">Group</label>
                    <select class="form-select block w-full mt-2 text-gray-700" name="group_id" id="group_id">
                        <option value="">Pilih Groups</option>
                        @foreach ($groups as $id => $name)
                            <option value="{{ $id }}" {{ request('group_id') == $id ? 'selected' : '' }}>
                                {{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="month" class="block text-white">Bulan</label>
                    <select class="form-select block w-full mt-2 text-gray-700" name="month" id="month">
                        <option value="">Pilih Bulan</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="year" class="block text-white">Tahun</label>
                    <select class="form-select block w-full mt-2 text-gray-700" name="year" id="year">
                        <option value="">Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Filter
            </button>
            <a href="{{ route('reports.payment') }}" style="text-decoration: none"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 mt-2 inline-block">
                Bersihkan Filter
            </a>

        </form>

        <hr class="my-6 border-gray-600">

        <h3 class="text-xl font-semibold text-white">Data</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-gray-800 text-white rounded-lg shadow-md">
                <thead>
                    <tr class="text-left">
                        <th class="px-4 py-2">Pembayar</th>
                        <th class="px-4 py-2">Group </th>
                        <th class="px-4 py-2">Admin</th>
                        <th class="px-4 py-2">Manajer</th>
                        <th class="px-4 py-2">Total Harus Dibayar</th>
                        <th class="px-4 py-2">Total Dibayar</th>
                        <th class="px-4 py-2">Admin Bonuses</th>
                        <th class="px-4 py-2">Manager Bonuses</th>
                        <th class="px-4 py-2">Modal</th>
                        <th class="px-4 py-2">Bersih</th>
                        <th class="px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr class="border-t border-gray-700">
                            <td class="px-4 py-2">{{ $row->pembayar }}</td>
                            <td class="px-4 py-2">{{ $row->group_name }}</td>
                            <td class="px-4 py-2">{{ $row->admin }}</td>
                            <td class="px-4 py-2">{{ $row->manajer }}</td>
                            <td class="px-4 py-2">{{ number_format($row->total_harus_dibayar, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($row->total_dibayar, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($row->admin_bonuses, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($row->manager_bonuses, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($row->modal, 2) }}</td>
                            <td class="px-4 py-2">{{ number_format($row->bersih, 2) }}</td>
                            <td class="px-4 py-2">
                                {{ $row->loan_date ? \Carbon\Carbon::parse($row->loan_date)->format('d M Y') : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr class="my-6 border-gray-600">

    <!-- Grafik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-8 mt-8 px-4">
        <!-- Grafik per Group -->
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Perkembangan Total Amount berdasarkan Group</h3>
            <canvas id="groupChart"></canvas>
        </div>

        <!-- Grafik per Manager -->
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Perkembangan Total Amount berdasarkan Manager</h3>
            <canvas id="managerChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-8 mt-8 px-4">
        <!-- Grafik per Admin, ditempatkan di tengah -->
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md mx-auto w-full sm:w-full md:w-2/3 lg:w-2/3">
            <h3 class="text-xl font-semibold mb-4">Perkembangan Total Amount berdasarkan Admin</h3>
            <canvas id="adminChart"></canvas>
        </div>
    </div>


    <!-- Data Table -->
    <h3 class="text-xl font-semibold text-white">Data</h3>
    <div class="overflow-x-auto">
        <!-- Table Here -->
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Grafik per Group
            var groupCtx = document.getElementById('groupChart').getContext('2d');
            var groupChart = new Chart(groupCtx, {
                type: 'line', // Jenis grafik: garis
                data: {
                    labels: @json($date), // Label berdasarkan bulan
                    datasets: @json($groupChartData), // Data dari controller untuk group
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                                color: 'white', // Ubah warna judul sumbu X menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu X menjadi putih
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Amount',
                                color: 'white', // Ubah warna judul sumbu Y menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu Y menjadi putih
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white', // Ubah warna teks legenda menjadi putih
                            },
                            position: 'top',
                            onHover: function(event, legendItem) {
                                // Adjust background on hover
                                legendItem.backgroundColor = 'rgba(255, 255, 255, 0.5)';
                            }
                        },
                        tooltip: {
                            titleColor: 'white', // Ubah warna judul tooltip menjadi putih
                            bodyColor: 'white', // Ubah warna teks body tooltip menjadi putih
                            backgroundColor: 'rgba(0, 0, 0, 0.8)', // Tooltip background transparent
                        }
                    },
                    elements: {
                        point: {
                            backgroundColor: 'rgba(255, 255, 255, 0.8)', // White point color
                        }
                    }
                }
            });

            // Grafik per Manager
            var managerCtx = document.getElementById('managerChart').getContext('2d');
            var managerChart = new Chart(managerCtx, {
                type: 'line', // Jenis grafik: garis
                data: {
                    labels: @json($date), // Label berdasarkan bulan
                    datasets: @json($managerChartData), // Data dari controller untuk manager
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                                color: 'white', // Ubah warna judul sumbu X menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu X menjadi putih
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Amount',
                                color: 'white', // Ubah warna judul sumbu Y menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu Y menjadi putih
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white', // Ubah warna teks legenda menjadi putih
                            },
                            position: 'top',
                        },
                        tooltip: {
                            titleColor: 'white', // Ubah warna judul tooltip menjadi putih
                            bodyColor: 'white', // Ubah warna teks body tooltip menjadi putih
                        }
                    }
                }
            });

            // Grafik per Admin
            var adminCtx = document.getElementById('adminChart').getContext('2d');
            var adminChart = new Chart(adminCtx, {
                type: 'line', // Jenis grafik: garis
                data: {
                    labels: @json($date), // Label berdasarkan bulan
                    datasets: @json($adminChartData), // Data dari controller untuk admin
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                                color: 'white', // Ubah warna judul sumbu X menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu X menjadi putih
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Amount',
                                color: 'white', // Ubah warna judul sumbu Y menjadi putih
                            },
                            ticks: {
                                color: 'white', // Ubah warna angka label sumbu Y menjadi putih
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white', // Ubah warna teks legenda menjadi putih
                            },
                            position: 'top',
                        },
                        tooltip: {
                            titleColor: 'white', // Ubah warna judul tooltip menjadi putih
                            bodyColor: 'white', // Ubah warna teks body tooltip menjadi putih
                        }
                    }
                }
            });
        });
    </script>

</x-layouts>
