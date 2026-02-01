<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
            padding: 6px;
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

        .low-stock {
            background-color: #fee;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA OBAT</h1>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jenis</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obat as $index => $item)
                <tr class="{{ $item->stok < 10 ? 'low-stock' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_obat }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total: {{ count($obat) }} jenis obat</strong></p>
    <p><em>* Baris merah menandakan stok menipis (< 10)</em>
    </p>
</body>

</html>