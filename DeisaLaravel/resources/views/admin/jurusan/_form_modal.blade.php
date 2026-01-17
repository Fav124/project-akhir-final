<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">{{ isset($jurusan) ? 'Edit Jurusan' : 'Tambah Jurusan Baru' }}</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form action="{{ isset($jurusan) ? route('admin.jurusan.update', $jurusan->id) : route('admin.jurusan.store') }}"
    method="POST" data-ajax="true" data-reset="true">
    @csrf
    @if(isset($jurusan))
        @method('PUT')
    @endif

    <div class="p-6 space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" value="{{ $jurusan->kode_jurusan ?? '' }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: RPL, TKJ, AK">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" value="{{ $jurusan->nama_jurusan ?? '' }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: Rekayasa Perangkat Lunak">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Penjelasan singkat tentang jurusan...">{{ $jurusan->deskripsi ?? '' }}</textarea>
        </div>
    </div>

    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <x-button type="submit" class="shadow-lg shadow-blue-500/20">Simpan Jurusan</x-button>
    </div>
</form>