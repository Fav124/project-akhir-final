package com.example.deisacompose.data.repository

import com.example.deisacompose.data.models.*
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class ResourceRepository {
    private val api = RetrofitClient.apiService

    // ================= SANTRI =================
    suspend fun getSantri(
        search: String? = null,
        kelasId: Int? = null,
        jurusanId: Int? = null,
        perPage: Int = 20,
        page: Int = 1
    ): Result<List<Santri>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getSantri(search, kelasId, jurusanId, perPage, page)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data santri"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil data santri"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun createSantri(santri: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.createSantri(santri)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Santri ditambahkan")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menambah santri"))
                    }
                } else {
                    Result.failure(Exception("Gagal menambah santri"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun updateSantri(id: Int, santri: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.updateSantri(id, santri)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Santri diupdate")
                    } else {
                        Result.failure(Exception("Gagal mengupdate santri"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengupdate santri"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun deleteSantri(id: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.deleteSantri(id)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Santri dihapus")
                    } else {
                        Result.failure(Exception("Gagal menghapus santri"))
                    }
                } else {
                    Result.failure(Exception("Gagal menghapus santri"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    // ================= SAKIT =================
    suspend fun getSakit(
        status: String? = null,
        search: String? = null,
        perPage: Int = 20,
        page: Int = 1
    ): Result<List<Sakit>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getSakit(status, search, perPage, page)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data sakit"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil data sakit"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun createSakit(sakit: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.createSakit(sakit)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Data sakit ditambahkan")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menambah data sakit"))
                    }
                } else {
                    Result.failure(Exception("Gagal menambah data sakit"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun updateSakit(id: Int, sakit: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.updateSakit(id, sakit)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Data sakit diupdate")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengupdate data sakit"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengupdate data sakit"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun deleteSakit(id: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.deleteSakit(id)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Data sakit dihapus")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menghapus data sakit"))
                    }
                } else {
                    Result.failure(Exception("Gagal menghapus data sakit"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    // ================= OBAT =================
    suspend fun getObat(
        search: String? = null,
        lowStock: Boolean? = null,
        perPage: Int = 20,
        page: Int = 1
    ): Result<List<Obat>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getObat(search, lowStock, perPage, page)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data obat"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil data obat"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun createObat(obat: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.createObat(obat)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Obat ditambahkan")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menambah obat"))
                    }
                } else {
                    Result.failure(Exception("Gagal menambah obat"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun updateObat(id: Int, obat: Map<String, Any>): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.updateObat(id, obat)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Obat diupdate")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengupdate obat"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengupdate obat"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun restockObat(id: Int, jumlah: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.restockObat(id, mapOf("jumlah" to jumlah))
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Obat direstock")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal restock obat"))
                    }
                } else {
                    Result.failure(Exception("Gagal restock obat"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    suspend fun deleteObat(id: Int): Result<String> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.deleteObat(id)
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.message ?: "Obat dihapus")
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal menghapus obat"))
                    }
                } else {
                    Result.failure(Exception("Gagal menghapus obat"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    // ================= KELAS =================
    suspend fun getKelas(): Result<List<Kelas>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getKelas()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data kelas"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil data kelas"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }

    // ================= JURUSAN =================
    suspend fun getJurusan(): Result<List<Jurusan>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = api.getJurusan()
                val body = response.body()
                if (response.isSuccessful && body != null) {
                    if (body.success == true) {
                        Result.success(body.data ?: emptyList())
                    } else {
                        Result.failure(Exception(body.message ?: "Gagal mengambil data jurusan"))
                    }
                } else {
                    Result.failure(Exception("Gagal mengambil data jurusan"))
                }
            } catch (e: Exception) {
                Result.failure(e)
            }
        }
    }
}
