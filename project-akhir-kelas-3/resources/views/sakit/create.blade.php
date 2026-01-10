@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
             <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        Dashboard
                    </a>
                </li>
                 <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <a href="{{ route('sakit.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Sakit</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                         <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah Data Sakit</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Santri Sakit</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">clinical_notes</span>
                Form Input Data
            </h2>

            <form id="formSakit">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="space-y-6">
                     <!-- Data Santri Section -->
                    <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">person</span>
                            Data Santri
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Filter Kelas</label>
                                <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" id="filter_kelas" onchange="updateJurusans(this.value)">
                                    <option value="" selected>-- Semua Kelas --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Filter Jurusan</label>
                                <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" id="filter_jurusan" onchange="updateSantri()" disabled>
                                    <option value="" selected>-- Semua Jurusan --</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Pilih Santri</label>
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="santri_id" id="santri_id" required>
                                <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <!-- Data Penyakit Section -->
                     <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">stethoscope</span>
                            Data Penyakit
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Mulai Sakit</label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_mulai_sakit" id="tanggal_mulai_sakit" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Diagnosis Penyakit (Tags)</label>
                                <div id="diagnosisTagInput" class="w-full p-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus-within:ring-2 focus-within:ring-primary min-h-[42px] flex flex-wrap gap-2 items-center">
                                    <!-- Tags will be rendered here -->
                                    <input type="text" id="tagInput" class="flex-1 bg-transparent border-none outline-none text-sm min-w-[120px]" placeholder="Ketik & tekan Enter untuk tambah tag...">
                                </div>
                                <div id="tagSuggestions" class="absolute z-50 mt-1 w-full max-w-md bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-800 rounded-lg shadow-xl hidden overflow-hidden">
                                     <!-- Suggestions will be rendered here -->
                                </div>
                                <p class="text-xs text-text-muted mt-1 italic">Ketik diagnosis (misal: Demam) lalu tekan Enter. Anda bisa menambah lebih dari satu tag.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Gejala yang Dialami</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Deskripsikan gejala..." name="gejala" id="gejala" required></textarea>
                            </div>

                             <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tindakan/Perawatan</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Tindakan medis yang diberikan..." name="tindakan" id="tindakan" required></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Resep Obat (Deskripsi)</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" placeholder="Obat yang diberikan..." name="resep_obat" id="resep_obat" required></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Suhu Tubuh (°C)</label>
                                    <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="38.5" step="0.1" name="suhu_tubuh" id="suhu_tubuh">
                                </div>
                                <div>
                                     <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Status Kondisi</label>
                                    <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="status" id="status" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="sakit">Masih Sakit</option>
                                        <option value="sembuh">Sembuh</option>
                                        <option value="kontrol">Kontrol</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Selesai Sakit (Opsional)</label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_selesai_sakit" id="tanggal_selesai_sakit">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Catatan Tambahan</label>
                                <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="2" placeholder="Catatan lainnya..." name="catatan" id="catatan"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <!-- Obat Section -->
                    <div>
                        <h3 class="font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                             <span class="material-symbols-outlined text-primary text-md">medication_liquid</span>
                            Obat yang Digunakan
                        </h3>

                        <div id="obatContainer" class="space-y-4 mb-4">
                            <!-- Obat items added here -->
                        </div>

                         <button type="button" class="flex items-center gap-2 px-3 py-1.5 border border-primary text-primary hover:bg-primary/5 rounded-lg text-sm font-medium transition-colors" onclick="openObatModal()">
                            <span class="material-symbols-outlined text-lg">add_circle</span>
                            Tambah Obat
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="addToTemporary()" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-green-600 text-white font-medium rounded-lg transition-colors" id="btnSubmit">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        <span>TAMBAH KE DRAFT</span>
                    </button>
                    <button type="button" onclick="cancelEdit()" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors hidden" id="btnCancel">
                        <span class="material-symbols-outlined text-lg">cancel</span>
                        <span>Batal</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT SECTION - DRAFT TABLE -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">fact_check</span>
                    Draft Autosave
                </h2>
                <span class="px-3 py-1 bg-primary text-white text-sm font-bold rounded-full" id="draftCount">0</span>
            </div>

            <div class="flex-1 overflow-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Santri</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Diagnosis</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="draftTable" class="divide-y divide-gray-200 dark:divide-gray-800">
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data tersimpan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                <form action="{{ route('sakit.saveAll') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-medium rounded-lg transition-colors" id="btnSaveAll" disabled>
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>SIMPAN SEMUA KE DATABASE</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark z-10">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Detail Draft Sakit
                </h3>
                <button type="button" onclick="closeDetailModal()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <div class="flex justify-center py-8">
                    <div class="inline-flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined animate-spin">refresh</span>
                        <span>Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Box -->
    <div id="alertBox" class="fixed top-6 right-6 z-50 max-w-sm space-y-2"></div>

    <!-- MEDICINE MODAL -->
    <div id="obatModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[60] p-4">
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-md w-full">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">medication</span>
                    Input Data Obat
                </h3>
                <button type="button" onclick="closeObatModal()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <input type="hidden" id="modal_obat_index" value="">
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Pilih Obat</label>
                    <select id="modal_obat_id" class="w-full">
                        <option value="">-- Pilih Obat --</option>
                        @foreach($obats as $obat)
                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }} ({{ $obat->satuan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Jumlah</label>
                        <input type="number" id="modal_jumlah" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white" value="1" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Dosis</label>
                        <input type="text" id="modal_dosis" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white" placeholder="Contoh: 3x1">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Keterangan</label>
                    <textarea id="modal_keterangan" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white" rows="2" placeholder="Contoh: Sesudah makan"></textarea>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 dark:border-gray-800 flex gap-3">
                <button type="button" onclick="closeObatModal()" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Batal</button>
                <button type="button" onclick="saveObatFromModal()" class="flex-1 px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-green-600 transition-colors">Simpan Obat</button>
            </div>
        </div>
    </div>

    <script>
    /* =========================
       TAG INPUT FOR DIAGNOSIS
    ========================= */
    /* =========================
       INITIALIZATION
    ========================= */
    document.addEventListener('DOMContentLoaded', () => {
        // Tag Input for Diagnosis
        diagnosisTags = new TagInput('diagnosisContainer', 'diagnosis_input', 'diagnosisSuggestions', "{{ route('diagnosis.search') }}");
        
        // Manual override for remove button in older templates if necessary
        window.removeTagFromGlobal = (index) => diagnosisTags.removeTag(index);

        // Searchable Selects
        santriSelect = new SearchableSelect(document.getElementById('santri_id'), {
            placeholder: '--- Cari & Pilih Santri ---',
            emptyText: '-- Pilih Santri --'
        });

        obatModalSelect = new SearchableSelect(document.getElementById('modal_obat_id'), {
            placeholder: '--- Cari & Pilih Obat ---',
            emptyText: '-- Pilih Obat --'
        });

        // Search Filters
        document.getElementById('filter_kelas').addEventListener('change', (e) => updateJurusans(e.target.value));
        document.getElementById('filter_jurusan').addEventListener('change', updateSantri);
    });

    /* =========================
       OBAT HANDLER (MODAL BASED)
    ========================= */
    let currentObatData = [];
    let obatModalSelect = null;

    function openObatModal(index = null) {
        const modal = document.getElementById('obatModal');
        const title = modal.querySelector('h3');
        const modalIndex = document.getElementById('modal_obat_index');
        const modalObatId = document.getElementById('modal_obat_id');
        const modalJumlah = document.getElementById('modal_jumlah');
        const modalDosis = document.getElementById('modal_dosis');
        const modalKeterangan = document.getElementById('modal_keterangan');

        if (index !== null) {
            const data = currentObatData[index];
            title.innerHTML = '<span class="material-symbols-outlined text-primary">edit</span> Edit Data Obat';
            modalIndex.value = index;
            modalObatId.value = data.obat_id;
            modalJumlah.value = data.jumlah;
            modalDosis.value = data.dosis;
            modalKeterangan.value = data.keterangan;
        } else {
            title.innerHTML = '<span class="material-symbols-outlined text-primary">medication</span> Tambah Data Obat';
            modalIndex.value = '';
            modalObatId.value = '';
            modalJumlah.value = 1;
            modalDosis.value = '';
            modalKeterangan.value = '';
        }

        if (obatModalSelect) {
            obatModalSelect.setValue(modalObatId.value);
            obatModalSelect.refresh();
        }

        modal.classList.remove('hidden');
    }

    function closeObatModal() {
        document.getElementById('obatModal').classList.add('hidden');
    }

    function saveObatFromModal() {
        const index = document.getElementById('modal_obat_index').value;
        const obatId = document.getElementById('modal_obat_id').value;
        const jumlah = document.getElementById('modal_jumlah').value;
        const dosis = document.getElementById('modal_dosis').value;
        const keterangan = document.getElementById('modal_keterangan').value;

        if (!obatId) {
            showAlert("Pilih obat terlebih dahulu!", "danger");
            return;
        }

        const data = {
            obat_id: obatId,
            jumlah: jumlah,
            dosis: dosis,
            keterangan: keterangan
        };

        if (index !== '') {
            currentObatData[index] = data;
        } else {
            currentObatData.push(data);
        }

        renderObatList();
        closeObatModal();
    }

    function removeObat(index) {
        currentObatData.splice(index, 1);
        renderObatList();
    }

    function renderObatList() {
        const container = document.getElementById('obatContainer');
        container.innerHTML = '';

        if (currentObatData.length === 0) {
            container.innerHTML = `
                <div class="p-4 border border-dashed border-gray-300 dark:border-gray-700 rounded-lg text-center text-text-muted italic text-sm">
                    Belum ada obat ditambahkan
                </div>
            `;
            return;
        }

        currentObatData.forEach((item, index) => {
            const drug = obatList.find(o => o.id == item.obat_id);
            const card = document.createElement('div');
            card.className = 'p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-700 flex justify-between items-center';
            card.innerHTML = `
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-text-main dark:text-white">${drug ? drug.nama_obat : 'N/A'}</span>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded">${item.jumlah} ${drug ? drug.satuan : ''}</span>
                    </div>
                    <p class="text-[11px] text-text-muted mt-0.5">Dosis: ${item.dosis || '-'} • ${item.keterangan || '-'}</p>
                </div>
                <div class="flex items-center gap-2 ml-4">
                    <button type="button" onclick="openObatModal(${index})" class="p-1 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded">
                        <span class="material-symbols-outlined text-lg">edit</span>
                    </button>
                    <button type="button" onclick="removeObat(${index})" class="p-1 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </div>
            `;
            container.appendChild(card);
        });
    }

    function collectObatData() {
        return currentObatData;
    }

    /* =========================
       SUBMIT TEMPORARY
    ========================= */
    function addToTemporary() {
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const fd = new FormData(form);
        const editId = document.getElementById('edit_id').value;
        const obatData = collectObatData();
        const diagnoses = diagnosisTags.getTags();

        if (diagnoses.length === 0) {
            showAlert("Minimal harus ada satu diagnosis penyakit!", "warning");
            return;
        }

        const url = editId ? "{{ route('sakit.updateTemporary') }}" : "{{ route('sakit.storeTemporary') }}";

        const data = {
            santri_id: fd.get('santri_id'),
            tanggal_mulai_sakit: fd.get('tanggal_mulai_sakit'),
            gejala: fd.get('gejala'),
            tindakan: fd.get('tindakan'),
            resep_obat: fd.get('resep_obat'),
            suhu_tubuh: fd.get('suhu_tubuh'),
            status: fd.get('status'),
            tanggal_selesai_sakit: fd.get('tanggal_selesai_sakit'),
            catatan: fd.get('catatan'),
            obat_data: obatData,
            diagnoses: diagnoses
        };

        if (editId) {
            data.edit_id = editId;
            data._method = "PUT";
        }

        fetch(url, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                resetForm();
                renderDrafts();
                showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
            }
        })
        .catch(() => showAlert("Gagal menyimpan data!", "danger"));
    }

    function resetForm() {
        form.reset();
        document.getElementById('edit_id').value = '';
        document.getElementById('obatContainer').innerHTML = '';
        obatCounter = 0;
        
        // Reset filters
        document.getElementById('filter_kelas').value = '';
        const filterJurusan = document.getElementById('filter_jurusan');
        filterJurusan.innerHTML = '<option value="" selected>-- Semua Jurusan --</option>';
        filterJurusan.disabled = true;
        
        // Reset santri select
        document.getElementById('santri_id').innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
        if (santriSelect) {
            santriSelect.setValue('');
            santriSelect.refresh();
        }
        
        // Reset Obat
        currentObatData = [];
        renderObatList();
        
        if (diagnosisTags) diagnosisTags.clear();
        
        document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
        document.getElementById('btnCancel').classList.add('hidden');
    }

    /* =========================
       DRAFT LIST
    ========================= */
    function renderDrafts() {
        fetch("{{ route('sakit.getTemporary') }}")
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById("draftTable");
                const countBadge = document.getElementById("draftCount");
                const btnSaveAll = document.getElementById("btnSaveAll");

                countBadge.textContent = data.length;
                btnSaveAll.disabled = data.length === 0;

                if (!data.length) {
                    table.innerHTML = `
                        <tr><td colspan="3" class="px-6 py-8 text-center text-text-muted">
                            Belum ada data
                        </td></tr>`;
                    return;
                }

                table.innerHTML = data.map(item => {
                    const santri = santriList.find(s => s.id == item.santri_id);
                    const diagText = (item.diagnoses || []).join(', ') || 'N/A';

                    let statusClass = 'bg-amber-100 text-amber-800';
                    if (item.status === 'sakit') statusClass = 'bg-red-100 text-red-800';
                    else if (item.status === 'sembuh') statusClass = 'bg-green-100 text-green-800';

                    const statusBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${statusClass} capitalize">${item.status}</span>`;

                    return `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium">${santri ? santri.nama_lengkap : 'N/A'}</div>
                                <div class="text-xs text-gray-500">${santri ? santri.nis : ''}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="mb-1 truncate max-w-[200px]" title="${diagText}">${diagText}</div>
                                ${statusBadge}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-1">
                                    <button onclick="openDetail('${item.id}')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-blue-900/20 transition-colors" title="Detail">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                    <button onclick="editDraft('${item.id}')" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg dark:text-amber-400 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    <button onclick="deleteTemp('${item.id}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            });
    }

    function openDetail(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        content.innerHTML = `
            <div class="flex justify-center py-8">
                <div class="inline-flex items-center gap-2 text-primary text-sm font-medium">
                    <span class="material-symbols-outlined animate-spin">refresh</span>
                    <span>Mengambil data...</span>
                </div>
            </div>
        `;

        fetch(`{{ route('sakit.getTemporary') }}?id=${id}`)
            .then(res => res.json())
            .then(d => {
                const santri = santriList.find(s => s.id == d.santri_id);
                const diagnoses = d.diagnoses || [];
                const medicines = d.obat_data || [];

                content.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Data Santri</h4>
                                <p class="text-sm font-bold text-text-main dark:text-white">${santri ? santri.nama_lengkap : 'N/A'}</p>
                                <p class="text-xs text-text-muted">${santri ? santri.nis : ''}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Tanggal & Suhu</h4>
                                <p class="text-sm text-text-main dark:text-white">${d.tanggal_mulai_sakit} • ${d.suhu_tubuh || '-'} °C</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Diagnosis</h4>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    ${diagnoses.map(tag => `
                                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded border border-primary/20">${tag}</span>
                                    `).join('') || '<span class="text-xs italic text-gray-400">Tidak ada tags</span>'}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Gejala & Tindakan</h4>
                                <p class="text-sm text-text-main dark:text-white font-medium">Gejala:</p>
                                <p class="text-xs text-text-muted mb-2">${d.gejala || '-'}</p>
                                <p class="text-sm text-text-main dark:text-white font-medium">Tindakan:</p>
                                <p class="text-xs text-text-muted">${d.tindakan || '-'}</p>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Resep Obat (Text)</h4>
                                <p class="text-xs text-text-muted italic">${d.resep_obat || '-'}</p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h4 class="text-xs font-bold text-text-muted uppercase mb-3 border-b border-gray-100 dark:border-gray-800 pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">medication</span>
                                Daftar Obat Terpilih
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                ${medicines.map(m => {
                                    const drug = obatList.find(o => o.id == m.obat_id);
                                    return `
                                        <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <p class="text-sm font-bold text-text-main dark:text-white">${drug ? drug.nama_obat : 'N/A'}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] font-bold px-1.5 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded">${m.jumlah} ${drug ? drug.satuan : ''}</span>
                                                <span class="text-[10px] text-text-muted">• ${m.dosis || '-'}</span>
                                            </div>
                                            ${m.keterangan ? `<p class="text-xs text-gray-400 mt-2 italic">"${m.keterangan}"</p>` : ''}
                                        </div>
                                    `;
                                }).join('') || '<div class="col-span-full py-4 text-center text-xs italic text-gray-400">Tidak ada obat terpilih</div>'}
                            </div>
                        </div>

                        ${d.catatan ? `
                            <div class="md:col-span-2">
                                <h4 class="text-xs font-bold text-text-muted uppercase mb-1">Catatan Tambahan</h4>
                                <p class="text-xs text-text-muted bg-yellow-50 dark:bg-yellow-900/10 p-3 rounded-lg border border-yellow-100 dark:border-yellow-900/20">${d.catatan}</p>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    async function editDraft(id) {
        try {
            const res = await fetch(`{{ route('sakit.getTemporary') }}?id=${id}`);
            const d = await res.json();
            
            document.getElementById('edit_id').value = d.id;
            
            // Set Filters first
            if (d.santri) {
                document.getElementById('filter_kelas').value = d.santri.kelas_id || '';
                await updateJurusans(d.santri.kelas_id);
                
                if (d.santri.jurusan_id) {
                    document.getElementById('filter_jurusan').value = d.santri.jurusan_id;
                    await updateSantri();
                }
                
                if (santriSelect) {
                    santriSelect.setValue(d.santri_id);
                }
            }
            
            if (diagnosisTags) diagnosisTags.setTags(d.diagnoses);
            
            document.getElementById('tanggal_mulai_sakit').value = d.tanggal_mulai_sakit;
            document.getElementById('gejala').value = d.gejala;
            document.getElementById('tindakan').value = d.tindakan;
            document.getElementById('resep_obat').value = d.resep_obat;
            document.getElementById('suhu_tubuh').value = d.suhu_tubuh || '';
            document.getElementById('status').value = d.status;
            document.getElementById('tanggal_selesai_sakit').value = d.tanggal_selesai_sakit || '';
            document.getElementById('catatan').value = d.catatan || '';

            // Set Obat
            currentObatData = d.obat_data || [];
            renderObatList();

            document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">check_circle</span><span>UPDATE DRAFT</span>';
            document.getElementById('btnCancel').classList.remove('hidden');

            closeDetailModal();
            const formElement = document.getElementById('formSakit');
            formElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            showAlert("Mode edit aktif!", "info");
        } catch (e) {
            console.error(e);
            showAlert("Gagal memuat data draft", "danger");
        }
    }

    function cancelEdit() {
        resetForm();
        showAlert("Mode edit dibatalkan", "secondary");
    }

    function deleteTemp(id) {
        if (!confirm('Yakin ingin menghapus draft ini?')) return;

        fetch("{{ route('sakit.deleteTemporary') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id, _method: "DELETE" })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDrafts();
                showAlert("Data berhasil dihapus 🗑️", "warning");
            }
        })
        .catch(() => showAlert("Gagal menghapus data!", "danger"));
    }

    async function updateJurusans(kelasId) {
        const jurusanSelect = document.getElementById('filter_jurusan');
        if (!kelasId) {
            jurusanSelect.innerHTML = '<option value="" selected>-- Semua Jurusan --</option>';
            jurusanSelect.disabled = true;
            updateSantri();
            return;
        }

        jurusanSelect.disabled = true;
        jurusanSelect.innerHTML = '<option value="" selected>Loading...</option>';

        try {
            const res = await fetch(`{{ route('santri.getJurusans') }}?kelas_id=${kelasId}`);
            const jurusans = await res.json();

            jurusanSelect.innerHTML = '<option value="" selected>-- Semua Jurusan --</option>' +
                jurusans.map(j => `<option value="${j.id}">${j.nama}</option>`).join('');
            jurusanSelect.disabled = false;
        } catch (e) {
            console.error(e);
            jurusanSelect.innerHTML = '<option value="" selected>Error</option>';
        }
        updateSantri();
    }

    async function updateSantri() {
        const kelasId = document.getElementById('filter_kelas').value;
        const jurusanId = document.getElementById('filter_jurusan').value;
        const santriIdSelect = document.getElementById('santri_id');

        if (!kelasId) {
            santriIdSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
            if (santriSelect) santriSelect.refresh();
            return;
        }

        try {
            const res = await fetch(`{{ route('santri.getSantriByFilter') }}?kelas_id=${kelasId}&jurusan_id=${jurusanId}`);
            const data = await res.json();

            if (data.length > 0) {
                santriIdSelect.innerHTML = '<option value="" disabled selected>-- Pilih Santri --</option>' +
                    data.map(s => `<option value="${s.id}">${s.nis} - ${s.nama_lengkap}</option>`).join('');
            } else {
                santriIdSelect.innerHTML = '<option value="" disabled selected>Tidak ada santri ditemukan</option>';
            }
        } catch (e) {
            console.error(e);
            santriIdSelect.innerHTML = '<option value="" disabled selected>Error memuat data</option>';
        }
        
        if (santriSelect) santriSelect.refresh();
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderDrafts();
        renderObatList();
        
        // Initialize Santri Search
        const sSelect = document.getElementById('santri_id');
        if (sSelect) {
            santriSelect = new SearchableSelect(sSelect, {
                placeholder: 'Cari santri...',
                emptyText: '-- Pilih Santri --'
            });
        }

        // Initialize Medicine Modal Search
        const oSelect = document.getElementById('modal_obat_id');
        if (oSelect) {
            obatModalSelect = new SearchableSelect(oSelect, {
                placeholder: 'Cari obat...',
                emptyText: '-- Pilih Obat --'
            });
        }

        // Initialize Diagnosis Tags
        diagnosisTags = new TagInput('diagnosisTagInput', 'tagInput', 'tagSuggestions');
    });
</script>

</div>
@endsection
