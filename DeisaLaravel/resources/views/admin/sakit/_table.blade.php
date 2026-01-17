<div class="overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-slate-900 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 font-semibold w-[100px]">Tanggal</th>
                <th class="px-4 py-3 font-semibold w-[200px]">Santri</th>
                <th class="px-4 py-3 font-semibold">Diagnosis & Gejala</th>
                <th class="px-4 py-3 font-semibold w-[120px]">Perawatan</th>
                <th class="px-4 py-3 font-semibold text-center w-[100px]">Status</th>
                <th class="px-4 py-3 font-semibold text-right w-[250px]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($records as $record)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 text-slate-500 font-medium">{{ $record->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-slate-900">{{ $record->santri->nama_lengkap }}</div>
                        <div class="text-xs text-slate-500">{{ $record->santri->kelas->nama_kelas ?? 'N/A' }}</div>
                    </td>
                    <td class="px-4 py-3 min-w-[200px]">
                        <div class="font-medium text-slate-800 truncate max-w-[250px]" title="{{ $record->diagnosis_utama }}">{{ $record->diagnosis_utama }}</div>
                        <div class="text-[10px] text-slate-400 line-clamp-1" title="{{ $record->gejala }}">{{ $record->gejala }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $record->jenis_perawatan }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @php
                            $statusColors = [
                                'Sakit' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'Pulang' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Sembuh' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            ];
                            $color = $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $color }}">
                            {{ $record->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2 justify-end">
                            <div class="flex gap-1.5 mr-2 pr-2 border-r border-slate-200">
                                @if($record->status == 'Sakit')
                                    <button data-ajax-url="{{ route('admin.sakit.setStatus', [$record->id, 'Pulang']) }}"
                                        onclick="return confirm('Set Pulang (Rawat Jalan)?')"
                                        class="px-2 py-1 text-[10px] font-bold uppercase bg-blue-50 text-blue-600 border border-blue-200 rounded hover:bg-blue-100 transition-colors">
                                        Pulang
                                    </button>
                                @endif
                                @if($record->status == 'Pulang')
                                    <button data-ajax-url="{{ route('admin.sakit.setStatus', [$record->id, 'Sakit']) }}"
                                        onclick="return confirm('Kembali ke UKS?')"
                                        class="px-2 py-1 text-[10px] font-bold uppercase bg-amber-50 text-amber-600 border border-amber-200 rounded hover:bg-amber-100 transition-colors">
                                        Kembali
                                    </button>
                                @endif
                                @if($record->status != 'Sembuh')
                                    <button data-ajax-url="{{ route('admin.sakit.setStatus', [$record->id, 'Sembuh']) }}"
                                        onclick="return confirm('Set Sembuh?')"
                                        class="px-2 py-1 text-[10px] font-bold uppercase bg-emerald-50 text-emerald-600 border border-emerald-200 rounded hover:bg-emerald-100 transition-colors">
                                        Sembuh
                                    </button>
                                @endif
                            </div>

                            <button data-detail-url="{{ route('admin.sakit.show', $record->id) }}" title="Detail"
                                class="p-1 hover:bg-blue-50 rounded text-blue-500 transition-colors border border-transparent hover:border-blue-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button data-form-url="{{ route('admin.sakit.edit', $record->id) }}" title="Edit"
                                class="p-1 hover:bg-slate-100 rounded text-slate-500 transition-colors border border-transparent hover:border-slate-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('admin.sakit.destroy', $record->id) }}" method="POST" data-ajax="true"
                                data-reload="true" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus riwayat? Stok obat akan dipulihkan.')"
                                    title="Hapus"
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
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span>Tidak ada riwayat sakit ditemukan.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $records->links() }}
</div>