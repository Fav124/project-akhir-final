@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="header">
    <h1>Dashboard Utama</h1>
    <div style="font-size: 0.875rem; color: var(--text-muted);">Selamat datang, {{ Auth::user()->name }}</div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="border-left: 4px solid var(--primary);">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Total Santri</div>
        <div style="font-size: 1.875rem; font-weight: 700; margin-top: 0.5rem;">{{ $stats['total_santri'] }}</div>
    </div>
    
    <div class="card" style="border-left: 4px solid #f59e0b;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Sedang Sakit</div>
        <div style="font-size: 1.875rem; font-weight: 700; margin-top: 0.5rem; color: #d97706;">{{ $stats['total_sakit'] }}</div>
    </div>

    <div class="card" style="border-left: 4px solid #10b981;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Sudah Sembuh</div>
        <div style="font-size: 1.875rem; font-weight: 700; margin-top: 0.5rem; color: #059669;">{{ $stats['total_sembuh'] }}</div>
    </div>

    <div class="card" style="border-left: 4px solid #ef4444;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Stok Obat Rendah</div>
        <div style="font-size: 1.875rem; font-weight: 700; margin-top: 0.5rem; color: #dc2626;">{{ $stats['low_stock'] }}</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card">
        <h3 style="margin-bottom: 1rem; font-size: 1rem;">Tren Grafik Sakit (6 Bulan Terakhir)</h3>
        <canvas id="sakitChart" style="max-height: 300px;"></canvas>
    </div>
    
    <div class="card">
        <h3 style="margin-bottom: 1rem; font-size: 1rem;">Distribusi Tingkat Kondisi</h3>
        <canvas id="severityChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="header" style="margin-top: 2rem;">
    <h2>Aksi Cepat</h2>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
    <a href="{{ route('web.santri.create') }}" class="card" style="text-decoration: none; text-align: center; color: var(--text-main); transition: 0.2s;">
        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">👨‍🎓</div>
        <div style="font-weight: 600;">Tambah Santri</div>
    </a>
    <a href="{{ route('web.sakit.create') }}" class="card" style="text-decoration: none; text-align: center; color: var(--text-main); transition: 0.2s;">
        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏥</div>
        <div style="font-weight: 600;">Catat Sakit</div>
    </a>
    <a href="{{ route('web.obat.index') }}" class="card" style="text-decoration: none; text-align: center; color: var(--text-main); transition: 0.2s;">
        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">💊</div>
        <div style="font-weight: 600;">Cek Stok Obat</div>
    </a>
    <a href="{{ route('web.admin.registrations') }}" class="card" style="text-decoration: none; text-align: center; color: var(--text-main); transition: 0.2s;">
        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">👤</div>
        <div style="font-weight: 600;">Aproval User</div>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sakit Chart
    const ctxSakit = document.getElementById('sakitChart').getContext('2d');
    new Chart(ctxSakit, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values(array_map(fn($m) => DateTime::createFromFormat('!m', $m)->format('F'), array_keys($monthlySakit->toArray())))) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! json_encode(array_values($monthlySakit->toArray())) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, stepSize: 1 } }
        }
    });

    // Severity Chart
    const ctxSeverity = document.getElementById('severityChart').getContext('2d');
    new Chart(ctxSeverity, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($severityData->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($severityData->toArray())) !!},
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#3b82f6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
