<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
        <tr>
            <th class="px-4 py-3 font-semibold">Kode</th>
            <th class="px-4 py-3 font-semibold">Nama Obat</th>
            <th class="px-4 py-3 font-semibold">Kategori</th>
            <th class="px-4 py-3 font-semibold">Stok</th>
            <th class="px-4 py-3 font-semibold">Kadaluarsa</th>
            <th class="px-4 py-3 text-right font-semibold">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($obats as $obat)
            @php
                $isCritical = $obat->stok <= $obat->stok_minimum;
                $isExpired = $obat->tanggal_kadaluarsa && \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->isPast();
                $bgClass = 'hover:bg-slate-50';
                if ($isCritical && $isExpired)
                    $bgClass = 'bg-purple-50 hover:bg-purple-100';
                elseif ($isCritical)
                    $bgClass = 'bg-red-50 hover:bg-red-100';
                elseif ($isExpired)
                    $bgClass = 'bg-blue-50 hover:bg-blue-100';
            @endphp
            <tr class="{{ $bgClass }} transition-colors">
                <td class="px-4 py-3 font-mono text-slate-500">{{ $obat->kode_obat }}</td>
                <td class="px-4 py-3 font-bold text-slate-900">{{ $obat->nama_obat }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs">
                        {{ $obat->kategori }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="font-bold {{ $obat->stok <= $obat->stok_minimum ? 'text-red-600' : 'text-slate-900' }}">
                        {{ $obat->stok }} {{ $obat->satuan }}
                    </span>
                </td>
                <td class="px-4 py-3 text-slate-500">
                    {{ $obat->tanggal_kadaluarsa ? \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex gap-2 justify-end">
                        <x-button variant="outline" class="px-2 py-1 text-xs"
                            data-detail-url="{{ route('admin.obat.show', $obat->id) }}">Detail</x-button>
                        <x-button variant="outline" class="px-2 py-1 text-xs"
                            data-form-url="{{ route('admin.obat.edit', $obat->id) }}">Edit</x-button>
                        <x-button variant="outline" class="px-2 py-1 text-xs"
                            onclick="openRestockModal({{ json_encode($obat) }})">Restock</x-button>
                        <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" data-ajax="true"
                            data-reload="true">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" class="px-2 py-1 text-xs" type="submit"
                                onclick="return confirm('Hapus data?')">Hapus</x-button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada data obat atau pencarian tidak
                    ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-6">
    {{ $obats->links() }}
</div>