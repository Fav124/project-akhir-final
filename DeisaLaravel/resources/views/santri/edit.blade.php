@extends('layouts.app')

@section('title', 'Edit Santri')

@section('content')
<div class="header">
    <h1>Edit Data Santri: {{ $santri->nama_lengkap }}</h1>
    <a href="{{ route('santri.index') }}" class="btn" style="background: #f3f4f6; color: #374151;">Kembali</a>
</div>

<form action="{{ route('santri.update', $santri) }}" method="POST">
    @csrf @method('PUT')
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Data Pribadi -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Data Pribadi</h2>
            
            <div class="form-group">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-input" value="{{ $santri->nis }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-input" value="{{ $santri->nama_lengkap }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Panggilan (Fallback)</label>
                <input type="text" name="nama" class="form-input" value="{{ $santri->nama }}">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-input" required>
                        <option value="L" {{ $santri->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $santri->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <input type="text" name="golongan_darah" class="form-input" value="{{ $santri->golongan_darah }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-input" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $santri->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jurusan</label>
                <select name="jurusan_id" class="form-input" required>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ $santri->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Data Wali -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Data Wali Santri</h2>
            
            <div class="form-group">
                <label class="form-label">Nama Wali</label>
                <input type="text" name="nama_wali" class="form-input" value="{{ $santri->wali?->nama_wali }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">No. Telp Wali</label>
                <input type="text" name="no_telp_wali" class="form-input" value="{{ $santri->wali?->no_telp_wali }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Hubungan Wali</label>
                <input type="text" name="hubungan_wali" class="form-input" value="{{ $santri->wali?->hubungan }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan_wali" class="form-input" value="{{ $santri->wali?->pekerjaan }}">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Wali</label>
                <textarea name="alamat_wali" class="form-input" rows="3">{{ $santri->wali?->alamat }}</textarea>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem; text-align: right;">
        <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Perbarui Data Santri</button>
    </div>
</form>
@endsection
