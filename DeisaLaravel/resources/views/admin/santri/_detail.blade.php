@php
    $status = strtolower((string) $santri->status_kesehatan);
    $statusClass = $status === 'sehat'
        ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
        : 'bg-rose-100 text-rose-700 border-rose-200';
    $riwayatSakit = $santri->sakit
        ->sortByDesc(fn($item) => $item->tgl_masuk ?? $item->tanggal_mulai_sakit ?? $item->created_at)
        ->take(5);
    $hasWali = (bool) $santri->wali;
    $rawPhone = $hasWali ? (string) ($santri->wali->no_hp ?? '') : '';
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if ($cleanPhone) {
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        } elseif (!str_starts_with($cleanPhone, '62')) {
            $cleanPhone = '62' . $cleanPhone;
        }
    }
    $waMessage = "Assalamu'alaikum Bapak/Ibu " . ($hasWali ? $santri->wali->nama_wali : '') .
        ", kami dari UKS Deisa ingin menyampaikan informasi terkait kondisi kesehatan ananda " . $santri->nama_lengkap . ".";
    $waLink = $cleanPhone ? ('https://api.whatsapp.com/send?phone=' . $cleanPhone . '&text=' . urlencode($waMessage)) : null;
@endphp

<div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
    <div>
        <h3 class="font-bold text-slate-900">Detail Santri</h3>
        <p class="text-xs text-slate-500">Ringkasan profil, kesehatan, dan kontak wali</p>
    </div>
    <button data-modal-close class="text-slate-400 hover:text-slate-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

<div class="p-6 space-y-5">
    <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-5">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="w-28 h-28 mx-auto rounded-2xl bg-blue-100 flex items-center justify-center text-deisa-blue text-4xl font-bold shadow-inner">
                @if($santri->foto)
                    <img src="{{ asset('storage/' . $santri->foto) }}" class="w-full h-full object-cover rounded-2xl">
                @else
                    {{ substr($santri->nama_lengkap, 0, 1) }}
                @endif
            </div>
            <div class="text-center mt-3">
                <p class="font-bold text-slate-900 leading-tight">{{ $santri->nama_lengkap }}</p>
                <p class="text-xs text-slate-500 mt-1">NIS: {{ $santri->nis }}</p>
            </div>
            <div class="mt-3 text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $statusClass }}">
                    {{ $santri->status_kesehatan }}
                </span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 p-4">
                <h4 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">1. Identitas Santri</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Nama Lengkap</p>
                        <p class="font-semibold text-slate-900">{{ $santri->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">NIS / ID</p>
                        <p class="font-mono text-slate-900">{{ $santri->nis }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Kelas</p>
                        <p class="font-semibold text-slate-900">{{ $santri->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Jurusan</p>
                        <p class="font-semibold text-slate-900">{{ $santri->jurusan->nama_jurusan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold text-slate-900">
                            {{ $santri->tempat_lahir ?: '-' }},
                            {{ $santri->tanggal_lahir ? \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Tahun Masuk</p>
                        <p class="font-semibold text-slate-900">{{ $santri->tahun_masuk ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 p-4">
                <h4 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">2. Informasi Medis</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Golongan Darah</p>
                        <p class="font-semibold text-slate-900">{{ $santri->golongan_darah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase text-slate-400">Status Kesehatan Saat Ini</p>
                        <p class="font-semibold text-slate-900">{{ $santri->status_kesehatan }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-[10px] font-bold uppercase text-slate-400 mb-1">Riwayat Alergi</p>
                    <div class="text-sm text-slate-700 bg-amber-50 p-3 rounded-lg border border-amber-100">
                        {{ $santri->riwayat_alergi ?: 'Tidak ada riwayat alergi yang tercatat.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 p-4">
        <h4 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-3">3. Riwayat Kesehatan Terakhir</h4>
        <div class="space-y-2">
            @forelse($riwayatSakit as $s)
                @php
                    $tgl = $s->tgl_masuk ?? $s->tanggal_mulai_sakit ?? $s->created_at;
                    $statusSakit = strtolower((string) $s->status);
                    $statusBadge = $statusSakit === 'sembuh' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700';
                    $diagnosisText = $s->diagnosis_utama ?: ($s->diagnosis ?: ($s->keluhan ?: '-'));
                @endphp
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $diagnosisText }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($tgl)->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $statusBadge }}">
                        {{ ucfirst($s->status ?? '-') }}
                    </span>
                </div>
            @empty
                <div class="text-sm text-slate-500 italic">Belum ada riwayat sakit yang tercatat.</div>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 p-4">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h4 class="text-[11px] font-black tracking-wider uppercase text-slate-500 mb-1">4. Kontak Wali</h4>
                <p class="text-xs text-slate-500">Gunakan kanal cepat untuk komunikasi kondisi santri</p>
            </div>
            @if($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-xl text-xs font-bold transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884" />
                    </svg>
                    Chat Wali (WhatsApp API)
                </a>
            @endif
        </div>

        @if($hasWali)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3 text-sm">
                <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                    <p class="text-[10px] font-bold uppercase text-slate-400">Nama Wali</p>
                    <p class="font-semibold text-slate-900">{{ $santri->wali->nama_wali }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                    <p class="text-[10px] font-bold uppercase text-slate-400">Hubungan</p>
                    <p class="font-semibold text-slate-900">{{ ucfirst($santri->wali->hubungan ?? '-') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 p-3 bg-slate-50">
                    <p class="text-[10px] font-bold uppercase text-slate-400">No. HP / WhatsApp</p>
                    <p class="font-semibold text-slate-900">{{ $santri->wali->no_hp ?? '-' }}</p>
                </div>
            </div>
        @else
            <div class="mt-3 text-sm text-slate-500 italic">Data wali belum tersedia.</div>
        @endif
    </div>
</div>

<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-2 text-sm">
    <x-button variant="primary" data-form-url="{{ route('admin.santri.edit', $santri->id) }}"
        onclick="document.getElementById('global-detail-modal').classList.add('hidden')">Edit Data</x-button>
</div>
