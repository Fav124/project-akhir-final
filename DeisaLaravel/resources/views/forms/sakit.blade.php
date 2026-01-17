@extends('layouts.app')

@section('title', 'Input Sakit')

@section('content')
    <div class="min-h-screen bg-slate-50 pb-20 max-w-2xl mx-auto">
        <!-- Header -->
        <header class="bg-white px-6 py-4 flex items-center gap-4 sticky top-0 z-30 border-b border-slate-200 shadow-sm">
            <a href="{{ route('user.dashboard') }}" class="text-slate-500 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="font-bold text-slate-900 text-lg">Input Santri Sakit</h1>
                <div class="text-xs text-slate-500">Langkah <span id="step-count">1</span> dari 4</div>
            </div>
        </header>

        <div class="relative pt-6">
            <!-- Progress Bar -->
            <div class="mb-8 mx-6 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-deisa-blue transition-all duration-300" style="width: 25%" id="progress-bar"></div>
            </div>

            <form id="sakitForm" class="p-6" action="{{ route('user.sakit.store') }}" method="POST" data-ajax="true"
                data-reload="true">
                @csrf
                <!-- Step 1: Identitas -->
                <div id="step1" class="step-content space-y-6">
                    <h2 class="text-xl font-bold text-slate-800">Identitas Santri</h2>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cari Santri / ID</label>
                        <div class="relative">
                            <input type="text" name="santri_id_input" required
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue"
                                placeholder="Ketik nama atau NIS..." list="santriList">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <datalist id="santriList">
                            @foreach($santris as $santri)
                                <option value="{{ $santri->nis }}">{{ $santri->nama_lengkap }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="pt-4">
                        <button type="button"
                            class="w-full bg-deisa-blue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 active:scale-95 transition-all"
                            onclick="nextStep(2)">Lanjut ke Keluhan</button>
                    </div>
                </div>

                <!-- Step 2: Diagnosis -->
                <div id="step2" class="step-content hidden space-y-6">
                    <h2 class="text-xl font-bold text-slate-800">Keluhan & Diagnosis</h2>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Keluhan Utama</label>
                        <textarea name="keluhan" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue h-32"
                            placeholder="Contoh: Panas tinggi sejak semalam, mual..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Diagnosis Awal</label>
                        <select name="diagnosis_awal" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-deisa-blue bg-white">
                            <option value="Demam">Demam</option>
                            <option value="Flu / Influenza">Flu / Influenza</option>
                            <option value="Maag / Gastritis">Maag / Gastritis</option>
                            <option value="Luka Luar">Luka Luar</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button"
                            class="flex-1 bg-white text-slate-600 border border-slate-300 py-3.5 rounded-xl font-bold hover:bg-slate-50"
                            onclick="prevStep(1)">Kembali</button>
                        <button type="button"
                            class="flex-1 bg-deisa-blue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 active:scale-95 transition-all"
                            onclick="nextStep(3)">Lanjut</button>
                    </div>
                </div>

                <!-- Step 3: Tindakan & Obat -->
                <div id="step3" class="step-content hidden space-y-6">
                    <h2 class="text-xl font-bold text-slate-800">Tindakan</h2>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tindakan yang diambil</label>
                        <div class="grid grid-cols-1 gap-3">
                            <label
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500 cursor-pointer">
                                <input type="radio" name="tindakan" value="Istirahat di UKS"
                                    class="w-5 h-5 text-deisa-blue focus:ring-blue-500 border-gray-300" checked>
                                <span class="text-sm font-medium text-slate-700">Istirahat di UKS</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500 cursor-pointer">
                                <input type="radio" name="tindakan" value="Rawat Jalan (Asrama)"
                                    class="w-5 h-5 text-deisa-blue focus:ring-blue-500 border-gray-300">
                                <span class="text-sm font-medium text-slate-700">Rawat Jalan (Asrama)</span>
                            </label>
                            <label
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500 cursor-pointer">
                                <input type="radio" name="tindakan" value="Rujuk ke RS"
                                    class="w-5 h-5 text-deisa-blue focus:ring-blue-500 border-gray-300">
                                <span class="text-sm font-medium text-slate-700">Rujuk ke RS</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-slate-700">Obat yang Diberikan</label>
                        </div>
                        <div class="space-y-3" id="obat-container">
                            <div class="flex gap-2 obat-row">
                                <select name="obat[0][id]" class="flex-1 px-4 py-2 rounded-lg border border-slate-300 text-sm bg-white">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($obats as $obat)
                                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                    @endforeach
                                </select>
                                <input type="number" name="obat[0][jumlah]" placeholder="Jml"
                                    class="w-20 px-4 py-2 rounded-lg border border-slate-300 text-sm">
                            </div>
                        </div>
                        <button type="button" class="mt-2 text-xs text-deisa-blue font-bold" onclick="addObatRow()">+ Tambah Obat</button>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button"
                            class="flex-1 bg-white text-slate-600 border border-slate-300 py-3.5 rounded-xl font-bold hover:bg-slate-50"
                            onclick="prevStep(2)">Kembali</button>
                        <button type="button"
                            class="flex-1 bg-deisa-blue text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 active:scale-95 transition-all"
                            onclick="nextStep(4)">Ringkasan</button>
                    </div>
                </div>

                <!-- Step 4: Konfirmasi -->
                <div id="step4" class="step-content hidden space-y-6">
                    <div class="text-center py-6">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">Konfirmasi Data</h2>
                        <p class="text-slate-500">Pastikan data yang dimasukkan sudah benar.</p>
                    </div>

                    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100 p-4 space-y-2">
                        <p class="text-sm text-slate-600">Tekan tombol di bawah untuk menyimpan laporan kesehatan santri secara permanen ke sistem.</p>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button"
                            class="flex-1 bg-white text-slate-600 border border-slate-300 py-3.5 rounded-xl font-bold hover:bg-slate-50"
                            onclick="prevStep(3)">Kembali</button>
                        <button type="submit"
                            class="flex-1 bg-emerald-500 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-500/30 active:scale-95 transition-all">Simpan
                            Laporan</button>
                    </div>
                </div>
            </form>

            @if($errors->any())
                <div
                    class="fixed top-20 right-4 z-50 bg-red-50 text-red-700 p-4 rounded-xl shadow-lg border border-red-200 animate-bounce">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <script>
            let obatCount = 1;

            function addObatRow() {
                const container = document.getElementById('obat-container');
                const row = document.createElement('div');
                row.className = 'flex gap-2 obat-row mt-3';
                row.innerHTML = `
                    <select name="obat[${obatCount}][id]" class="flex-1 px-4 py-2 rounded-lg border border-slate-300 text-sm bg-white">
                        <option value="">-- Pilih Obat --</option>
                        @foreach($obats as $obat)
                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="obat[${obatCount}][jumlah]" placeholder="Jml"
                        class="w-20 px-4 py-2 rounded-lg border border-slate-300 text-sm">
                `;
                container.appendChild(row);
                obatCount++;
            }

            function nextStep(step) {
                document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
                document.getElementById('step' + step).classList.remove('hidden');
                updateProgress(step);
            }

            function prevStep(step) {
                document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
                document.getElementById('step' + step).classList.remove('hidden');
                updateProgress(step);
            }

            function updateProgress(step) {
                document.getElementById('step-count').innerText = step;
                document.getElementById('progress-bar').style.width = (step * 25) + '%';
            }
        </script>
@endsection