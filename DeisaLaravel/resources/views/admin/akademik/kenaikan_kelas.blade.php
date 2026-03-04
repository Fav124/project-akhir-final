@extends('layouts.admin')

@section('title', 'Kenaikan Kelas & Alumni')

@section('header')
<h2 class="text-xl font-bold text-slate-900">Proses Akademik Tahunan</h2>
<p class="text-sm text-slate-500">Kelola kenaikan kelas dan kelulusan santri.</p>
@endsection

@section('admin-content')
@php
    $santriCount = count($santris);
@endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-indigo-50 p-4">
            <p class="text-[11px] font-black uppercase tracking-wider text-blue-700">Kelas Sumber</p>
            <p class="mt-2 text-lg font-black text-slate-900">{{ $currentClass?->nama_kelas ?? 'Belum dipilih' }}</p>
            <p class="text-xs text-blue-700">{{ $currentClass ? $currentClass->jenjang . ' Tingkat ' . $currentClass->tingkat : 'Pilih dari panel kiri' }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-teal-50 p-4">
            <p class="text-[11px] font-black uppercase tracking-wider text-emerald-700">Santri Aktif</p>
            <p class="mt-2 text-2xl font-black text-slate-900">{{ $santriCount }}</p>
            <p class="text-xs text-emerald-700">Total santri dalam kelas terpilih</p>
        </div>
        <div class="rounded-2xl border border-violet-100 bg-gradient-to-br from-violet-50 to-fuchsia-50 p-4">
            <p class="text-[11px] font-black uppercase tracking-wider text-violet-700">Target Kenaikan Valid</p>
            <p class="mt-2 text-2xl font-black text-slate-900">{{ $promotionTargets->count() }}</p>
            <p class="text-xs text-violet-700">Kelas tujuan yang bisa dipilih</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 space-y-6">
            <div class="sticky top-24 space-y-6">
                <x-card class="border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-900 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-deisa-blue flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            Pilih Sumber Data
                        </h3>
                    </div>

                    <form action="{{ route('admin.akademik.index') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase mb-1">Pilih Kelas Saat Ini</label>
                            <select name="kelas_id" onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all bg-white">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($academicClasses as $c)
                                    <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                                        {{ $c->nama_kelas }} ({{ $c->jenjang ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    @if($currentClass)
                        <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-3">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Kelas sumber aktif</p>
                            <p class="mt-1 text-sm font-semibold text-blue-900">
                                {{ $currentClass->nama_kelas }} - {{ $currentClass->jenjang }} {{ $currentClass->tingkat }}
                            </p>
                        </div>
                    @endif

                    @if($selectedClassId && $santriCount > 0)
                        <div class="pt-6 border-t border-slate-100 mt-6">
                            <h4 class="text-sm font-bold text-slate-800 mb-3">Tindakan Kolektif</h4>
                            <div class="grid grid-cols-1 gap-2 mb-3">
                                <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2 text-xs text-emerald-800">
                                    <span class="font-bold">⬆ Naik Kelas:</span> pindahkan ke tingkat lebih tinggi.
                                </div>
                                <div class="rounded-xl border border-amber-100 bg-amber-50 px-3 py-2 text-xs text-amber-800">
                                    <span class="font-bold">⏸ Tetap:</span> tandai sebagai tinggal kelas.
                                </div>
                                <div class="rounded-xl border border-violet-100 bg-violet-50 px-3 py-2 text-xs text-violet-800">
                                    <span class="font-bold">🎓 Alumni:</span> ubah status menjadi alumni.
                                </div>
                            </div>

                            <div class="space-y-2" x-data="{ action: 'promote' }">
                                <select id="bulk-action-type" x-model="action"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm bg-white">
                                    <option value="promote">⬆ Naik ke Kelas Baru</option>
                                    <option value="stay">⏸ Tetap di Kelas Ini</option>
                                    <option value="graduate">🎓 Lulus (Jadi Alumni)</option>
                                </select>

                                <div x-show="action === 'promote'" class="pt-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Target Kelas</label>
                                    <select id="bulk-target-kelas"
                                        class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500/20 outline-none bg-white">
                                        <option value="">-- Pilih Kelas Tujuan --</option>
                                        @foreach($promotionTargets as $class)
                                            <option value="{{ $class->id }}" class="text-emerald-700 font-semibold">
                                                {{ $class->nama_kelas }} ({{ $class->jenjang ?? '-' }} {{ $class->tingkat }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($promotionTargets->isEmpty())
                                        <p class="mt-2 text-xs text-amber-700 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2">
                                            Tidak ada kelas target yang valid untuk kenaikan dari kelas ini.
                                        </p>
                                    @endif
                                </div>

                                <x-button class="w-full mt-4" variant="primary" id="btn-execute-process">
                                    Proses Sekarang
                                </x-button>
                            </div>
                        </div>
                    @endif
                </x-card>

                <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl">
                    <h4 class="text-sm font-bold text-blue-900 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi
                    </h4>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Siswa yang diluluskan akan kehilangan akses kelas reguler namun data kesehatannya tetap tersimpan
                        dalam riwayat Alumni.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <x-card class="border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-slate-900 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">👥</span>
                        Daftar Santri Terpilih
                    </h3>
                    <div class="text-xs font-bold text-slate-500 bg-slate-100 rounded-full px-3 py-1">
                        {{ $santriCount }} Santri ditemukan
                    </div>
                </div>

                @if($selectedClassId)
                    <form id="form-akademik" action="{{ route('admin.akademik.process') }}" method="POST">
                        @csrf
                        <div class="overflow-hidden border border-slate-100 rounded-xl">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black">
                                    <tr>
                                        <th class="px-4 py-3 w-10">
                                            <input type="checkbox" id="check-all" class="rounded border-slate-300 text-deisa-blue">
                                        </th>
                                        <th class="px-4 py-3">Nama Lengkap</th>
                                        <th class="px-4 py-3">NIS</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($santris as $s)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="santri_ids[]" value="{{ $s->id }}"
                                                    class="santri-check rounded border-slate-300 text-deisa-blue">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-black flex items-center justify-center">
                                                        {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-slate-900">{{ $s->nama_lengkap }}</div>
                                                        <div class="text-xs text-slate-500">{{ optional($s->jurusan)->nama_jurusan ?: 'Tanpa Jurusan' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 font-mono text-slate-500">{{ $s->nis }}</td>
                                            <td class="px-4 py-3">
                                                @if($s->is_repeating)
                                                    <span class="text-[10px] font-black text-rose-700 bg-rose-50 px-2 py-1 rounded-full border border-rose-200">
                                                        ⏸ TINGGAL KELAS
                                                    </span>
                                                @else
                                                    <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-2 py-1 rounded-full border border-emerald-200">
                                                        ✔ NORMAL
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-12 text-center text-slate-400 italic">
                                                Tidak ada santri aktif di kelas ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                @else
                    <div class="relative overflow-hidden rounded-2xl border border-dashed border-slate-200 bg-gradient-to-br from-slate-50 to-slate-100 py-20">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100/50 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-100/50 rounded-full blur-2xl"></div>
                        <div class="relative flex flex-col items-center justify-center text-slate-500">
                            <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7" />
                                </svg>
                            </div>
                            <p class="font-semibold text-slate-700">Belum ada kelas sumber dipilih</p>
                            <p class="text-sm text-slate-500 mt-1">Pilih kelas di panel kiri untuk menampilkan daftar santri.</p>
                        </div>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('check-all');
        const checks = document.querySelectorAll('.santri-check');
        const executeBtn = document.getElementById('btn-execute-process');
        const form = document.getElementById('form-akademik');

        if (checkAll) {
            checkAll.onclick = () => {
                checks.forEach(c => c.checked = checkAll.checked);
            };
        }

        if (executeBtn) {
            executeBtn.onclick = () => {
                const selectedIds = Array.from(document.querySelectorAll('.santri-check:checked')).map(c => c.value);
                if (selectedIds.length === 0) {
                    showAlert('error', 'Pilih setidaknya satu santri.');
                    return;
                }

                const action = document.getElementById('bulk-action-type').value;
                const targetKelasId = document.getElementById('bulk-target-kelas')?.value;
                const sourceKelasId = '{{ $selectedClassId }}';

                if (action === 'promote' && !targetKelasId) {
                    showAlert('error', 'Pilih kelas tujuan kenaikan.');
                    return;
                }

                const actionLabels = {
                    'promote': 'Naik Kelas',
                    'graduate': 'Lulus / Alumni',
                    'stay': 'Tinggal Kelas'
                };

                showConfirm(
                    'Konfirmasi Proses Akademik',
                    `Anda akan memproses ${selectedIds.length} santri untuk ${actionLabels[action]}. Tindakan ini tidak dapat dibatalkan secara kolektif.`,
                    async () => {
                        const originalText = executeBtn.innerHTML;
                        executeBtn.disabled = true;
                        executeBtn.innerHTML = `
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg> Memproses...`;

                        const formData = new FormData();
                        selectedIds.forEach(id => formData.append('santri_ids[]', id));
                        formData.append('action', action);
                        formData.append('source_kelas_id', sourceKelasId);
                        formData.append('_token', '{{ csrf_token() }}');
                        if (targetKelasId) formData.append('target_kelas_id', targetKelasId);

                        try {
                            const response = await fetch('{{ route("admin.akademik.process") }}', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });
                            const data = await response.json();
                            if (response.ok) {
                                showAlert('success', data.message);
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                showAlert('error', data.message);
                                executeBtn.disabled = false;
                                executeBtn.innerHTML = originalText;
                            }
                        } catch (e) {
                            showAlert('error', 'Terjadi kesalahan sistem.');
                            executeBtn.disabled = false;
                            executeBtn.innerHTML = originalText;
                        }
                    }
                );
            };
        }
    });
</script>
@endpush
