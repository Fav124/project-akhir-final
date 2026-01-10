package com.example.deisa.network

import com.example.deisa.models.*
import retrofit2.Response
import retrofit2.http.*

interface ApiService {
    // ==================
    // AUTH
    // ==================
    @POST("login")
    suspend fun login(@Body loginRequest: LoginRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(@Header("Authorization") token: String): Response<ApiResponse>

    @GET("user")
    suspend fun getUser(@Header("Authorization") token: String): Response<UserResponse>

    // ==================
    // SANTRI
    // ==================
    @GET("santri")
    suspend fun getSantri(
        @Header("Authorization") token: String,
        @Query("search") search: String? = null,
        @Query("per_page") perPage: Int? = null
    ): Response<SantriListResponse>

    @GET("santri/{id}")
    suspend fun getSantriDetail(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<SantriDetailResponse>

    @GET("santri/search")
    suspend fun searchSantri(
        @Header("Authorization") token: String,
        @Query("q") query: String
    ): Response<SantriSearchResponse>

    // ==================
    // SAKIT
    // ==================
    @GET("sakit")
    suspend fun getSakit(
        @Header("Authorization") token: String
    ): Response<SakitResponse>

    @GET("sakit/{id}")
    suspend fun getSakitDetail(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<SakitDetailResponse>

    @POST("sakit")
    suspend fun storeSakit(
        @Header("Authorization") token: String,
        @Body sakitRequest: SakitRequest
    ): Response<ApiResponse>

    @PUT("sakit/{id}")
    suspend fun updateSakit(
        @Header("Authorization") token: String,
        @Path("id") id: Int,
        @Body sakitRequest: SakitRequest
    ): Response<ApiResponse>

    @DELETE("sakit/{id}")
    suspend fun deleteSakit(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ApiResponse>

    @PUT("sakit/{id}/sembuh")
    suspend fun markRecovered(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ApiResponse>

    // ==================
    // OBAT (Medicine)
    // ==================
    @GET("obats")
    suspend fun getObats(
        @Header("Authorization") token: String,
        @Query("search") search: String? = null,
        @Query("low_stock") lowStock: Boolean? = null,
        @Query("expiring_soon") expiringSoon: Boolean? = null
    ): Response<ObatListResponse>

    @GET("obats/{id}")
    suspend fun getObatDetail(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ObatDetailResponse>

    @POST("obats")
    suspend fun storeObat(
        @Header("Authorization") token: String,
        @Body obatRequest: ObatRequest
    ): Response<ApiResponse>

    @PUT("obats/{id}")
    suspend fun updateObat(
        @Header("Authorization") token: String,
        @Path("id") id: Int,
        @Body obatRequest: ObatRequest
    ): Response<ApiResponse>

    @DELETE("obats/{id}")
    suspend fun deleteObat(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ApiResponse>

    @GET("obats/low-stock")
    suspend fun getLowStockObats(
        @Header("Authorization") token: String
    ): Response<ObatListResponse>

    @GET("obats/expiring")
    suspend fun getExpiringObats(
        @Header("Authorization") token: String,
        @Query("days") days: Int? = 30
    ): Response<ExpiringObatResponse>

    // ==================
    // LAPORAN (Reports)
    // ==================
    @GET("laporan/summary")
    suspend fun getLaporanSummary(
        @Header("Authorization") token: String,
        @Query("from") from: String? = null,
        @Query("to") to: String? = null
    ): Response<LaporanSummaryResponse>

    @GET("laporan/monthly")
    suspend fun getLaporanMonthly(
        @Header("Authorization") token: String,
        @Query("year") year: Int? = null
    ): Response<LaporanMonthlyResponse>
}
