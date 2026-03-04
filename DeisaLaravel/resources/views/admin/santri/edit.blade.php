@extends('layouts.admin')

@section('title', 'Edit Santri')

@section('header')
    <div class="space-y-0.5">
        <a href="{{ route('admin.santri.show', $santri->id) }}" class="inline-flex items-center gap-2 text-xs text-slate-500 hover:text-deisa-blue">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Detail Santri
        </a>
        <h2 class="text-lg font-bold text-slate-900 leading-tight">Edit Santri {{ $santri->nama_lengkap }}</h2>
    </div>
@endsection

@section('admin-content')
    @php
        $status = strtolower((string) old('status_kesehatan', $santri->status_kesehatan));
        $statusClass = $status === 'sehat'
            ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
            : ($status === 'pemulihan'
                ? 'bg-blue-100 text-blue-700 border-blue-200'
                : 'bg-rose-100 text-rose-700 border-rose-200');
    @endphp

    <div class="mx-auto max-w-6xl" x-data='{
        selectedKelas: @json((string) old("kelas_id", $santri->kelas_id)),
        selectedJurusan: @json((string) old("jurusan_id", $santri->jurusan_id)),
        fallbackJurusanId: @json((string) ($santri->jurusan_id ?? "")),
        fallbackJurusanNama: @json(optional($santri->jurusan)->nama_jurusan),
        classes: @json($classes),
        get availableJurusans() {
            if (!this.selectedKelas) return [];
            const kelas = this.classes.find(k => String(k.id) === String(this.selectedKelas));
            return kelas ? (kelas.jurusans || []) : [];
        },
        get hasSelectedInKelas() {
            return this.availableJurusans.some(j => String(j.id) === String(this.selectedJurusan));
        }
    }'>
        <form action="{{ route('admin.santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/40 rounded-3xl">
                <div class="p-6 grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="w-28 h-28 mx-auto rounded-2xl bg-blue-100 flex items-center justify-center text-deisa-blue text-4xl font-bold overflow-hidden">
                            @if($santri->foto)
                                <img src="{{ asset('storage/' . $santri->foto) }}" class="w-full h-full object-cover rounded-2xl" alt="Foto {{ $santri->nama_lengkap }}">
                            @else
                                {{ substr($santri->nama_lengkap, 0, 1) }}
                            @endif
                        </div>
                        <div class="text-center mt-3">
                            <p class="font-bold text-slate-900 leading-tight">{{ $santri->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 mt-1">NIS: {{ $santri->nis }}</p>
                        </div>
                        <div class="mt-3 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $statusClass }}">
                                {{ old('status_kesehatan', $santri->status_kesehatan) }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Ganti Foto</label>
                            <input type="file" name="foto" accept="image/*"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Identitas & Akademik</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">NIS</label>
                                <input type="text" name="nis" value="{{ old('nis', $santri->nis) }}" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Kelas</label>
                                <select name="kelas_id" required x-model="selectedKelas"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Jurusan</label>
                                <select name="jurusan_id" required x-model="selectedJurusan" :disabled="!selectedKelas"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white disabled:opacity-60 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                    <option value="">Pilih Jurusan</option>
                                    <template x-if="selectedJurusan && !hasSelectedInKelas && String(fallbackJurusanId) === String(selectedJurusan) && fallbackJurusanNama">
                                        <option :value="String(fallbackJurusanId)" x-text="fallbackJurusanNama + ' (data lama)'"></option>
                                    </template>
                                    <template x-for="jurusan in availableJurusans" :key="jurusan.id">
                                        <option :value="String(jurusan.id)" x-text="jurusan.nama_jurusan"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                    <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" min="1900" max="{{ date('Y') + 1 }}"
                                    value="{{ old('tahun_masuk', $santri->tahun_masuk) }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Status Kesehatan Awal</label>
                                <select name="status_kesehatan" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                    @foreach(['Sehat', 'Sakit', 'Rawat Inap', 'Pulang', 'Pemulihan'] as $statusValue)
                                        <option value="{{ $statusValue }}" {{ old('status_kesehatan', $santri->status_kesehatan) === $statusValue ? 'selected' : '' }}>
                                            {{ $statusValue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Medis</h3>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Golongan Darah</label>
                            <select name="golongan_darah"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                <option value="">Pilih Golongan Darah</option>
                                @foreach(['A', 'B', 'AB', 'O'] as $darah)
                                    <option value="{{ $darah }}" {{ old('golongan_darah', $santri->golongan_darah) === $darah ? 'selected' : '' }}>{{ $darah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Alamat</label>
                            <textarea name="alamat" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">{{ old('alamat', $santri->alamat) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Riwayat Alergi</label>
                            <textarea name="riwayat_alergi" rows="3"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">{{ old('riwayat_alergi', $santri->riwayat_alergi) }}</textarea>
                        </div>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_repeating" value="1" {{ old('is_repeating', $santri->is_repeating) ? 'checked' : '' }}
                                class="rounded border-slate-300 text-deisa-blue focus:ring-deisa-blue">
                            <span class="text-sm text-slate-700">Santri pernah mengulang kelas</span>
                        </label>
                    </div>
                </x-card>

                <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/30 rounded-3xl">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Kontak Wali (Emergency)</h3>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Nama Wali</label>
                            <input type="text" name="nama_wali" value="{{ old('nama_wali', optional($santri->wali)->nama_wali) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Hubungan</label>
                            <select name="hubungan"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                                <option value="">Pilih Hubungan</option>
                                <option value="Ayah" {{ old('hubungan', optional($santri->wali)->hubungan) === 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="Ibu" {{ old('hubungan', optional($santri->wali)->hubungan) === 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Wali" {{ old('hubungan', optional($santri->wali)->hubungan) === 'Wali' ? 'selected' : '' }}>Wali / Saudara</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">No HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', optional($santri->wali)->no_hp) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                                placeholder="08xxxxxx">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', optional($santri->wali)->pekerjaan) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        </div>
                    </div>
                </x-card>
            </div>

            <x-card class="overflow-hidden border-none shadow-lg shadow-slate-200/30 rounded-3xl">
                <div class="p-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Simpan perubahan data santri</p>
                        <p class="text-xs text-slate-500">Pastikan seluruh data penting sudah benar sebelum menyimpan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.santri.show', $santri->id) }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-deisa-blue px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </x-card>
        </form>
    </div>
@endsection
