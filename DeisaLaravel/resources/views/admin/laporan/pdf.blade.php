<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0B63D6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #0B63D6;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 5px;
            font-size: 12px;
        }

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .summary-box h3 {
            margin-top: 0;
            font-size: 16px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }

        table.records {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.records th {
            background: #0B63D6;
            color: white;
            padding: 10px;
            font-size: 12px;
            text-align: left;
        }

        table.records td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .status-pill {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
        }

        .badge-sakit {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-sembuh {
            background: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DEISA HEALTH</h1>
        <p>Unit Kesehatan Dar El-Ilmi (UKS)</p>
        <p style="font-size: 10px;">Laporan Ringkasan Kesehatan Santri</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150">Jenis Laporan:</td>
                <td><strong>Laporan Kunjungan Berkala</strong></td>
                <td align="right">Dicetak Pada:</td>
                <td align="right">{{ now()->translatedFormat('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td>Rentang Waktu:</td>
                <td><strong>{{ $date_range }}</strong></td>
                <td align="right">Oleh:</td>
                <td align="right">{{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>

    <div class="summary-box">
        <h3>Ringkasan Statistik</h3>
        <table>
            <tr>
                <td>Total Kunjungan UKS:</td>
                <td><strong>{{ $summary['total_kunjungan'] }} Kasus</strong></td>
                <td>Total Obat Terdistribusi:</td>
                <td><strong>{{ $summary['total_obat'] }} Unit</strong></td>
            </tr>
        </table>
    </div>

    <h3>Daftar Detail Kunjungan</h3>
    <table class="records">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Santri</th>
                <th>Kelas</th>
                <th>Keluhan / Diagnosis</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $row->santri->nama_lengkap }}</strong></td>
                    <td>{{ $row->santri->kelas->nama_kelas ?? 'N/A' }}</td>
                    <td>{{ $row->keluhan ?: ($row->gejala ?: '-') }}</td>
                    <td>
                        <span class="status-pill {{ $row->status == 'Sembuh' ? 'badge-sembuh' : 'badge-sakit' }}">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada data untuk periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate secara otomatis oleh Sistem Informasi Deisa Health - &copy; {{ date('Y') }} Dar El-Ilmi
    </div>
</body>

</html>