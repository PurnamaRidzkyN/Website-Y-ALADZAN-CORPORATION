<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>

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
        .image-preview {
            margin-top: 20px;
            text-align: center;
        }
        .image-preview img {
            max-width: 30%;
            height: auto;
            border-radius: 8px;
        }
    </style>

    <div class="container">
        <h2 class="text-center mb-4">Input Absensi</h2>

        <form action="/submit-attendance" method="POST" enctype="multipart/form-data">

            <!-- Ambil Gambar -->
            <div class="mb-3">
                <label for="cameraInput" class="form-label">Ambil Foto</label>
                <input type="file" class="form-control" id="cameraInput" name="attendance_image" accept="image/*" capture="camera" required>
                
                <div class="image-preview" id="imagePreview"></div>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <label for="description" class="form-label">Keterangan</label>
                <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Masukkan keterangan absensi"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Simpan Absensi</button>
            </div>
        </form>

        <!-- Tombol Kembali -->
        <div class="mt-4 text-center">
            <a href="back-page-url" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Preview image after capture
        document.getElementById('cameraInput').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Captured Image">';
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
</x-layouts>
