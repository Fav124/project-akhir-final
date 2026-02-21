package com.example.deisacompose.data.repository

import com.example.deisacompose.data.models.*
import com.example.deisacompose.data.network.ApiClient
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class AuthRepository {
    private val api = RetrofitClient.apiService

    suspend fun login(email: String, password: String, remember: Boolean = false): Result<LoginData> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.login(LoginRequest(email, password, remember))
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success) {
                        body.data?.let {
                            // Save token and user info for session persistence
                            RetrofitClient.setAuthToken(it.token)
                            ApiClient.getSessionManager().saveAuthToken(it.token, true)
                            ApiClient.getSessionManager().saveUserRole(it.user.role)
                            ApiClient.getSessionManager().saveUserName(it.user.name)
                            Result.success(it)
                        } ?: Result.failure(Exception("Data tidak valid"))
                    } else {
                        Result.failure(Exception(body.message ?: "Login gagal"))
                    }
                } else {
                    Result.failure(Exception("Login gagal"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun register(
        name: String,
        email: String,
        password: String,
        passwordConfirmation: String,
        role: String
    ): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.register(
                    RegisterRequest(name, email, password, passwordConfirmation, role)
                )
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success) {
                        Result.success(body.message ?: "Registrasi berhasil")
                    } else {
                        Result.failure(Exception(body.message ?: "Registrasi gagal"))
                    }
                } else {
                    Result.failure(Exception("Registrasi gagal"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun logout(): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.logout()
                RetrofitClient.setAuthToken(null)
                if (response.isSuccessful) {
                    Result.success("Logout berhasil")
                } else {
                    Result.failure(Exception("Logout gagal"))
                }
            } catch (e: Exception) {
                RetrofitClient.setAuthToken(null)
                Result.failure(e)
            }
        }
    }

    suspend fun getCurrentUser(): Result<User> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getCurrentUser()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        body.data?.let {
                            Result.success(it)
                        } ?: Result.failure(Exception("User data tidak valid"))
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data user"))
                    }
                } else if (response.code() == 401) {
                    Result.failure(Exception("UNAUTHORIZED"))
                } else {
                    Result.failure(Exception("Gagal mengambil data user"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun forgotPassword(email: String): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.forgotPassword(mapOf("email" to email))
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Link reset dikirim")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal"))
                    }
                } else {
                    Result.failure(Exception("Gagal"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }
}
