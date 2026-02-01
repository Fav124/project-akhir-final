package com.example.deisacompose.data.models

import com.google.gson.annotations.SerializedName

data class DashboardData(
    val stats: DashboardStats,
    @SerializedName("chart_data") val chartData: List<ChartPoint>,
    @SerializedName("recent_activities") val recentActivities: List<ActivityItem>
)

data class DashboardStats(
    @SerializedName("total_santri") val totalSantri: Int,
    @SerializedName("total_sakit") val totalSakit: Int,
    @SerializedName("total_obat") val totalObat: Int,
    @SerializedName("obat_hampir_habis") val obatHampirHabis: Int,
    @SerializedName("pending_users") val pendingUsers: Int
)

data class ChartPoint(
    val date: String,
    val label: String,
    val count: Int
)

data class ActivityItem(
    val id: Int,
    @SerializedName("user_name") val userName: String,
    val action: String,
    val description: String,
    @SerializedName("created_at") val createdAt: String
)

data class Notification(
    val id: String,
    val type: String, // "warning", "danger", "info"
    val title: String,
    val message: String,
    val action: String,
    @SerializedName("created_at") val createdAt: String
)
