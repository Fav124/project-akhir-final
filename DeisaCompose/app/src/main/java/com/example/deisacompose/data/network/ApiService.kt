package com.example.deisacompose.data.network

import com.example.deisacompose.data.models.*
import retrofit2.Response
import retrofit2.http.*
import okhttp3.MultipartBody
import okhttp3.RequestBody

interface ApiService {

    // ================= AUTH =================
    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(): Response<ApiResponse>

    @POST("register")
    suspend fun register(@Body request: RegisterRequest): Response<MessageResponse>

    @GET("user")
    suspend fun getProfile(): Response<UserResponse>

    // ================= SANTRI =================
    @GET("santri")
    suspend fun getSantri(@Query("page") page: Int = 1, @Query("per_page") perPage: Int = 10, @Query("search") search: String? = null): Response<SantriListResponse>

    @GET("santri/{id}")
    suspend fun getSantriById(@Path("id") id: Int): Response<SantriDetailResponse>

    @Multipart
    @POST("santri")
    suspend fun createSantri(@PartMap partMap: Map<String, @JvmSuppressWildcards RequestBody>, @Part foto: MultipartBody.Part? = null): Response<ApiResponse>

    @Multipart
    @POST("santri/{id}")
    suspend fun updateSantri(@Path("id") id: Int, @PartMap partMap: Map<String, @JvmSuppressWildcards RequestBody>, @Part foto: MultipartBody.Part? = null): Response<ApiResponse>

    @DELETE("santri/{id}")
    suspend fun deleteSantri(@Path("id") id: Int): Response<ApiResponse>

    // ================= OBAT =================
    @GET("v1/obat")
    suspend fun getObat(@Query("page") page: Int = 1, @Query("per_page") perPage: Int = 10, @Query("search") search: String? = null, @Query("all") all: Boolean? = null): Response<ObatListResponse>

    @GET("v1/obat/{id}")
    suspend fun getObatById(@Path("id") id: Int): Response<ObatDetailResponse>

    @Multipart
    @POST("v1/obat")
    suspend fun createObat(@PartMap partMap: Map<String, @JvmSuppressWildcards RequestBody>, @Part foto: MultipartBody.Part? = null): Response<ApiResponse>

    @Multipart
    @POST("v1/obat/{id}")
    suspend fun updateObat(@Path("id") id: Int, @PartMap partMap: Map<String, @JvmSuppressWildcards RequestBody>, @Part foto: MultipartBody.Part? = null): Response<ApiResponse>

    @DELETE("v1/obat/{id}")
    suspend fun deleteObat(@Path("id") id: Int): Response<ApiResponse>

    // ================= SAKIT =================
    @GET("sakit")
    suspend fun getSakit(@Query("page") page: Int = 1, @Query("per_page") perPage: Int = 10, @Query("search") search: String? = null): Response<SakitResponse>

    @GET("sakit/{id}")
    suspend fun getSakitById(@Path("id") id: Int): Response<SakitDetailResponse>

    @POST("sakit")
    suspend fun createSakit(@Body sakit: SakitRequest): Response<ApiResponse>

    @PUT("sakit/{id}")
    suspend fun updateSakit(@Path("id") id: Int, @Body sakit: SakitRequest): Response<ApiResponse>

    @DELETE("sakit/{id}")
    suspend fun deleteSakit(@Path("id") id: Int): Response<ApiResponse>

    @POST("sakit/{id}/sembuh")
    suspend fun markAsSembuh(@Path("id") id: Int): Response<ApiResponse>

    // ================= MANAGEMENT =================
    @GET("management/users")
    suspend fun getUsers(): Response<DataResponse<List<User>>>

    @DELETE("management/users/{id}")
    suspend fun deleteUser(@Path("id") id: Int): Response<ApiResponse>
    
    @GET("management/pending-registrations")
    suspend fun getPendingRegistrations(): Response<DataResponse<List<RegistrationRequest>>>
    
    @POST("management/approve/{id}")
    suspend fun approveRegistration(@Path("id") id: Int): Response<ApiResponse>

    @POST("management/reject/{id}")
    suspend fun rejectRegistration(@Path("id") id: Int): Response<ApiResponse>

    @GET("management/kelas")
    suspend fun getKelas(): Response<KelasResponse>

    @POST("management/kelas")
    suspend fun addKelas(@Body request: KelasRequest): Response<ApiResponse>

    @DELETE("management/kelas/{id}")
    suspend fun deleteKelas(@Path("id") id: Int): Response<ApiResponse>

    @GET("management/jurusan")
    suspend fun getJurusan(): Response<JurusanResponse>

    @POST("management/jurusan")
    suspend fun addJurusan(@Body request: JurusanRequest): Response<ApiResponse>

    @DELETE("management/jurusan/{id}")
    suspend fun deleteJurusan(@Path("id") id: Int): Response<ApiResponse>

    @GET("management/diagnosis")
    suspend fun getDiagnosis(): Response<DataResponse<List<Diagnosis>>>
    
    @POST("management/diagnosis")
    suspend fun addDiagnosis(@Body request: DiagnosisRequest): Response<ApiResponse>
    
    @DELETE("management/diagnosis/{id}")
    suspend fun deleteDiagnosis(@Path("id") id: Int): Response<ApiResponse>
    
    @GET("management/history")
    suspend fun getHistory(): Response<HistoryResponse>
    
    @GET("management/angkatan")
    suspend fun getAngkatan(): Response<DataResponse<List<Angkatan>>>

    // ================= LAPORAN =================
    @GET("laporan/summary")
    suspend fun getLaporanSummary(): Response<LaporanSummaryResponse>
}