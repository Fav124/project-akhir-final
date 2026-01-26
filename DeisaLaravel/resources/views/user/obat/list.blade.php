@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-24 max-w-lg mx-auto relative">
        <header class="bg-deisa-blue p-4 sticky top-0 z-30 shadow-md">
            <div class="flex gap-3 items-center">
                <a href="{{ route('user.dashboard') }}" class="text-white hover:bg-white/10 p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex-1 relative">
                    <input type="text" id="obatSearch" placeholder="Cari obat..."
                        class="w-full bg-white/20 text-white placeholder-blue-100 px-4 py-2 pl-10 rounded-full border border-white/10 focus:outline-none focus:bg-white/30 transition-all">
                    <svg class="w-4 h-4 text-white/50 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </header>

        <div class="p-4 space-y-4" id="obat-list-container">
            @forelse($obats as $obat)
                <div class="obat-item bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center gap-4 hover:shadow-md transition-all active:scale-[0.98]" 
                    data-nama="{{ strtolower($obat->nama_obat) }}">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex-shrink-0 flex items-center justify-center border border-blue-100">
                        <svg class="w-7 h-7 text-deisa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 text-base leading-tight truncate mb-1">{{ $obat->nama_obat }}</h4>
                        <div class="flex items-center gap-2">
                             <span class="text-[10px] font-black uppercase tracking-wider px-1.5 py-0.5 rounded {{ $obat->stok <= $obat->stok_minimum ? 'bg-red-50 text-red-500' : 'bg-emerald-50 text-emerald-500' }}">
                                {{ $obat->stok }} {{ $obat->satuan }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $obat->kategori }}</span>
                        </div>
                    </div>
                    <button class="bg-slate-900 text-white py-2 px-4 rounded-xl text-xs font-bold hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10"
                        onclick="openUseModal({{ $obat->id }}, '{{ $obat->nama_obat }}', '{{ $obat->satuan }}', {{ $obat->stok }})">Gunakan</button>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-20 text-slate-400">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-4xl text-slate-300">💊</span>
                    </div>
                    <p class="font-bold text-slate-500">Stok obat kosong</p>
                    <p class="text-xs text-slate-400 mt-1">Belum ada data obat aktif.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Usage Bottom Sheet (Modal) -->
    <div id="useModal" class="fixed inset-0 z-50 hidden overflow-hidden" x-data="{ amount: 1 }">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeUseModal()"></div>

        <div class="absolute bottom-0 left-0 right-0 max-w-lg mx-auto bg-white rounded-t-[2.5rem] shadow-2xl p-8 transform transition-transform duration-300 translate-y-full" id="modalContent">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-8"></div>

            <div class="flex items-center gap-4 mb-8">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-deisa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h4 id="modalObatName" class="text-2xl font-black text-slate-800 leading-tight">Nama Obat</h4>
                    <p class="text-slate-400 text-sm font-medium">Stok Tersedia: <span id="modalStokLabel" class="text-slate-800 font-bold">0</span></p>
                </div>
            </div>

            <form id="useObatForm">
                <input type="hidden" id="modalObatId" name="id">
                <div class="mb-8">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Jumlah Pemakaian (<span id="modalSatuan">Satuan</span>)</label>
                    <div class="flex items-center gap-6">
                        <button type="button"
                            class="w-16 h-16 rounded-3xl border-2 border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-900 text-2xl font-black transition-all"
                            onclick="adjustAmount(-1)">-</button>
                        
                        <input type="number" id="useAmount" name="jumlah" value="1" min="1"
                            class="flex-1 h-20 text-center text-4xl font-black border-4 border-blue-50 bg-blue-50/30 rounded-[2rem] focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue transition-all text-slate-800">
                        
                        <button type="button"
                            class="w-16 h-16 rounded-3xl border-2 border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-900 text-2xl font-black transition-all"
                            onclick="adjustAmount(1)">+</button>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-5 bg-deisa-blue text-white rounded-[1.8rem] text-lg font-black shadow-2xl shadow-blue-500/40 hover:-translate-y-1 active:scale-95 transition-all">Konfirmasi Gunakan</button>
                    <button type="button" class="w-full py-4 text-slate-400 font-bold hover:text-slate-700 transition-colors"
                        onclick="closeUseModal()">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let maxStok = 0;

        function openUseModal(id, name, unit, stok) {
            maxStok = stok;
            document.getElementById('useModal').classList.remove('hidden');
            document.getElementById('modalObatId').value = id;
            document.getElementById('modalObatName').innerText = name;
            document.getElementById('modalSatuan').innerText = unit;
            document.getElementById('modalStokLabel').innerText = stok + ' ' + unit;
            document.getElementById('useAmount').value = 1;
            
            setTimeout(() => {
                document.getElementById('modalContent').classList.remove('translate-y-full');
            }, 10);
        }

        function closeUseModal() {
            document.getElementById('modalContent').classList.add('translate-y-full');
            setTimeout(() => {
                document.getElementById('useModal').classList.add('hidden');
            }, 300);
        }

        function adjustAmount(delta) {
            let input = document.getElementById('useAmount');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > maxStok) val = maxStok;
            input.value = val;
        }

        // Search logic
        document.getElementById('obatSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('.obat-item').forEach(item => {
                const name = item.dataset.nama;
                if (name.includes(term)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        // Form Submit
        document.getElementById('useObatForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('modalObatId').value;
            const jumlah = document.getElementById('useAmount').value;
            const url = `/user/obat/${id}/use`;
            
            closeUseModal();
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ jumlah: jumlah })
                });
                
                const data = await response.json();
                if (response.ok) {
                    showAlert('success', data.message);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showAlert('error', data.message || 'Gagal menyimpan data.');
                }
            } catch (error) {
                showAlert('error', 'Terjadi kesalahan sistem.');
            }
        });
    </script>
@endsection