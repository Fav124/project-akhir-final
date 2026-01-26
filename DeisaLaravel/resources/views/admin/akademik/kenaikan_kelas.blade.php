@extends('layouts.admin')

@section('title', 'Kenaikan Kelas & Alumni')

@section('header')
    <h2 class="text-xl font-bold text-slate-900">Proses Akademik Tahunan</h2>
    <p class="text-sm text-slate-500">Kelola kenaikan kelas dan kelulusan santri.</p>
@endsection

@section('admin-content')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Sidebar Filter / Instruction -->
        <div class="lg:col-span-4 space-y-6">
            <div class="sticky top-24 space-y-6">
                <x-card>
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-deisa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Pilih Sumber Data
                    </h3>
                    <form action="{{ route('admin.akademik.index') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-1">Pilih Kelas Saat Ini</label>
                            <select name="kelas_id" onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue outline-none transition-all">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $selectedClassId == $class->id ? 'selected' : '' }}>
                                        {{ $class->nama_kelas }} ({{ $class->angkatan->nama_angkatan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    @if($selectedClassId && count($santris) > 0)
                    <div class="pt-6 border-t border-slate-100 mt-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Tindakan Kolektif</h4>
                        <div class="space-y-2" x-data="{ action: 'promote' }">
                            <select id="bulk-action-type" x-model="action"
                                class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                                <option value="promote">Naik ke Kelas Baru</option>
                                <option value="stay">Tetap di Kelas Ini</option>
                                <option value="graduate">Lulus (Jadi Alumni)</option>
                            </select>

                            <div x-show="action === 'promote'" class="pt-2">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Target Kelas</label>
                                <select id="bulk-target-kelas"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-200 text-sm">
                                    <option value="">-- Pilih Kelas Tujuan --</option>
                                    @foreach($classes as $class)
                                        @if($class->id != $selectedClassId)
                                            <option value="{{ $class->id }}">{{ $class->nama_kelas }} ({{ $class->angkatan->nama_angkatan ?? '-' }})</option>
                                        @endif
                                    @endforeach
                                </select>
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
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi
                    </h4>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Siswa yang diluluskan akan kehilangan akses kelas reguler namun data kesehatannya tetap tersimpan dalam riwayat Alumni.
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-8">
            <x-card>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-900">Daftar Santri Terpilih</h3>
                    <div class="text-xs font-bold text-slate-400">
                        {{ count($santris) }} Santri ditemukan
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
                                        <th class="px-4 py-3">Angkatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($santris as $s)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="santri_ids[]" value="{{ $s->id }}" class="santri-check rounded border-slate-300 text-deisa-blue">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-slate-900">{{ $s->nama_lengkap }}</div>
                                            </td>
                                            <td class="px-4 py-3 font-mono text-slate-500">{{ $s->nis }}</td>
                                            <td class="px-4 py-3">
                                                <span class="text-[10px] font-bold px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded">
                                                    {{ $s->angkatan->nama_angkatan ?? '-' }}
                                                </span>
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
                    <div class="flex flex-col items-center justify-center py-20 text-slate-400">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p>Silakan pilih kelas sumber terlebih dahulu.</p>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
                    const formData = new FormData();
                    selectedIds.forEach(id => formData.append('santri_ids[]', id));
                    formData.append('action', action);
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
                        }
                    } catch (e) {
                        showAlert('error', 'Terjadi kesalahan sistem.');
                    }
                }
            );
        };
    }
});
</script>
@endpush
