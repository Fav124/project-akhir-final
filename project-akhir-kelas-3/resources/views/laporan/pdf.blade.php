<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kesehatan Santri - Deisa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }
        .period {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background: #007bff;
            color: white;
            padding: 8px 12px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .stat-box {
            display: inline-block;
            width: 23%;
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin-right: 2%;
            vertical-align: top;
        }
        .stat-box:last-child {
            margin-right: 0;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 3px;
            color: white;
        }
        .badge-danger { background: #dc3545; }
        .badge-warning { background: #ffc107; color: #333; }
        .badge-success { background: #28a745; }
        .badge-info { background: #17a2b8; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN KESEHATAN SANTRI</h1>
            <p>Sistem Informasi Manajemen Kesehatan Santri - DEISA</p>
        </div>

        <!-- Period -->
        <div class="period">
            <strong>Periode:</strong> 
            {{ $start ? $start->format('d F Y') : '-' }} s/d {{ $end ? $end->format('d F Y') : '-' }}
            <br>
            <strong>Dicetak:</strong> {{ now()->format('d F Y H:i') }} WIB
        </div>

        <!-- Statistics Summary -->
        <div class="section">
            <div class="section-title">RINGKASAN STATISTIK</div>
            <div style="text-align: center;">
                <div class="stat-box">
                    <div class="stat-number">{{ $uniqueSantriCount }}</div>
                    <div class="stat-label">Total Santri Sakit</div>
                </div>
            </div>
        </div>

        <!-- Top Santri Sakit -->
        <div class="section">
            <div class="section-title">TOP 10 SANTRI PALING SERING SAKIT</div>
            @if(count($topSantri) > 0)
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="50%">Nama Santri</th>
                        <th width="25%">Kelas</th>
                        <th width="20%">Jumlah Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topSantri as $index => $santri)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $santri['nama'] ?? '-' }}</td>
                        <td>{{ $santri['kelas'] ?? '-' }}</td>
                        <td>
                            <span class="badge badge-danger">{{ $santri['times_sick'] }}x sakit</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data">Tidak ada data santri sakit dalam periode ini</div>
            @endif
        </div>

        <!-- Top Obat -->
        <div class="section">
            <div class="section-title">TOP 10 OBAT PALING SERING DIGUNAKAN</div>
            @if(count($topObats) > 0)
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="55%">Nama Obat</th>
                        <th width="20%">Jumlah Penggunaan</th>
                        <th width="20%">Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topObats as $index => $obat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $obat->nama_obat }}</td>
                        <td>{{ $obat->total_jumlah }}x</td>
                        <td>{{ $obat->total_jumlah }} unit</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="no-data">Tidak ada data penggunaan obat dalam periode ini</div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini digenerate secara otomatis oleh Sistem DEISA</p>
            <p>&copy; {{ date('Y') }} - Deisa Santri Health Management</p>
        </div>
    </div>
</body>
</html>
