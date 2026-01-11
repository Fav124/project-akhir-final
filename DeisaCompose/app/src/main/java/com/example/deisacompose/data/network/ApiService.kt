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

    @POST("santri")
    suspend fun storeSantri(
        @Header("Authorization") token: String, 
        @Body request: SantriRequest
    ): Response<ApiResponse>
    
    @PUT("santri/{id}")
    suspend fun updateSantri(
        @Header("Authorization") token: String, 
        @Path("id") id: Int, 
        @Body request: SantriRequest
    ): Response<ApiResponse>
    
    @DELETE("santri/{id}")
    suspend fun deleteSantri(
        @Header("Authorization") token: String, 
        @Path("id") id: Int
    ): Response<ApiResponse>

    // Sakit
    @GET("sakit")
    suspend fun getSakit(@Header("Authorization") token: String): Response<SakitResponse>

    @POST("sakit")
    suspend fun storeSakit(
        @Header("Authorization") token: String,
        @Body request: SakitRequest
    ): Response<ApiResponse>

    @POST("sakit/{id}/sembuh")
    suspend fun markSembuh(
        @Header("Authorization") token: String,
        @Path("id") id: Int
    ): Response<ApiResponse>

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

    @PUT("obat/{id}")
    suspend fun updateObat(
        @Header("Authorization") token: String, 
        @Path("id") id: Int, 
        @Body request: ObatRequest
    ): Response<ApiResponse>
    
    @DELETE("obat/{id}")
    suspend fun deleteObat(
        @Header("Authorization") token: String, 
        @Path("id") id: Int
    ): Response<ApiResponse>

    // Laporan
    @GET("laporan/summary")
    suspend fun getLaporanSummary(
        @Header("Authorization") token: String,
        @Query("start_date") startDate: String?,
        @Query("end_date") endDate: String?
    ): Response<LaporanSummaryResponse>

    // Master Data
    @GET("jurusans")
    suspend fun getJurusans(@Header("Authorization") token: String): Response<JurusanResponse> 

    @POST("jurusans")
    suspend fun storeJurusan(@Header("Authorization") token: String, @Body request: JurusanRequest): Response<ApiResponse>
    
    @DELETE("jurusans/{id}")
    suspend fun deleteJurusan(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    @GET("kelas")
    suspend fun getKelas(@Header("Authorization") token: String): Response<KelasResponse>

    @POST("kelas")
    suspend fun storeKelas(@Header("Authorization") token: String, @Body request: KelasRequest): Response<ApiResponse>
    
    @DELETE("kelas/{id}")
    suspend fun deleteKelas(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    @GET("diagnosis")
    suspend fun getDiagnosis(@Header("Authorization") token: String): Response<List<Diagnosis>> 
    
    @POST("diagnosis")
    suspend fun storeDiagnosis(@Header("Authorization") token: String, @Body request: DiagnosisRequest): Response<ApiResponse>
    
    @DELETE("diagnosis/{id}")
    suspend fun deleteDiagnosis(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    // Users
    @GET("users")
    suspend fun getUsers(@Header("Authorization") token: String): Response<List<User>>

    @DELETE("users/{id}")
    suspend fun deleteUser(@Header("Authorization") token: String, @Path("id") id: Int): Response<ApiResponse>

    // History
    @GET("history")
    suspend fun getHistory(
        @Header("Authorization") token: String,
        @Query("page") page: Int? = 1
    ): Response<HistoryResponse>
    // --- Admin & Logs ---
    @GET("api/admin/registrations")
    suspend fun getPendingRegistrations(): Response<DataResponse<List<RegistrationRequest>>>

    @POST("api/admin/registrations/{id}/approve")
    suspend fun approveRegistration(@Path("id") id: Int): Response<MessageResponse>

    @POST("api/admin/registrations/{id}/reject")
    suspend fun rejectRegistration(@Path("id") id: Int): Response<MessageResponse>

    @GET("api/admin/users")
    suspend fun getUsers(): Response<DataResponse<List<User>>>

    @DELETE("api/admin/users/{id}")
    suspend fun deleteUser(@Path("id") id: Int): Response<MessageResponse>

    @GET("api/logs")
    suspend fun getLogs(@Query("limit") limit: Int = 50): Response<PaginationResponse<ActivityLog>>

    @POST("api/logs")
    suspend fun createLog(@Body log: Map<String, String>): Response<DataResponse<ActivityLog>>
}
