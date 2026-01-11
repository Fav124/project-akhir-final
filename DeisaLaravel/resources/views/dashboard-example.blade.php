@extends('layouts.app')

@section('title', 'Dashboard - DEISA')

@section('content')
<!-- Header dengan Breadcrumb -->
<div style="margin-bottom: 2rem;">
    <div class="breadcrumb-health">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <span class="separator">/</span>
        <span class="active">Ringkasan Kesehatan</span>
    </div>
    <h1 style="font-size: 2rem; color: #064e3b; font-weight: 800; margin: 0;">
        Selamat Datang di DEISA
    </h1>
    <p style="color: #6b7280; margin-top: 0.5rem;">Sistem Manajemen Kesehatan Pesantren</p>
</div>

<!-- Statistics Cards Grid -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); margin-bottom: 2rem;">
    <!-- Total Santri Card -->
    <div class="health-stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $total_santri ?? 245 }}</div>
        <div class="stat-label">Total Santri Terdaftar</div>
        <div class="stat-change">↑ 12 santri baru bulan ini</div>
    </div>

    <!-- Santri Sakit Card -->
    <div class="health-stat-card">
        <div class="stat-icon">🏥</div>
        <div class="stat-value">{{ $santri_sakit ?? 15 }}</div>
        <div class="stat-label">Santri Dalam Perawatan</div>
        <div class="stat-change negative">↑ 3 dari kemarin</div>
    </div>

    <!-- Obat Stok Card -->
    <div class="health-stat-card">
        <div class="stat-icon">💊</div>
        <div class="stat-value">{{ $total_obat ?? 42 }}</div>
        <div class="stat-label">Jenis Obat Tersedia</div>
        <div class="stat-change">5 obat kritis</div>
    </div>

    <!-- Recovery Rate Card -->
    <div class="health-stat-card">
        <div class="stat-icon">📈</div>
        <div class="stat-value">98%</div>
        <div class="stat-label">Tingkat Pemulihan</div>
        <div class="stat-change">↑ 2% bulan ini</div>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); margin-bottom: 2rem;">
    <!-- Chart Kesehatan -->
    <div class="chart-container">
        <div class="chart-title">Status Kesehatan Santri</div>
        <canvas id="healthChart" height="300"></canvas>
    </div>

    <!-- Chart Penyakit -->
    <div class="chart-container">
        <div class="chart-title">Penyakit Terbanyak Bulan Ini</div>
        <canvas id="diseaseChart" height="300"></canvas>
    </div>
</div>

<!-- Recent Patients Section -->
<div class="card shadow-health" style="margin-bottom: 2rem;">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Santri yang Baru Dicatat Sakit</h5>
    </div>
    <div class="card-body">
        <div style="display: grid; gap: 1rem;">
            <!-- Patient 1 -->
            <div class="patient-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; flex: 1;">
                        <div class="patient-avatar">AB</div>
                        <div class="patient-info">
                            <div class="patient-name">Ahmad Burhan</div>
                            <div class="patient-detail">Kelas: X Teknik Komputer Jaringan</div>
                            <div class="patient-detail">📍 Asrama A-5</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="health-status sakit">Demam</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.5rem;">Dicatat: 2 jam lalu</div>
                    </div>
                </div>
            </div>

            <!-- Patient 2 -->
            <div class="patient-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; flex: 1;">
                        <div class="patient-avatar" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">SN</div>
                        <div class="patient-info">
                            <div class="patient-name">Siti Nurhaliza</div>
                            <div class="patient-detail">Kelas: XI Kesehatan</div>
                            <div class="patient-detail">📍 Asrama B-12</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="health-status pemulihan">Pemulihan</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.5rem;">Update: 30 menit lalu</div>
                    </div>
                </div>
            </div>

            <!-- Patient 3 -->
            <div class="patient-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; flex: 1;">
                        <div class="patient-avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">MR</div>
                        <div class="patient-info">
                            <div class="patient-name">Moh. Rafif</div>
                            <div class="patient-detail">Kelas: XII Pendidikan</div>
                            <div class="patient-detail">📍 Asrama C-8</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="health-status pemeriksaan">Pemeriksaan</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.5rem;">Sedang diperiksa</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('web.santri.index') }}" class="btn-health btn-health-primary">
                Lihat Semua Data Santri →
            </a>
        </div>
    </div>
</div>

<!-- Medicine Stock Section -->
<div class="card shadow-health" style="margin-bottom: 2rem;">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Status Stok Obat</h5>
    </div>
    <div class="card-body">
        <div style="display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <!-- Medicine 1 -->
            <div class="medicine-card">
                <div class="medicine-icon">💊</div>
                <div class="medicine-name">Paracetamol</div>
                <div class="medicine-info">Tablet - 500mg</div>
                <div class="medicine-stock">Stok: 245</div>
            </div>

            <!-- Medicine 2 -->
            <div class="medicine-card">
                <div class="medicine-icon">🌡️</div>
                <div class="medicine-name">Amoxicillin</div>
                <div class="medicine-info">Kapsul - 500mg</div>
                <div class="medicine-stock low">Stok: 42</div>
            </div>

            <!-- Medicine 3 -->
            <div class="medicine-card">
                <div class="medicine-icon">💉</div>
                <div class="medicine-name">Vitamin C</div>
                <div class="medicine-info">Tablet - 500mg</div>
                <div class="medicine-stock">Stok: 180</div>
            </div>

            <!-- Medicine 4 -->
            <div class="medicine-card">
                <div class="medicine-icon">🧴</div>
                <div class="medicine-name">Obat Batuk</div>
                <div class="medicine-info">Sirup</div>
                <div class="medicine-stock critical">Stok: 5 ⚠️</div>
            </div>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('web.obat.index') }}" class="btn-health btn-health-primary">
                Kelola Inventaris Obat →
            </a>
        </div>
    </div>
</div>

<!-- Activity Timeline -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Aktivitas Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="timeline">
            <div class="timeline-item active">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-time">Hari ini, 14:30</div>
                    <div class="timeline-title">Santri Baru Dicatat Sakit</div>
                    <div class="timeline-description">Ahmad Burhan dicatat dengan diagnosis Demam, diberi resep Paracetamol</div>
                </div>
            </div>

            <div class="timeline-item active">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-time">Hari ini, 13:15</div>
                    <div class="timeline-title">Stok Obat Dikritisi</div>
                    <div class="timeline-description">Stok Obat Batuk Sirup tersisa hanya 5 botol, perlu segera dipesan</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-time">Kemarin, 16:45</div>
                    <div class="timeline-title">Santri Dinyatakan Sembuh</div>
                    <div class="timeline-description">Siti Nurhaliza dinyatakan sehat dan diizinkan kembali ke asrama</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-time">2 hari lalu, 10:20</div>
                    <div class="timeline-title">Data Diagnosis Diperbarui</div>
                    <div class="timeline-description">Tiga diagnosis baru ditambahkan ke database kesehatan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div style="margin-top: 2rem; display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
    @if(Route::has('web.santri.index'))
    <a href="{{ route('web.santri.index') }}" class="btn-health btn-health-primary" style="justify-content: center;">
        👥 Kelola Santri
    </a>
    @endif
    
    @if(Route::has('web.sakit.index'))
    <a href="{{ route('web.sakit.index') }}" class="btn-health btn-health-primary" style="justify-content: center;">
        📋 Catatan Sakit
    </a>
    @endif
    
    @if(Route::has('web.obat.index'))
    <a href="{{ route('web.obat.index') }}" class="btn-health btn-health-primary" style="justify-content: center;">
        💊 Manajemen Obat
    </a>
    @endif
    
    @if(Auth::check() && Auth::user()->role === 'admin' && Route::has('admin.registrations'))
    <a href="{{ route('web.admin.registrations') }}" class="btn-health btn-health-secondary" style="justify-content: center;">
        ⚙️ Admin Panel
    </a>
    @endif
</div>

<!-- Scripts untuk Chart (opsional) -->
<script>
    // Jika menggunakan Chart.js
    // const healthCtx = document.getElementById('healthChart').getContext('2d');
    // const healthChart = new Chart(healthCtx, { ... });
</script>
@endsection
