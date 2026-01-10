@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <a href="{{ route('santri.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Santri</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Edit Santri</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Edit Data Santri</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Perbarui data identitas santri dan wali.</p>
    </div>

    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('santri.update', $santri->id) }}">
            @csrf
            @method('PUT')

            <!-- SANTRI INFO -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Santri</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">NIS</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nis') border-red-500 @enderror" 
                               name="nis" value="{{ old('nis', $santri->nis) }}" required placeholder="Masukkan NIS">
                        @error('nis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nama_lengkap') border-red-500 @enderror" 
                               name="nama_lengkap" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required placeholder="Nama Lengkap">
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Jenis Kelamin</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('jenis_kelamin') border-red-500 @enderror" 
                                    name="jenis_kelamin" required>
                                <option disabled>-- Pilih --</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </div>
                        </div>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Kelas</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('kelas_id') border-red-500 @enderror" 
                                    name="kelas_id" id="kelas_id" required onchange="fetchJurusans(this.value)">
                                <option disabled>-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </div>
                        </div>
                        @error('kelas_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Jurusan</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none disabled:opacity-50 @error('jurusan_id') border-red-500 @enderror" 
                                    name="jurusan_id" id="jurusan_id" required>
                                <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </div>
                        </div>
                        @error('jurusan_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tempat Lahir</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('tempat_lahir') border-red-500 @enderror" 
                               name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" required placeholder="Kota Lahir">
                        @error('tempat_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Lahir</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('tanggal_lahir') border-red-500 @enderror" 
                               name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : '') }}" required>
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- WALI INFO -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-text-main dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Wali</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Wali</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('nama_wali') border-red-500 @enderror" 
                               name="nama_wali" value="{{ old('nama_wali', $wali->nama_wali ?? '') }}" required placeholder="Nama Wali">
                        @error('nama_wali')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Hubungan</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary appearance-none @error('hubungan') border-red-500 @enderror" 
                                    name="hubungan" required>
                                <option disabled>-- Pilih Hubungan --</option>
                                <option value="Ayah" {{ old('hubungan', $wali->hubungan ?? '') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="Ibu" {{ old('hubungan', $wali->hubungan ?? '') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Wali" {{ old('hubungan', $wali->hubungan ?? '') == 'Wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                             <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-text-muted">
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </div>
                        </div>
                        @error('hubungan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">No. HP Wali</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('no_hp') border-red-500 @enderror" 
                               name="no_hp" value="{{ old('no_hp', $wali->no_hp ?? '') }}" required placeholder="08xx...">
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tempat Lahir Wali</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('wali_tempat_lahir') border-red-500 @enderror" 
                               name="wali_tempat_lahir" value="{{ old('wali_tempat_lahir', $wali->tempat_lahir ?? '') }}" required>
                         @error('wali_tempat_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Lahir Wali</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('wali_tanggal_lahir') border-red-500 @enderror" 
                               name="wali_tanggal_lahir" value="{{ old('wali_tanggal_lahir', (isset($wali->tanggal_lahir) && $wali->tanggal_lahir instanceof \Carbon\Carbon) ? $wali->tanggal_lahir->format('Y-m-d') : ($wali->tanggal_lahir ?? '')) }}" required>
                        @error('wali_tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Alamat</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary @error('alamat') border-red-500 @enderror" 
                                  rows="3" name="alamat" required placeholder="Alamat Lengkap Domisili">{{ old('alamat', $wali->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('santri.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    async function fetchJurusans(kelasId, selectedJurusanId = null) {
        const jurusanSelect = document.getElementById('jurusan_id');
        if (!kelasId) {
            jurusanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
            jurusanSelect.disabled = true;
            return;
        }

        jurusanSelect.disabled = true;
        jurusanSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

        try {
            const res = await fetch(`{{ route('santri.getJurusans') }}?kelas_id=${kelasId}`);
            const jurusans = await res.json();

            if (jurusans.length > 0) {
                jurusanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Jurusan --</option>' +
                    jurusans.map(j => `<option value="${j.id}" ${selectedJurusanId == j.id ? 'selected' : ''}>${j.nama}</option>`).join('');
                jurusanSelect.disabled = false;
            } else {
                jurusanSelect.innerHTML = '<option value="" disabled selected>Tidak ada jurusan tersedia</option>';
                jurusanSelect.disabled = true;
            }
        } catch (e) {
            console.error(e);
            jurusanSelect.innerHTML = '<option value="" disabled selected>Error memuat data</option>';
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const initialKelas = "{{ old('kelas_id', $santri->kelas_id) }}";
        const initialJurusan = "{{ old('jurusan_id', $santri->jurusan_id) }}";
        if (initialKelas) {
            fetchJurusans(initialKelas, initialJurusan);
        }
    });
</script>
@endpush
