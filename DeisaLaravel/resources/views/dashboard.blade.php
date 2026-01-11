@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="header">
    <h1>Dashboard</h1>
    <div class="badge badge-success">Sistem Online</div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
    <div class="card" style="border-left: 4px solid var(--primary);">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Santri</h3>
        <p style="font-size: 2rem; font-weight: 700;">{{ $stats['total_santri'] }}</p>
    </div>
    
    <div class="card" style="border-left: 4px solid #ef4444;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">Santri Sakit</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #ef4444;">{{ $stats['total_sakit'] }}</p>
    </div>

    <div class="card" style="border-left: 4px solid #3b82f6;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">Total Sembuh</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #3b82f6;">{{ $stats['total_sembuh'] }}</p>
    </div>

    <div class="card" style="border-left: 4px solid #f59e0b;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">Stok Obat Rendah</h3>
        <p style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ $stats['low_stock'] }}</p>
    </div>
</div>

<div style="margin-top: 2rem;">
    <div class="card">
        <h2 style="margin-bottom: 1rem;">Akses Cepat</h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('santri.create') }}" class="btn btn-primary">Tambah Santri Baru</a>
            <a href="{{ route('sakit.create') }}" class="btn" style="background: #ef4444; color: white;">Catat Santri Sakit</a>
            <a href="{{ route('obat.index') }}" class="btn" style="background: #3b82f6; color: white;">Cek Stok Obat</a>
        </div>
    </div>
</div>
@endsection
