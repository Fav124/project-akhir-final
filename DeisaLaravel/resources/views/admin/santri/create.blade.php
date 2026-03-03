@extends('layouts.admin')

@section('title', 'Tambah Santri Baru')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.santri.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Tambah Santri Baru</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-5xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form id="santri-stepper-form" action="{{ route('admin.santri.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <div class="px-6 pt-6">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center w-full max-w-xs">
                            <div id="step-1-indicator"
                                class="w-8 h-8 rounded-full bg-deisa-blue text-white flex items-center justify-center text-sm font-bold transition-colors">
                                1</div>
                            <div class="flex-1 h-1 bg-slate-200 mx-2 rounded">
                                <div id="step-progress" class="h-full bg-deisa-blue w-0 transition-all duration-300"></div>
                            </div>
                            <div id="step-2-indicator"
                                class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold transition-colors">
                                2</div>
                        </div>
                    </div>
                </div>

                <div id="step-1" class="px-6 space-y-4"
                    x-data='{
                        selectedKelas: @json(old("kelas_id")),
                        selectedJurusan: @json(old("jurusan_id")),
                        classes: @json($classes),
                        get availableJurusans() {
                            if (!this.selectedKelas) return [];
                            const kelas = this.classes.find(k => String(k.id) === String(this.selectedKelas));
                            return kelas ? (kelas.jurusans || []) : [];
                        }
                    }'>
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Identitas Dasar</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Santri</label>
                            <input type="file" name="foto" accept="image/*"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-deisa-blue hover:file:bg-blue-100">
                            <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG. Max: 2MB</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIS / ID Santri</label>
                            <input type="text" name="nis" value="{{ old('nis') }}" required
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Contoh: 2024001">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Nama sesuai ijazah">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kelas</label>
                            <select name="kelas_id" required x-model="selectedKelas"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}" required
                                min="1900" max="{{ date('Y') + 1 }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Contoh: {{ date('Y') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
                            <select name="jurusan_id" required x-model="selectedJurusan" :disabled="!selectedKelas"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white disabled:opacity-50 disabled:bg-slate-50">
                                <option value="">Pilih Jurusan</option>
                                <template x-for="jurusan in availableJurusans" :key="jurusan.id">
                                    <option :value="jurusan.id" x-text="jurusan.nama_jurusan"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Kesehatan Awal</label>
                            <select name="status_kesehatan" required
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                @foreach(['Sehat', 'Sakit', 'Rawat Inap', 'Pulang', 'Pemulihan'] as $status)
                                    <option value="{{ $status }}" {{ old('status_kesehatan', 'Sehat') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="step-2" class="hidden px-6 pb-6 space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Detail & Data Wali</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Golongan Darah</label>
                            <select name="golongan_darah"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                <option value="">Pilih Golongan Darah</option>
                                @foreach(['A', 'B', 'AB', 'O'] as $darah)
                                    <option value="{{ $darah }}" {{ old('golongan_darah') == $darah ? 'selected' : '' }}>{{ $darah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pernah Tinggal Kelas</label>
                            <label class="inline-flex items-center gap-2 mt-2">
                                <input type="checkbox" name="is_repeating" value="1" {{ old('is_repeating') ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-deisa-blue focus:ring-deisa-blue">
                                <span class="text-sm text-slate-700">Ya, santri pernah mengulang kelas</span>
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Alamat lengkap santri...">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Riwayat Alergi</label>
                            <textarea name="riwayat_alergi" rows="2"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="Contoh: Alergi kacang, antibiotik tertentu...">{{ old('riwayat_alergi') }}</textarea>
                        </div>
                        <div class="md:col-span-2 pt-2 border-t border-slate-100 mt-2">
                            <h4 class="text-sm font-bold text-slate-800 mb-3">Data Orang Tua / Wali</h4>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Wali</label>
                            <input type="text" name="nama_wali" value="{{ old('nama_wali') }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hubungan</label>
                            <select name="hubungan"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                <option value="">Pilih Hubungan</option>
                                <option value="Ayah" {{ old('hubungan') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="Ibu" {{ old('hubungan') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Wali" {{ old('hubungan') == 'Wali' ? 'selected' : '' }}>Wali / Saudara</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                                placeholder="08xxxxxx">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex justify-between px-6 pb-6 pt-4 border-t border-slate-100">
                    <x-button variant="outline" type="button" href="{{ route('admin.santri.index') }}"
                        class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <div class="flex gap-2">
                        <button type="button" id="prev-step"
                            class="hidden px-4 py-2 text-sm font-medium text-deisa-blue border border-deisa-blue hover:bg-blue-50 rounded-lg transition-colors">Kembali</button>
                        <button type="button" id="next-step"
                            class="px-4 py-2 text-sm font-medium text-white bg-deisa-blue hover:bg-blue-600 rounded-lg shadow-lg shadow-blue-500/20 transition-all">Lanjut</button>
                        <x-button type="submit" id="submit-form" class="hidden rounded-2xl px-8 font-black shadow-lg shadow-blue-500/20">
                            Simpan Data
                        </x-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('santri-stepper-form');
        if (!form) return;

        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const nextBtn = document.getElementById('next-step');
        const prevBtn = document.getElementById('prev-step');
        const submitBtn = document.getElementById('submit-form');
        const progress = document.getElementById('step-progress');
        const ind2 = document.getElementById('step-2-indicator');

        nextBtn.addEventListener('click', function() {
            const fields = step1.querySelectorAll('input[required], select[required], textarea[required]');
            let valid = true;

            fields.forEach(function(field) {
                if (!field.value) {
                    field.classList.add('border-red-500');
                    valid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!valid) {
                if (typeof showAlert === 'function') {
                    showAlert('error', 'Mohon lengkapi data yang wajib diisi.');
                }
                return;
            }

            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            prevBtn.classList.remove('hidden');
            submitBtn.classList.remove('hidden');
            progress.style.width = '100%';
            ind2.classList.replace('bg-slate-200', 'bg-deisa-blue');
            ind2.classList.replace('text-slate-500', 'text-white');
        });

        prevBtn.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            prevBtn.classList.add('hidden');
            submitBtn.classList.add('hidden');
            progress.style.width = '0%';
            ind2.classList.replace('bg-deisa-blue', 'bg-slate-200');
            ind2.classList.replace('text-white', 'text-slate-500');
        });
    });
</script>
@endpush
