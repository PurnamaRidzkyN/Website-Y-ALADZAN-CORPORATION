<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <?php
    // Data array PHP
    $payments = [
        ['name' => 'John Doe', 'code' => 'INV001', 'total_payment' => 500000, 'paid' => 500000],
        ['name' => 'Jane Smith', 'code' => 'INV002', 'total_payment' => 700000, 'paid' => 400000],
        ['name' => 'Bob Johnson', 'code' => 'INV003', 'total_payment' => 300000, 'paid' => 300000],
    ];

    $fullyPaid = array_filter($payments, fn($p) => $p['total_payment'] === $p['paid']);
    $notFullyPaid = array_filter($payments, fn($p) => $p['total_payment'] > $p['paid']);
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
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .card-text {
            font-size: 1rem;
        }
        .container {
            padding-top: 30px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
    </style>

    <div class="container">
        <h2 class="text-center mb-4">Status Pembayaran</h2>

        <!-- Button Container -->
        <div class="button-container">
            <!-- Tombol Kembali -->
            <a href="back-page-url" class="btn btn-secondary">Kembali</a>
            <!-- Tombol Tambah Data -->
            <a href="tambah-peminjam" class="btn btn-primary">Tambah Data</a>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="fully-paid-tab" data-bs-toggle="tab" data-bs-target="#fully-paid" type="button" role="tab" aria-controls="fully-paid" aria-selected="true">Sudah Lunas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="not-fully-paid-tab" data-bs-toggle="tab" data-bs-target="#not-fully-paid" type="button" role="tab" aria-controls="not-fully-paid" aria-selected="false">Belum Lunas</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="paymentTabsContent">
            <!-- Sudah Lunas -->
            <div class="tab-pane fade show active" id="fully-paid" role="tabpanel" aria-labelledby="fully-paid-tab">
                <div class="row mt-4">
                    <?php foreach ($fullyPaid as $payment): ?>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-dark"><?= htmlspecialchars($payment['name']) ?></h5>
                                <p class="card-text text-secondary">
                                    Kode: <?= htmlspecialchars($payment['code']) ?><br>
                                    Total: Rp<?= number_format($payment['total_payment'], 0, ',', '.') ?><br>
                                    Status: <span class="text-success">Lunas</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Belum Lunas -->
            <div class="tab-pane fade" id="not-fully-paid" role="tabpanel" aria-labelledby="not-fully-paid-tab">
                <div class="row mt-4">
                    <?php foreach ($notFullyPaid as $payment): ?>
                    <a href="/detail-peminjaman" class="text-decoration-none">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title text-dark"><?= htmlspecialchars($payment['name']) ?></h5>
                                    <p class="card-text text-secondary">
                                        Kode: <?= htmlspecialchars($payment['code']) ?><br>
                                        Total: Rp<?= number_format($payment['total_payment'], 0, ',', '.') ?><br>
                                        Telah Dibayar: Rp<?= number_format($payment['paid'], 0, ',', '.') ?><br>
                                        Status: <span class="text-danger">Belum Lunas</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>
