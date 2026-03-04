# Dokumentasi Hak Akses

Dokumen ini menjelaskan pemisahan peran antara aplikasi website Laravel dan aplikasi Android DEISA.

## Ringkasan Peran

- `Admin` menggunakan **Website Laravel** untuk manajemen sistem dan kontrol data tingkat global.
- `Petugas` menggunakan **Aplikasi Android** untuk operasional harian layanan kesehatan santri.

## Hak Akses Admin (Website Laravel)

Admin mengakses fitur melalui modul `admin/*` pada website:

- Dashboard admin dan statistik keseluruhan.
- Persetujuan akun petugas (`pending -> active`).
- Manajemen user (approve, hapus user).
- CRUD master data:
  - Kelas
  - Jurusan
  - Data santri
  - Data obat
  - Data sakit
- Laporan, ekspor, dan aktivitas sistem.
- Monitoring notifikasi sistem (stok obat menipis, lonjakan kasus, dll).

## Hak Akses Petugas (Android)

Petugas mengakses API operasional via aplikasi Android:

- Login/logout akun petugas.
- Melihat dashboard operasional (`/api/dashboard`).
- Melihat data santri dan detail santri.
- Mengelola data sakit santri.
- Mengelola data obat.
- Membuat laporan operasional dari aplikasi.

Batasan penting:

- Aplikasi Android hanya ditujukan untuk role `petugas`.
- Jika role `admin` login dari Android, aplikasi menolak akses dan mengarahkan admin untuk menggunakan website.
- Endpoint admin-only (`/api/admin/*`) tidak dipakai untuk alur petugas Android.

## Matriks Akses Fitur

| Fitur | Admin Web | Petugas Android |
|---|---|---|
| Login | Ya | Ya |
| Dashboard operasional | Ya | Ya |
| Dashboard admin penuh | Ya | Tidak |
| Approve user | Ya | Tidak |
| Manajemen user | Ya | Tidak |
| Data santri | Ya | Ya |
| Data sakit | Ya | Ya |
| Data obat | Ya | Ya |
| Master kelas/jurusan | Ya | Tidak |
| Laporan | Ya | Ya |

## Endpoint API yang Dipakai Android (Petugas)

- `POST /api/login`
- `POST /api/register`
- `POST /api/logout`
- `GET /api/user`
- `GET /api/dashboard`
- `GET /api/santri`
- `GET /api/santri/{id}`
- `GET /api/sakit`
- `POST /api/sakit`
- `PUT /api/sakit/{id}`
- `DELETE /api/sakit/{id}`
- `GET /api/obat`
- `POST /api/obat`
- `PUT /api/obat/{id}`
- `DELETE /api/obat/{id}`

## Catatan Implementasi

- Role user disimpan di sisi Android untuk validasi sesi.
- Status persetujuan akun (`active/pending`) tetap dikontrol admin melalui website.
- Branding Android sudah diselaraskan dengan website (palet DEISA biru-hijau, gaya kartu putih, copy operasional petugas).
