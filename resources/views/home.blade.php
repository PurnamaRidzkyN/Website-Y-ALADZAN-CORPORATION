<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            margin-bottom: 20px;
        }
        .chart-container {
            height: 200px;
        }
        .chart-container canvas {
            height: 100%;
            width: 100%;
        }
    </style>
    <!-- Kontainer Utama -->
    <div class="container">
        <h1 class="text-center mb-4">Dashboard</h1>

        <!-- Baris 1: Grafik di kanan, data di kiri -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex flex-column flex-md-row">
                        <!-- Data -->
                        <div class="col-md-6">
                            <h5 class="card-title">Data Summary</h5>
                            <ul>
                                <li>Q1: 10</li>
                                <li>Q2: 20</li>
                                <li>Q3: 30</li>
                                <li>Q4: 40</li>
                            </ul>
                        </div>
                        <!-- Grafik -->
                        <div class="col-md-6 chart-container">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris 2: Grafik di kiri, data di kanan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex flex-column flex-md-row-reverse">
                        <!-- Data -->
                        <div class="col-md-6">
                            <h5 class="card-title">Data Summary</h5>
                            <ul>
                                <li>Q1: 15</li>
                                <li>Q2: 25</li>
                                <li>Q3: 35</li>
                                <li>Q4: 45</li>
                            </ul>
                        </div>
                        <!-- Grafik -->
                        <div class="col-md-6 chart-container">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Grafik -->
    <script>
        const labels = ['Q1', 'Q2', 'Q3', 'Q4'];

        // Grafik 1: Bar Chart
        new Chart(document.getElementById('chart1'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: [10, 20, 30, 40],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }]
            },
        });

        // Grafik 2: Line Chart
        new Chart(document.getElementById('chart2'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: [15, 25, 35, 45],
                    borderColor: 'rgba(153, 102, 255, 0.6)',
                    fill: false
                }]
            },
        });
    </script>
</x-layouts>