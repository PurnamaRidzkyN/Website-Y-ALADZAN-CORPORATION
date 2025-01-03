<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <?php
    // Data array PHP untuk kode pembayaran
    $paymentCodes = [
        'INV001' => 'Invoice 001',
        'INV002' => 'Invoice 002',
        'INV003' => 'Invoice 003',
    ];
    ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 30px;
        }
        .form-control {
            margin-bottom: 15px;
        }
    </style>

    <div class="container">
        <h2 class="text-center mb-4">Tambah Data Pembayaran</h2>

        <form action="/submit-payment" method="POST">
            <!-- Nama Peminjam -->
            <div class="mb-3">
                <label for="borrowerName" class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" id="borrowerName" name="borrower_name" required placeholder="Masukkan nama peminjam">
            </div>

            <!-- Pilih Kode Pembayaran -->
            <div class="mb-3">
                <label for="paymentCode" class="form-label">Pilih Kode Pembayaran</label>
                <select class="form-select" id="paymentCode" name="payment_code" required>
                    <option value="" disabled selected>Pilih Kode Pembayaran</option>
                    <?php foreach ($paymentCodes as $code => $description): ?>
                        <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($description) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Nominal Pembayaran -->
            <div class="mb-3">
                <label for="nominal" class="form-label">Nominal Pembayaran</label>
                <input type="number" class="form-control" id="nominal" name="nominal" required placeholder="Masukkan nominal pembayaran" min="0" step="1000">
            </div>

            <!-- Tanggal Pinjam -->
            <div class="mb-3">
                <label for="borrowDate" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="borrowDate" name="borrow_date" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Masukkan deskripsi pembayaran atau keterangan"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>
        </form>

        <!-- Tombol Kembali -->
        <div class="mt-4 text-center">
            <a href="back-page-url" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>
