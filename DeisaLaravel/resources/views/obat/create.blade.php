@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="header">
    <h1>Tambah Obat Baru</h1>
    <a href="{{ route('obat.index') }}" class="btn" style="background: #f3f4f6; color: #374151;">Kembali</a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" placeholder="Analgasik, Antibiotik, dll">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Stok Awal</label>
                <input type="number" name="stok" class="form-input" value="0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Stok Minimum</label>
                <input type="number" name="stok_minimum" class="form-input" value="10" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Satuan</label>
            <input type="text" name="satuan" class="form-input" placeholder="Tablet, Botol, Pcs" required>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi / Kegunaan</label>
            <textarea name="deskripsi" class="form-input" rows="3"></textarea>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Obat</button>
        </div>
    </form>
</div>
@endsection
