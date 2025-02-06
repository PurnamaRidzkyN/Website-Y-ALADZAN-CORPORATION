<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Tambahkan Chart.js di dalam tag <head> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container mx-auto p-6">
        <!-- Baris pertama dengan dua grafik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Grafik Pembayaran per Tanggal -->
            <div class="bg-[#1A2634] p-4 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">Grafik Pembayaran per Bulan</h3>
                <canvas id="paymentChart" width="400" height="200"></canvas>
            </div>

            <!-- Card Grafik Pembayaran Terbesar -->
            <div class="bg-[#1A2634] p-4 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">Grafik Pembayaran Terbesar</h3>
                <canvas id="highPaymentChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Baris kedua dengan dua grafik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Card Grafik User Paling Sering Datang -->
            <div class="bg-[#1A2634] p-4 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">User Paling Sering Datang</h3>
                <canvas id="frequentVisitorChart" width="400" height="200"></canvas>
            </div>

            <!-- Card Grafik User dengan Durasi Paling Lama -->
            <div class="bg-[#1A2634] p-4 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">User dengan Durasi Paling Lama</h3>
                <canvas id="longestDurationUserChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        const paymentData = @json($paymentData);
        const ctx = document.getElementById('paymentChart').getContext('2d');

        const datasets = Object.keys(paymentData).map(groupId => ({
            label: groupId,
            data: paymentData[groupId].totals,
            borderColor: '#' + Math.floor(Math.random() * 16777215).toString(16), // Warna random
            fill: false
        }));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: paymentData[Object.keys(paymentData)[0]].labels,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });

        // Data untuk grafik pembayaran terbesar
        const highPaymentDates = @json($highPaymentDates);
        const highPaymentTotals = @json($highPaymentTotals);

        const ctx2 = document.getElementById('highPaymentChart').getContext('2d');
        const highPaymentChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: highPaymentDates,
                datasets: [{
                    label: 'Total Pembayaran',
                    data: highPaymentTotals,
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });

        // Grafik User Paling Sering Datang
        const frequentVisitorUserIds = @json($visitorUsernames);
        const visitCounts = @json($visitCounts);

        const ctx3 = document.getElementById('frequentVisitorChart').getContext('2d');
        const frequentVisitorChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: frequentVisitorUserIds,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: visitCounts,
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });

        // Grafik User dengan Durasi Paling Lama
        const durationUserIds = @json($durationUsernames);
        const totalDurations = @json($totalDurations);

        const ctx4 = document.getElementById('longestDurationUserChart').getContext('2d');
        const longestDurationUserChart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: durationUserIds,
                datasets: [{
                    label: 'Total Durasi',
                    data: totalDurations,
                    backgroundColor: 'rgb(75, 192, 192)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    </script>

</x-layouts>
