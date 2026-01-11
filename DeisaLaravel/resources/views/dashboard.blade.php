@extends('layouts.app')

@section('title', 'Beranda')
@section('page_title', 'Beranda')

@section('content')
<div class="mb-6">
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Total Santri</div>
        <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_santri'] }}</div>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Sedang Sakit</div>
        <div class="text-2xl font-semibold text-amber-600">{{ $stats['total_sakit'] }}</div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Sudah Sembuh</div>
        <div class="text-2xl font-semibold text-emerald-600">{{ $stats['total_sembuh'] }}</div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Stok Obat Rendah</div>
        <div class="text-2xl font-semibold text-red-600">{{ $stats['low_stock'] }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Tren Grafik Sakit (6 Bulan Terakhir)</h3>
        <canvas id="sakitChart"></canvas>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Distribusi Tingkat Kondisi</h3>
        <canvas id="severityChart"></canvas>
    </div>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold mb-4">Aksi Cepat</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('web.santri.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors">
        <div class="text-2xl mb-2">👨‍🎓</div>
        <div class="font-medium text-gray-900">Tambah Santri</div>
    </a>
    <a href="{{ route('web.sakit.create') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors">
        <div class="text-2xl mb-2">🏥</div>
        <div class="font-medium text-gray-900">Catat Sakit</div>
    </a>
    <a href="{{ route('web.obat.index') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors">
        <div class="text-2xl mb-2">💊</div>
        <div class="font-medium text-gray-900">Cek Stok Obat</div>
    </a>
    <a href="{{ route('web.admin.registrations') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50 transition-colors">
        <div class="text-2xl mb-2">👤</div>
        <div class="font-medium text-gray-900">Persetujuan Pengguna</div>
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
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
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
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
