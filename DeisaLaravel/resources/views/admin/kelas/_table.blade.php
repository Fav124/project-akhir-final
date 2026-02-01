<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
        <tr>
            <th class="px-4 py-3 font-semibold">Nama Kelas</th>
            <th class="px-4 py-3 font-semibold">Jurusan</th>
            <th class="px-4 py-3 font-semibold">Tahun Ajaran</th>
            <th class="px-4 py-3 font-semibold">Jumlah Santri</th>
            <th class="px-4 py-3 font-semibold text-right">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($kelases as $kelas)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <span
                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 mr-2">
                        {{ $kelas->jenjang ?? '-' }}
                    </span>
                    <span class="font-bold text-slate-900">{{ $kelas->nama_kelas }}</span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-1">
                        @forelse($kelas->jurusans as $jurusan)
                            <span
                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-deisa-blue border border-blue-100">
                                {{ $jurusan->nama_jurusan }}
                            </span>
                        @empty
                            <span class="text-slate-300 text-xs">-</span>
                        @endforelse
                    </div>
                </td>
                <td class="px-4 py-3 text-slate-500 italic text-xs">{{ $kelas->tahun_ajaran ?? '-' }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span
                            class="font-bold text-slate-700">{{ $kelas->santri_count ?? $kelas->santri()->count() }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2 justify-end">
                        <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                            data-form-url="{{ route('admin.kelas.edit', $kelas->id) }}">Edit</x-button>
                        <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" data-ajax="true"
                            data-reload="true" data-confirm-required="true"
                            data-confirm="Menghapus kelas akan berdampak pada relasi data santri aktif. Lanjutkan?">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit" class="px-2 py-1 text-xs h-8"
                                onclick="return confirm('Hapus data kelas?')">Hapus</x-button>
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
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Data Kelas Kosong</h3>
                        <p class="text-sm">Belum ada data kelas yang terdaftar.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-6">
    {{ $kelases->links() }}
</div>