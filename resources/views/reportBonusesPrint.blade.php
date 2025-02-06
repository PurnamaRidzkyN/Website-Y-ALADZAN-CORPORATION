<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gaji Periode {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Menyusun logo dan teks di kiri dan kanan */
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
            /* Sesuaikan ukuran logo */
            height: auto;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
            text-align: right;
            /* Agar nama perusahaan berada di kanan */
        }

        .header p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
            text-align: right;
            /* Teks lainnya sejajar dengan nama perusahaan */
        }

        .content {
            margin-bottom: 20px;
        }

        .content h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .content table th,
        .content table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .content table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .net-income {
            background-color: #e8f5e9;
        }

        .remaining-bonus {
            background-color: #fff3e0;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
        }

        .footer p {
            margin: 5px 0;
            color: #333;
        }

        .footer .signature {
            margin-top: 50px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        @media print {
            .back-button {
                display: none;
            }
        }
    </style>
    <script>
        // Auto-trigger print when the page loads
        window.onload = function() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <!-- Tempat untuk logo -->
            <img src="{{ asset('icon.png') }}" alt="Your Company">
            <div>
                <h1>Y-ALADZAN</h1>
                <p>Jln. Kehutanan No.04 Kp.Lengka Rt.01 Rw.27 Desa Ciwidey Kec.Ciwidey Kab.Bandung Prov.Jawa Barat.
                    Indonesia.</p>
                <p>No. 083135919345 | y.aladzan.92@gmail.com</p>
            </div>
        </div>
        <!-- Content -->
        <div class="content">
            <h2>Gaji Periode {{ $monthName }} {{ $year }}</h2>
            <table>
                <tr>
                    <th>Nama</th>
                    <td>{{ $expense->admin->name ?? $expense->manager->name }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>
                        @if ($expense->admin)
                            Admin
                        @elseif($expense->manager)
                            Manajer
                        @else
                            Tidak Diketahui
                        @endif
                    </td>
                </tr>
            </table>


            <h2>Rincian Pendapatan Periode {{ $monthName }} {{ $year }}</h2>
            <table>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>{{ number_format($expense->amount, 0, ',', '.') }}</td> <!-- Gaji Pokok dengan format -->
                </tr>
                <tr>
                    <th>Bonus Kinerja</th>
                    <td>{{ number_format($expenseB->amount ?? 0, 0, ',', '.') }}</td>
                    <!-- Bonus Kinerja dengan format -->
                </tr>
                <tr class="net-income">
                    <th>Pendapatan Bersih</th>
                    <td>{{ number_format($expense->amount + ($expenseB->amount ?? 0), 0, ',', '.') }}</td>
                    <!-- Pendapatan Bersih dengan format -->
                </tr>
            </table>


            <h2>Rincian Keuangan Total</h2>
            <table>
                <tr>
                    <th>Bonus Bulan Sebelumnya</th>
                    <td>Rp {{ number_format($totalBonusPrev, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tambahan Bonus</th>
                    <td>Rp {{ number_format($newBonus, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Total Bonus Keseluruhan</th>
                    <td>Rp {{ number_format($totalBonusPrev + $newBonus, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Bonus yang Sudah Diterima</th>
                    <td>Rp {{ number_format($totalRemaining, 0, ',', '.') }}</td>
                </tr>
                <tr class="remaining-bonus">
                    <th>Sisa Bonus</th>
                    <td><strong>Rp {{ number_format(($totalBonusPrev + $newBonus)-$totalRemaining, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Back Button -->
        <a href="javascript:history.back()" class="back-button">Kembali</a>

        <!-- Footer -->
        <div class="footer">
            <p>President of Foundation</p>
            <p>Y-Aladzan</p>
            <div class="signature">
                <p>Adzani Kusumawardani</p>
            </div>
        </div>
    </div>
</body>

</html>
