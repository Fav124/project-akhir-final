package com.example.deisacompose.data.repository

import com.example.deisacompose.data.models.DashboardData
import com.example.deisacompose.data.models.PendingUser
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class AdminRepository {
    private val api = RetrofitClient.apiService

    suspend fun getDashboard(): Result<DashboardData> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getAdminDashboard()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        body.data?.let {
                            Result.success(it)
                        } ?: Result.failure(Exception("Data tidak valid"))
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil dashboard"))
                    }
                } else if (response.code() == 401) {
                    Result.failure(Exception("UNAUTHORIZED"))
                } else {
                    Result.failure(Exception("Gagal mengambil dashboard"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun getPendingUsers(): Result<List<PendingUser>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getPendingUsers()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil pending users"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil pending users"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun approveUser(id: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.approveUser(id)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "User disetujui")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menyetujui user"))
                    }
                } else {
                    Result.failure(Exception("Gagal menyetujui user"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun deleteUser(id: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.deleteUser(id)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "User dihapus")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menghapus user"))
                    }
                } else {
                    Result.failure(Exception("Gagal menghapus user"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun getActivities(perPage: Int = 20, page: Int = 1): Result<Unit> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getActivities(perPage, page)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(Unit)
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil aktivitas"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil aktivitas"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun getNotifications(): Result<Unit> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getNotifications()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(Unit)
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil notifikasi"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil notifikasi"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }
}
