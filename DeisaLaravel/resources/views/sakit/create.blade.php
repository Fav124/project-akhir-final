@extends('layouts.app')

@section('title', 'Catat Santri Sakit')

@section('content')
<div class="header">
    <h1>Catat Santri Sakit</h1>
    <a href="{{ route('sakit.index') }}" class="btn" style="background: #f3f4f6; color: #374151;">Kembali</a>
</div>

<form action="{{ route('sakit.store') }}" method="POST" id="sakitForm">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Data Kejadian -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informasi Kejadian</h2>
            
            <div class="form-group">
                <label class="form-label">Pilih Santri</label>
                <select name="santri_id" class="form-input" required>
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santris as $s)
                        <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai Sakit</label>
                    <input type="date" name="tanggal_mulai_sakit" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="Sakit">Sakit (UKS)</option>
                        <option value="Pulang">Izin Pulang</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tingkat Kondisi</label>
                <select name="tingkat_kondisi" class="form-input">
                    <option value="Ringan">Ringan</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Berat">Berat</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Keluhan / Gejala</label>
                <textarea name="keluhan" class="form-input" rows="2" placeholder="Apa yang dirasakan santri?" required></textarea>
                <input type="hidden" name="gejala" id="gejala_hidden">
            </div>

            <div class="form-group">
                <label class="form-label">Diagnosis</label>
                <textarea name="diagnosis" class="form-input" rows="2" placeholder="Hasil pemeriksaan awal"></textarea>
            </div>
        </div>

        <!-- Pemberian Obat -->
        <div class="card">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Pemberian Obat</h2>
            
            <div class="form-group">
                <label class="form-label">Pilih Obat (Multi-select)</label>
                <div style="max-height: 200px; overflow-y: auto; border: 1px solid var(--border); padding: 0.5rem; border-radius: 0.5rem;">
                    @foreach($obats as $o)
                        <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0; font-size: 0.875rem;">
                            <input type="checkbox" name="obat_ids[]" value="{{ $o->id }}"> 
                            {{ $o->nama_obat }} (Stok: {{ $o->stok }})
                        </label>
                    @endforeach
                </div>
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Obat yang dipilih akan dikurangi stoknya sebanyak 1 unit per item.</p>
            </div>

            <div class="form-group" style="margin-top: 1.5rem;">
                <label class="form-label">Tindakan / Perawatan</label>
                <textarea name="tindakan" class="form-input" rows="3" placeholder="Pemberian obat, kompres, dsb"></textarea>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem; text-align: right;">
        <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem; background: #ef4444;">Simpan Data Sakit</button>
    </div>
</form>

<script>
    document.getElementById('sakitForm').addEventListener('submit', function() {
        // Sync keluhan to gejala for backward compatibility if needed
        document.getElementById('gejala_hidden').value = document.querySelector('textarea[name="keluhan"]').value;
    });
</script>
@endsection
