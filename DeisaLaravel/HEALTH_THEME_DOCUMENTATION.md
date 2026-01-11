# Dokumentasi Health Theme CSS

## Panduan Penggunaan Style Health Application

Aplikasi Kesehatan DEISA telah ditingkatkan dengan sistem CSS yang komprehensif, khusus dirancang dengan palet warna hijau dan tema kesehatan yang profesional.

---

## 📁 File CSS yang Ditambahkan

### 1. **health-theme.css**
File utama yang berisi:
- Definisi variabel warna (custom properties)
- Styling global untuk semua elemen
- Komponen navbar, sidebar, cards, buttons, forms, modals, tables
- Utility classes untuk styling cepat

### 2. **health-components.css**
File spesifik yang berisi komponen khusus aplikasi kesehatan:
- Health Statistics Cards
- Patient/Santri Cards
- Medicine/Obat Cards
- Activity Timeline
- Health Status Badges
- Form Elements untuk Health Theme
- Chart Containers
- Action Buttons
- Toast Notifications

---

## 🎨 Palet Warna Kesehatan

### CSS Variables yang Tersedia
```css
--health-primary: #10b981          /* Hijau Utama */
--health-primary-light: #d1fae5    /* Hijau Terang */
--health-primary-dark: #059669     /* Hijau Gelap */
--health-secondary: #14b8a6        /* Hijau Biru */
--health-accent: #06b6d4           /* Cyan Aksen */
--health-success: #10b981          /* Hijau Sukses */
--health-warning: #f59e0b          /* Kuning Peringatan */
--health-danger: #ef4444           /* Merah Bahaya */
--health-info: #3b82f6             /* Biru Informasi */
--health-light: #f0fdf4            /* Latar Terang */
--health-dark: #064e3b             /* Gelap */
--health-gray: #6b7280             /* Abu-abu */
--health-gray-light: #f3f4f6       /* Abu-abu Terang */
```

### Cara Menggunakan Variabel
```html
<!-- Menggunakan variabel dalam HTML class -->
<div class="bg-health-primary">Hijau Utama</div>
<div class="text-health-primary">Teks Hijau</div>
<div class="border-health-primary">Border Hijau</div>
```

---

## 📊 Component Menggunakan Health Theme

### 1. Health Statistics Card
```html
<div class="health-stat-card">
    <div class="stat-icon">📊</div>
    <div class="stat-value">150</div>
    <div class="stat-label">Total Santri</div>
    <div class="stat-change">↑ 12% dari minggu lalu</div>
</div>
```

### 2. Patient/Santri Card
```html
<div class="patient-card">
    <div style="display: flex; align-items: center;">
        <div class="patient-avatar">AB</div>
        <div class="patient-info">
            <div class="patient-name">Ahmad Burhan</div>
            <div class="patient-detail">Kelas: X TKJ</div>
            <div class="patient-detail">No Induk: 001234</div>
        </div>
    </div>
</div>
```

### 3. Health Status Badge
```html
<span class="health-status sehat">✓ Sehat</span>
<span class="health-status sakit">✗ Sakit</span>
<span class="health-status darurat">⚠ Darurat</span>
<span class="health-status pemulihan">→ Pemulihan</span>
<span class="health-status pemeriksaan">🔍 Pemeriksaan</span>
```

### 4. Medicine/Obat Card
```html
<div class="medicine-card">
    <div class="medicine-icon">💊</div>
    <div class="medicine-name">Paracetamol</div>
    <div class="medicine-info">Tablet - 500mg</div>
    <div class="medicine-stock">Stok: 150</div>
</div>
```

### 5. Activity Timeline
```html
<div class="timeline">
    <div class="timeline-item active">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
            <div class="timeline-time">14:30 - 15:45</div>
            <div class="timeline-title">Pemeriksaan Awal</div>
            <div class="timeline-description">Pemeriksaan kesehatan rutin oleh dr. Siti</div>
        </div>
    </div>
</div>
```

### 6. Form Elements
```html
<div class="form-group-health">
    <label class="form-label-health">Nama Pasien</label>
    <input type="text" class="form-input-health" placeholder="Masukkan nama">
</div>

<div class="form-group-health">
    <label class="form-label-health">Diagnosis</label>
    <select class="form-select-health">
        <option>Pilih diagnosis...</option>
    </select>
</div>

<div class="form-group-health">
    <label class="form-label-health">Catatan</label>
    <textarea class="form-input-health form-textarea-health"></textarea>
</div>
```

### 7. Action Buttons
```html
<button class="btn-health btn-health-primary">Simpan</button>
<button class="btn-health btn-health-secondary">Batal</button>
<button class="btn-health btn-health-danger">Hapus</button>
<button class="btn-health btn-health-success">Setuju</button>

<!-- Size Variants -->
<button class="btn-health btn-health-primary btn-health-sm">Kecil</button>
<button class="btn-health btn-health-primary btn-health-lg">Besar</button>
```

### 8. Tables
```html
<table class="table-health">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Ahmad Burhan</td>
            <td><span class="health-status sehat">Sehat</span></td>
            <td class="action-cell">
                <button class="btn-health btn-health-sm btn-health-primary">Edit</button>
            </td>
        </tr>
    </tbody>
</table>
```

---

## 🎯 Utility Classes

### Text Colors
```html
<p class="text-health-primary">Teks Hijau Utama</p>
<p class="text-health-success">Teks Sukses</p>
<p class="text-health-danger">Teks Bahaya</p>
<p class="text-health-warning">Teks Peringatan</p>
<p class="text-health-info">Teks Informasi</p>
```

### Background Colors
```html
<div class="bg-health-primary">Latar Hijau Utama</div>
<div class="bg-health-primary-light">Latar Hijau Terang</div>
<div class="bg-health-light">Latar Terang</div>
<div class="bg-health-dark">Latar Gelap</div>
```

### Border Utilities
```html
<div class="border-health-primary">Border Hijau</div>
<div class="border-left-health-primary">Border Kiri Hijau</div>
<div class="border-top-health-primary">Border Atas Hijau</div>
```

### Shadows
```html
<div class="shadow-health">Shadow Normal</div>
<div class="shadow-health-lg">Shadow Besar</div>
```

### Animations
```html
<div class="animate-slide-down">Geser dari Atas</div>
<div class="animate-slide-up">Geser dari Bawah</div>
<div class="animate-fade-in">Fade In</div>
```

---

## 📱 Responsive Design

Semua komponen sudah dirancang untuk responsive di perangkat mobile:
- **Desktop (> 768px)**: Layout penuh dengan sidebar
- **Tablet (768px - 480px)**: Komponen menyesuaikan
- **Mobile (< 480px)**: Layout optimized untuk sentuhan

```html
<!-- Responsive Grid -->
<div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    <div class="health-stat-card">...</div>
    <div class="health-stat-card">...</div>
    <div class="health-stat-card">...</div>
</div>
```

---

## ✨ Best Practices

### 1. Kombinasi Class yang Umum
```html
<!-- Card dengan styling lengkap -->
<div class="card shadow-health">
    <div class="card-header bg-health-primary text-white">
        <h5>Judul</h5>
    </div>
    <div class="card-body">
        Konten di sini
    </div>
</div>
```

### 2. Form dengan Validasi
```html
<div class="form-group-health">
    <label class="form-label-health">Email</label>
    <input type="email" class="form-input-health" required>
    <small class="text-health-danger">Email harus valid</small>
</div>
```

### 3. Alert Styling
```html
<div class="alert alert-success">
    <div class="alert-heading">Berhasil!</div>
    Data telah disimpan dengan sukses.
</div>
```

### 4. Modal Dialog
```html
<div class="modal-health" id="myModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi</h5>
        </div>
        <div class="modal-body">Apakah Anda yakin?</div>
        <div class="modal-footer">
            <button class="btn-health btn-health-secondary">Batal</button>
            <button class="btn-health btn-health-danger">Hapus</button>
        </div>
    </div>
</div>
```

---

## 🔄 Integrasi dengan Blade Templates

### Di Dalam Blade View
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-health-primary mb-4">Dashboard Kesehatan</h1>
    
    <div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <div class="health-stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ $total_santri }}</div>
            <div class="stat-label">Total Santri</div>
        </div>
        
        <div class="health-stat-card">
            <div class="stat-icon">🏥</div>
            <div class="stat-value">{{ $santri_sakit }}</div>
            <div class="stat-label">Santri Sakit</div>
        </div>
    </div>
    
    @foreach($santri as $item)
    <div class="patient-card">
        <div style="display: flex; align-items: center;">
            <div class="patient-avatar">{{ substr($item->nama, 0, 1) }}</div>
            <div class="patient-info">
                <div class="patient-name">{{ $item->nama }}</div>
                <div class="patient-detail">{{ $item->kelas }}</div>
                <span class="health-status sehat">✓ Sehat</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
```

---

## 🎨 Customization

Jika ingin mengubah warna, edit CSS variables di `:root` dalam file:
- `resources/css/health-theme.css` (baris 14-26)

Contoh:
```css
:root {
    --health-primary: #10b981;        /* Ubah ke warna pilihan Anda */
    --health-secondary: #14b8a6;
    /* ... */
}
```

---

## 📚 Referensi Warna untuk Kesehatan

### Status Pasien
- **Sehat**: Hijau (#10b981)
- **Sakit**: Merah (#ef4444)
- **Darurat**: Merah gelap dengan animasi (#ef4444)
- **Pemulihan**: Kuning (#f59e0b)
- **Pemeriksaan**: Biru (#3b82f6)

### Action Buttons
- **Simpan/Setuju**: Hijau
- **Batal**: Abu-abu
- **Hapus/Bahaya**: Merah
- **Edit**: Biru

---

## ❓ Troubleshooting

### CSS Tidak Terbaca
Pastikan link di `<head>` benar:
```html
<link rel="stylesheet" href="{{ asset('css/health-theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/health-components.css') }}">
```

### Build CSS Tailwind (jika menggunakan)
Jika project menggunakan Tailwind CSS, pastikan CSS files di-import sebelum `@tailwind`:
```css
@import 'health-theme.css';
@import 'health-components.css';
@tailwind base;
@tailwind components;
@tailwind utilities;
```

---

## 📞 Support

Untuk pertanyaan atau perbaikan, hubungi tim development.

---

**Last Updated**: January 2026
**Version**: 1.0
**Theme**: Health Application (Green Color Scheme)
