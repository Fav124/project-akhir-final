package com.example.deisacompose.data.network

import android.content.Context
import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ApiClient {
    // IMPORTANT: For Emulator use "http://10.0.2.2:8000/api/"
    // For Physical Device, use your machine's local IP, e.g., "http://192.168.1.5:8000/api/"
    private const val BASE_URL = "http://10.0.2.2:8000/api/"
    
    private lateinit var sessionManager: SessionManager

    fun initialize(context: Context) {
        sessionManager = SessionManager(context)
    }

    val instance: ApiService by lazy {
        val logging = HttpLoggingInterceptor().apply {
            level = HttpLoggingInterceptor.Level.BODY
        }

        val authInterceptor = AuthInterceptor(sessionManager)

        val httpClient = OkHttpClient.Builder()
            .addInterceptor(logging)
            .addInterceptor(authInterceptor)
            .build()

        val retrofit = Retrofit.Builder()
            .baseUrl(BASE_URL)
            .addConverterFactory(GsonConverterFactory.create())
            .client(httpClient)
            .build()

        retrofit.create(ApiService::class.java)
    }

    fun getSessionManager(): SessionManager = sessionManager
}