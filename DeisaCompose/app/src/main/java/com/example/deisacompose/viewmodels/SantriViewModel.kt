package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.data.models.SantriRequest
import kotlinx.coroutines.launch

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

    fun createSantri(request: SantriRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.createSantri(request)
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

    fun updateSantri(id: Int, request: SantriRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.updateSantri(id, request)
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