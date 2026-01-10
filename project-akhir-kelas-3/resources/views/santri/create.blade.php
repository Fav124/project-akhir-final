@extends('layouts.master')
@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Santri</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        @if(isset($allSantri))
            <script>window.santriList = {!! json_encode($allSantri) !!};</script>
        @endif
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">edit_square</span>
                Form Input Data
            </h2>

            <form id="formSantri" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">

                <!-- Data Santri Section -->
                <div class="space-y-4 mb-6">
                    <h3 class="font-bold text-text-main dark:text-white">Data Santri</h3>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">NIS</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="nis" id="nis" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <div style="position:relative">
                            <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="nama_lengkap" id="nama_lengkap" autocomplete="off" required>
                            <ul id="searchResults" class="absolute w-full mt-1 hidden border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 shadow-lg z-50 max-h-60 overflow-y-auto">
                            </ul>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Jenis Kelamin</label>
                        <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="" disabled selected>-- Pilih --</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Kelas</label>
                        <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="kelas_id" id="kelas_id" onchange="fetchJurusans(this.value)" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Jurusan</label>
                        <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary disabled:opacity-50 disabled:cursor-not-allowed" name="jurusan_id" id="jurusan_id" disabled required>
                            <option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tempat Lahir</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tempat_lahir" id="tempat_lahir" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Lahir</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_lahir" id="tanggal_lahir" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Foto Santri</label>
                        <div class="relative">
                            <input type="file" class="hidden" name="foto" id="foto" accept="image/*">
                            <label for="foto" class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-primary hover:bg-primary/5 transition-colors">
                                <div class="text-center">
                                    <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-500 block mb-2">image</span>
                                    <p class="text-sm text-text-muted dark:text-gray-400">Klik untuk pilih foto</p>
                                    <p class="text-xs text-text-muted dark:text-gray-500 mt-1">Max 5MB</p>
                                </div>
                            </label>
                            <div id="fotoPreview" class="mt-3 hidden">
                                <img id="fotoImg" src="" alt="Preview" class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <!-- Data Wali Section -->
                <div class="space-y-4">
                    <h3 class="font-bold text-text-main dark:text-white">Data Wali Santri</h3>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Wali</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="nama_wali" id="nama_wali" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Hubungan</label>
                        <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="hubungan" id="hubungan" required>
                            <option value="" disabled selected>-- Pilih --</option>
                            <option value="Ayah">Ayah</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Wali">Wali</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">No HP</label>
                        <input type="tel" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="no_hp" id="no_hp" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tempat Lahir Wali</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="wali_tempat_lahir" id="wali_tempat_lahir" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Lahir Wali</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="wali_tanggal_lahir" id="wali_tanggal_lahir" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Alamat</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="3" name="alamat" id="alamat" required></textarea>
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
                    <span class="material-symbols-outlined text-primary">check_circle</span>
                    Draft Autosave
                </h2>
                <span class="px-3 py-1 bg-primary text-white text-sm font-bold rounded-full" id="draftCount">0</span>
            </div>

            <!-- Table -->
            <div class="flex-1 overflow-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Nama</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-text-main dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="autosaveTable" class="divide-y divide-gray-200 dark:divide-gray-800">
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data tersimpan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Save All Button -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                <form action="{{ route('santri.saveAll') }}" method="POST" enctype="multipart/form-data">
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
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    Detail Draft
                </h3>
                <button type="button" onclick="closeDetailModal()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Modal Body -->
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



    <script>

        const form = document.getElementById('formSantri');
        const fotoInput = document.getElementById('foto');
        const fotoPreview = document.getElementById('fotoPreview');
        const fotoImg = document.getElementById('fotoImg');

        // Photo preview
        fotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoImg.src = e.target.result;
                    fotoPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Add to draft
        function addToTemporary() {
            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;

            const url = editId ?
                "{{ route('santri.updateTemporary') }}" :
                "{{ route('santri.autosave') }}";

            const method = editId ? "PUT" : "POST";
            let body = fd;
            
            if (method === "PUT") {
                const obj = {};
                fd.forEach((value, key) => obj[key] = value);
                body = JSON.stringify(obj);
            }

            fetch(url, {
                    method: method,
                    headers: method === "PUT" ? {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                        'Content-Type': 'application/json'
                    } : {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    },
                    body: body
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        form.reset();
                        document.getElementById('jurusan_id').innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
                        document.getElementById('jurusan_id').disabled = true;
                        fotoPreview.classList.add('hidden');
                        document.getElementById('edit_id').value = '';
                        document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
                        document.getElementById('btnCancel').classList.add('hidden');
                        renderAutosave();
                        showAlert(data.message || "Data berhasil disimpan! 🎉", "success");
                    }
                })
                .catch(() => showAlert("Gagal menyimpan data! Periksa koneksi.", "danger"));
        }

        // Render draft table
        function renderAutosave() {
            fetch("{{ route('santri.getTemporary') }}")
                .then(res => res.json())
                .then(data => {
                    const table = document.getElementById("autosaveTable");
                    const countBadge = document.getElementById("draftCount");
                    const btnSaveAll = document.getElementById("btnSaveAll");

                    countBadge.textContent = data.length;
                    btnSaveAll.disabled = data.length === 0;

                    if (!data.length) {
                        table.innerHTML = `
                            <tr><td colspan="2" class="px-6 py-8 text-center text-text-muted dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>
                                Belum ada data
                            </td></tr>`;
                        return;
                    }

                    table.innerHTML = data.map(item => `
                        <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 text-sm text-text-main dark:text-gray-300">${item.nama_lengkap}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors" onclick='openDetail(${JSON.stringify(item.id)})' title="Detail">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                    <button class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors" onclick='editDraft(${JSON.stringify(item.id)})' title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors" onclick='deleteTemp(${JSON.stringify(item.id)})' title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                });
        }

        // Open detail modal
        function openDetail(id) {
            document.getElementById('detailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            fetch(`{{ route('santri.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    document.getElementById("modalContent").innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">NIS</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.nis || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Nama</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.nama_lengkap}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Jenis Kelamin</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1 capitalize">${d.jenis_kelamin}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Kelas</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.kelas_id || '-'}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Nama Wali</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.nama_wali}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Hubungan</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.hubungan || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">No HP</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.no_hp || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">Alamat</p>
                                    <p class="text-sm font-medium text-text-main dark:text-gray-300 mt-1">${d.alamat || '-'}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-800">
                            <button class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg flex items-center justify-center gap-2 transition-colors" onclick='editDraft("${d.id}")'>
                                <span class="material-symbols-outlined text-lg">edit</span>
                                <span>Edit</span>
                            </button>
                            <button class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg flex items-center justify-center gap-2 transition-colors" onclick='deleteTemp("${d.id}")'>
                                <span class="material-symbols-outlined text-lg">delete</span>
                                <span>Hapus</span>
                            </button>
                        </div>
                    `;
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit draft
        function editDraft(id) {
            fetch(`{{ route('santri.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('nis').value = d.nis;
                    document.getElementById('nama_lengkap').value = d.nama_lengkap;
                    document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                    document.getElementById('kelas_id').value = d.kelas_id;
                    document.getElementById('tempat_lahir').value = d.tempat_lahir;
                    document.getElementById('tanggal_lahir').value = d.tanggal_lahir;
                    document.getElementById('nama_wali').value = d.nama_wali;
                    document.getElementById('hubungan').value = d.hubungan;
                    document.getElementById('no_hp').value = d.no_hp;
                    document.getElementById('wali_tempat_lahir').value = d.wali_tempat_lahir;
                    document.getElementById('wali_tanggal_lahir').value = d.wali_tanggal_lahir;
                    document.getElementById('alamat').value = d.alamat;

                    // Fetch jurusans and then select the value
                    fetchJurusans(d.kelas_id, d.jurusan_id);

                    document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">check_circle</span><span>UPDATE DRAFT</span>';
                    document.getElementById('btnCancel').classList.remove('hidden');

                    closeDetailModal();
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    showAlert("Mode edit aktif! Ubah data lalu klik UPDATE DRAFT", "info");
                });
        }

        function cancelEdit() {
            form.reset();
            document.getElementById('jurusan_id').innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
            document.getElementById('jurusan_id').disabled = true;
            fotoPreview.classList.add('hidden');
            document.getElementById('edit_id').value = '';
            document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
            document.getElementById('btnCancel').classList.add('hidden');
            showAlert("Mode edit dibatalkan", "secondary");
        }

        // Delete draft
        function deleteTemp(id) {
            if (!confirm('Yakin ingin menghapus draft ini?')) return;

            fetch("{{ route('santri.deleteTemporary') }}", {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderAutosave();
                        closeDetailModal();
                        showAlert("Data berhasil dihapus dari draft 🗑️", "warning");
                    }
                })
                .catch(() => showAlert("Gagal menghapus data!", "danger"));
        }

        // Search functionality
        function debounce(fn, wait = 250) {
            let t;
            return (...args) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...args), wait);
            };
        }

        async function querySantri(q) {
            if (!q) return [];

            if (window.santriList && Array.isArray(window.santriList)) {
                return window.santriList.filter(s => (s.nama_lengkap || '').toLowerCase().includes(q.toLowerCase())).slice(0, 8);
            }

            try {
                const res = await fetch(`/santri/search?q=${encodeURIComponent(q)}`);
                if (!res.ok) return [];
                return await res.json();
            } catch (e) {
                return [];
            }
        }

        const inputName = document.getElementById('nama_lengkap');
        const resultsEl = document.getElementById('searchResults');

        function renderResults(items) {
            if (!items || !items.length) {
                resultsEl.classList.add('hidden');
                return;
            }

            resultsEl.innerHTML = items.map(item => `
                <li class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer text-text-main dark:text-gray-300 border-b border-gray-200 dark:border-gray-700 last:border-b-0 transition-colors" data-nis="${item.nis || ''}" data-id="${item.id || ''}">
                    <div class="text-xs text-text-muted dark:text-gray-400">${item.nis || ''}</div>
                    <div class="font-medium">${item.nama_lengkap}</div>
                </li>
            `).join('');

            resultsEl.querySelectorAll('li').forEach(li => {
                li.addEventListener('click', () => {
                    const name = li.querySelector('div:nth-child(2)').textContent.trim();
                    const nis = li.dataset.nis || '';
                    inputName.value = name;
                    document.getElementById('nis').value = nis;
                    resultsEl.classList.add('hidden');
                });
            });

            resultsEl.classList.remove('hidden');
        }

        const handleSearch = debounce(async function (e) {
            const q = e.target.value.trim();
            if (!q) {
                resultsEl.classList.add('hidden');
                return;
            }
            const items = await querySantri(q);
            renderResults(items);
        }, 200);

        inputName.addEventListener('input', handleSearch);

        document.addEventListener('click', (ev) => {
            if (!ev.target.closest('#searchResults') && ev.target !== inputName) {
                resultsEl.classList.add('hidden');
            }
        });

        async function fetchJurusans(kelasId, selectedJurusanId = null) {
            const jurusanSelect = document.getElementById('jurusan_id');
            if (!kelasId) {
                jurusanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelas Terlebih Dahulu --</option>';
                jurusanSelect.disabled = true;
                return;
            }

            jurusanSelect.disabled = true;
            jurusanSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            try {
                const res = await fetch(`{{ route('santri.getJurusans') }}?kelas_id=${kelasId}`);
                const jurusans = await res.json();

                if (jurusans.length > 0) {
                    jurusanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Jurusan --</option>' +
                        jurusans.map(j => `<option value="${j.id}" ${selectedJurusanId == j.id ? 'selected' : ''}>${j.nama}</option>`).join('');
                    jurusanSelect.disabled = false;
                } else {
                    jurusanSelect.innerHTML = '<option value="" disabled selected>Tidak ada jurusan tersedia</option>';
                    jurusanSelect.disabled = true;
                }
            } catch (e) {
                showAlert("Gagal memuat data jurusan", "danger");
                jurusanSelect.innerHTML = '<option value="" disabled selected>Error memuat data</option>';
            }
        }

        document.addEventListener("DOMContentLoaded", renderAutosave);
    </script>
@endsection
