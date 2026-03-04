<tr class="hover:bg-slate-50 transition-colors">
    <td class="px-4 py-3 font-mono text-slate-500">{{ $obat->kode_obat }}</td>
    <td class="px-4 py-3">
        <div class="font-medium text-slate-900">{{ $obat->nama_obat }}</div>
        <div class="text-xs text-slate-500">Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }} /
            {{ $obat->satuan }}</div>
    </td>
    <td class="px-4 py-3">{{ $obat->kategori }}</td>
    <td class="px-4 py-3">
        <x-obat-badge :stok="$obat->stok" :min="$obat->stok_minimum" />
    </td>
    <td class="px-4 py-3">{{ optional($obat->tanggal_kadaluarsa)->format('Y-m-d') }}</td>
    <td class="px-4 py-3">
        <div class="flex gap-2 items-center">
            <button type="button" title="Restock"
                onclick="openRestockModal({{ $obat->id }})"
                class="p-1 hover:bg-emerald-50 rounded text-emerald-600 transition-colors border border-transparent hover:border-emerald-100 inline-flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <a href="{{ route('admin.obat.show', $obat->id) }}" title="Detail"
                class="p-1 hover:bg-blue-50 rounded text-blue-500 transition-colors border border-transparent hover:border-blue-100 inline-flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
        </div>
    </td>
</tr>
