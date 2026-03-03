<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 28px 28px 90px 28px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.35;
            color: #111827;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }

        .header .org {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .header .unit {
            margin: 0;
            margin-top: 2px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .header .address {
            margin-top: 3px;
            font-size: 11px;
        }

        .title {
            margin: 14px 0 8px;
            text-align: center;
        }

        .title h1 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .title .subtitle {
            margin-top: 3px;
            font-size: 11px;
        }

        .meta,
        .summary,
        .records,
        .signature {
            width: 100%;
            border-collapse: collapse;
        }

        .meta {
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .meta td {
            padding: 3px 2px;
            font-size: 12px;
            vertical-align: top;
        }

        .meta .label {
            width: 135px;
        }

        .meta .separator {
            width: 10px;
            text-align: center;
        }

        .section-title {
            margin: 10px 0 5px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
        }

        .summary {
            margin-bottom: 10px;
            border: 1px solid #000;
        }

        .summary td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 12px;
        }

        .summary .value {
            width: 160px;
            text-align: center;
            font-weight: 700;
        }

        .records {
            margin-top: 4px;
            margin-bottom: 20px;
        }

        .records th,
        .records td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 11px;
            vertical-align: top;
        }

        .records th {
            text-align: center;
            font-weight: 700;
        }

        .records .num,
        .records .date,
        .records .class,
        .records .status {
            text-align: center;
        }

        .no-data {
            text-align: center;
            font-style: italic;
        }

        .signature {
            margin-top: 20px;
        }

        .signature td {
            font-size: 12px;
            padding: 2px 0;
            vertical-align: top;
        }

        .signature .right {
            width: 42%;
            text-align: center;
            padding-left: 20px;
        }

        .signature-space {
            height: 62px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 6px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="org">DEISA HEALTH</p>
        <p class="unit">UNIT KESEHATAN DAR EL-ILMI (UKS)</p>
        <p class="address">Dokumen Internal Layanan Kesehatan Santri</p>
    </div>

    <div class="title">
        <h1>Laporan Ringkasan Kesehatan Santri</h1>
        <div class="subtitle">Periode {{ $date_range }}</div>
    </div>

    <table class="meta">
        <tr>
            <td class="label">Jenis Laporan</td>
            <td class="separator">:</td>
            <td>Laporan Kunjungan Berkala</td>
            <td class="label">Tanggal Cetak</td>
            <td class="separator">:</td>
            <td>{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Rentang Waktu</td>
            <td class="separator">:</td>
            <td>{{ $date_range }}</td>
            <td class="label">Petugas Pencetak</td>
            <td class="separator">:</td>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Dokumen</td>
            <td class="separator">:</td>
            <td>LKS/{{ now()->format('Ymd') }}/{{ str_pad((string) $records->count(), 3, '0', STR_PAD_LEFT) }}</td>
            <td class="label">Jumlah Data</td>
            <td class="separator">:</td>
            <td>{{ $records->count() }} kunjungan</td>
        </tr>
    </table>

    <div class="section-title">I. Ringkasan Statistik</div>
    <table class="summary">
        <tr>
            <td>Total Kunjungan UKS</td>
            <td class="value">{{ $summary['total_kunjungan'] }} Kasus</td>
            <td>Total Obat Terdistribusi</td>
            <td class="value">{{ $summary['total_obat'] }} Unit</td>
        </tr>
    </table>

    <div class="section-title">II. Rincian Kunjungan</div>
    <table class="records">
        <thead>
            <tr>
                <th style="width: 34px;">No</th>
                <th style="width: 72px;">Tanggal</th>
                <th style="width: 170px;">Nama Santri</th>
                <th style="width: 70px;">Kelas</th>
                <th>Keluhan / Diagnosis</th>
                <th style="width: 70px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $row)
                <tr>
                    <td class="num">{{ $index + 1 }}</td>
                    <td class="date">{{ $row->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $row->santri->nama_lengkap }}</strong></td>
                    <td class="class">{{ $row->santri->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $row->keluhan ?: ($row->gejala ?: '-') }}</td>
                    <td class="status">{{ strtoupper($row->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">Tidak ada data kunjungan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature">
        <tr>
            <td></td>
            <td class="right">Dar El-Ilmi, {{ now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="right">Petugas UKS,</td>
        </tr>
        <tr>
            <td></td>
            <td class="right signature-space"></td>
        </tr>
        <tr>
            <td></td>
            <td class="right"><strong><u>{{ auth()->user()->name }}</u></strong></td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan oleh Sistem Informasi DEISA | {{ date('Y') }} Dar El-Ilmi
    </div>
</body>

</html>
