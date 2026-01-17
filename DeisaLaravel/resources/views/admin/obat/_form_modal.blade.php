<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">
        {{ isset($obat) ? 'Edit Data Obat' : 'Tambah Obat Baru' }}
    </h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<form action="{{ isset($obat) ? route('admin.obat.update', $obat->id) : route('admin.obat.store') }}" method="POST"
    enctype="multipart/form-data" class="p-6 space-y-4" data-ajax="true">
    @csrf
    @if(isset($obat))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Obat</label>
            <input type="text" name="nama" value="{{ $obat->nama_obat ?? '' }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
            <select name="kategori" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                <option value="Tablet" {{ (isset($obat) && $obat->kategori == 'Tablet') ? 'selected' : '' }}>Tablet
                </option>
                <option value="Sirup" {{ (isset($obat) && $obat->kategori == 'Sirup') ? 'selected' : '' }}>Sirup</option>
                <option value="Kapsul" {{ (isset($obat) && $obat->kategori == 'Kapsul') ? 'selected' : '' }}>Kapsul
                </option>
                <option value="Alkes" {{ (isset($obat) && $obat->kategori == 'Alkes') ? 'selected' : '' }}>Alkes</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Satuan</label>
            <select name="satuan" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                <option value="Strip" {{ (isset($obat) && $obat->satuan == 'Strip') ? 'selected' : '' }}>Strip</option>
                <option value="Botol" {{ (isset($obat) && $obat->satuan == 'Botol') ? 'selected' : '' }}>Botol</option>
                <option value="Tablet" {{ (isset($obat) && $obat->satuan == 'Tablet') ? 'selected' : '' }}>Tablet</option>
                <option value="Pcs" {{ (isset($obat) && $obat->satuan == 'Pcs') ? 'selected' : '' }}>Pcs</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Stok Minimum</label>
            <input type="number" name="stok_min" value="{{ $obat->stok_minimum ?? 10 }}" required
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
        </div>
        @if(!isset($obat))
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Stok Awal</label>
                <input type="number" name="stok" value="0" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
        @endif
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
            <input type="number" name="harga" value="{{ $obat->harga_satuan ?? 0 }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kadaluarsa</label>
            <input type="date" name="kadaluarsa"
                value="{{ (isset($obat) && $obat->tanggal_kadaluarsa) ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Penyimpanan</label>
            <input type="text" name="lokasi" value="{{ $obat->lokasi_penyimpanan ?? '' }}"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                placeholder="Contoh: Rak A1">
        </div>
    </div>

    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
        <button type="button" data-modal-close
            class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">Batal</button>
        <button type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-deisa-blue hover:bg-blue-600 rounded-lg shadow-lg shadow-blue-500/20 transition-all">
            {{ isset($obat) ? 'Simpan Perubahan' : 'Tambah Obat' }}
        </button>
    </div>
</form>