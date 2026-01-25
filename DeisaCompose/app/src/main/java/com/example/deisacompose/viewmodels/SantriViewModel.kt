package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.data.models.SantriRequest
import kotlinx.coroutines.launch
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody

class SantriViewModel : BaseViewModel() {

    private val _santriList = MutableLiveData<List<Santri>>()
    val santriList: LiveData<List<Santri>> = _santriList

    private val _santriDetail = MutableLiveData<Santri?>()
    val santriDetail: LiveData<Santri?> = _santriDetail

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchSantri(search: String? = null) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getSantri(search = search)
                if (response.isSuccessful) {
                    _santriList.postValue(response.body()?.data)
                } else {
                    _message.postValue("Error: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun fetchSantriById(id: Int) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getSantriById(id)
                if (response.isSuccessful) {
                    _santriDetail.postValue(response.body()?.data?.santri)
                } else {
                    _message.postValue("Error: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    private fun createPartFromString(string: String): okhttp3.RequestBody {
        return string.toRequestBody(okhttp3.MultipartBody.FORM)
    }

    fun createSantri(request: SantriRequest, photoFile: java.io.File?, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val map = HashMap<String, okhttp3.RequestBody>()
                map["nis"] = createPartFromString(request.nis)
                map["nama_lengkap"] = createPartFromString(request.namaLengkap)
                map["jenis_kelamin"] = createPartFromString(request.jenisKelamin)
                map["kelas_id"] = createPartFromString(request.kelasId.toString())
                request.jurusanId?.let { map["jurusan_id"] = createPartFromString(it.toString()) }
                map["status_kesehatan"] = createPartFromString(request.statusKesehatan)
                request.tempatLahir?.let { map["tempat_lahir"] = createPartFromString(it) }
                request.tanggalLahir?.let { map["tanggal_lahir"] = createPartFromString(it) }
                request.angkatanId?.let { map["angkatan_id"] = createPartFromString(it.toString()) }
                request.alamat?.let { map["alamat"] = createPartFromString(it) }
                request.riwayatAlergi?.let { map["riwayat_alergi"] = createPartFromString(it) }
                request.namaWali?.let { map["nama_wali"] = createPartFromString(it) }
                request.hubunganWali?.let { map["hubungan"] = createPartFromString(it) }
                request.noTelpWali?.let { map["no_hp"] = createPartFromString(it) }
                request.pekerjaanWali?.let { map["pekerjaan"] = createPartFromString(it) }

                val photoPart = photoFile?.let {
                    val requestFile = it.asRequestBody("image/*".toMediaTypeOrNull())
                    okhttp3.MultipartBody.Part.createFormData("foto", it.name, requestFile)
                }

                val response = apiService.createSantri(map, photoPart)
                if (response.isSuccessful) {
                    fetchSantri()
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menambahkan santri")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun updateSantri(id: Int, request: SantriRequest, photoFile: java.io.File?, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val map = HashMap<String, okhttp3.RequestBody>()
                map["_method"] = createPartFromString("PUT") // Method spoofing
                map["nis"] = createPartFromString(request.nis)
                map["nama_lengkap"] = createPartFromString(request.namaLengkap)
                map["jenis_kelamin"] = createPartFromString(request.jenisKelamin)
                map["kelas_id"] = createPartFromString(request.kelasId.toString())
                request.jurusanId?.let { map["jurusan_id"] = createPartFromString(it.toString()) }
                map["status_kesehatan"] = createPartFromString(request.statusKesehatan)
                request.tempatLahir?.let { map["tempat_lahir"] = createPartFromString(it) }
                request.tanggalLahir?.let { map["tanggal_lahir"] = createPartFromString(it) }
                request.angkatanId?.let { map["angkatan_id"] = createPartFromString(it.toString()) }
                request.alamat?.let { map["alamat"] = createPartFromString(it) }
                request.riwayatAlergi?.let { map["riwayat_alergi"] = createPartFromString(it) }
                request.namaWali?.let { map["nama_wali"] = createPartFromString(it) }
                request.hubunganWali?.let { map["hubungan"] = createPartFromString(it) }
                request.noTelpWali?.let { map["no_hp"] = createPartFromString(it) }
                request.pekerjaanWali?.let { map["pekerjaan"] = createPartFromString(it) }

                val photoPart = photoFile?.let {
                    val requestFile = it.asRequestBody("image/*".toMediaTypeOrNull())
                    okhttp3.MultipartBody.Part.createFormData("foto", it.name, requestFile)
                }

                val response = apiService.updateSantri(id, map, photoPart)
                if (response.isSuccessful) {
                    fetchSantriById(id)
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal memperbarui santri")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun deleteSantri(id: Int, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.deleteSantri(id)
                if (response.isSuccessful) {
                    fetchSantri()
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menghapus santri")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun clearDetail() {
        _santriDetail.value = null
    }

    fun clearMessage() {
        _message.value = null
    }
}
