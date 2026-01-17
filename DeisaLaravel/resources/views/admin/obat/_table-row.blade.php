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
        <div class="flex gap-2">
            <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                onclick="openRestockModal({{ $obat->id }})">Restock</x-button>
            <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                href="{{ route('admin.obat.show', $obat->id) }}">Detail</x-button>
            <a href="{{ route('admin.obat.edit', $obat->id) }}"
                class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-2 py-1 rounded inline-flex items-center">Edit</a>
        </div>
    </td>
</tr>