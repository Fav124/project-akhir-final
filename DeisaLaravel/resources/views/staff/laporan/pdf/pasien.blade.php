<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pasien</title>
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
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN DATA PASIEN</h1>
        <p>Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th>Diagnosis</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasien as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->santri->nama_lengkap }}</td>
                    <td>{{ $item->santri->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->diagnosis_utama }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total: {{ count($pasien) }} pasien</strong></p>
</body>

</html>