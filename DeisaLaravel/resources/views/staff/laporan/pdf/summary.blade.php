<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Ringkasan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            color: #0B63D6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0B63D6;
            color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .stat-box {
            text-align: center;
            padding: 15px;
            border: 2px solid #0B63D6;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN RINGKASAN DEISA</h1>
        <p>Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h3>Statistik Pasien</h3>
    <table>
        <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>Total Pasien</td>
            <td>{{ $totalPasien }}</td>
        </tr>
        <tr>
            <td>Pasien Sembuh</td>
            <td>{{ $pasienSembuh }}</td>
        </tr>
        <tr>
            <td>Pasien Masih Sakit</td>
            <td>{{ $pasienSakit }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px;">Statistik Obat</h3>
    <table>
        <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>Total Jenis Obat</td>
            <td>{{ $totalObat }}</td>
        </tr>
        <tr>
            <td>Obat Stok Menipis (< 10)</td>
            <td>{{ $obatHampirHabis }}</td>
        </tr>
    </table>
</body>

</html>