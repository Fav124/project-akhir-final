<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
            <tr>
                <th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
                <th class="px-6 py-4 font-bold" scope="col">Tanggal</th>
                <th class="px-6 py-4 font-bold" scope="col">Santri</th>
                <th class="px-6 py-4 font-bold" scope="col">Diagnosis</th>
                <th class="px-6 py-4 font-bold" scope="col">Obat</th>
                <th class="px-6 py-4 font-bold" scope="col">Status</th>
                <th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($sakit as $index => $item)
            <tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $sakit->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($item->tanggal_mulai_sakit)->format('d/m/Y') }}
                    <span class="block text-xs text-text-muted mt-0.5">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai_sakit)->format('H:i') }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-text-main dark:text-white">{{ $item->santri->nama_lengkap }}</div>
                    <div class="text-xs text-text-muted">{{ $item->santri->kelas->nama_kelas ?? '-' }}</div>
                </td>
                <td class="px-6 py-4">
                    {{ $item->diagnosis }}
                </td>
                <td class="px-6 py-4">
                    @if($item->obats->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($item->obats as $obat)
                                <span class="bg-blue-50 text-blue-700 text-[10px] px-1.5 py-0.5 rounded border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                    {{ $obat->nama_obat }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="text-text-muted text-xs italic">Tidak ada obat</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($item->status == 'sakit')
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                            Sakit
                        </span>
                    @elseif($item->status == 'sembuh')
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            Sembuh
                        </span>
                    @else
                        <span class="bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-amber-900 dark:text-amber-300">
                            Kontrol
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        @if($item->status == 'sakit')
                        <form action="{{ route('sakit.sembuh', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai santri ini sudah sembuh?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg dark:text-green-400 dark:hover:bg-green-900/20 transition-colors" title="Tandai Sembuh">
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            </button>
                        </form>
                        @endif
                        
                        @if($item->status != 'sembuh')
                        <button type="button" onclick="openObatModal({{ $item->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg dark:text-green-400 dark:hover:bg-green-900/20 transition-colors" title="Tambah Obat">
                            <span class="material-symbols-outlined text-[20px]">medication</span>
                        </button>
                        @endif

                        <a href="{{ route('sakit.show', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="Detail">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </a>

                        <a href="{{ route('sakit.edit', $item->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        
                        <form action="{{ route('sakit.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada riwayat sakit ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    {{ $sakit->links('pagination::tailwind') }}
</div>
