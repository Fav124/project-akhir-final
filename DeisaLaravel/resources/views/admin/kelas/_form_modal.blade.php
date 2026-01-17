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
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Kelas</label>
            <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas ?? '' }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: X IPA 1">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
            <select name="jurusan_id" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ (isset($kelas) && $kelas->jurusan_id == $jurusan->id) ? 'selected' : '' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Ajaran</label>
            <input type="text" name="tahun_ajaran" value="{{ $kelas->tahun_ajaran ?? '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: 2024/2025">
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Kelas</x-button>
    </div>
</form>