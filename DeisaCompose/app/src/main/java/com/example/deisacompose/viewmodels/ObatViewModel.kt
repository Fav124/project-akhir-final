package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.data.models.ObatRequest
import kotlinx.coroutines.launch
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody

class ObatViewModel : BaseViewModel() {

    private val _obatList = MutableLiveData<List<Obat>>()
    val obatList: LiveData<List<Obat>> = _obatList

    private val _obatDetail = MutableLiveData<Obat?>()
    val obatDetail: LiveData<Obat?> = _obatDetail

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchObat(search: String? = null, all: Boolean? = null) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getObat(1, 100, search = search, all = all)
                if (response.isSuccessful) {
                    _obatList.postValue(response.body()?.data)
                } else {
                    _message.postValue("Failed to fetch obat: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun getObatById(id: Int) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getObatById(id)
                if (response.isSuccessful) {
                    _obatDetail.postValue(response.body()?.data?.obat)
                } else {
                    _message.postValue("Failed to fetch obat details: ${response.message()}")
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

    fun createObat(request: ObatRequest, photoFile: java.io.File?, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val map = HashMap<String, okhttp3.RequestBody>()
                map["nama"] = createPartFromString(request.namaObat)
                if (!request.kategori.isNullOrBlank()) map["kategori"] = createPartFromString(request.kategori)
                map["stok"] = createPartFromString(request.stok.toString())
                if (request.stokAwal != null) map["stok_awal"] = createPartFromString(request.stokAwal.toString())
                if (!request.satuan.isNullOrBlank()) map["satuan"] = createPartFromString(request.satuan)
                request.stokMinimum?.let { map["stok_min"] = createPartFromString(it.toString()) }
                request.harga?.let { map["harga"] = createPartFromString(it.toString()) }
                request.tglKadaluarsa?.let { map["kadaluarsa"] = createPartFromString(it) }
                request.lokasiPenyimpanan?.let { map["lokasi"] = createPartFromString(it.toString()) }
                request.deskripsi?.let { map["deskripsi"] = createPartFromString(it) }

                val photoPart = photoFile?.let {
                    val requestFile = it.asRequestBody("image/*".toMediaTypeOrNull())
                    okhttp3.MultipartBody.Part.createFormData("foto", it.name, requestFile)
                }

                val response = apiService.createObat(map, photoPart)
                if (response.isSuccessful) {
                    fetchObat()
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menambahkan obat")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun updateObat(id: Int, request: ObatRequest, photoFile: java.io.File?, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val map = HashMap<String, okhttp3.RequestBody>()
                map["_method"] = createPartFromString("PUT")
                map["nama"] = createPartFromString(request.namaObat)
                if (!request.kategori.isNullOrBlank()) map["kategori"] = createPartFromString(request.kategori)
                map["stok"] = createPartFromString(request.stok.toString())
                request.stokMinimum?.let { map["stok_min"] = createPartFromString(it.toString()) }
                if (!request.satuan.isNullOrBlank()) map["satuan"] = createPartFromString(request.satuan)
                request.harga?.let { map["harga"] = createPartFromString(it.toString()) }
                request.tglKadaluarsa?.let { map["kadaluarsa"] = createPartFromString(it) }
                request.lokasiPenyimpanan?.let { map["lokasi"] = createPartFromString(it) }

                val photoPart = photoFile?.let {
                    val requestFile = it.asRequestBody("image/*".toMediaTypeOrNull())
                    okhttp3.MultipartBody.Part.createFormData("foto", it.name, requestFile)
                }

                val response = apiService.updateObat(id, map, photoPart)
                if (response.isSuccessful) {
                    getObatById(id)
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal memperbarui obat")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun deleteObat(id: Int, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.deleteObat(id)
                if (response.isSuccessful) {
                    fetchObat() // Refresh list
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menghapus obat")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun clearDetail() {
        _obatDetail.value = null
    }

    fun clearMessage() {
        _message.value = null
    }
}
