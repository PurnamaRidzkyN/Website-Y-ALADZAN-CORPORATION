<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <?php
    // Data array PHP
    $groups = [
        ['group_name' => 'Group A', 'admins' => ['Alice', 'Bob']],
        ['group_name' => 'Group B', 'admins' => ['Charlie']],
        ['group_name' => 'Group C', 'admins' => ['Alice', 'Charlie', 'David']],
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
            overflow: hidden;
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
            font-size: 1.2rem;
        }
        .container {
            padding-top: 30px;
        }
        /* Styling for the buttons */
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>

    <!-- Button Container -->
    <div class="container mb-4 button-container">
        <!-- Back Button -->
        <a href="back-page-url" class="btn btn-secondary">Kembali</a>
        <!-- Add Group Button -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGroupModal">Tambah Grup</button>
    </div>

    <!-- Groups Display -->
    <div class="container">
        <div class="row">
            <?php foreach ($groups as $group): ?>
            <div class="col-md-4">
                <a href="admin" class="text-decoration-none">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title text-dark"><?= htmlspecialchars($group['group_name']) ?></h5>
                            <p class="card-text text-secondary">
                                Admin Count: <strong><?= count($group['admins']) ?></strong>
                            </p>
                        </div>
                    </div>
                </a>
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
                            <label for="groupName" class="form-label">Nama Grup</label>
                            <input type="text" class="form-control" id="groupName" placeholder="Masukkan nama grup">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Grup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-layouts>
