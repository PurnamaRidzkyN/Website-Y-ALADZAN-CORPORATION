<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <?php
    // Data detail pembayaran
    $loanDetails = [
        'name' => 'John Doe',
        'total_payment' => 1000000,
        'paid' => 700000,
        'remaining' => 300000,
        'created_at' => '2024-01-01',
        'phone' => '+628123456789'
    ];

    $paymentHistory = [
        ['nominal' => 500000, 'date' => '2024-01-15', 'method' => 'Transfer Bank', 'description' => 'Pembayaran cicilan pertama'],
        ['nominal' => 200000, 'date' => '2024-02-01', 'method' => 'Cash', 'description' => 'Pembayaran cicilan kedua'],
    ];
    ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-action {
            font-size: 1rem;
            margin-right: 10px;
        }
        .detail-item {
            font-size: 1.1rem;
        }
    </style>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Detail Pembayaran</h2>

        <!-- Detail Pembayaran -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Utama</h5>
                <ul class="list-unstyled">
                    <li class="detail-item"><strong>Nama:</strong> <?= htmlspecialchars($loanDetails['name']) ?></li>
                    <li class="detail-item"><strong>Total Pembayaran:</strong> Rp<?= number_format($loanDetails['total_payment'], 0, ',', '.') ?></li>
                    <li class="detail-item"><strong>Dibayar:</strong> Rp<?= number_format($loanDetails['paid'], 0, ',', '.') ?></li>
                    <li class="detail-item"><strong>Sisa Pembayaran:</strong> Rp<?= number_format($loanDetails['remaining'], 0, ',', '.') ?></li>
                    <li class="detail-item"><strong>Tanggal Peminjaman:</strong> <?= htmlspecialchars($loanDetails['created_at']) ?></li>
                    <li class="detail-item"><strong>No HP:</strong> <?= htmlspecialchars($loanDetails['phone']) ?></li>
                </ul>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <h5 class="mb-3">Riwayat Pembayaran</h5>
        <div class="row">
            <?php foreach ($paymentHistory as $payment): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Pembayaran</h6>
                        <p><strong>Nominal:</strong> Rp<?= number_format($payment['nominal'], 0, ',', '.') ?></p>
                        <p><strong>Tanggal:</strong> <?= htmlspecialchars($payment['date']) ?></p>
                        <p><strong>Cara Bayar:</strong> <?= htmlspecialchars($payment['method']) ?></p>
                        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($payment['description']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary btn-action" onclick="printReport()">Cetak Laporan</button>
            <button class="btn btn-success btn-action" onclick="sendWhatsapp()">Kirim Pemberitahuan WA</button>
        </div>
    </div>

    <script>
        function printReport() {
            alert('Fitur Cetak Laporan akan mengunduh atau mencetak laporan.');
            // Tambahkan logika untuk mencetak laporan
        }

        function sendWhatsapp() {
            const phone = "<?= htmlspecialchars($loanDetails['phone']) ?>";
            const message = encodeURIComponent("Halo <?= htmlspecialchars($loanDetails['name']) ?>, sisa pembayaran Anda adalah Rp<?= number_format($loanDetails['remaining'], 0, ',', '.') ?>. Mohon segera lunasi. Terima kasih!");
            const url = `https://wa.me/${phone}?text=${message}`;
            window.open(url, '_blank');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>
