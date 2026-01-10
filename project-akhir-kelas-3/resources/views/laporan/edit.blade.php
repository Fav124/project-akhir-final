@extends('layouts.master')
@section('content')
    <!-- PAGE HEADER -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('laporan.index') }}" class="text-decoration-none">Laporan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Edit Laporan Pemeriksaan
                </li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-0">Edit Laporan Pemeriksaan</h4>
        <small class="text-muted">Perbarui data pemeriksaan kesehatan santri</small>
    </div>

    <!-- FORM CARD -->
    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i> Form Edit Laporan
            </h5>

            <form method="POST" action="{{ route('laporan.update', $laporan->id) }}">
                @csrf
                @method('PUT')

                <!-- SANTRI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Santri</label>
                    <select class="form-select @error('santri_id') is-invalid @enderror" id="santri_id" name="santri_id"
                        required>
                        <option selected disabled>-- Pilih Santri --</option>
                        @foreach ($santri as $s)
                            <option value="{{ $s->id }}"
                                {{ old('santri_id', $laporan->santri_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @error('santri_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TANGGAL PEMERIKSAAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Pemeriksaan</label>
                    <input type="date" class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror"
                        id="tanggal_pemeriksaan" name="tanggal_pemeriksaan"
                        value="{{ old('tanggal_pemeriksaan', $laporan->tanggal_pemeriksaan ? $laporan->tanggal_pemeriksaan->format('Y-m-d') : '') }}" required>
                    @error('tanggal_pemeriksaan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- KELUHAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Keluhan</label>
                    <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" rows="3"
                        placeholder="Masukkan keluhan santri" name="keluhan" required>{{ old('keluhan', $laporan->keluhan) }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- SUHU TUBUH -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Suhu Tubuh (°C)</label>
                    <input type="number" class="form-control @error('suhu_tubuh') is-invalid @enderror" id="suhu_tubuh"
                        placeholder="Contoh: 36.5" name="suhu_tubuh" step="0.1"
                        value="{{ old('suhu_tubuh', $laporan->suhu_tubuh) }}" required>
                    @error('suhu_tubuh')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TINDAKAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tindakan</label>
                    <textarea class="form-control @error('tindakan') is-invalid @enderror" id="tindakan" rows="3"
                        placeholder="Tindakan yang diberikan" name="tindakan">{{ old('tindakan', $laporan->tindakan) }}</textarea>
                    @error('tindakan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- STATUS KONDISI -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status Kondisi</label>
                    <select class="form-select @error('status_kondisi') is-invalid @enderror" id="status_kondisi"
                        name="status_kondisi" required>
                        <option selected disabled>-- Pilih Status --</option>
                        <option value="sehat"
                            {{ old('status_kondisi', $laporan->status_kondisi) == 'sehat' ? 'selected' : '' }}>Sehat
                        </option>
                        <option value="sakit-ringan"
                            {{ old('status_kondisi', $laporan->status_kondisi) == 'sakit-ringan' ? 'selected' : '' }}>Sakit
                            Ringan</option>
                        <option value="sakit-berat"
                            {{ old('status_kondisi', $laporan->status_kondisi) == 'sakit-berat' ? 'selected' : '' }}>Sakit
                            Berat</option>
                    </select>
                    @error('status_kondisi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary flex-grow-1">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-save me-1"></i> Perbarui
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
