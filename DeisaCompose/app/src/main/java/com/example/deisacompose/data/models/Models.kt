package com.example.deisacompose.data.models

import com.google.gson.annotations.SerializedName

// ==================
// GENERIC RESPONSES
// ==================
data class DataResponse<T>(val data: T)
data class MessageResponse(val message: String)
data class PaginationResponse<T>(val data: List<T>, val meta: PaginationMeta)


// ==================
// AUTH
// ==================
data class LoginRequest(
    val email: String,
    val password: String,
    @SerializedName("device_name") val deviceName: String = "android-app"
)

data class RegisterRequest(
    val name: String,
    val email: String,
    val password: String,
    @SerializedName("device_name") val deviceName: String = "android-app",
    @SerializedName("google_id") val googleId: String? = null,
    val avatar: String? = null
)

data class RegistrationRequest(
    val id: Int,
    val name: String,
    val email: String,
    @SerializedName("created_at") val createdAt: String
)

data class LoginResponse(
    val success: Boolean,
    val message: String,
    val data: LoginData
)

data class LoginData(
    val user: User,
    val token: String,
    @SerializedName("token_type") val tokenType: String? = "Bearer"
)

data class User(
    val id: Int,
    val name: String,
    val email: String,
    val role: String? = null,
    val foto: String? = null,
    val phone: String? = null,
    val status: String? = null,
    @SerializedName("is_admin") val isAdmin: Boolean = false
)

data class UserResponse(
    val success: Boolean,
    val data: User
)

data class ApiResponse(
    val success: Boolean? = null,
    val message: String,
    val status: Boolean? = null
)

// ==================
// SANTRI
// ==================
data class SantriListResponse(
    val success: Boolean,
    val data: List<Santri>,
    val meta: PaginationMeta?
)

data class SantriDetailResponse(
    val success: Boolean,
    val data: SantriDetail
)

data class Wali(
    @SerializedName("nama_wali") val namaWali: String,
    val hubungan: String,
    @SerializedName("no_hp") val noHp: String
)

data class Santri(
    val id: Int,
    val nis: String? = null,
    @SerializedName("nama_lengkap") val namaLengkap: String? = null,
    val nama: String? = null, // Fallback
    val foto: String? = null,
    @SerializedName("kelas_id") val kelasId: Int? = null,
    val kelas: Kelas? = null,
    @SerializedName("jurusan_id") val jurusanId: Int? = null,
    val jurusan: Jurusan? = null,
    @SerializedName("status_kesehatan") val statusKesehatan: String? = null,
    @SerializedName("jenis_kelamin") val jenisKelamin: String? = null,
    @SerializedName("tempat_lahir") val tempatLahir: String? = null,
    @SerializedName("tanggal_lahir") val tanggalLahir: String? = null,
    val alamat: String? = null,
    @SerializedName("golongan_darah") val golonganDarah: String? = null,
    val wali: Wali? = null
) {
    fun displayName(): String = namaLengkap ?: nama ?: "Unknown"
    fun displayKelas(): String = kelas?.namaKelas ?: "-"
}

data class SantriDetail(
    val santri: Santri,
    val statistics: SantriStats?,
    @SerializedName("recent_sick_records") val recentSickRecords: List<Sakit>?
)

data class SantriStats(
    @SerializedName("total_sick_records") val totalSickRecords: Int,
    @SerializedName("currently_sick") val currentlySick: Boolean
)

data class Kelas(
    val id: Int,
    @SerializedName("nama_kelas") val namaKelas: String?
)

data class Jurusan(
    val id: Int,
    @SerializedName("nama_jurusan") val namaJurusan: String?
)

data class Diagnosis(
    val id: Int,
    @SerializedName("nama_penyakit") val namaPenyakit: String?,
    @SerializedName("deskripsi") val deskripsi: String? = null
)

data class ActivityLog(
    val id: Int,
    @SerializedName("description") val description: String?,
    @SerializedName("action") val action: String?,
    @SerializedName("created_at") val createdAt: String?,
    val user: User?
)

data class PaginationMeta(
    @SerializedName("current_page") val currentPage: Int,
    @SerializedName("last_page") val lastPage: Int,
    @SerializedName("per_page") val perPage: Int,
    val total: Int
)

// ==================
// SAKIT
// ==================
data class SakitResponse(
    val success: Boolean,
    val data: List<Sakit>,
    val meta: PaginationMeta? = null
)

data class SakitDetailResponse(
    val success: Boolean,
    val data: Sakit
)

data class Sakit(
    val id: Int,
    @SerializedName("santri_id") val santriId: Int,
    @SerializedName("tanggal_mulai_sakit") val tanggalMulaiSakit: String? = null,
    @SerializedName("tanggal_sakit") val tanggalSakit: String? = null,
    @SerializedName("tanggal_selesai_sakit") val tanggalSelesaiSakit: String? = null,
    val keluhan: String? = null,
    val diagnosis: String? = null,
    val gejala: String? = null,
    val tindakan: String? = null,
    @SerializedName("tingkat_kondisi") val tingkatKondisi: String? = null,
    val status: String? = null,
    val catatan: String? = null,
    val santri: Santri? = null,
    val obats: List<Obat>? = null
) {
    fun displayDate(): String = tanggalMulaiSakit ?: tanggalSakit ?: "-"
    fun displayStatus(): String = tingkatKondisi ?: status ?: "-"
}

data class SakitRequest(
    @SerializedName("santri_id") val santriId: Int,
    @SerializedName("tgl_masuk") val tglMasuk: String,
    val status: String,
    @SerializedName("jenis_perawatan") val jenisPerawatan: String,
    @SerializedName("tujuan_rujukan") val tujuanRujukan: String? = null,
    val gejala: String,
    val tindakan: String,
    val catatan: String? = null,
    @SerializedName("diagnosis_ids") val diagnosisIds: List<Int>? = emptyList(),
    @SerializedName("obat_usage") val obatUsage: List<ObatUsageRequest>? = emptyList(),
    @SerializedName("keluhan") val keluhan: String? = null // For backward compatibility
)

data class ObatUsageRequest(
    @SerializedName("obat_id") val obatId: Int,
    val jumlah: Int
)

// ==================
// OBAT (Medicine)
// ==================
data class ObatListResponse(
    val success: Boolean,
    val data: List<Obat>,
    val meta: PaginationMeta?
)

data class ObatDetailResponse(
    val success: Boolean,
    val data: ObatDetail
)

data class Obat(
    val id: Int,
    @SerializedName("nama_obat") val namaObat: String,
    val kategori: String? = null,
    val foto: String? = null,
    val deskripsi: String? = null,
    val stok: Int,
    val satuan: String? = null,
    @SerializedName("stok_minimum") val stokMinimum: Int? = null,
    @SerializedName("harga_satuan") val harga: Double? = null,
    @SerializedName("tanggal_kadaluarsa") val tglKadaluarsa: String? = null,
    @SerializedName("lokasi_penyimpanan") val lokasiPenyimpanan: String? = null
)

data class ObatDetail(
    val obat: Obat,
    val statistics: ObatStats?,
    @SerializedName("purchase_history") val purchaseHistory: List<ObatHistory>?
)

data class ObatStats(
    @SerializedName("usage_count") val usageCount: Int,
    @SerializedName("total_used") val totalUsed: Int
)

data class ObatHistory(
    val id: Int,
    @SerializedName("tanggal_pembelian") val tanggalPembelian: String,
    val jumlah: Int,
    val supplier: String?,
    val keterangan: String?
)

data class ObatRequest(
    @SerializedName("nama_obat") val namaObat: String,
    @SerializedName("nama") val nama: String? = null, // Fallback for some API versions
    val kategori: String,
    val deskripsi: String? = null,
    val stok: Int,
    @SerializedName("stok_awal") val stokAwal: Int? = null,
    val satuan: String,
    @SerializedName("stok_minimum") val stokMinimum: Int? = null,
    @SerializedName("harga_satuan") val harga: Double? = null,
    @SerializedName("tanggal_kadaluarsa") val tglKadaluarsa: String? = null,
    @SerializedName("lokasi_penyimpanan") val lokasiPenyimpanan: String? = null
)

// ==================
// LAPORAN
// ==================
data class LaporanSummaryResponse(
    val success: Boolean,
    val data: LaporanData
)

data class LaporanData(
    val summary: LaporanSummary,
    @SerializedName("top_santri") val topSantri: List<TopSantri>,
    @SerializedName("top_obat") val topObat: List<TopObat>
)

data class LaporanSummary(
    @SerializedName("total_sakit") val totalSakit: Int,
    @SerializedName("unique_santri_sakit") val uniqueSantriSakit: Int,
    @SerializedName("currently_sick") val currentlySick: Int,
    @SerializedName("by_tingkat") val byTingkat: TingkatBreakdown
)

data class TingkatBreakdown(
    @SerializedName("ringan") val ringan: Int = 0,
    @SerializedName("sedang") val sedang: Int = 0,
    @SerializedName("berat") val berat: Int = 0
)

data class KelasRequest(@SerializedName("nama_kelas") val namaKelas: String)
data class JurusanRequest(@SerializedName("nama_jurusan") val namaJurusan: String)
data class DiagnosisRequest(@SerializedName("nama_penyakit") val namaPenyakit: String, val deskripsi: String?)

data class KelasResponse(val success: Boolean, val data: List<Kelas>)
data class JurusanResponse(val success: Boolean, val data: List<Jurusan>)

data class SantriRequest(
    val nis: String,
    @SerializedName("nama_lengkap") val namaLengkap: String,
    @SerializedName("nama") val nama: String? = null,
    @SerializedName("kelas_id") val kelasId: Int,
    @SerializedName("jurusan_id") val jurusanId: Int? = null,
    @SerializedName("tempat_lahir") val tempatLahir: String? = null,
    @SerializedName("tanggal_lahir") val tanggalLahir: String? = null,
    @SerializedName("jenis_kelamin") val jenisKelamin: String = "L",
    val alamat: String? = null,
    @SerializedName("status_kesehatan") val statusKesehatan: String = "Sehat",
    @SerializedName("riwayat_alergi") val riwayatAlergi: String? = null,
    @SerializedName("golongan_darah") val golonganDarah: String? = null,
    @SerializedName("nama_wali") val namaWali: String? = null,
    @SerializedName("no_telp_wali") val noTelpWali: String? = null,
    @SerializedName("no_hp_wali") val noHpWali: String? = null,
    @SerializedName("hubungan_wali") val hubunganWali: String? = null,
    @SerializedName("pekerjaan_wali") val pekerjaanWali: String? = null,
    @SerializedName("alamat_wali") val alamatWali: String? = null
)

data class HistoryResponse(
    val success: Boolean,
    val data: HistoryData
)

data class HistoryData(
    val data: List<ActivityLog>,
    @SerializedName("current_page") val currentPage: Int,
    @SerializedName("last_page") val lastPage: Int
)

data class TopSantri(
    val id: Int,
    val nis: String?,
    @SerializedName("nama_lengkap") val namaLengkap: String,
    @SerializedName("sakit_count") val sakitCount: Int
)

data class TopObat(
    val id: Int,
    @SerializedName("nama_obat") val namaObat: String,
    @SerializedName("times_used") val timesUsed: Int,
    @SerializedName("total_quantity") val totalQuantity: Int
)
