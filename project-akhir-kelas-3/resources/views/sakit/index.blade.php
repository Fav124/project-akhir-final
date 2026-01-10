@extends('layouts.master')

@section('title', 'Data Sakit Santri - Deisa')

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a class="inline-flex items-center text-sm font-medium text-text-muted hover:text-primary dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-lg mr-2">home</span>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <span class="material-symbols-outlined text-text-muted text-lg">chevron_right</span>
                <span class="ml-1 text-sm font-medium text-text-main md:ml-2 dark:text-white">Riwayat Kesehatan</span>
            </div>
        </li>
    </ol>
</nav>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-bold text-text-main dark:text-white">Riwayat Kesehatan</h2>
        <p class="text-text-muted text-sm mt-1">Pantau riwayat sakit santri.</p>
    </div>
    <a href="{{ route('sakit.create') }}" class="bg-primary hover:bg-green-400 text-surface-dark font-bold py-2.5 px-5 rounded-lg shadow-lg shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
        <span class="material-symbols-outlined">add_circle</span>
        Catat Sakit
    </a>
</div>

<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden p-4">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="material-symbols-outlined text-gray-400">search</span>
            </div>
            <input type="text" id="searchInput" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary" placeholder="Cari riwayat sakit...">
        </div>
        <div class="w-full md:w-64">
            <select id="filterStatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary">
                <option value="">Semua Status</option>
                <option value="Sakit">Masih Sakit</option>
                <option value="Sembuh">Sudah Sembuh</option>
                <option value="Kontrol">Perlu Kontrol</option>
            </select>
        </div>
    </div>

    <div id="tableContainer">
        @include('sakit.table')
    </div>
</div>

<!-- QUICK MEDICINE MODAL -->
<div id="quickObatModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[60] p-4">
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
            <div>
                <h3 class="text-xl font-bold text-text-main dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">medication</span>
                    Kelola Obat Santri
                </h3>
                <p id="modalSantriName" class="text-xs text-text-muted mt-1 font-medium"></p>
            </div>
            <button type="button" onclick="closeQuickObatModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-gray-500">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6">
            <input type="hidden" id="current_sakit_id" value="">
            
            <div class="space-y-6">
                <!-- Add New Medicine Section -->
                <div class="bg-primary/5 dark:bg-primary/10 p-4 rounded-xl border border-primary/10">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Obat Baru
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-text-muted uppercase mb-1.5 ml-1">Pilih Obat</label>
                            <select id="modal_obat_id" class="w-full">
                                <option value="">-- Pilih Obat --</option>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} ({{ $obat->satuan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-text-muted uppercase mb-1.5 ml-1">Jumlah</label>
                                <input type="number" id="modal_jumlah" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:ring-2 focus:ring-primary/20" value="1" min="1">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-text-muted uppercase mb-1.5 ml-1">Dosis</label>
                                <input type="text" id="modal_dosis" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:ring-2 focus:ring-primary/20" placeholder="Contoh: 3x1">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-text-muted uppercase mb-1.5 ml-1">Keterangan</label>
                            <input type="text" id="modal_keterangan" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white text-sm focus:ring-2 focus:ring-primary/20" placeholder="Sesudah makan, dll.">
                        </div>
                        <button type="button" onclick="addQuickObat()" class="w-full py-2 bg-primary hover:bg-green-400 text-surface-dark font-bold rounded-lg transition-all shadow-md shadow-primary/10 flex items-center justify-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-lg">add</span>
                            Tambahkan
                        </button>
                    </div>
                </div>

                <!-- Current Medicines List -->
                <div>
                    <h4 class="text-xs font-bold text-text-muted uppercase tracking-wider mb-3 flex items-center gap-1.5 ml-1">
                        <span class="material-symbols-outlined text-sm">list_alt</span>
                        Daftar Obat Terpakai
                    </h4>
                    <div id="quickObatList" class="space-y-2 max-h-48 overflow-y-auto pr-1 custom-scrollbar">
                        <!-- Items injected here -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex gap-3">
            <button type="button" onclick="closeQuickObatModal()" class="flex-1 px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-text-main dark:text-white font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-sm">Batal</button>
            <button type="button" onclick="saveQuickObat()" id="btnSaveQuick" class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-600/20 flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
</style>
<script>
    /* =========================
       CUSTOM SEARCHABLE SELECT
    ========================= */

    $(document).ready(function() {
        // Initialize medicine select
        const mSelect = document.getElementById('modal_obat_id');
        window.medicineSearch = new SearchableSelect(mSelect, {
            placeholder: 'Cari obat...',
            emptyText: '-- Pilih Obat --'
        });

        // Current Obat state
        window.currentQuickObatData = [];
        window.obatInfo = @json($obats);

        window.openObatModal = function(sakitId) {
            $('#current_sakit_id').val(sakitId);
            $('#quickObatModal').removeClass('hidden');
            $('#quickObatList').html('<div class="py-4 text-center text-xs text-text-muted animate-pulse">Memuat data...</div>');
            
            // Get santri name from table row
            const row = $(`button[onclick="openObatModal(${sakitId})"]`).closest('tr');
            const santriName = row.find('td:nth-child(3) .font-medium').text();
            $('#modalSantriName').text('Untuk: ' + santriName);

            // Fetch current medicines for this record
            $.get(`{{ url('sakit') }}/${sakitId}/medicines`, function(data) {
                window.currentQuickObatData = data;
                renderQuickObatList();
            });

            // Fetch latest medicine info (stock, etc)
            window.refreshObatData();
            
            // Reset form
            medicineSearch.setValue('');
            $('#modal_jumlah').val(1);
            $('#modal_dosis').val('');
            $('#modal_keterangan').val('');
        }

        window.closeQuickObatModal = function() {
            $('#quickObatModal').addClass('hidden');
        }

        window.refreshObatData = function() {
            return $.get("{{ route('obat.index') }}?json=1", function(data) {
                window.obatInfo = data;
                
                // Update the hidden select options
                const select = $('#modal_obat_id');
                const currentValue = select.val();
                
                select.empty().append('<option value="" disabled>-- Pilih Obat --</option>');
                data.forEach(o => {
                    select.append(`<option value="${o.id}">${o.nama_obat} (Stok: ${o.stok} ${o.satuan})</option>`);
                });
                
                // Refresh searchable select
                if (window.medicineSearch) {
                    window.medicineSearch.setValue(currentValue);
                    window.medicineSearch.refresh();
                }
            });
        }

        window.addQuickObat = function() {
            const id = $('#modal_obat_id').val();
            const count = $('#modal_jumlah').val();
            const dose = $('#modal_dosis').val();
            const note = $('#modal_keterangan').val();

            if (!id) {
                Toast.fire({ icon: 'warning', title: 'Pilih obat dulu!' });
                return;
            }

            const drug = window.obatInfo.find(o => o.id == id);
            window.currentQuickObatData.push({
                obat_id: id,
                nama_obat: drug.nama_obat,
                satuan: drug.satuan,
                jumlah: count,
                dosis: dose,
                keterangan: note
            });

            renderQuickObatList();
            
            // Reset fields
            medicineSearch.setValue('');
            $('#modal_jumlah').val(1);
            $('#modal_dosis').val('');
            $('#modal_keterangan').val('');
        }

        window.removeQuickObat = function(index) {
            window.currentQuickObatData.splice(index, 1);
            renderQuickObatList();
        }

        window.renderQuickObatList = function() {
            const list = $('#quickObatList');
            list.empty();

            if (window.currentQuickObatData.length === 0) {
                list.html('<div class="py-4 text-center text-xs text-text-muted italic border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-lg">Belum ada obat</div>');
                return;
            }

            window.currentQuickObatData.forEach((item, idx) => {
                list.append(`
                    <div class="p-2.5 bg-gray-50 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 rounded-xl flex justify-between items-center group hover:border-primary/30 transition-all">
                        <div class="flex-1 min-w-0 pr-2">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <span class="font-bold text-xs text-text-main dark:text-white truncate">${item.nama_obat}</span>
                                <span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-[9px] font-bold rounded capitalize">${item.jumlah} ${item.satuan}</span>
                            </div>
                            <div class="text-[10px] text-text-muted truncate">
                                ${item.dosis || '-'} • ${item.keterangan || '-'}
                            </div>
                        </div>
                        <button onclick="removeQuickObat(${idx})" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>
                `);
            });
        }

        window.saveQuickObat = function() {
            const id = $('#current_sakit_id').val();
            const btn = $('#btnSaveQuick');
            const originalContent = btn.html();

            btn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin">refresh</span> <span>Menyimpan...</span>');

            $.ajax({
                url: `{{ url('sakit') }}/${id}/medicines`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    obat_data: window.currentQuickObatData
                },
                success: function(res) {
                    closeQuickObatModal();
                    Toast.fire({ icon: 'success', title: res.message });
                    // Refresh table without full reload
                    const search = $('#searchInput').val();
                    const filterStatus = $('#filterStatus').val();
                    const page = $('.pagination .active span').text() || 1;
                    fetchData(page, search, filterStatus);
                    
                    // Also refresh medicine data in case they open modal elsewhere
                    window.refreshObatData();
                },
                error: function() {
                    Toast.fire({ icon: 'error', title: 'Gagal menyimpan data.' });
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalContent);
                }
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        function fetchData(page = 1, search = '', filterStatus = '') {
            $.ajax({
                url: "{{ route('sakit.index') }}",
                data: {
                    page: page,
                    search: search,
                    filter_status: filterStatus
                },
                success: function(data) {
                    $('#tableContainer').html(data);
                }
            });
        }

        $('#searchInput').on('keyup', debounce(function() {
            let search = $(this).val();
            let filterStatus = $('#filterStatus').val();
            fetchData(1, search, filterStatus);
        }, 300));

        $('#filterStatus').on('change', function() {
            let search = $('#searchInput').val();
            let filterStatus = $(this).val();
            fetchData(1, search, filterStatus);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#searchInput').val();
            let filterStatus = $('#filterStatus').val();
            fetchData(page, search, filterStatus);
        });
    });
</script>
@endpush
