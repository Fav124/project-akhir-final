@extends('layouts.admin')

@section('title', 'Tambah Obat Baru')

@section('header')
    <div class="flex items-center gap-4">
        <a href="/admin/obat" class="text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h2 class="text-xl font-bold text-slate-900">Tambah Obat Baru</h2>
    </div>
@endsection

@section('admin-content')
    <div class="max-w-4xl mx-auto">
        <x-card class="overflow-hidden border-none shadow-xl shadow-slate-200/50 rounded-3xl">
            <form action="{{ route('admin.obat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
                data-ajax="true" id="obat-form">
                @csrf

                <!-- Section: Informasi Utama -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-deisa-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Informasi Utama</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-deisa-blue">Kode Obat</label>
                            <div class="relative">
                                <input type="text" name="kode" value="OBT-003"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 font-bold cursor-not-allowed"
                                    readonly>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] bg-white px-2 py-0.5 rounded-md border border-slate-100 text-slate-400 font-bold">Auto</div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Kode digenerate otomatis oleh sistem
                            </p>
                        </div>
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-deisa-blue">Nama Obat <span class="text-red-400">*</span></label>
                            <input type="text" name="nama"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue transition-all placeholder:text-slate-300 font-medium"
                                required placeholder="Contoh: Paracetamol 500mg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-deisa-blue">Kategori</label>
                            <select name="kategori"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue bg-white transition-all font-medium appearance-none">
                                <option>Tablet</option>
                                <option>Sirup</option>
                                <option>Kapsul</option>
                                <option>Alat Kesehatan</option>
                            </select>
                        </div>
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-deisa-blue">Satuan</label>
                            <select name="satuan"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-deisa-blue bg-white transition-all font-medium appearance-none">
                                <option>Strip</option>
                                <option>Botol</option>
                                <option>Pcs</option>
                                <option>Box</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section: Detail Stok & Harga -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Detail Stok & Harga</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-emerald-500">Stok Awal <span class="text-red-400">*</span></label>
                            <input type="number" name="stok"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all font-bold text-emerald-600"
                                required min="0" value="0">
                        </div>
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-red-500">Stok Minimum (Alert)</label>
                            <input type="number" name="stok_min"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all font-bold text-red-600"
                                value="10" min="0">
                        </div>
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-amber-500">Harga (Opsional)</label>
                            <div class="relative">
                                <input type="number" name="harga"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all font-medium"
                                    placeholder="0">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs uppercase">Rp</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Logistik & Penyimpanan -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Logistik & Penyimpanan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-indigo-500">Tanggal Kadaluarsa</label>
                            <input type="date" name="kadaluarsa"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5 transition-colors group-focus-within:text-indigo-500">Lokasi Rak</label>
                            <input type="text" name="lokasi"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-medium placeholder:text-slate-300 uppercase"
                                placeholder="CONTOH: RAK A2">
                        </div>
                    </div>
                </div>

                <!-- Section: Media / Foto -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Foto Obat</h3>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest bg-slate-50 px-2 py-0.5 rounded border border-slate-100">Optimal: Square</span>
                    </div>

                    <div id="drop-zone" class="relative group">
                        <div
                            class="flex flex-col items-center justify-center p-8 border-3 border-slate-200 border-dashed rounded-3xl transition-all duration-300 group-hover:bg-blue-50/30 group-hover:border-deisa-blue bg-slate-50/50">
                            
                            <!-- Initial State -->
                            <div id="upload-placeholder" class="space-y-3 text-center transition-all duration-300">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center mx-auto transition-transform group-hover:scale-110 group-hover:rotate-3">
                                    <svg class="w-8 h-8 text-deisa-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-700 uppercase tracking-wide">Pilih atau Seret Foto</div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">PNG, JPG, GIF • Max 2MB</p>
                                </div>
                                <button type="button" onclick="document.getElementById('file-upload').click()" 
                                    class="mt-2 bg-deisa-blue hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                                    Pilih Berkas
                                </button>
                                <input id="file-upload" name="foto" type="file" class="hidden" accept="image/*" data-no-auto-image>
                            </div>

                            <!-- Preview State -->
                            <div id="preview-container" class="hidden w-full max-w-xs relative group/preview transition-all duration-500 scale-90 opacity-0">
                                <div class="aspect-square rounded-2xl overflow-hidden border-4 border-white shadow-2xl relative">
                                    <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover/preview:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                        <button type="button" id="remove-preview" class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-full shadow-lg transition-all active:scale-90 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="file-name" class="mt-3 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center truncate px-4"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex justify-end pt-6 border-t border-slate-100 gap-4">
                    <x-button variant="outline" type="button" href="/admin/obat" class="rounded-2xl px-8 font-bold border-slate-200">Batal</x-button>
                    <x-button class="rounded-2xl px-10 font-black shadow-lg shadow-blue-500/20">Simpan Data</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-upload');
        const previewContainer = document.getElementById('preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        const previewImage = document.getElementById('image-preview');
        const removeButton = document.getElementById('remove-preview');
        const fileNameText = document.getElementById('file-name');

        function handleFile(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    fileNameText.textContent = file.name;
                    
                    // Smooth Transition
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                    setTimeout(() => {
                        previewContainer.classList.remove('scale-90', 'opacity-0');
                    }, 50);
                };
                reader.readAsDataURL(file);
            }
        }

        // Click mapping
        dropZone.addEventListener('click', (e) => {
            if (e.target.closest('#remove-preview')) return;
            if (placeholder.contains(e.target) || e.target === dropZone) {
                // Ignore if clicked on buttons inside placeholder to avoid double trigger
                if (!e.target.closest('button')) {
                    fileInput.click();
                }
            }
        });

        // Input change
        fileInput.addEventListener('change', (e) => {
            handleFile(e.target.files[0]);
        });

        // Drag & Drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.querySelector('div').classList.add('bg-blue-50', 'border-deisa-blue', 'scale-[1.01]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.querySelector('div').classList.remove('bg-blue-50', 'border-deisa-blue', 'scale-[1.01]');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const file = dt.files[0];
            fileInput.files = dt.files; // Sync with hidden input
            handleFile(file);
        });

        // Remove preview
        removeButton.addEventListener('click', (e) => {
            e.stopPropagation();
            previewContainer.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
                fileInput.value = ''; // Clear input
                previewImage.src = '#';
            }, 300);
        });
    });
</script>
@endpush
