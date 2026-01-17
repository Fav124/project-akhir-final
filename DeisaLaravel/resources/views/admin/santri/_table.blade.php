<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
        <tr>
            <th class="px-4 py-3 font-semibold">ID / NIS</th>
            <th class="px-4 py-3 font-semibold">Nama Lengkap</th>
            <th class="px-4 py-3 font-semibold">Kelas</th>
            <th class="px-4 py-3 font-semibold">Jenis Kelamin</th>
            <th class="px-4 py-3 font-semibold">Status Kesehatan</th>
            <th class="px-4 py-3 font-semibold text-right">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($santris as $santri)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 font-mono text-slate-500">{{ $santri->nis }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-deisa-blue font-bold">
                            {{ substr($santri->nama_lengkap, 0, 1) }}
                        </div>
                        <span class="font-medium text-slate-900">{{ $santri->nama_lengkap }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">{{ $santri->kelas->nama_kelas ?? 'N/A' }}</td>
                <td class="px-4 py-3">{{ $santri->jenis_kelamin }}</td>
                <td class="px-4 py-3">
                    @php
                        $statusClasses = [
                            'sehat' => 'bg-emerald-100 text-emerald-800',
                            'sakit' => 'bg-red-100 text-red-800',
                            'pemulihan' => 'bg-blue-100 text-blue-800'
                        ];
                        $cls = $statusClasses[$santri->status_kesehatan] ?? 'bg-slate-100 text-slate-800';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cls }}">
                        {{ ucfirst($santri->status_kesehatan ?? 'sehat') }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2 justify-end">
                        <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                            data-detail-url="{{ route('admin.santri.show', $santri->id) }}">Detail</x-button>
                        <x-button variant="outline" class="px-2 py-1 text-xs h-8"
                            data-form-url="{{ route('admin.santri.edit', $santri->id) }}">Edit</x-button>
                        <form action="{{ route('admin.santri.destroy', $santri->id) }}" method="POST" data-ajax="true"
                            data-reload="true">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit" class="px-2 py-1 text-xs h-8"
                                onclick="return confirm('Hapus data santri?')">Hapus</x-button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Data Santri Kosong</h3>
                        <p class="text-sm">Belum ada data santri yang terdaftar atau pencarian tidak ditemukan.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-6">
    {{ $santris->links() }}
</div>