package com.example.deisacompose.data.network

import com.example.deisacompose.data.models.*
import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    // Auth
    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(@Header("Authorization") token: String): Response<ApiResponse>

    @GET("user")
    suspend fun getUser(@Header("Authorization") token: String): Response<UserResponse>

    @POST("register")
    suspend fun register(@Body request: RegisterRequest): Response<ApiResponse>

    // Santri
    @GET("santri")
    suspend fun getSantri(
        @Header("Authorization") token: String, 
        @Query("page") page: Int? = null
    ): Response<SantriListResponse>

    @GET("santri/{id}")
    suspend fun getSantriDetail(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<SantriDetailResponse>

    // Sakit
    @GET("sakit")
    suspend fun getSakit(@Header("Authorization") token: String): Response<SakitResponse>

    @POST("sakit")
    suspend fun storeSakit(
        @Header("Authorization") token: String,
        @Body request: SakitRequest
    ): Response<ApiResponse>

    @GET("sakit/{id}")
    suspend fun getSakitDetail(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<SakitDetailResponse>

    // Obat
    @GET("obat")
    suspend fun getObat(
        @Header("Authorization") token: String,
        @Query("page") page: Int? = null
    ): Response<ObatListResponse>
    
    @POST("obat")
    suspend fun storeObat(
        @Header("Authorization") token: String,
        @Body request: ObatRequest
    ): Response<ApiResponse>

    // Laporan
    @GET("laporan/summary")
    suspend fun getLaporanSummary(
        @Header("Authorization") token: String,
        @Query("start_date") startDate: String?,
        @Query("end_date") endDate: String?
    ): Response<LaporanSummaryResponse>
    // ==================
    // USERS (Admin Only)
    // ==================
    @GET("users")
    suspend fun getUsers(@Header("Authorization") token: String): Response<List<User>> // Assuming list response

    @POST("users")
    suspend fun createUser(
        @Header("Authorization") token: String, 
        @Body request: RegisterRequest // Reusing RegisterRequest as it has same fields
    ): Response<ApiResponse>
    
    @PUT("users/{id}")
    suspend fun updateUser(
        @Header("Authorization") token: String,
        @Path("id") id: Int,
        @Body request: RegisterRequest
    ): Response<ApiResponse>

    @DELETE("users/{id}")
    suspend fun deleteUser(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ApiResponse>

    // ==================
    // KELAS & JURUSAN
    // ==================
    @GET("kelas")
    suspend fun getKelas(@Header("Authorization") token: String): Response<KelasResponse> // Using wrapper

    @POST("kelas")
    suspend fun storeKelas(@Header("Authorization") token: String, @Body request: KelasRequest): Response<ApiResponse>
    
    @PUT("kelas/{id}")
    suspend fun updateKelas(@Header("Authorization") token: String, @Path("id") id: Int, @Body request: KelasRequest): Response<ApiResponse>
    
    @DELETE("kelas/{id}")
    suspend fun deleteKelas(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    @GET("jurusan")
    suspend fun getJurusan(@Header("Authorization") token: String): Response<JurusanResponse> 

    @POST("jurusan")
    suspend fun storeJurusan(@Header("Authorization") token: String, @Body request: JurusanRequest): Response<ApiResponse>
    
    @PUT("jurusan/{id}")
    suspend fun updateJurusan(@Header("Authorization") token: String, @Path("id") id: Int, @Body request: JurusanRequest): Response<ApiResponse>
    
    @DELETE("jurusan/{id}")
    suspend fun deleteJurusan(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    // ==================
    // SANTRI (Full CRUD)
    // ==================
    @POST("santri")
    suspend fun storeSantri(@Header("Authorization") token: String, @Body request: SantriRequest): Response<ApiResponse>
    
    @PUT("santri/{id}")
    suspend fun updateSantri(@Header("Authorization") token: String, @Path("id") id: Int, @Body request: SantriRequest): Response<ApiResponse>
    
    @DELETE("santri/{id}")
    suspend fun deleteSantri(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    // ==================
    // SAKIT & DIAGNOSIS
    // ==================
    @PUT("sakit/{id}")
    suspend fun updateSakit(@Header("Authorization") token: String, @Path("id") id: Int, @Body request: SakitRequest): Response<ApiResponse>
    
    @DELETE("sakit/{id}")
    suspend fun deleteSakit(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    @GET("diagnosis")
    suspend fun getDiagnosis(@Header("Authorization") token: String): Response<List<Diagnosis>> // Assuming list
    
    @POST("diagnosis")
    suspend fun storeDiagnosis(@Header("Authorization") token: String, @Body request: DiagnosisRequest): Response<ApiResponse>

    // ==================
    // OBAT
    // ==================
    @PUT("obat/{id}")
    suspend fun updateObat(@Header("Authorization") token: String, @Path("id") id: Int, @Body request: ObatRequest): Response<ApiResponse>
    
    @DELETE("obat/{id}")
    suspend fun deleteObat(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    // ==================
    // HISTORY
    // ==================
    @GET("history")
    suspend fun getHistory(
        @Header("Authorization") token: String,
        @Query("page") page: Int? = 1
    ): Response<HistoryResponse>
}
