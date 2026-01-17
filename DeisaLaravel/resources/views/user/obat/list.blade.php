@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-24 max-w-lg mx-auto">
        <header class="bg-deisa-blue p-4 sticky top-0 z-30 shadow-md">
            <div class="flex gap-3 items-center">
                <a href="/preview/user/dashboard" class="text-white hover:bg-white/10 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <input type="text" placeholder="Cari obat..."
                    class="w-full bg-white/20 text-white placeholder-blue-100 px-4 py-2 rounded-full border border-white/10 focus:outline-none focus:bg-white/30 transition-colors">
            </div>
        </header>

        <div class="p-4 space-y-4">
            <!-- Card Item -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 truncate">Paracetamol 500mg</h4>
                    <div class="text-sm text-slate-500">Stok: <span class="font-semibold text-deisa-green">150 Tablet</span>
                    </div>
                </div>
                <x-button class="py-1.5 px-3 text-sm h-auto whitespace-nowrap"
                    onclick="openUseModal(1, 'Paracetamol 500mg', 'Tablet')">Pakai</x-button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 truncate">Amoxicillin</h4>
                    <div class="text-sm text-slate-500">Stok: <span class="font-semibold text-red-500">10 Kapsul</span>
                    </div>
                </div>
                <x-button class="py-1.5 px-3 text-sm h-auto whitespace-nowrap"
                    onclick="openUseModal(2, 'Amoxicillin', 'Kapsul')">Pakai</x-button>
            </div>
        </div>
    </div>

    <!-- Use Modal -->
    <div id="useModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeUseModal()"></div>

        <!-- Modal Panel -->
        <div
            class="absolute bottom-0 left-0 w-full bg-white rounded-t-3xl p-6 transition-transform transform translate-y-0 sm:max-w-lg sm:left-1/2 sm:-translate-x-1/2">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>

            <h4 id="modalObatName" class="text-xl font-bold text-slate-900 mb-6">Nama Obat</h4>
            <form>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-500 mb-2">Jumlah (<span
                            id="modalSatuan">Satuan</span>)</label>
                    <div class="flex items-center gap-4">
                        <button type="button"
                            class="w-12 h-12 rounded-xl border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 text-xl font-bold"
                            onclick="adjustAmount(-1)">-</button>
                        <input type="number" id="useAmount" value="1"
                            class="flex-1 h-12 text-center text-xl font-bold border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue">
                        <button type="button"
                            class="w-12 h-12 rounded-xl border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 text-xl font-bold"
                            onclick="adjustAmount(1)">+</button>
                    </div>
                </div>

                <x-button class="w-full py-3.5 text-lg shadow-lg shadow-blue-500/30">Konfirmasi Pakai</x-button>
                <button type="button" class="w-full mt-3 py-3 text-slate-500 font-medium hover:text-slate-700"
                    onclick="closeUseModal()">Batal</button>
            </form>
        </div>
    </div>

    <script>
        function openUseModal(id, name, unit) {
            document.getElementById('useModal').classList.remove('hidden');
            document.getElementById('modalObatName').innerText = name;
            document.getElementById('modalSatuan').innerText = unit;
        }
        function closeUseModal() {
            document.getElementById('useModal').classList.add('hidden');
        }
        function adjustAmount(delta) {
            let input = document.getElementById('useAmount');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            input.value = val;
        }
    </script>
@endsection