<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
        <tr>
            <th class="px-4 py-3 font-semibold">NIS</th>
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
                    @if($santri->is_repeating)
                    <span
                        class="ml-2 text-[9px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200 uppercase tracking-tighter w-fit items-center flex">
                        Tinggal Kelas
                    </span>
                    @endif
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
                <div class="flex gap-2 justify-end items-center">
                    <div class="mr-1 pr-1 border-r border-slate-200"></div>
                    <a href="{{ route('admin.santri.show', $santri->id) }}" title="Detail"
                        class="p-1 hover:bg-blue-50 rounded text-blue-500 transition-colors border border-transparent hover:border-blue-100 inline-flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                    <form action="{{ route('admin.santri.destroy', $santri->id) }}" method="POST" data-ajax="true"
                        data-reload="true" data-confirm-required="true"
                        data-confirm="Apakah Anda yakin ingin menghapus data santri ini secara permanen?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus data santri?')" title="Hapus"
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
