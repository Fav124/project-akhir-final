package com.example.deisa.models

import com.google.gson.annotations.SerializedName

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

data class LoginResponse(
    val success: Boolean,
    val message: String,
    val data: LoginData
)

data class LoginData(
    val user: User,
    val token: String,
    @SerializedName("token_type") val tokenType: String
)

data class User(
    val id: Int,
    val name: String,
    val email: String,
    val role: String? = null,
    val foto: String? = null,
    val phone: String? = null,
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

data class SantriSearchResponse(
    val success: Boolean,
    val data: List<Santri>
)

data class SantriResponse(
    val data: List<Santri>
)

data class Santri(
    val id: Int,
    val nis: String? = null,
    @SerializedName("nama_lengkap") val namaLengkap: String? = null,
    val nama: String? = null, // Fallback
    val foto: String? = null,
    @SerializedName("kelas_id") val kelasId: Int? = null,
    val kelas: Kelas? = null,
    @SerializedName("status_kesehatan") val statusKesehatan: String? = null
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

data class JurusanResponse(
    val success: Boolean,
    val data: List<Jurusan>
)

data class Diagnosis(
    val id: Int,
    @SerializedName("nama_penyakit") val namaPenyakit: String?,
    @SerializedName("deskripsi") val deskripsi: String? = null
)

data class DiagnosisResponse(
    val success: Boolean,
    val data: List<Diagnosis>
)

data class ActivityLog(
    val id: Int,
    @SerializedName("description") val description: String?,
    @SerializedName("action") val action: String?,
    @SerializedName("created_at") val createdAt: String?,
    val user: User?
)

data class HistoryResponse(
    @SerializedName("data") val data: List<ActivityLog>,
    @SerializedName("current_page") val currentPage: Int,
    @SerializedName("last_page") val lastPage: Int
)

data class PaginationMeta(
    @SerializedName("current_page") val currentPage: Int,

    @SerializedName("last_page") val lastPage: Int,
    @SerializedName("per_page") val perPage: Int,
    val total: Int
)

data class KelasResponse(
    val success: Boolean,
    val data: List<Kelas>
)

// ==================
// SAKIT
// ==================
data class SakitResponse(
    val data: List<Sakit>
)

data class SakitDetailResponse(
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
    @SerializedName("tanggal_mulai_sakit") val tanggalMulaiSakit: String,
    val keluhan: String? = null,
    val diagnosis: String? = null,
    val gejala: String? = null,
    val tindakan: String? = null,
    @SerializedName("tingkat_kondisi") val tingkatKondisi: String? = null,
    val status: String? = "sakit",
    @SerializedName("obat_ids") val obatIds: List<Int>? = null
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

data class ExpiringObatResponse(
    val success: Boolean,
    val data: ExpiringData
)

data class ExpiringData(
    @SerializedName("expiring_soon") val expiringSoon: List<Obat>,
    val expired: List<Obat>
)

data class Obat(
    val id: Int,
    @SerializedName("nama_obat") val namaObat: String,
    val foto: String? = null,
    val deskripsi: String? = null,
    val stok: Int,
    val satuan: String? = null,
    @SerializedName("stok_minimum") val stokMinimum: Int? = null,
    @SerializedName("harga_satuan") val hargaSatuan: Double? = null,
    @SerializedName("tanggal_kadaluarsa") val tanggalKadaluarsa: String? = null,
    val alerts: ObatAlerts? = null
)

data class ObatAlerts(
    @SerializedName("low_stock") val lowStock: Boolean,
    @SerializedName("expiring_soon") val expiringSoon: Boolean,
    val expired: Boolean
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
    val deskripsi: String? = null,
    val stok: Int,
    val satuan: String,
    @SerializedName("stok_minimum") val stokMinimum: Int? = null,
    @SerializedName("harga_satuan") val hargaSatuan: Double? = null,
    @SerializedName("tanggal_kadaluarsa") val tanggalKadaluarsa: String? = null
)

// ==================
// LAPORAN (Reports)
// ==================
data class LaporanSummaryResponse(
    val success: Boolean,
    val data: LaporanData
)

data class LaporanData(
    val period: LaporanPeriod,
    val summary: LaporanSummary,
    @SerializedName("top_santri") val topSantri: List<TopSantri>,
    @SerializedName("top_obat") val topObat: List<TopObat>,
    @SerializedName("obat_alerts") val obatAlerts: ObatAlertsCount
)

data class LaporanPeriod(
    val from: String,
    val to: String
)

data class LaporanSummary(
    @SerializedName("total_sakit") val totalSakit: Int,
    @SerializedName("unique_santri_sakit") val uniqueSantriSakit: Int,
    @SerializedName("currently_sick") val currentlySick: Int,
    @SerializedName("by_tingkat") val byTingkat: TingkatBreakdown
)

data class TingkatBreakdown(
    val ringan: Int,
    val sedang: Int,
    val berat: Int
)

data class TopSantri(
    val id: Int,
    val nis: String?,
    @SerializedName("nama_lengkap") val namaLengkap: String,
    val foto: String?,
    @SerializedName("nama_kelas") val namaKelas: String?,
    @SerializedName("sakit_count") val sakitCount: Int
)

data class TopObat(
    val id: Int,
    @SerializedName("nama_obat") val namaObat: String,
    val satuan: String?,
    @SerializedName("times_used") val timesUsed: Int,
    @SerializedName("total_quantity") val totalQuantity: Int
)

data class ObatAlertsCount(
    @SerializedName("expiring_soon") val expiringSoon: Int,
    @SerializedName("low_stock") val lowStock: Int,
    val expired: Int
)

data class LaporanMonthlyResponse(
    val success: Boolean,
    val data: MonthlyData
)

data class MonthlyData(
    val year: Int,
    val statistics: List<MonthStat>
)

data class MonthStat(
    val month: Int,
    @SerializedName("month_name") val monthName: String,
    val total: Int,
    @SerializedName("unique_santri") val uniqueSantri: Int
)
