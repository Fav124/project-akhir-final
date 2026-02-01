package com.example.deisacompose.data.models

import com.google.gson.annotations.SerializedName

data class Santri(
    val id: Int,
    val nis: String,
    @SerializedName("nama_lengkap") val nama_lengkap: String,
    @SerializedName("jenis_kelamin") val jenis_kelamin: String,
    @SerializedName("tempat_lahir") val tempat_lahir: String,
    @SerializedName("tanggal_lahir") val tanggal_lahir: String,
    val alamat: String,
    @SerializedName("nama_wali") val nama_wali: String,
    @SerializedName("no_hp_wali") val no_hp_wali: String,
    val status: String,
    val kelas: KelasInfo?,
    val jurusan: JurusanInfo?
)

data class KelasInfo(
    val id: Int,
    @SerializedName("nama_kelas") val nama_kelas: String
)

data class JurusanInfo(
    val id: Int,
    @SerializedName("nama_jurusan") val nama_jurusan: String
)

data class Kelas(
    val id: Int,
    @SerializedName("nama_kelas") val nama_kelas: String,
    val tingkat: String?
)

data class Jurusan(
    val id: Int,
    @SerializedName("nama_jurusan") val nama_jurusan: String,
    val kode: String?
)

data class Sakit(
    val id: Int,
    val santri: SantriInfo,
    @SerializedName("diagnosis_utama") val diagnosis_utama: String,
    val keluhan: String?,
    val tindakan: String?,
    val status: String,
    @SerializedName("tanggal_masuk") val tanggal_masuk: String,
    @SerializedName("tanggal_masuk_human") val tanggal_masuk_human: String? = null
)

data class SantriInfo(
    val id: Int,
    @SerializedName("nama_lengkap") val nama_lengkap: String,
    val kelas: KelasInfo?
)

data class Obat(
    val id: Int,
    @SerializedName("nama_obat") val nama_obat: String,
    val jenis: String,
    val stok: Int,
    val satuan: String,
    val keterangan: String?,
    @SerializedName("is_low_stock") val is_low_stock: Boolean = false
)

data class PendingUser(
    val id: Int,
    val name: String,
    val email: String,
    val role: String,
    @SerializedName("created_at") val created_at: String
)
