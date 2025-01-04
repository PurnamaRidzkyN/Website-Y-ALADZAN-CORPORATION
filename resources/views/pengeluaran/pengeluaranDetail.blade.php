<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
@php
    $expenseData = [
    ['id' => 'E001', 'id_user' => '1', 'date' => '2025-01-01', 'amount' => 100.00, 'id_category' => 'C001', 'description' => 'Pembelian Laptop',  'method' => 'Transfer', 'image_url' => 'expense1.jpg'],
    ['id' => 'E002', 'id_user' => '2', 'date' => '2025-01-02', 'amount' => 50.00, 'id_category' => 'C002', 'description' => 'Makan Siang',  'method' => 'Cash', 'image_url' => 'expense2.jpg'],
    ['id' => 'E003', 'id_user' => '3', 'date' => '2025-01-03', 'amount' => 200.00, 'id_category' => 'C003', 'description' => 'Pembelian Peralatan Kantor',  'method' => 'Credit Card', 'image_url' => 'expense3.jpg'],
    ['id' => 'E004', 'id_user' => '1', 'date' => '2025-01-04', 'amount' => 75.00, 'id_category' => 'C001', 'description' => 'Pembayaran Internet',  'method' => 'Transfer', 'image_url' => 'expense4.jpg'],
    ['id' => 'E005', 'id_user' => '2', 'date' => '2025-01-05', 'amount' => 120.00, 'id_category' => 'C002', 'description' => 'Beli Buku',  'method' => 'Cash', 'image_url' => 'expense5.jpg'],
];
@endphp
    <div class="container mt-4">
    <!-- Pencarian -->
    <div class="row mb-3">
        <div class="col-md-8">
            <h3>Data Pengeluaran</h3>
        </div>
        <div class="col-md-4 text-end">
            <!-- Pencarian -->
            <input type="text" class="form-control" id="searchExpense" placeholder="Cari Pengeluaran...">
        </div>
    </div>

    <!-- Tabel Pengeluaran -->
    <table class="table table-bordered table-striped" id="expenseTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Pembayaran</th>
                <th>Metode</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenseData as $expense): ?>
            <tr>
                <td><?= htmlspecialchars($expense['id']) ?></td>
                <td><?= htmlspecialchars($expense['date']) ?></td>
                <td><?= htmlspecialchars($expense['description']) ?></td>
                <td>Rp<?= number_format($expense['amount'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($expense['method']) ?></td>
                <td><img src="<?= htmlspecialchars($expense['image_url']) ?>" alt="Expense Image" class="img-thumbnail" style="width: 100px;"></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editExpenseModal">Edit</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExpenseModal">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tombol Tambah Pengeluaran -->
    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal">Tambah Pengeluaran</button>

    <!-- Tombol Kembali -->
    <a href="dashboard.php" class="btn btn-secondary mt-3">Kembali</a>
</div>

<!-- Modal untuk Edit Pengeluaran -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseModalLabel">Edit Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Pengeluaran -->
                <form>
                    <!-- Form fields here -->
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="editDescription" value="Pembelian Laptop">
                    </div>
                    <div class="mb-3">
                        <label for="editAmount" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="editAmount" value="1000000">
                    </div>
                    <!-- Additional fields as necessary -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Hapus Pengeluaran -->
<div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-labelledby="deleteExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteExpenseModalLabel">Hapus Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengeluaran ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Pengeluaran -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Pengeluaran -->
                <form>
                    <div class="mb-3">
                        <label for="addDescription" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="addDescription">
                    </div>
                    <div class="mb-3">
                        <label for="addAmount" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="addAmount">
                    </div>
                    <!-- Additional fields for adding expense -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Script untuk Pencarian -->
<script>
    document.getElementById("searchExpense").addEventListener("input", function() {
        var searchTerm = this.value.toLowerCase();
        var rows = document.querySelectorAll("#expenseTable tbody tr");

        rows.forEach(function(row) {
            var cells = row.getElementsByTagName("td");
            var match = false;
            
            for (var i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                    match = true;
                    break;
                }
            }

            row.style.display = match ? "" : "none";
        });
    });
</script>
</x-layouts>