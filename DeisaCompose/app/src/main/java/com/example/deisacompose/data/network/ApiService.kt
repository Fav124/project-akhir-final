package com.example.deisacompose.data.network

import com.example.deisacompose.data.models.*
import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    // ================= AUTH =================
    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @POST("register")
    suspend fun register(@Body request: RegisterRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(): Response<ApiResponse<Unit>>

    @GET("user")
    suspend fun getCurrentUser(): Response<ApiResponse<User>>

    @POST("forgot-password")
    suspend fun forgotPassword(@Body email: Map<String, String>): Response<ApiResponse<Unit>>

    @POST("reset-password")
    suspend fun resetPassword(@Body request: Map<String, String>): Response<ApiResponse<Unit>>

    // ================= ADMIN =================
    @GET("admin/dashboard")
    suspend fun getAdminDashboard(): Response<ApiResponse<DashboardData>>

    @GET("admin/users/pending")
    suspend fun getPendingUsers(): Response<ApiResponse<List<PendingUser>>>

    @POST("admin/users/{id}/approve")
    suspend fun approveUser(@Path("id") id: Int): Response<ApiResponse<Unit>>

    @DELETE("admin/users/{id}")
    suspend fun deleteUser(@Path("id") id: Int): Response<ApiResponse<Unit>>

    @GET("admin/activities")
    suspend fun getActivities(
        @Query("per_page") perPage: Int = 20,
        @Query("page") page: Int = 1
    ): Response<ApiResponse<Unit>>

    @GET("admin/notifications")
    suspend fun getNotifications(): Response<ApiResponse<Unit>>

    // ================= SANTRI =================
    @GET("santri")
    suspend fun getSantri(
        @Query("search") search: String? = null,
        @Query("kelas_id") kelasId: Int? = null,
        @Query("jurusan_id") jurusanId: Int? = null,
        @Query("per_page") perPage: Int = 20,
        @Query("page") page: Int = 1
    ): Response<ApiResponse<List<Santri>>>

    @GET("santri/{id}")
    suspend fun getSantriById(@Path("id") id: Int): Response<ApiResponse<Santri>>

    @POST("santri")
    suspend fun createSantri(@Body santri: Map<String, Any>): Response<ApiResponse<Santri>>

    @PUT("santri/{id}")
    suspend fun updateSantri(
        @Path("id") id: Int,
        @Body santri: Map<String, Any>
    ): Response<ApiResponse<Santri>>

    @DELETE("santri/{id}")
    suspend fun deleteSantri(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // ================= SAKIT =================
    @GET("sakit")
    suspend fun getSakit(
        @Query("status") status: String? = null,
        @Query("search") search: String? = null,
        @Query("per_page") perPage: Int = 20,
        @Query("page") page: Int = 1
    ): Response<ApiResponse<List<Sakit>>>

    @GET("sakit/{id}")
    suspend fun getSakitById(@Path("id") id: Int): Response<ApiResponse<Sakit>>

    @POST("sakit")
    suspend fun createSakit(@Body sakit: Map<String, Any>): Response<ApiResponse<Sakit>>

    @PUT("sakit/{id}")
    suspend fun updateSakit(
        @Path("id") id: Int,
        @Body sakit: Map<String, Any>
    ): Response<ApiResponse<Sakit>>

    @DELETE("sakit/{id}")
    suspend fun deleteSakit(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // ================= OBAT =================
    @GET("obat")
    suspend fun getObat(
        @Query("search") search: String? = null,
        @Query("low_stock") lowStock: Boolean? = null,
        @Query("per_page") perPage: Int = 20,
        @Query("page") page: Int = 1
    ): Response<ApiResponse<List<Obat>>>

    @GET("obat/{id}")
    suspend fun getObatById(@Path("id") id: Int): Response<ApiResponse<Obat>>

    @POST("obat")
    suspend fun createObat(@Body obat: Map<String, Any>): Response<ApiResponse<Obat>>

    @PUT("obat/{id}")
    suspend fun updateObat(
        @Path("id") id: Int,
        @Body obat: Map<String, Any>
    ): Response<ApiResponse<Obat>>

    @POST("obat/{id}/restock")
    suspend fun restockObat(
        @Path("id") id: Int,
        @Body jumlah: Map<String, Int>
    ): Response<ApiResponse<Obat>>

    @DELETE("obat/{id}")
    suspend fun deleteObat(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // ================= KELAS =================
    @GET("kelas")
    suspend fun getKelas(): Response<ApiResponse<List<Kelas>>>

    @GET("kelas/{id}")
    suspend fun getKelasById(@Path("id") id: Int): Response<ApiResponse<Kelas>>

    @POST("kelas")
    suspend fun createKelas(@Body kelas: Map<String, String>): Response<ApiResponse<Kelas>>

    @PUT("kelas/{id}")
    suspend fun updateKelas(
        @Path("id") id: Int,
        @Body kelas: Map<String, String>
    ): Response<ApiResponse<Kelas>>

    @DELETE("kelas/{id}")
    suspend fun deleteKelas(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // ================= JURUSAN =================
    @GET("jurusan")
    suspend fun getJurusan(): Response<ApiResponse<List<Jurusan>>>

    @GET("jurusan/{id}")
    suspend fun getJurusanById(@Path("id") id: Int): Response<ApiResponse<Jurusan>>

    @POST("jurusan")
    suspend fun createJurusan(@Body jurusan: Map<String, String>): Response<ApiResponse<Jurusan>>

    @PUT("jurusan/{id}")
    suspend fun updateJurusan(
        @Path("id") id: Int,
        @Body jurusan: Map<String, String>
    ): Response<ApiResponse<Jurusan>>

    @DELETE("jurusan/{id}")
    suspend fun deleteJurusan(@Path("id") id: Int): Response<ApiResponse<Unit>>
}
