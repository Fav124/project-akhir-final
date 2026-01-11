@extends('layouts.app')

@section('title', 'Tambah Santri')

@section('content')
<div class="header">
    <h1>Tambah Santri Baru</h1>
    <a href="{{ route('santri.index') }}" class="btn" style="background: #f3f4f6; color: #374151;">Kembali</a>
</div>

<form action="{{ route('santri.store') }}" method="POST">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Data Pribadi -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Data Pribadi</h2>
            
            <div class="form-group">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Panggilan (Fallback)</label>
                <input type="text" name="nama" class="form-input">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-input" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <input type="text" name="golongan_darah" class="form-input">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-input" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jurusan</label>
                <select name="jurusan_id" class="form-input" required>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Data Wali -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Data Wali Santri</h2>
            
            <div class="form-group">
                <label class="form-label">Nama Wali</label>
                <input type="text" name="nama_wali" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">No. Telp Wali</label>
                <input type="text" name="no_telp_wali" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Hubungan Wali</label>
                <input type="text" name="hubungan_wali" class="form-input" placeholder="Ayah/Ibu/Paman" required>
            </div>

            <div class="form-group">
                <label class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan_wali" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Wali</label>
                <textarea name="alamat_wali" class="form-input" rows="3"></textarea>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem; text-align: right;">
        <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;">Simpan Data Santri</button>
    </div>
</form>
@endsection
