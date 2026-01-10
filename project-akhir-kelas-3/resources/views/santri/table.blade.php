<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
            <tr>
                <th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
                <th class="px-6 py-4 font-bold" scope="col">NIS</th>
                <th class="px-6 py-4 font-bold" scope="col">Nama Lengkap</th>
                <th class="px-6 py-4 font-bold" scope="col">Kelas</th>
                <th class="px-6 py-4 font-bold" scope="col">Status Kesehatan</th>
                <th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($santri as $index => $item)
            <tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $santri->firstItem() + $index }}
                </td>
                <td class="px-6 py-4">{{ $item->nis }}</td>
                <td class="px-6 py-4 font-medium text-text-main dark:text-white flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold overflow-hidden">
                        @if($item->foto)
                            <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($item->nama_lengkap, 0, 1) }}
                        @endif
                    </div>
                    {{ $item->nama_lengkap }}
                </td>
                <td class="px-6 py-4">
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                        {{ $item->kelas->nama_kelas ?? '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($item->status == 'sakit')
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                            Sakit
                        </span>
                    @else
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            Sehat
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('santri.show', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="Detail">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </a>
                        <a href="{{ route('santri.edit', $item->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('santri.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data santri ini?')">
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
                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data santri ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    {{ $santri->links('pagination::tailwind') }}
</div>
