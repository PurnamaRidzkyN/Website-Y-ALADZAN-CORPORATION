<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    @php
        $categoryExpenseData = [
    ['id' => 'C001', 'name' => 'bonus'],
    ['id' => 'C002', 'name' => 'gaji'],
    ['id' => 'C003', 'name' => 'lainya'],
];

    @endphp
   <div class="container mt-5">
    <div class="row">
      <?php foreach ($categoryExpenseData as $index => $item): ?>
        <div class="col-md-4">
          <div class="card shadow-sm" onclick="window.location.href='pengeluaran-detail'">
            <div class="card-body">
              <h5 class="card-title"> <?= $item['name'] ?></h5>
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
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGroupModal">Tambah kategori</button>
  </div>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Link ke JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>