<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Tambahkan Chart.js di dalam tag <head> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h3>Grafik Pembayaran per Tanggal</h3>
    <canvas id="paymentChart" width="400" height="200"></canvas>

    <h3>Grafik Pembayaran Terbesar</h3>
    <canvas id="highPaymentChart" width="400" height="200"></canvas>

    <!-- Grafik User Paling Sering Datang -->
    <h3>User Paling Sering Datang</h3>
    <canvas id="frequentVisitorChart" width="400" height="200"></canvas>

    <!-- Grafik User dengan Durasi Paling Lama -->
    <h3>User dengan Durasi Paling Lama</h3>
    <canvas id="longestDurationUserChart" width="400" height="200"></canvas>

    <script>
        // Data untuk grafik pembayaran
        const paymentDates = @json($paymentDates);
        const paymentTotals = @json($paymentTotals);

        const ctx1 = document.getElementById('paymentChart').getContext('2d');
        const paymentChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: paymentDates,
                datasets: [{
                    label: 'Total Pembayaran',
                    data: paymentTotals,
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false,
                    tension: 0.1
                }]
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
            }
        });
    </script>

</x-layouts>
