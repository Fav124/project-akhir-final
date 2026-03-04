<div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-[11px] font-black uppercase tracking-widest text-deisa-blue/80">Inventori Obat</p>
            <h3 class="mt-1 text-lg font-bold text-slate-900">
                {{ isset($obat) ? 'Edit Data Obat' : 'Tambah Obat Baru' }}
            </h3>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi utama, stok minimum, dan penyimpanan obat.</p>
        </div>
        <button data-modal-close class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<form action="{{ isset($obat) ? route('admin.obat.update', $obat->id) : route('admin.obat.store') }}" method="POST"
    enctype="multipart/form-data" class="p-6 space-y-5" data-ajax="true">
    @csrf
    @if(isset($obat))
    @method('PUT')
    @endif

    <div class="space-y-4">
        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586"></path>
                </svg>
            </div>
            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Utama</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Obat</label>
                <input type="text" name="nama" value="{{ $obat->nama_obat ?? '' }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Contoh: Paracetamol 500mg">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Obat</label>
                <input type="file" name="foto" accept="image/*"
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-deisa-blue hover:file:bg-blue-100">
                <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                <select name="kategori" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="Tablet" {{ (isset($obat) && $obat->kategori == 'Tablet') ? 'selected' : '' }}>Tablet</option>
                    <option value="Sirup" {{ (isset($obat) && $obat->kategori == 'Sirup') ? 'selected' : '' }}>Sirup</option>
                    <option value="Kapsul" {{ (isset($obat) && $obat->kategori == 'Kapsul') ? 'selected' : '' }}>Kapsul</option>
                    <option value="Alkes" {{ (isset($obat) && $obat->kategori == 'Alkes') ? 'selected' : '' }}>Alkes</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Satuan</label>
                <select name="satuan" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                    <option value="Strip" {{ (isset($obat) && $obat->satuan == 'Strip') ? 'selected' : '' }}>Strip</option>
                    <option value="Botol" {{ (isset($obat) && $obat->satuan == 'Botol') ? 'selected' : '' }}>Botol</option>
                    <option value="Tablet" {{ (isset($obat) && $obat->satuan == 'Tablet') ? 'selected' : '' }}>Tablet</option>
                    <option value="Pcs" {{ (isset($obat) && $obat->satuan == 'Pcs') ? 'selected' : '' }}>Pcs</option>
                </select>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                </svg>
            </div>
            <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Stok & Logistik</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Stok Minimum</label>
                <input type="number" name="stok_min" value="{{ $obat->stok_minimum ?? 10 }}" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
            @if(!isset($obat))
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Stok Awal</label>
                <input type="number" name="stok" value="0" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
            @endif
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Harga Satuan (Rp)</label>
                <input type="number" name="harga" value="{{ $obat->harga_satuan ?? 0 }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Kadaluarsa</label>
                <input type="date" name="kadaluarsa"
                    value="{{ (isset($obat) && $obat->tanggal_kadaluarsa) ? $obat->tanggal_kadaluarsa->format('Y-m-d') : '' }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lokasi Penyimpanan</label>
                <input type="text" name="lokasi" value="{{ $obat->lokasi_penyimpanan ?? '' }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all"
                    placeholder="Contoh: Rak A1">
            </div>
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
