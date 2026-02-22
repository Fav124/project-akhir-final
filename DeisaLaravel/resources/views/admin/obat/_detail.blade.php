<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">Detail Persediaan Obat</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<div class="p-6">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-40">
            <div
                class="w-40 h-40 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-300 text-5xl overflow-hidden">
                @if($obat->foto)
                    <img src="{{ asset('storage/' . $obat->foto) }}" class="w-full h-full object-cover">
                @else
                    💊
                @endif
            </div>
            <div class="mt-4 space-y-2">
                <div class="text-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Status Stok</span>
                    @if($obat->stok <= $obat->stok_minimum)
                        <div class="bg-red-100 text-red-600 px-2 py-1 rounded-lg text-xs font-bold mt-1">KRITIS</div>
                    @else
                        <div class="bg-emerald-100 text-emerald-600 px-2 py-1 rounded-lg text-xs font-bold mt-1">AVAILABLE
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex-1 space-y-6">
            <div>
                <h4 class="text-2xl font-bold text-slate-900">{{ $obat->nama_obat }}</h4>
                <div class="text-sm text-slate-500 font-mono">{{ $obat->kode_obat }} • {{ $obat->kategori }}</div>
            </div>

            <div class="grid grid-cols-2 gap-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Stok Saat Ini</label>
                    <div class="text-xl font-bold text-slate-900">{{ $obat->stok }} <span
                            class="text-sm font-normal text-slate-500">{{ $obat->satuan }}</span></div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Harga Satuan</label>
                    <div class="text-xl font-bold text-slate-900">Rp
                        {{ number_format($obat->harga_satuan, 0, ',', '.') }}</div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Lokasi Rak</label>
                    <div class="text-sm font-medium text-slate-800">{{ $obat->lokasi_penyimpanan ?: '-' }}</div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Kadaluarsa</label>
                    <div
                        class="text-sm font-medium {{ $obat->tanggal_kadaluarsa && \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->isPast() ? 'text-red-500 font-bold' : 'text-slate-800' }}">
                        {{ $obat->tanggal_kadaluarsa ? \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d F Y') : '-' }}
                    </div>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">Deskripsi / Catatan</label>
                <p class="text-sm text-slate-600 mt-1">
                    {{ $obat->deskripsi ?: 'Tidak ada deskripsi tambahan untuk obat ini.' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
    <x-button variant="primary" onclick="openRestockModal({{ json_encode($obat) }})">Restock</x-button>
</div>