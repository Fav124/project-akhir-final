<!-- 
    DEISA Health Application - HTML/Blade Code Snippets
    Snippets siap pakai untuk berbagai komponen
-->

<!-- ====================================================
    1. STATISTICS DASHBOARD GRID
    ==================================================== -->

<!-- Snippet: Statistics Cards Grid -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
    <div class="health-stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value">{{ $total_santri ?? 0 }}</div>
        <div class="stat-label">Total Santri</div>
        <div class="stat-change">↑ {{ $new_santri ?? 0 }} baru</div>
    </div>

    <div class="health-stat-card">
        <div class="stat-icon">🏥</div>
        <div class="stat-value">{{ $sakit ?? 0 }}</div>
        <div class="stat-label">Dalam Perawatan</div>
        <div class="stat-change">{{ $today_new ?? 0 }} hari ini</div>
    </div>

    <div class="health-stat-card">
        <div class="stat-icon">💊</div>
        <div class="stat-value">{{ $total_obat ?? 0 }}</div>
        <div class="stat-label">Jenis Obat</div>
        <div class="stat-change">{{ $low_stock ?? 0 }} stok rendah</div>
    </div>

    <div class="health-stat-card">
        <div class="stat-icon">📈</div>
        <div class="stat-value">98%</div>
        <div class="stat-label">Tingkat Pemulihan</div>
        <div class="stat-change">↑ 2% bulan ini</div>
    </div>
</div>

<!-- ====================================================
    2. PATIENT LIST WITH STATUS
    ==================================================== -->

<!-- Snippet: Patient List -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Daftar Santri Sakit</h5>
    </div>
    <div class="card-body">
        @forelse($santri_sakit as $item)
        <div class="patient-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; flex: 1;">
                    <div class="patient-avatar">{{ substr($item->nama, 0, 1) }}</div>
                    <div class="patient-info">
                        <div class="patient-name">{{ $item->nama }}</div>
                        <div class="patient-detail">Kelas: {{ $item->kelas }}</div>
                        <div class="patient-detail">📍 {{ $item->asrama }}</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    @if($item->status === 'sakit')
                        <span class="health-status sakit">Sakit</span>
                    @elseif($item->status === 'pemulihan')
                        <span class="health-status pemulihan">Pemulihan</span>
                    @elseif($item->status === 'darurat')
                        <span class="health-status darurat">Darurat</span>
                    @else
                        <span class="health-status sehat">Sehat</span>
                    @endif
                    <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.5rem;">
                        {{ $item->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-state-icon">😊</div>
            <div class="empty-state-title">Tidak Ada Data Sakit</div>
            <div class="empty-state-message">Semua santri dalam kondisi sehat</div>
        </div>
        @endforelse
    </div>
</div>

<!-- ====================================================
    3. MEDICINE INVENTORY GRID
    ==================================================== -->

<!-- Snippet: Medicine Stock Grid -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Inventaris Obat</h5>
    </div>
    <div class="card-body">
        <div style="display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            @foreach($obat as $item)
            <div class="medicine-card">
                <div class="medicine-icon">💊</div>
                <div class="medicine-name">{{ $item->nama }}</div>
                <div class="medicine-info">{{ $item->jenis }} - {{ $item->dosis }}</div>
                <div class="medicine-stock {{ $item->stok <= 10 ? 'critical' : ($item->stok <= 50 ? 'low' : '') }}">
                    Stok: {{ $item->stok }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ====================================================
    4. FORM DENGAN STYLING HEALTH THEME
    ==================================================== -->

<!-- Snippet: Patient Form -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Input Data Santri Sakit</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('web.sakit.store') }}" method="POST">
            @csrf
            
            <div class="form-group-health">
                <label class="form-label-health">Nama Santri *</label>
                <select class="form-select-health" name="santri_id" required>
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santri as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; gap: 1.5rem; grid-template-columns: 1fr 1fr;">
                <div class="form-group-health">
                    <label class="form-label-health">Tanggal Sakit *</label>
                    <input type="date" class="form-input-health" name="tanggal_sakit" required>
                </div>

                <div class="form-group-health">
                    <label class="form-label-health">Status *</label>
                    <select class="form-select-health" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="sakit">Sakit</option>
                        <option value="pemeriksaan">Pemeriksaan</option>
                        <option value="pemulihan">Pemulihan</option>
                        <option value="darurat">Darurat</option>
                    </select>
                </div>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Diagnosis *</label>
                <select class="form-select-health" name="diagnosis_id" required>
                    <option value="">-- Pilih Diagnosis --</option>
                    @foreach($diagnosis as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Gejala/Keluhan</label>
                <textarea class="form-input-health form-textarea-health" name="gejala" placeholder="Deskripsikan gejala yang dialami..."></textarea>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Resep Obat</label>
                <div style="display: grid; gap: 0.75rem;">
                    @foreach($obat as $item)
                    <div class="form-check-health">
                        <input type="checkbox" class="form-check-input-health" id="obat_{{ $item->id }}" name="obat_ids[]" value="{{ $item->id }}">
                        <label for="obat_{{ $item->id }}" style="margin-left: 0.5rem;">
                            {{ $item->nama }} ({{ $item->jenis }})
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Catatan Dokter</label>
                <textarea class="form-input-health form-textarea-health" name="catatan" placeholder="Catatan tambahan..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-health btn-health-primary">
                    💾 Simpan Data
                </button>
                <a href="javascript:history.back()" class="btn-health btn-health-secondary">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
            @csrf
            
            <div class="form-group-health">
                <label class="form-label-health">Nama Santri *</label>
                <select class="form-select-health" name="santri_id" required>
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santri as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; gap: 1.5rem; grid-template-columns: 1fr 1fr;">
                <div class="form-group-health">
                    <label class="form-label-health">Tanggal Sakit *</label>
                    <input type="date" class="form-input-health" name="tanggal_sakit" required>
                </div>

                <div class="form-group-health">
                    <label class="form-label-health">Status *</label>
                    <select class="form-select-health" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="sakit">Sakit</option>
                        <option value="pemeriksaan">Pemeriksaan</option>
                        <option value="pemulihan">Pemulihan</option>
                        <option value="darurat">Darurat</option>
                    </select>
                </div>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Diagnosis *</label>
                <select class="form-select-health" name="diagnosis_id" required>
                    <option value="">-- Pilih Diagnosis --</option>
                    @foreach($diagnosis as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Gejala/Keluhan</label>
                <textarea class="form-input-health form-textarea-health" name="gejala" placeholder="Deskripsikan gejala yang dialami..."></textarea>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Resep Obat</label>
                <div style="display: grid; gap: 0.75rem;">
                    @foreach($obat as $item)
                    <div class="form-check-health">
                        <input type="checkbox" class="form-check-input-health" id="obat_{{ $item->id }}" name="obat_ids[]" value="{{ $item->id }}">
                        <label for="obat_{{ $item->id }}" style="margin-left: 0.5rem;">
                            {{ $item->nama }} ({{ $item->jenis }})
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group-health">
                <label class="form-label-health">Catatan Dokter</label>
                <textarea class="form-input-health form-textarea-health" name="catatan" placeholder="Catatan tambahan..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn-health btn-health-primary">
                    💾 Simpan Data
                </button>
                <a href="javascript:history.back()" class="btn-health btn-health-secondary">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ====================================================
    5. TABLE DENGAN DATA
    ==================================================== -->

<!-- Snippet: Data Table -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Daftar Catatan Sakit</h5>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table class="table-health w-full">
            <thead>
                <tr>
                    <th>Nama Santri</th>
                    <th>Diagnosis</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($catatan_sakit as $item)
                <tr>
                    <td><strong>{{ $item->santri->nama }}</strong></td>
                    <td>{{ $item->diagnosis->nama }}</td>
                    <td>
                        @if($item->status === 'sakit')
                            <span class="health-status sakit">Sakit</span>
                        @elseif($item->status === 'pemulihan')
                            <span class="health-status pemulihan">Pemulihan</span>
                        @elseif($item->status === 'darurat')
                            <span class="health-status darurat">⚠ Darurat</span>
                        @else
                            <span class="health-status sehat">Sehat</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="action-cell">
                        @if(Route::has('web.sakit.show'))
                        <a href="{{ route('web.sakit.show', $item->id) }}" class="btn-health btn-health-sm btn-health-primary">
                            👁️ Lihat
                        </a>
                        @endif
                        @if(Route::has('web.sakit.edit'))
                        <a href="{{ route('web.sakit.edit', $item->id) }}" class="btn-health btn-health-sm btn-health-secondary">
                            ✏️ Edit
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem;">
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <div class="empty-state-title">Tidak Ada Data</div>
                            <div class="empty-state-message">Belum ada catatan sakit</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ====================================================
    6. ALERT NOTIFICATIONS
    ==================================================== -->

<!-- Snippet: Alert Messages -->
@if(session('success'))
<div class="alert alert-success" style="margin-bottom: 1.5rem;">
    <div class="alert-heading">✓ Berhasil!</div>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="margin-bottom: 1.5rem;">
    <div class="alert-heading">✗ Error!</div>
    {{ session('error') }}
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning" style="margin-bottom: 1.5rem;">
    <div class="alert-heading">⚠ Perhatian!</div>
    {{ session('warning') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" style="margin-bottom: 1.5rem;">
    <div class="alert-heading">Terdapat Kesalahan:</div>
    <ul style="margin: 0.5rem 0 0 1.5rem;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- ====================================================
    7. BUTTONS VARIATIONS
    ==================================================== -->

<!-- Snippet: Button Variations -->
<div style="display: flex; gap: 1rem; flex-wrap: wrap;">
    <!-- Primary Button -->
    <button class="btn-health btn-health-primary">
        💾 Simpan
    </button>

    <!-- Primary Small -->
    <button class="btn-health btn-health-primary btn-health-sm">
        💾 Simpan Kecil
    </button>

    <!-- Primary Large -->
    <button class="btn-health btn-health-primary btn-health-lg">
        💾 Simpan Besar
    </button>

    <!-- Success Button -->
    <button class="btn-health btn-health-success">
        ✓ Setuju
    </button>

    <!-- Danger Button -->
    <button class="btn-health btn-health-danger">
        🗑️ Hapus
    </button>

    <!-- Secondary Button -->
    <button class="btn-health btn-health-secondary">
        ← Batal
    </button>
</div>

<!-- ====================================================
    8. MODAL CONFIRMATION
    ==================================================== -->

<!-- Snippet: Confirmation Modal -->
<div class="modal-health" id="confirmModal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Penghapusan</h5>
            <button type="button" class="btn-close" onclick="closeModal('confirmModal')"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <p style="color: #ef4444; font-weight: 600;">⚠️ Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-health btn-health-secondary" onclick="closeModal('confirmModal')">
                Batal
            </button>
            <button type="button" class="btn-health btn-health-danger" id="confirmDeleteBtn">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- ====================================================
    9. TIMELINE
    ==================================================== -->

<!-- Snippet: Activity Timeline -->
<div class="card shadow-health">
    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);">
        <h5 style="color: white; margin: 0;">Riwayat Aktivitas</h5>
    </div>
    <div class="card-body">
        <div class="timeline">
            @foreach($activities as $activity)
            <div class="timeline-item active">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-time">
                        {{ $activity->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="timeline-title">
                        {{ $activity->title }}
                    </div>
                    <div class="timeline-description">
                        {{ $activity->description }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ====================================================
    10. EMPTY STATE
    ==================================================== -->

<!-- Snippet: Empty State -->
<div class="empty-state">
    <div class="empty-state-icon">📋</div>
    <div class="empty-state-title">Tidak Ada Data</div>
    <div class="empty-state-message">Belum ada data untuk ditampilkan</div>
    <div style="margin-top: 1.5rem;">
        @if(Route::has('web.sakit.create'))
        <a href="{{ route('web.sakit.create') }}" class="btn-health btn-health-primary">
            ➕ Tambah Data Baru
        </a>
        @endif
    </div>
</div>

<!-- ====================================================
    11. LOADING SKELETON
    ==================================================== -->

<!-- Snippet: Loading Skeleton -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(4, 1fr);">
    @for($i = 0; $i < 4; $i++)
    <div class="card shadow-health">
        <div class="skeleton-card"></div>
    </div>
    @endfor
</div>

<!-- ====================================================
    12. RESPONSIVE GRID
    ==================================================== -->

<!-- Snippet: Responsive Grid -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    <div class="card shadow-health">Kolom 1</div>
    <div class="card shadow-health">Kolom 2</div>
    <div class="card shadow-health">Kolom 3</div>
    <div class="card shadow-health">Kolom 4</div>
</div>

<!-- ====================================================
    JAVASCRIPT HELPERS (Copy ke file JS)
    ==================================================== -->

<script>
// Modal Functions
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Toast Notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-health ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Confirm Delete
function confirmDelete(deleteUrl) {
    const modal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    modal.style.display = 'flex';
    confirmBtn.onclick = () => {
        window.location.href = deleteUrl;
    };
}

// Loading State
function setLoading(buttonId, isLoading = true) {
    const btn = document.getElementById(buttonId);
    if (isLoading) {
        btn.disabled = true;
        btn.innerHTML = '⏳ Memproses...';
    } else {
        btn.disabled = false;
        btn.innerHTML = '💾 Simpan';
    }
}
</script>

<!-- ====================================================
    END OF SNIPPETS
    ==================================================== -->
