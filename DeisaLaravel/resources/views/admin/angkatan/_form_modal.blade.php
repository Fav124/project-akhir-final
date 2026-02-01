<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">{{ isset($angkatan) ? 'Edit Angkatan' : 'Tambah Angkatan Baru' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form action="{{ isset($angkatan) ? route('admin.angkatan.update', $angkatan->id) : route('admin.angkatan.store') }}"
    method="POST" data-ajax="true" data-reset="true">
    @csrf
    @if(isset($angkatan))
        @method('PUT')
    @endif

    <div class="p-6 space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Entry</label>
            <input type="number" name="tahun" value="{{ $angkatan->tahun ?? date('Y') }}" required min="2000" max="2100"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: 2024">
            <p class="text-[10px] text-slate-400 mt-1 italic">*Tahun ini digunakan sebagai dasar perhitungan semester
                dan kenaikan kelas.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Angkatan (Opsional)</label>
            <input type="text" name="nama_angkatan" value="{{ $angkatan->nama_angkatan ?? '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Biarkan kosong untuk auto-generate">
            <p class="text-[10px] text-slate-400 mt-1 italic">Contoh: Laskar Pelangi, Angkatan 10, dsb.</p>
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Angkatan</x-button>
    </div>
</form>