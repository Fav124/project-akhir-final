package com.example.deisacompose.data.models

import com.google.gson.annotations.SerializedName

data class Angkatan(
    @SerializedName("id") val id: Int,
    @SerializedName("tahun") val tahun: String,
    @SerializedName("nama_angkatan") val namaAngkatan: String
)
