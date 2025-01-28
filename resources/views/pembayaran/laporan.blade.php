<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Informasi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fff;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }

        h5 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li strong {
            display: inline-block;
            width: 150px;
        }

        .btn-back {
            display: block;
            margin: 20px auto 0;
            text-align: center;
            padding: 10px 20px;
            background-color: #FF6347;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            width: fit-content;
        }

        .btn-back:hover {
            background-color: #FF4500;
        }

        @media print {
            /* Optimalkan tampilan untuk cetak */
            body {
                background: #fff;
            }

            .container {
                border: none;
                box-shadow: none;
            }

            .btn-back {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Detail Pembayaran -->
        <h5>Informasi Pembayaran</h5>
        <ul>
            <li><strong>Nama:</strong> {{ $loan->name }}</li>
            <li><strong>Deskripsi:</strong> {{ $loan->description }}</li>
            <li><strong>Kode:</strong> {{ $loan->code ? $loan->code->code : 'Kode tidak tersedia' }}</li>
            <li><strong>Total Pembayaran:</strong> Rp{{ number_format($loan->total_amount, 0, ',', '.') }}</li>
            <li><strong>Dibayar:</strong> Rp{{ number_format($loan->total_payment, 0, ',', '.') }}</li>
            <li><strong>Sisa Pembayaran:</strong> Rp{{ number_format($loan->outstanding_amount, 0, ',', '.') }}</li>
            <li><strong>Tanggal Awal:</strong> {{ $loan->loan_date }}</li>
            <li><strong>Terakhir Dirubah:</strong> {{ $loan->created_at->diffForHumans() }}</li>
            <li><strong>No HP:</strong> {{ $loan->phone }}</li>
        </ul>
        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn-back">Kembali</a>
    </div>

    <!-- Script untuk otomatis membuka dialog cetak -->
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</body>
</html>
