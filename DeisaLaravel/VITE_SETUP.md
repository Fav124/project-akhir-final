# Setup Vite & Realtime untuk DEISA Laravel

## 🚀 Quick Start

### 1. Install Dependencies
```bash
cd DeisaLaravel
npm install
```

### 2. Jalankan Development Server

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server (HMR):**
```bash
npm run dev
```

Vite akan berjalan di `http://localhost:5173` dengan Hot Module Replacement (HMR) aktif.

### 3. Build untuk Production
```bash
npm run build
```

## 📦 Fitur Realtime

Aplikasi sudah terintegrasi dengan sistem realtime menggunakan polling:

### Dashboard Stats (Auto-update setiap 30 detik)
Dashboard stats akan otomatis update setiap 30 detik tanpa reload halaman.

### Realtime Search (Debounce 300ms)
Search input dengan `data-realtime-search="true"` akan otomatis search dengan debounce.

### Table Updates (Auto-refresh setiap 1 menit)
Tabel dengan `data-realtime-table` akan otomatis refresh setiap 1 menit.

### Notifikasi Badge (Auto-update setiap 15 detik)
Badge notifikasi akan otomatis update setiap 15 detik.

## 🔧 Konfigurasi

### Vite Config (`vite.config.js`)
- **HMR**: Aktif di development
- **Port**: 5173
- **Watch**: Auto-reload saat file berubah
- **Refresh**: Auto-refresh Blade views

### Realtime Config (`resources/js/realtime.js`)
- **Dashboard Stats**: Update setiap 30 detik
- **Notifications**: Update setiap 15 detik
- **Tables**: Update setiap 60 detik

## 📝 Penggunaan di View

### 1. Dashboard dengan Stats Realtime
```blade
<div data-realtime-stats="{{ route('admin.dashboard.stats') }}">
    <div data-stat="totalPasienHariIni">0</div>
    <div data-stat="totalSakit">0</div>
</div>
```

### 2. Realtime Search
```blade
<input type="text" 
       data-realtime-search="true"
       data-search-target="#table-container"
       data-search-url="{{ route('admin.santri.index') }}">
```

### 3. Realtime Table
```blade
<table id="santri-table" 
       data-realtime-table="#santri-table"
       data-realtime-url="{{ route('admin.santri.index') }}"
       data-realtime-interval="60000">
    <!-- Table content -->
</table>
```

### 4. Notification Badge
```blade
<span data-notification-badge>0</span>
```

## 🎨 Animasi & Transitions

Semua update realtime menggunakan smooth fade transitions:
- **Fade Out**: 0.3s opacity
- **Content Update**
- **Fade In**: 0.3s opacity

## 🔍 Troubleshooting

### Vite tidak connect?
1. Pastikan Vite dev server berjalan: `npm run dev`
2. Cek browser console untuk error
3. Pastikan `APP_URL` di `.env` sesuai

### Realtime tidak update?
1. Cek browser console untuk error
2. Pastikan route API tersedia
3. Cek network tab untuk request response

### HMR tidak bekerja?
1. Pastikan Vite server berjalan di port 5173
2. Cek firewall/network settings
3. Restart Vite server: `npm run dev`

## 📚 File Structure

```
resources/
├── js/
│   ├── app.js          # Main entry point
│   ├── bootstrap.js    # Axios setup
│   ├── ajax.js         # AJAX utilities
│   ├── realtime.js     # Realtime updater classes
│   └── santri-js.js    # Santri-specific JS
├── css/
│   ├── app.css         # Main Tailwind CSS
│   └── health-theme.css # Custom theme
└── views/
    └── layouts/
        ├── app.blade.php   # Main layout (uses @vite)
        └── admin.blade.php # Admin layout (extends app)
```

## ✅ Checklist

- [x] Vite config dengan HMR
- [x] Realtime stats updater
- [x] Realtime search dengan debounce
- [x] Realtime table refresh
- [x] Notification badge updater
- [x] Smooth animations
- [x] Error handling

## 🎯 Next Steps

Untuk meningkatkan performa realtime:
1. Implement WebSocket (Laravel Echo + Pusher)
2. Add Service Worker untuk offline support
3. Optimize polling intervals
4. Add caching untuk API responses
