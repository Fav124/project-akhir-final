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
                    <div class="flex gap-2 justify-end">
                        <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                            data-form-url="{{ route('admin.jurusan.edit', $jurusan->id) }}">Edit</x-button>
                        <form action="{{ route('admin.jurusan.destroy', $jurusan->id) }}" method="POST" data-ajax="true"
                            data-reload="true">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit" class="px-2 py-1 text-xs h-8"
                                onclick="return confirm('Hapus data jurusan? Semua data kelas dan santri mungkin terdampak.')">Hapus</x-button>
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