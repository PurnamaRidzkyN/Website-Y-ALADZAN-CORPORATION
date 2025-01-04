<x-layouts>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="bg-gray-50 py-4 sm:py-5">
    
    <div class="mx-auto max-w- px-3 lg:px-4">
      <!-- Grafik Utama (Persegi Panjang) -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <div class="px-8 pt-8">
          <h3 class="text-2xl font-semibold text-gray-900">Grafik Utama</h3>
          <p class="mt-2 text-lg text-gray-600">Grafik yang menggambarkan tren utama yang perlu dianalisis.</p>
        </div>
        <div class="px-8 py-8">
          <div class="h-96 bg-gray-300 rounded-lg">
            <!-- Grafik Utama (misalnya menggunakan chart.js, atau grafik lainnya) -->
            <div class="container">
              <h2 class="text-center">Grafik Pembayaran Tertinggi per Tanggal</h2>
              <canvas id="paymentChart" width="400" height="200"></canvas>
            </div>
          </div>
        </div>
      </div>
  
      <!-- 3 Card Data di bawah Grafik Utama -->
      <div class="container mx-auto my-8 px-4">
        <h3 class="text-2xl font-semibold text-gray-900">Daftar Pembayaran Terbesar</h3>
        <p class="mt-2 text-lg text-gray-600">Tabel ini menampilkan pembayaran dengan jumlah terbesar.</p>
        
        <!-- Tabel Pembayaran -->
        <table class="min-w-full bg-white border border-gray-300 mt-6">
            <thead>
                <tr>
                    <th class="px-6 py-4 border-b text-left text-gray-700">Tanggal Pembayaran</th>
                    <th class="px-6 py-4 border-b text-left text-gray-700">Total Pembayaran (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($highPayments as $payment)
                    <tr>
                        <td class="px-6 py-4 border-b text-gray-800">{{ $payment->payment_date }}</td>
                        <td class="px-6 py-4 border-b text-gray-800">Rp {{ number_format($payment->total_payment, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
      <!-- 2 Card untuk Grafik dan Data -->
      <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-3">
        <!-- Grafik Kedua -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <div class="px-8 pt-8">
            <h3 class="text-2xl font-semibold text-gray-900">Grafik Kedua</h3>
            <p class="mt-2 text-lg text-gray-600">Grafik tambahan untuk analisis lebih lanjut.</p>
          </div>
          <div class="px-8 py-8">
            <div class="h-96 bg-gray-300 rounded-lg">
              <!-- Grafik Kedua -->
              <canvas id="secondChart"></canvas>
            </div>
          </div>
        </div>
  
        <!-- Data Kedua -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <div class="px-8 py-6">
            <h4 class="text-xl font-semibold text-gray-900">Data Kedua</h4>
            <p class="mt-2 text-lg text-gray-600">Penjelasan terkait dengan data yang digunakan untuk grafik kedua.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
   document.addEventListener('DOMContentLoaded', function () {
    const paymentData = @json($payments); // Data dari PHP
    
    // Menyiapkan label tanggal dan data pembayaran
    const labels = paymentData.map(payment => payment.payment_date);
    const totalPayments = paymentData.map(payment => parseFloat(payment.total_payment)); // Ubah total_payment menjadi angka

    console.log(labels, totalPayments); // Periksa data yang sudah dikonversi

    // Membuat grafik
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx, {
        type: 'line', // Grafik jenis garis
        data: {
            labels: labels, // Tanggal
            datasets: [{
                label: 'Total Pembayaran',
                data: totalPayments, // Jumlah pembayaran per tanggal
                borderColor: 'rgb(75, 192, 192)', // Warna garis
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang area
                fill: true, // Isi area di bawah garis
                tension: 0.4 // Kelengkungan garis
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Tanggal Pembayaran'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Pembayaran (Rp)'
                    }
                }
            }
        }
    });
});

  </script>
  
</x-layouts>
