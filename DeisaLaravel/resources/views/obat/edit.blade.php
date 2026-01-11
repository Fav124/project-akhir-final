@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="header">
    <h1>Edit Obat: {{ $obat->nama_obat }}</h1>
    <a href="{{ route('obat.index') }}" class="btn" style="background: #f3f4f6; color: #374151;">Kembali</a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('obat.update', $obat) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-input" value="{{ $obat->nama_obat }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-input" value="{{ $obat->kategori }}">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-input" value="{{ $obat->stok }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Stok Minimum</label>
                <input type="number" name="stok_minimum" class="form-input" value="{{ $obat->stok_minimum }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label">Harga Satuan (Rp)</label>
                <input type="number" name="harga_satuan" class="form-input" value="{{ $obat->harga_satuan }}">
            </div>
            <div class="form-group">
                <label class="form-label">Satuan</label>
                <input type="text" name="satuan" class="form-input" value="{{ $obat->satuan }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Taggal Kadaluarsa</label>
            <input type="date" name="tanggal_kadaluarsa" class="form-input" value="{{ $obat->tanggal_kadaluarsa ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '' }}">
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi / Kegunaan</label>
            <textarea name="deskripsi" class="form-input" rows="3">{{ $obat->deskripsi }}</textarea>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
