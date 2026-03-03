<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 font-semibold w-[190px]">Santri</th>
                <th class="px-4 py-3 font-semibold">Alasan Pulang</th>
                <th class="px-4 py-3 font-semibold w-[130px]">Tanggal Pulang</th>
                <th class="px-4 py-3 font-semibold w-[130px]">Tanggal Kembali</th>
                <th class="px-4 py-3 font-semibold w-[120px]">Durasi</th>
                <th class="px-4 py-3 font-semibold text-center w-[120px]">Status</th>
                <th class="px-4 py-3 font-semibold text-right w-[90px]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($records as $record)
                @php
                    $pulangAt = $record->tgl_pulang;
                    $kembaliAt = $record->tgl_kembali;
                    $statusMonitor = $record->status === 'Pulang'
                        ? 'Masih Pulang'
                        : ($kembaliAt ? 'Sudah Kembali' : ($record->status === 'Sembuh' ? 'Sembuh' : 'Dalam UKS'));
                    $durationLabel = '-';
                    if ($pulangAt) {
                        $end = $kembaliAt ?? ($record->status === 'Pulang' ? now() : null);
                        if ($end) {
                            $diffMinutes = (int) $pulangAt->diffInMinutes($end);
                            if ($diffMinutes < 60) {
                                $durationLabel = $diffMinutes . ' menit';
                            } elseif ($diffMinutes < 1440) {
                                $durationLabel = (int) floor($diffMinutes / 60) . ' jam';
                            } else {
                                $durationLabel = (int) floor($diffMinutes / 1440) . ' hari';
                            }
                        }
                    }
                    $badge = $record->status === 'Pulang'
                        ? 'bg-blue-100 text-blue-700 border-blue-200'
                        : ($record->status === 'Sembuh'
                            ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
                            : 'bg-amber-100 text-amber-700 border-amber-200');
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="font-bold text-slate-900">{{ $record->santri->nama_lengkap ?? '-' }}</div>
                        <div class="text-xs text-slate-500">{{ $record->santri->kelas->nama_kelas ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-slate-700">
                            {{ $record->alasan_pulang ?: ($record->diagnosis_utama ?: 'Tanpa keterangan') }}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $pulangAt ? $pulangAt->format('d/m/Y H:i') : '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $kembaliAt ? $kembaliAt->format('d/m/Y H:i') : '-' }}</td>
                    <td class="px-4 py-3 text-slate-700 font-semibold">{{ $durationLabel }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $badge }}">
                            {{ $statusMonitor }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end">
                            <a href="{{ route('admin.sakit.show', $record->id) }}" title="Detail"
                                class="p-1 hover:bg-blue-50 rounded text-blue-500 transition-colors border border-transparent hover:border-blue-100 inline-flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                        Belum ada data kepulangan santri karena sakit.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $records->links() }}
</div>
