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
                        <a href="{{ route('obat.index') }}" class="text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white">Data Obat</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-text-muted text-lg mx-1">chevron_right</span>
                        <span class="text-sm font-medium text-text-main dark:text-gray-200">Tambah Obat</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-text-main dark:text-white">Tambah Data Obat</h1>
        <p class="text-text-muted dark:text-gray-400 mt-1">Semua input masuk ke draft dulu! Bisa tambah banyak tanpa hilang 😎</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- LEFT SECTION - FORM INPUT -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">medication</span>
                Form Input Data
            </h2>

            <form id="formObat" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">

                <div class="space-y-4">
                    <!-- Foto Obat -->
                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Foto Obat</label>
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-700">
                                <span class="material-symbols-outlined text-gray-400 text-3xl" id="previewPlaceholder">medication</span>
                                <img src="" alt="Preview" class="w-full h-full object-cover hidden" id="previewFoto">
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" id="fotoInput" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-green-600 transition-all">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Obat</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <span class="material-symbols-outlined text-lg">medication</span>
                            </span>
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: Paracetamol" name="nama_obat" id="nama_obat" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Deskripsi</label>
                        <textarea class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" rows="2" placeholder="Deskripsi obat..." name="description" id="deskripsi"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="100" min="0" name="stok" id="stok" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Satuan</label>
                            <select class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="satuan" id="satuan" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach(['Tablet', 'Kapsul', 'Botol', 'Strip', 'Box', 'Pcs', 'Ampul', 'Tube'] as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Stok Minimum</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="10" min="0" name="stok_minimum" id="stok_minimum">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Harga Satuan (Rp)</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" placeholder="5000" min="0" name="harga_satuan" id="harga_satuan">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Tanggal Kadaluarsa</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa">
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Obat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-text-main dark:text-gray-300">Status</th>
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
                <form action="{{ route('obat.saveAll') }}" method="POST">
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
        <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 sticky top-0 bg-surface-light dark:bg-surface-dark">
                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    Detail Draft Obat
                </h3>
                <button type="button" onclick="closeDetailModal()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Content injected via JS -->
            </div>
        </div>
    </div>

    <!-- Alert Box -->
    <div id="alertBox" class="fixed top-6 right-6 z-50 max-w-sm space-y-2"></div>

    <script>
        const form = document.getElementById('formObat');

        // Preview Foto
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('previewFoto');
                    const placeholder = document.getElementById('previewPlaceholder');
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });


        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function addToTemporary() {
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fd = new FormData(form);
            const editId = document.getElementById('edit_id').value;
            const url = editId ? "{{ route('obat.updateTemporary') }}" : "{{ route('obat.storeTemporary') }}";

            // If updating, we need to spoof PUT if sending as FormData or just use POST and handle in controller
            // Laravel's PUT doesn't support FormData file uploads easily without spoofing or using POST
            if (editId) {
                fd.append('_method', 'PUT');
            }

            fetch(url, {
                method: "POST", // Always use POST with _method spoofing for file uploads
                headers: { 'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value },
                body: fd
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    form.reset();
                    document.getElementById('edit_id').value = '';
                    document.getElementById('previewFoto').classList.add('hidden');
                    document.getElementById('previewPlaceholder').classList.remove('hidden');
                    document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
                    document.getElementById('btnCancel').classList.add('hidden');
                    renderDrafts();
                    showAlert(result.message || "Data berhasil disimpan! 🎉", "success");
                }
            })
            .catch(() => showAlert("Gagal menyimpan data!", "danger"));
        }

        function renderDrafts() {
            fetch("{{ route('obat.getTemporary') }}")
                .then(res => res.json())
                .then(data => {
                    const table = document.getElementById("draftTable");
                    const countBadge = document.getElementById("draftCount");
                    const btnSaveAll = document.getElementById("btnSaveAll");

                    countBadge.textContent = data.length;
                    btnSaveAll.disabled = data.length === 0;

                    if (!data.length) {
                        table.innerHTML = `<tr><td colspan="3" class="px-6 py-8 text-center text-text-muted dark:text-gray-400"><span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 block mb-2">inbox</span>Belum ada data</td></tr>`;
                        return;
                    }

                    table.innerHTML = data.map(item => {
                        const lowStock = (item.stok_minimum && item.stok <= item.stok_minimum);
                        const isExpired = item.tanggal_kadaluarsa && new Date(item.tanggal_kadaluarsa) < new Date();
                        
                        return `
                            <tr class="border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-gray-100 dark:bg-gray-800 overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-700">
                                            ${item.foto ? `<img src="/storage/${item.foto}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-gray-400 text-sm">medication</span>`}
                                        </div>
                                        <div>
                                            <div class="font-medium text-text-main dark:text-white">${item.nama_obat}</div>
                                            <div class="text-[10px] text-text-muted uppercase">${item.satuan}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        ${lowStock ? '<span class="px-1.5 py-0.5 rounded-full text-[10px] bg-red-100 text-red-700 w-fit font-bold">STOK MENIPIS</span>' : '<span class="px-1.5 py-0.5 rounded-full text-[10px] bg-green-100 text-green-700 w-fit font-bold">AMAN</span>'}
                                        ${isExpired ? '<span class="px-1.5 py-0.5 rounded-full text-[10px] bg-red-100 text-red-700 w-fit font-bold">KADALUARSA</span>' : ''}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" onclick='openDetail("${item.id}")'><span class="material-symbols-outlined text-lg">visibility</span></button>
                                        <button class="p-1.5 text-amber-600 hover:bg-amber-50 rounded" onclick='editDraft("${item.id}")'><span class="material-symbols-outlined text-lg">edit</span></button>
                                        <button class="p-1.5 text-red-600 hover:bg-red-50 rounded" onclick='deleteTemp("${item.id}")'><span class="material-symbols-outlined text-lg">delete</span></button>
                                    </div>
                                </td>
                            </tr>`;
                    }).join('');
                });
        }

        function openDetail(id) {
            document.getElementById('detailModal').classList.remove('hidden');
            fetch(`{{ route('obat.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    const lowStock = (d.stok_minimum && d.stok <= d.stok_minimum);
                    const isExpired = d.tanggal_kadaluarsa && new Date(d.tanggal_kadaluarsa) < new Date();

                    document.getElementById("modalContent").innerHTML = `
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/3">
                                <div class="aspect-square rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-700 shadow-inner">
                                    ${d.foto ? `<img src="/storage/${d.foto}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-gray-400 text-6xl">medication</span>`}
                                </div>
                            </div>
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h4 class="text-2xl font-bold text-text-main dark:text-white">${d.nama_obat}</h4>
                                    <p class="text-text-muted">${d.satuan}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                        <p class="text-[10px] font-bold text-text-muted uppercase">Stok</p>
                                        <p class="text-lg font-bold ${lowStock ? 'text-red-500' : 'text-primary'}">${d.stok}</p>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                        <p class="text-[10px] font-bold text-text-muted uppercase">Kadaluarsa</p>
                                        <p class="text-sm font-bold ${isExpired ? 'text-red-500' : 'text-text-main dark:text-white'}">${d.tanggal_kadaluarsa || '-'}</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-[10px] font-bold text-text-muted uppercase">Harga Satuan</p>
                                    <p class="text-lg font-bold dark:text-white">${formatRupiah(d.harga_satuan)}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800">
                            <p class="text-[10px] font-bold text-text-muted uppercase mb-2">Deskripsi</p>
                            <p class="text-sm text-text-main dark:text-gray-300 italic">${d.deskripsi || 'Tidak ada deskripsi.'}</p>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button class="flex-1 px-4 py-2 bg-amber-600 text-white font-bold rounded-lg" onclick='editDraft("${d.id}")'>Edit</button>
                            <button class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg" onclick='deleteTemp("${d.id}")'>Hapus</button>
                        </div>
                    `;
                });
        }

        function closeDetailModal() { document.getElementById('detailModal').classList.add('hidden'); }

        function editDraft(id) {
            fetch(`{{ route('obat.getTemporary') }}?id=${id}`)
                .then(res => res.json())
                .then(d => {
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('nama_obat').value = d.nama_obat;
                    document.getElementById('deskripsi').value = d.deskripsi || '';
                    document.getElementById('stok').value = d.stok;
                    document.getElementById('satuan').value = d.satuan;
                    document.getElementById('stok_minimum').value = d.stok_minimum || '';
                    document.getElementById('harga_satuan').value = d.harga_satuan || '';
                    document.getElementById('tanggal_kadaluarsa').value = d.tanggal_kadaluarsa || '';

                    if (d.foto) {
                        const preview = document.getElementById('previewFoto');
                        preview.src = "/storage/" + d.foto;
                        preview.classList.remove('hidden');
                        document.getElementById('previewPlaceholder').classList.add('hidden');
                    }

                    document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">check_circle</span><span>UPDATE DRAFT</span>';
                    document.getElementById('btnCancel').classList.remove('hidden');
                    closeDetailModal();
                    form.scrollIntoView({ behavior: 'smooth' });
                });
        }

        function cancelEdit() {
            form.reset();
            document.getElementById('edit_id').value = '';
            document.getElementById('previewFoto').classList.add('hidden');
            document.getElementById('previewPlaceholder').classList.remove('hidden');
            document.getElementById('btnSubmit').innerHTML = '<span class="material-symbols-outlined text-lg">add_circle</span><span>TAMBAH KE DRAFT</span>';
            document.getElementById('btnCancel').classList.add('hidden');
        }

        function deleteTemp(id) {
            if (!confirm('Hapus draft?')) return;
            fetch("{{ route('obat.deleteTemporary') }}", {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value, "Content-Type": "application/json" },
                body: JSON.stringify({ id })
            }).then(res => res.json()).then(() => { renderDrafts(); closeDetailModal(); showAlert("Dihapus!", "warning"); });
        }

        document.addEventListener("DOMContentLoaded", renderDrafts);
    </script>
</div>
@endsection
