<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900" id="modal-title">
        {{ isset($santri) ? 'Edit Data Santri' : 'Tambah Santri Baru' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form id="santri-stepper-form"
    action="{{ isset($santri) ? route('admin.santri.update', $santri->id) : route('admin.santri.store') }}"
    method="POST" data-ajax="true">
    @csrf
    @if(isset($santri))
        @method('PUT')
    @endif

    <div class="p-6">
        <!-- Stepper Indicator -->
        <div class="flex items-center justify-center mb-8">
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

        <!-- Step 1: Identitas Dasar -->
        <div id="step-1" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIS / ID Santri</label>
                    <input type="text" name="nis" value="{{ $santri->nis ?? '' }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Contoh: 2024001">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ $santri->nama_lengkap ?? '' }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Nama sesuai ijazah">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ (isset($santri) && $santri->jenis_kelamin == 'L') ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="P" {{ (isset($santri) && $santri->jenis_kelamin == 'P') ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kelas</label>
                    <select name="kelas_id" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ (isset($santri) && $santri->kelas_id == $class->id) ? 'selected' : '' }}>
                                {{ $class->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
                    <select name="jurusan_id" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="">Pilih Jurusan</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ (isset($santri) && $santri->jurusan_id == $jurusan->id) ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Kesehatan Awal</label>
                    <select name="status_kesehatan" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="sehat" {{ (isset($santri) && $santri->status_kesehatan == 'sehat') ? 'selected' : '' }}>Sehat</option>
                        <option value="sakit" {{ (isset($santri) && $santri->status_kesehatan == 'sakit') ? 'selected' : '' }}>Sakit</option>
                        <option value="pemulihan" {{ (isset($santri) && $santri->status_kesehatan == 'pemulihan') ? 'selected' : '' }}>Pemulihan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Step 2: Detail & Wali -->
        <div id="step-2" class="hidden space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ $santri->tempat_lahir ?? '' }}"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ $santri->tanggal_lahir ?? '' }}"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Riwayat Alergi</label>
                    <textarea name="riwayat_alergi" rows="2"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="Contoh: Alergi kacang, antibiotik tertentu...">{{ $santri->riwayat_alergi ?? '' }}</textarea>
                </div>
                <div class="md:col-span-2 pt-2 border-t border-slate-100 mt-2">
                    <h4 class="text-sm font-bold text-slate-800 mb-3">Data Orang Tua / Wali</h4>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ $santri->wali->nama_wali ?? '' }}"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hubungan</label>
                    <select name="hubungan"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                        <option value="">Pilih Hubungan</option>
                        <option value="Ayah" {{ (isset($santri) && optional($santri->wali)->hubungan == 'Ayah') ? 'selected' : '' }}>Ayah</option>
                        <option value="Ibu" {{ (isset($santri) && optional($santri->wali)->hubungan == 'Ibu') ? 'selected' : '' }}>Ibu</option>
                        <option value="Wali" {{ (isset($santri) && optional($santri->wali)->hubungan == 'Wali') ? 'selected' : '' }}>Wali / Saudara</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ $santri->wali->no_hp ?? '' }}"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                        placeholder="08xxxxxx">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ $santri->wali->pekerjaan ?? '' }}"
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <div class="flex gap-2">
            <button type="button" id="prev-step"
                class="hidden px-4 py-2 text-sm font-medium text-deisa-blue border border-deisa-blue hover:bg-blue-50 rounded-lg transition-colors">Kembali</button>
            <button type="button" id="next-step"
                class="px-4 py-2 text-sm font-medium text-white bg-deisa-blue hover:bg-blue-600 rounded-lg shadow-lg shadow-blue-500/20 transition-all">Lanjut</button>
            <button type="submit" id="submit-form"
                class="hidden px-4 py-2 text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg shadow-lg shadow-emerald-500/20 transition-all">Simpan
                Data</button>
        </div>
    </div>
</form>