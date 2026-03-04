# DEISA HealthOps

> Sistem manajemen kesehatan santri berbasis **Laravel (Web Admin)** + **Android (Petugas Lapangan)** dalam satu monorepo.

![Laravel](https://img.shields.io/badge/Laravel-12-red?logo=laravel)
![Android](https://img.shields.io/badge/Android-Jetpack%20Compose-3DDC84?logo=android)
![Kotlin](https://img.shields.io/badge/Kotlin-1.9+-7F52FF?logo=kotlin)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)
![License](https://img.shields.io/badge/License-MIT-blue)

## Tentang Proyek
DEISA HealthOps adalah platform untuk pengelolaan operasional UKS/santri: data santri, riwayat sakit, obat, kelas, jurusan, laporan, dan aktivitas sistem.

Proyek ini terdiri dari:
- **DeisaLaravel**: aplikasi web admin + API backend.
- **DeisaAndroid**: aplikasi Android untuk petugas kesehatan.

## Fitur Utama
### Web (Laravel)
- Dashboard dan summary operasional.
- CRUD `Santri`, `Sakit`, `Obat`, `Kelas`, `Jurusan`.
- Monitoring santri pulang.
- Manajemen user & persetujuan akun (admin).
- Activity log dan laporan (termasuk export).
- UI admin konsisten dengan komponen card, tabel aksi ikon, dan halaman detail/edit terstruktur.

### Android (Jetpack Compose)
- Login/logout berbasis API.
- Dashboard petugas.
- Daftar dan detail santri.
- Pengelolaan riwayat sakit.
- Pengelolaan obat dan laporan.
- Navigasi modern dengan Compose + Material 3.

## Arsitektur Singkat
```text
project-akhir-final/
├── DeisaLaravel/   # Backend API + Web Admin (Laravel)
└── DeisaAndroid/   # Aplikasi Android (Kotlin + Compose)
```

### Teknologi yang Dipakai
- **Backend/Web**: Laravel 12, Sanctum, Livewire, Vite, MySQL/SQLite, DOMPDF.
- **Android**: Kotlin, Jetpack Compose, Hilt, Retrofit/OkHttp, DataStore, MPAndroidChart.

## Role & Hak Akses
- **Admin (Website)**: kontrol penuh sistem, manajemen user, master data, monitoring & laporan.
- **Petugas (Android)**: operasional harian (santri/sakit/obat/laporan).

Dokumen detail role:
- [DOKUMENTASI_AKSES_ADMIN_WEB_DAN_PETUGAS_ANDROID.md](./DOKUMENTASI_AKSES_ADMIN_WEB_DAN_PETUGAS_ANDROID.md)

## API Overview
Contoh endpoint utama (berbasis token `Sanctum`):
- `POST /api/login`
- `GET /api/user`
- `GET /api/dashboard`
- `GET /api/santri`, `GET /api/santri/{id}`
- `GET/POST/PUT/DELETE /api/sakit`
- `GET/POST/PUT/DELETE /api/obat`
- `GET/POST/PUT/DELETE /api/kelas`
- `GET/POST/PUT/DELETE /api/jurusan`

Referensi route lengkap:
- [DeisaLaravel/routes/web.php](./DeisaLaravel/routes/web.php)
- [DeisaLaravel/routes/api.php](./DeisaLaravel/routes/api.php)

## Quick Start (Laravel)
### 1) Masuk folder backend
```bash
cd DeisaLaravel
```

### 2) Install dependency
```bash
composer install
npm install
```

### 3) Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4) Setup database
Sesuaikan `.env` (MySQL/SQLite), lalu:
```bash
php artisan migrate
```

### 5) Jalankan aplikasi
```bash
php artisan serve
npm run dev
```

Akses web di: `http://127.0.0.1:8000`

## Quick Start (Android)
### 1) Buka project Android
Buka folder `DeisaAndroid` di Android Studio.

### 2) Pastikan base URL API sesuai
Default saat emulator:
- `http://10.0.2.2:8000/api/`

Lokasi konstanta:
- [DeisaAndroid/app/src/main/java/com/example/deisaandroid/util/Constants.kt](./DeisaAndroid/app/src/main/java/com/example/deisaandroid/util/Constants.kt)

### 3) Jalankan app
- Sync Gradle
- Run ke emulator/device

## Catatan Pengembangan
- Semua endpoint sensitif dilindungi autentikasi token (`auth:sanctum`).
- Route admin mobile memakai middleware khusus `admin.api`.
- Proyek aktif dikembangkan dengan pemisahan concern web vs mobile.

## Kontribusi
1. Buat branch fitur baru.
2. Commit dengan pesan jelas.
3. Buat PR dengan ringkasan perubahan + screenshot jika ada perubahan UI.

## Lisensi
Mengikuti lisensi default framework yang digunakan (MIT). Sesuaikan bila diperlukan untuk rilis produksi.
