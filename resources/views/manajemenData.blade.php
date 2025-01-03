<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

    <?php
    // Data array PHP
    $admins = [
        ['name' => 'John Doe', 'email' => 'john@example.com', 'salary' => 5000000, 'bonus' => 500000, 'ig' => '@john_doe', 'fb' => 'john.doe.fb','phone'=>"0909"],
        ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'salary' => 6000000, 'bonus' => 600000, 'ig' => '@jane_smith', 'fb' => 'jane.smith.fb','phone'=>"0909"],
    ];

    $attendance = [
        ['id' => 1, 'time' => '07:00 - 08:00', 'location' => 'Room A'],
        ['id' => 2, 'time' => '12:00 - 13:00', 'location' => 'Room B'],
    ];
   
$message = 
    [
        'title' => 'Pesan Pengumuman 1',
        'content' => 'Ini adalah isi pesan pengumuman pertama. Mohon untuk memperhatikan pengumuman ini dengan baik.',
        'created_at' => '2025-01-01 08:30:00'  // Waktu pengumuman
];
    


    $expenseCategories = [
        ['name' => 'Utilities'],
        ['name' => 'Salary'],
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
        .form-control {
            margin-bottom: 10px;
        }
        .card-body {
            text-align: left;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
        }
        

    .search-container {
      display: inline-block;
      margin-top: 20px;
    }

    input[type="text"] {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 300px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }
    </style>

    <div class="container">
        
        <h2 class="text-center mb-4">Manajemen Data</h2>
        <h1>Search Data</h1>
        <div class="search-container">
          <input type="text" placeholder="Enter data to search" id="search-input">
          <button onclick="search()">Search</button>
        </div>
      
        <script>
          function search() {
            alert('Search functionality will be implemented here.');
          }
        </script>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="managementTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true">Data Admin</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">Absensi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="message-tab" data-bs-toggle="tab" data-bs-target="#message" type="button" role="tab" aria-controls="message" aria-selected="false">Pengaturan Pesan</button>
            </li>
          
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false">Log Data</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="managementTabsContent">

            <!-- Data Admin -->
            <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                <div class="row mt-4">
                    <?php foreach ($admins as $admin): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                            <!-- Gambar acak menggunakan Lorem Picsum -->
                            <img src="https://picsum.photos/200/200?random=<?= rand() ?>" class="card-img-top" alt="Admin Photo" style="max-height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($admin['name']) ?></h5>
                                <p class="card-text">
                                    Email: <?= htmlspecialchars($admin['email']) ?><br>
                                    IG: <?= htmlspecialchars($admin['ig']) ?><br>
                                    FB: <?= htmlspecialchars($admin['fb']) ?><br>
                                    Phone: <?= htmlspecialchars($admin['phone']) ?><br>
                                    Gaji: Rp<?= number_format($admin['salary'], 0, ',', '.') ?><br>
                                    Bonus: Rp<?= number_format($admin['bonus'], 0, ',', '.') ?>
                                </p>
                                <div class="btn-container">
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAdminModal">Edit</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addAdminModal">Tambah Admin</button>
            </div>
            

            <!-- Absensi -->
            <!-- Tabel Absensi Karyawan dan Grafik Kehadiran -->
<div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
    <!-- Tabel Absensi -->
    <div class="table-responsive mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Absensi</th>
                    <th scope="col">Admin</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Bukti Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Data Absensi
                $attendanceData = [
                    ['id' => 'A001', 'id_user' => '1', 'date' => '2025-01-01 08:00:00', 'location' => 'Office', 'image_url' => 'image1.jpg'],
                    ['id' => 'A002', 'id_user' => '2', 'date' => '2025-01-02 08:00:00', 'location' => 'Office', 'image_url' => 'image2.jpg'],
                    ['id' => 'A003', 'id_user' => '3', 'date' => '2025-01-03 08:00:00', 'location' => 'Office', 'image_url' => 'image3.jpg'],
                    ['id' => 'A004', 'id_user' => '2', 'date' => '2025-01-04 08:00:00', 'location' => 'Office', 'image_url' => 'image4.jpg'],
                    ['id' => 'A005', 'id_user' => '2', 'date' => '2025-01-05 08:00:00', 'location' => 'Office', 'image_url' => 'image5.jpg'],
                    ['id' => 'A006', 'id_user' => '2', 'date' => '2025-01-06 08:00:00', 'location' => 'Office', 'image_url' => 'image6.jpg'],
                    ['id' => 'A007', 'id_user' => '3', 'date' => '2025-01-07 08:00:00', 'location' => 'Office', 'image_url' => 'image7.jpg'],
                    ['id' => 'A008', 'id_user' => '3', 'date' => '2025-01-08 08:00:00', 'location' => 'Office', 'image_url' => 'image8.jpg'],
                    ['id' => 'A009', 'id_user' => '3', 'date' => '2025-01-09 08:00:00', 'location' => 'Office', 'image_url' => 'image9.jpg'],
                    ['id' => 'A010', 'id_user' => '3', 'date' => '2025-01-10 08:00:00', 'location' => 'Office', 'image_url' => 'image10.jpg'],
                ];

                // Array Admin (ID => Nama)
                $admins = [
                    1 => 'Admin 1',
                    2 => 'Admin 2',
                    3 => 'Admin 3',
                    // Anda bisa menambahkan admin lebih banyak jika perlu
                ];

                // Menampilkan data absensi
                foreach ($attendanceData as $attendance):
                    $adminName = $admins[$attendance['id_user']];
                ?>
                <tr>
                    <td><?= htmlspecialchars($attendance['id']) ?></td>
                    <td><?= htmlspecialchars($adminName) ?></td>
                    <td><?= htmlspecialchars($attendance['date']) ?></td>
                    <td><?= htmlspecialchars($attendance['location']) ?></td>
                    <td><img src="<?= htmlspecialchars($attendance['image_url']) ?>" alt="Bukti Kehadiran" width="100"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Grafik Kehadiran -->
    <div class="mt-4">
        <canvas id="attendanceChart" width="400" height="200"></canvas>
    </div>

    <!-- Script untuk Grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Admin 1', 'Admin 2', 'Admin 3'], // Daftar nama admin yang akan ditampilkan
                datasets: [
                    <?php foreach ($admins as $adminId => $adminName): ?>
                    {
                        label: 'Jumlah Kehadiran <?= $adminName ?>',
                        data: [
                            <?php 
                            // Hitung jumlah absensi berdasarkan ID Admin
                            $attendanceCount = 0;
                            foreach ($attendanceData as $attendance) {
                                if ($attendance['id_user'] == $adminId) {
                                    $attendanceCount++;
                                }
                            }
                            echo $attendanceCount; 
                            ?>
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    <?php endforeach; ?>
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>


            <!-- Pengaturan Pesan -->
            <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">
                <div class="row mt-4">
                    <!-- Template Pesan -->
                    <div class="col-md-12 mb-3">
                        <h5><?= htmlspecialchars($message['title']) ?></h5>
                        <p><?= htmlspecialchars($message['content']) ?></p>
                        <p class="text-muted"><?= date('H:i', strtotime($message['created_at'])) ?></p> <!-- Jam -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editMessageModal">Edit</button>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addMessageModal">Tambah Pesan</button>
            </div>
        
           

            <!-- Log Data -->
            <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                <p>Log Data akan ditampilkan di sini.</p>
            </div>
        </div>
    </div>

    <!-- Modal untuk tambah dan edit data -->
    <!-- Modal untuk tambah dan edit admin, absensi, pesan, dan kategori pengeluaran dapat menggunakan struktur modal berikut -->

    <!-- Modal Edit Admin -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="adminName" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control" id="adminName" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="adminEmail" value="john@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="adminSalary" class="form-label">Gaji</label>
                            <input type="number" class="form-control" id="adminSalary" value="5000000">
                        </div>
                        <div class="mb-3">
                            <label for="adminBonus" class="form-label">Bonus</label>
                            <input type="number" class="form-control" id="adminBonus" value="500000">
                        </div>
                        <div class="mb-3">
                            <label for="adminIG" class="form-label">IG</label>
                            <input type="text" class="form-control" id="adminIG" value="500000">
                        </div>
                        <div class="mb-3">
                            <label for="adminFB" class="form-label">IG</label>
                            <input type="text" class="form-control" id="adminIG" value="500000">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="adminNameAdd" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control" id="adminNameAdd">
                        </div>
                        <div class="mb-3">
                            <label for="adminEmailAdd" class="form-label">Email</label>
                            <input type="email" class="form-control" id="adminEmailAdd">
                        </div>
                        <div class="mb-3">
                            <label for="adminSalaryAdd" class="form-label">Gaji</label>
                            <input type="number" class="form-control" id="adminSalaryAdd">
                        </div>
                        <div class="mb-3">
                            <label for="adminBonusAdd" class="form-label">Bonus</label>
                            <input type="number" class="form-control" id="adminBonusAdd">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan file JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-layouts>
