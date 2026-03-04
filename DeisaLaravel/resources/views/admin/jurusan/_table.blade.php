<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
        <tr>
            <th class="px-4 py-3 font-semibold">Kode</th>
            <th class="px-4 py-3 font-semibold">Nama Jurusan</th>
            <th class="px-4 py-3 font-semibold">Deskripsi</th>
            <th class="px-4 py-3 font-semibold">Total Kelas</th>
            <th class="px-4 py-3 font-semibold text-right">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($jurusans as $jurusan)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 font-mono font-bold text-deisa-blue">{{ $jurusan->kode_jurusan }}</td>
                <td class="px-4 py-3">
                    <span class="font-medium text-slate-900">{{ $jurusan->nama_jurusan }}</span>
                </td>
                <td class="px-4 py-3 text-slate-500 text-xs max-w-xs truncate">{{ $jurusan->deskripsi ?? '-' }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-700">{{ $jurusan->kelas()->count() }}</span>
                        <span class="text-xs text-slate-400 font-normal">Kelas</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2 justify-end items-center">
                        <div class="mr-1 pr-1 border-r border-slate-200"></div>
                        <a href="{{ route('admin.jurusan.show', $jurusan->id) }}" title="Detail"
                            class="p-1 hover:bg-blue-50 rounded text-blue-500 transition-colors border border-transparent hover:border-blue-100 inline-flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.jurusan.destroy', $jurusan->id) }}" method="POST" data-ajax="true"
                            data-reload="true">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus"
                                onclick="return confirm('Hapus data jurusan? Semua data kelas dan santri mungkin terdampak.')"
                                class="p-1 hover:bg-red-50 rounded text-red-500 transition-colors border border-transparent hover:border-red-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                        </svg>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Data Jurusan Kosong</h3>
                        <p class="text-sm">Belum ada data jurusan yang terdaftar.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-6">
    {{ $jurusans->links() }}
</div>
