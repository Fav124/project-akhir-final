# 📄 Dokumentasi Lengkap Aplikasi DEISA

**DEISA** (*Dar El-Ilmi Kesehatan System*) adalah ekosistem manajemen kesehatan santri yang dirancang untuk Pesantren Dar El-Ilmi. Sistem ini dibangun dengan prinsip MVC, SOLID, dan Agile untuk memastikan keandalan, skalabilitas, dan kemudahan penggunaan.

---

## 🏛️ Arsitektur Sistem

DEISA terdiri dari dua komponen utama yang saling terintegrasi:

1.  **Backend & Web Admin (DeisaLaravel)**:
    -   Dibangun menggunakan **Laravel 12.x**.
    -   Frontend Web menggunakan **Blade**, **Tailwind CSS 4.0**, dan **Alpine.js**.
    -   API RESTful yang diamankan dengan **Laravel Sanctum** (JWT-based logic).
    -   Fitur Real-time didukung oleh **Laravel Reverb**.
2.  **Mobile Application (DeisaCompose)**:
    -   Dibangun menggunakan **Kotlin** dan **Jetpack Compose (Material 3)**.
    -   Mengikuti arsitektur **MVVM** (Model-View-ViewModel).
    -   Komunikasi data menggunakan **Retrofit** & **OkHttp**.

---

## 👥 Peran Pengguna (User Roles)

### 1. Admin
Memiliki kendali penuh atas sistem, termasuk:
-   Manajemen Master Data (Kelas, Jurusan).
-   Manajemen Pengguna (Approving/Rejecting pendaftaran petugas baru).
-   Akses penuh ke semua laporan dan log aktivitas.
-   Proses Akademik (Kenaikan Kelas/Manajemen Semester).

### 2. Petugas (Health Officer)
Fokus pada operasional harian kesehatan:
-   Pencatatan sakit santri (EHR).
-   Manajemen inventaris obat.
-   Melihat dashboard statistik kesehatan.

### 3. User / Pengakses Umum (Internal)
-   Mengisi formulir sakit santri dengan cepat.
-   Melihat riwayat kesehatan mandiri atau terbatas.
-   Melihat daftar obat yang tersedia.

---

## 🌐 Fitur Utama Web Platform

### 📊 Dashboard Eksekutif
-   **Statistik Real-time**: Menampilkan jumlah santri, laporan sakit hari ini, dan peringatan stok obat kritis.
-   **Analitik Grafis**: Visualisasi tren kesehatan bulanan menggunakan **Chart.js**.

### 👨‍🎓 Manajemen Santri
-   **Profil Lengkap**: Data NIS, Nama, Kelas, Jurusan, hingga informasi Wali.
-   **Catatan Medis**: Riwayat alergi, golongan darah, dan catatan kesehatan khusus.

### 🩺 Electronic Health Records (EHR)
-   **Input Diagnosis**: Pencatatan gejala, diagnosis, dan tindakan medis secara detail.
-   **Pelacakan Status**: Status kondisi santri (Sakit, Dirawat, Sembuh).
-   **Export Laporan**: Menghasilkan laporan kesehatan bulanan dalam format **PDF**.

### 💊 Manajemen Inventaris Obat
-   **Pelacakan Stok Otomatis**: Stok berkurang otomatis saat obat diberikan kepada santri.
-   **Log Restock**: Mencatat riwayat penambahan stok obat.
-   **Real-time Stock Warning**: Notifikasi instan saat stok mencapai ambang batas kritis melalui integrasi Laravel Reverb.

### ⚙️ Manajemen Akademik & Sistem
-   **Kenaikan Kelas**: Modul untuk memproses kenaikan kelas santri secara batch.
-   **Log Aktivitas**: Rekaman komprehensif setiap perubahan data penting di sistem.

---

## 📱 Fitur Utama Aplikasi Mobile

### ✨ Modern & Responsive UI
-   **Material You**: Antarmuka bersih yang beradaptasi dengan tema sistem (Dark/Light Mode).
-   **Fluid Transitions**: Navigasi yang halus menggunakan Jetpack Compose Navigation.

### 📝 Alur Pelaporan Cepat
-   **Quick Sick Report**: Petugas dapat melaporkan santri yang sakit langsung dari lapangan tanpa harus membuka laptop.
-   **Smart Search**: Pencarian santri instan berdasarkan Nama atau NIS.

### 💊 Mobile Medicine Tracking
-   **Inventory View**: Melihat ketersediaan obat secara real-time dari aplikasi mobile.
-   **Usage Logging**: Mencatat penggunaan obat secara langsung saat penanganan santri.

### 🔒 Keamanan & Performa
-   **JWT Authentication**: Sesi aman dengan token yang diperbarui secara berkala.
-   **Optimized Loading**: Penggunaan *Skeleton Loading* untuk meningkatkan pengalaman pengguna pada koneksi internet yang lambat.

---

## ⚡ Teknologi Unggulan

-   **Laravel Reverb**: Memungkinkan pembaruan data (seperti stok obat) muncul di layar semua pengguna secara instan tanpa perlu refresh halaman.
-   **Tailwind CSS 4.0**: Memberikan tampilan web yang sangat modern, ringan, dan responsif.
-   **Jetpack Compose**: Teknologi terbaru UI Android untuk performa aplikasi mobile yang maksimal.

---
*Dokumentasi ini dibuat untuk mempermudah pemahaman alur kerja dan fitur yang tersedia dalam ekosistem DEISA.*
