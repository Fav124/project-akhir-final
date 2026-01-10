<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
            <tr>
                <th class="px-6 py-4 font-bold rounded-tl-xl" scope="col">No</th>
                <th class="px-6 py-4 font-bold" scope="col">Nama Jurusan</th>
                <th class="px-6 py-4 font-bold" scope="col">Deskripsi</th>
                <th class="px-6 py-4 font-bold" scope="col">Jumlah Kelas</th>
                <th class="px-6 py-4 font-bold" scope="col">Jumlah Santri</th>
                <th class="px-6 py-4 font-bold rounded-tr-xl text-center" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($jurusans as $index => $jurusan)
            <tr class="bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $jurusans->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 font-medium text-text-main dark:text-white">
                    {{ $jurusan->nama }}
                </td>
                <td class="px-6 py-4">
                    {{ Str::limit($jurusan->deskripsi, 50) ?: '-' }}
                </td>
                <td class="px-6 py-4">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                        {{ $jurusan->kelas_count }} Kelas
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                        {{ $jurusan->santris_count }} Santri
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('jurusan.edit', $jurusan->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">
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
                    Tidak ada data jurusan ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    {{ $jurusans->links('pagination::tailwind') }}
</div>
