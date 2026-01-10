@extends('layouts.master')

@section('content')
<div class="space-y-6">
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-text-main dark:text-white">Master Diagnosis</h1>
            <p class="text-text-muted dark:text-gray-400 mt-1">Kelola daftar diagnosis penyakit untuk sistem tagging.</p>
        </div>
        <button onclick="openModal()" class="flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            <span>Tambah Diagnosis</span>
        </button>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm p-4">
        <div class="relative max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">search</span>
            <input type="text" id="searchInput" placeholder="Cari nama diagnosis..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
    </div>

    <!-- TABLE CONTAINER -->
    <div id="tableContainer" class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-sm overflow-hidden">
        @include('diagnosis.table')
    </div>
</div>

<!-- MODAL -->
<div id="diagnosisModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-surface-light dark:bg-surface-dark rounded-lg shadow-xl max-w-md w-full animate-in zoom-in duration-200">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
            <h3 id="modalTitle" class="text-lg font-bold text-text-main dark:text-white">Tambah Diagnosis</h3>
            <button onclick="closeModal()" class="text-text-muted hover:text-text-main">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="diagnosisForm" onsubmit="handleSubmits(event)" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="diagnosisId">
            <div>
                <label class="block text-sm font-medium text-text-main dark:text-gray-300 mb-2">Nama Diagnosis</label>
                <input type="text" id="diagnosisNama" name="nama" required 
                       class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    let searchTimer;

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            fetchData(searchInput.value);
        }, 300);
    });

    function fetchData(q = '', page = 1) {
        fetch(`{{ route('diagnosis.index') }}?q=${q}&page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('tableContainer').innerHTML = html;
        });
    }

    function openModal(id = null, nama = '') {
        const modal = document.getElementById('diagnosisModal');
        const title = document.getElementById('modalTitle');
        const inputId = document.getElementById('diagnosisId');
        const inputNama = document.getElementById('diagnosisNama');

        inputId.value = id || '';
        inputNama.value = nama || '';
        title.innerText = id ? 'Edit Diagnosis' : 'Tambah Diagnosis';
        
        modal.classList.remove('hidden');
        inputNama.focus();
    }

    function closeModal() {
        document.getElementById('diagnosisModal').classList.add('hidden');
    }

    function handleSubmits(e) {
        e.preventDefault();
        const id = document.getElementById('diagnosisId').value;
        const nama = document.getElementById('diagnosisNama').value;
        const url = id ? `{{ url('diagnosis') }}/${id}` : `{{ route('diagnosis.store') }}`;
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                nama, 
                _method: method 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeModal();
                fetchData(searchInput.value);
                Toast.fire({ icon: 'success', title: data.message });
            } else {
                Toast.fire({ icon: 'error', title: 'Gagal menyimpan data' });
            }
        });
    }

    function deleteDiagnosis(id) {
        if (!confirm('Yakin ingin menghapus diagnosis ini? Data terkait di riwayat sakit akan terputus.')) return;

        fetch(`{{ url('diagnosis') }}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchData(searchInput.value);
                Toast.fire({ icon: 'warning', title: data.message });
            }
        });
    }
</script>
@endsection
