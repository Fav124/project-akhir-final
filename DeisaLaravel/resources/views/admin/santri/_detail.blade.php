<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <h3 class="font-bold text-slate-900">Detail Santri</h3>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
<div class="p-6">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-32 flex flex-col items-center">
            <div
                class="w-32 h-32 rounded-2xl bg-blue-100 flex items-center justify-center text-deisa-blue text-4xl font-bold mb-4 shadow-inner">
                @if($santri->foto)
                <img src="{{ asset('storage/' . $santri->foto) }}" class="w-full h-full object-cover rounded-2xl">
                @else
                {{ substr($santri->nama_lengkap, 0, 1) }}
                @endif
            </div>
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $santri->status_kesehatan == 'sehat' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                {{ $santri->status_kesehatan }}
            </span>
        </div>

        <div class="flex-1 space-y-4">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Nama Lengkap</label>
                    <div class="font-medium text-slate-900">{{ $santri->nama_lengkap }}</div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">NIS / ID</label>
                    <div class="font-mono text-slate-900">{{ $santri->nis }}</div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Kelas</label>
                    <div class="font-medium text-slate-900">
                        {{ $santri->kelas->nama_kelas ?? '-' }}
                    </div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Jurusan</label>
                    <div class="font-medium text-slate-900">{{ $santri->jurusan->nama_jurusan ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Tempat, Tgl Lahir</label>
                    <div class="font-medium text-slate-900">{{ $santri->tempat_lahir ?? '-' }},
                        {{ $santri->tanggal_lahir ? \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d F Y') : '-'
                        }}
                    </div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Tahun Masuk</label>
                    <div class="font-medium text-slate-900">{{ $santri->tahun_masuk ?? '-' }}</div>
                </div>
                <div>
                    <label class="text-slate-400 uppercase text-[10px] font-bold">Gol. Darah</label>
                    <div class="font-medium text-slate-900">{{ $santri->golongan_darah ?? '-' }}</div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <label class="text-slate-400 uppercase text-[10px] font-bold">Riwayat Alergi</label>
                <div class="text-sm text-slate-700 bg-amber-50 p-2 rounded-lg border border-amber-100 mt-1">
                    {{ $santri->riwayat_alergi ?? 'Tidak ada riwayat alergi yang tercatat.' }}
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <label class="text-slate-400 uppercase text-[10px] font-bold">Riwayat Kesehatan (Sakit)</label>
                <div class="mt-2 space-y-2">
                    @forelse($santri->sakit->take(3) as $s)
                    <div
                        class="flex items-center justify-between p-2 bg-slate-50 rounded-lg border border-slate-100 text-xs">
                        <div>
                            <div class="font-bold text-slate-800">{{ $s->diagnosis ?? 'Diagnosis tidak tersedia' }}
                            </div>
                            <div class="text-slate-500">{{ \Carbon\Carbon::parse($s->tanggal_sakit)->format('d/m/Y') }}
                            </div>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded-full {{ $s->status == 'sembuh' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </div>
                    @empty
                    <div class="text-xs text-slate-400 italic">Belum ada riwayat sakit yang tercatat.</div>
                    @endforelse
                </div>
            </div>

            @if($santri->wali)
            <div class="pt-4 border-t border-slate-100">
                <label class="text-slate-400 uppercase text-[10px] font-bold">Data Wali</label>
                <div class="grid grid-cols-2 gap-4 mt-1 text-sm">
                    <div>
                        <div class="font-medium text-slate-900">{{ $santri->wali->nama_wali }}</div>
                        <div class="text-xs text-slate-500">Nama Wali</div>
                    </div>
                    <div>
                        <div class="font-medium text-slate-900">{{ $santri->wali->no_hp ?? '-' }}</div>
                        <div class="text-xs text-slate-500">No. HP / WhatsApp</div>
                    </div>
                    <div>
                        <div class="font-medium text-slate-900">{{ ucfirst($santri->wali->hubungan ?? '-') }}</div>
                        <div class="text-xs text-slate-500">Hubungan</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2 text-sm">
    <x-button data-modal-close variant="outline">Tutup</x-button>
    <x-button variant="primary" data-form-url="{{ route('admin.santri.edit', $santri->id) }}"
        onclick="document.getElementById('global-detail-modal').classList.add('hidden')">Edit Data</x-button>
</div>