<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas Baru' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form action="{{ isset($kelas) ? route('admin.kelas.update', $kelas->id) : route('admin.kelas.store') }}" method="POST"
    data-ajax="true" data-reset="true">
    @csrf
    @if(isset($kelas))
        @method('PUT')
    @endif

    <div class="p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenjang Pendidikan</label>
                <select name="jenjang" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="">Pilih Jenjang</option>
                    @foreach(['TK', 'SD', 'SMP', 'SMA', 'SMK', 'Kuliah'] as $j)
                        <option value="{{ $j }}" {{ (isset($kelas) && $kelas->jenjang == $j) ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tingkat / Semester</label>
                <input type="number" name="tingkat" value="{{ $kelas->tingkat ?? '' }}" required min="1"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Contoh: 1, 7, atau 10">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Kelas (Opsional)</label>
            <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas ?? '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: X IPA 1 (Biarkan kosong untuk otomatis)">
        </div>

        <div class="mb-4">
            <p class="text-[10px] text-slate-400 italic">* Angkatan akan otomatis dihitung: Tahun Mulai - (Tingkat - 1).</p>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Jurusan (Bisa lebih dari satu)</label>
            <div class="grid grid-cols-2 gap-2 p-3 border border-slate-200 rounded-lg bg-slate-50 max-h-40 overflow-y-auto">
                @foreach($jurusans as $jurusan)
                    <label class="flex items-center space-x-2 text-sm text-slate-700 cursor-pointer hover:bg-white p-1 rounded transition-colors">
                        <input type="checkbox" name="jurusan_ids[]" value="{{ $jurusan->id }}"
                            {{ (isset($kelas) && $kelas->jurusans->contains($jurusan->id)) ? 'checked' : '' }}
                            class="rounded border-slate-300 text-deisa-blue focus:ring-deisa-blue">
                        <span>{{ $jurusan->nama_jurusan }}</span>
                    </label>
                @endforeach
            </div>
            <p class="text-[10px] text-slate-400 mt-1 italic">* Pilih satu atau lebih jurusan untuk kelas ini.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Ajaran</label>
            <input type="text" name="tahun_ajaran" value="{{ $kelas->tahun_ajaran ?? '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: 2023/2024">
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Kelas</x-button>
    </div>
</form>