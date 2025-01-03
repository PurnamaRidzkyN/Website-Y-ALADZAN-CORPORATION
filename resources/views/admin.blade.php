<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <?php
    // Data array dari PHP
    $data = [
        ["admin" => "Admin1", "members" => 20, "code" => "A123", "payment" => 5000],
        ["admin" => "Admin2", "members" => 15, "code" => "B456", "payment" => 3000],
        ["admin" => "Admin3", "members" => 25, "code" => "C789", "payment" => 7500],
    ];
    ?>
 <style>
    body {
      background-color: #f8f9fa; /* Warna solid */
    }
    .card {
      cursor: pointer;
      transition: transform 0.2s ease-in-out;
    }
    .card:hover {
      transform: scale(1.05); /* Efek hover */
    }
  </style>
   <div class="container mt-5">
    <h1 class="text-center mb-4">Data Admin dan Payment</h1>
    <div class="row">
      <?php foreach ($data as $index => $item): ?>
        <div class="col-md-4">
          <div class="card shadow-sm" onclick="window.location.href='peminjaman'">
            <div class="card-body">
              <h5 class="card-title">Admin: <?= $item['admin'] ?></h5>
              <p class="card-text">Jumlah Member: <?= $item['members'] ?></p>
              <p class="card-text">Total Payment: <?= $item['payment'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
   <!-- Modal Tambah Grup -->
   <div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGroupModalLabel">Tambah Grup Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="groupName" class="form-label">Nama admin</label>
                        <input type="text" class="form-control" id="groupName" placeholder="Masukkan nama grup">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Grup</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Button Container -->
    <div class="container mb-4 button-container">
      <!-- Back Button -->
      <a href="back-page-url" class="btn btn-secondary">Kembali</a>
      <!-- Add Group Button -->
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGroupModal">Tambah Grup</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>