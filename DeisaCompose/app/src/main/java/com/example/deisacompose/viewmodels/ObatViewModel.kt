package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.data.models.ObatRequest
import kotlinx.coroutines.launch

class ObatViewModel : BaseViewModel() {

    private val _obatList = MutableLiveData<List<Obat>>()
    val obatList: LiveData<List<Obat>> = _obatList

    private val _obatDetail = MutableLiveData<Obat?>()
    val obatDetail: LiveData<Obat?> = _obatDetail

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchObat() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getObat(1, 100) // Fetch first 100
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

    fun createObat(request: ObatRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.createObat(request)
                if (response.isSuccessful) {
                    fetchObat() // Refresh list
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menambahkan obat")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun updateObat(id: Int, request: ObatRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.updateObat(id, request)
                if (response.isSuccessful) {
                    getObatById(id) // Refresh detail
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
