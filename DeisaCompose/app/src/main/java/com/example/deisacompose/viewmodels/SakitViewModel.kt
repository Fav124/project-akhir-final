package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.data.models.SakitRequest
import kotlinx.coroutines.launch

class SakitViewModel : BaseViewModel() {

    private val _sakitList = MutableLiveData<List<Sakit>>()
    val sakitList: LiveData<List<Sakit>> = _sakitList

    private val _sakitDetail = MutableLiveData<Sakit?>()
    val sakitDetail: LiveData<Sakit?> = _sakitDetail

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    private val _diagnosisList = MutableLiveData<List<com.example.deisacompose.data.models.Diagnosis>>()
    val diagnosisList: LiveData<List<com.example.deisacompose.data.models.Diagnosis>> = _diagnosisList

    private val _obatList = MutableLiveData<List<com.example.deisacompose.data.models.Obat>>()
    val obatList: LiveData<List<com.example.deisacompose.data.models.Obat>> = _obatList

    fun fetchSakit(search: String? = null) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getSakit(search = search)
                if (response.isSuccessful) {
                    _sakitList.postValue(response.body()?.data)
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

    fun getSakitById(id: Int) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getSakitById(id)
                if (response.isSuccessful) {
                    _sakitDetail.postValue(response.body()?.data)
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

    fun submitSakit(request: SakitRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.createSakit(request)
                if (response.isSuccessful) {
                    fetchSakit()
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal mencatat sakit")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun updateSakit(id: Int, request: SakitRequest, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.updateSakit(id, request)
                if (response.isSuccessful) {
                    getSakitById(id)
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal memperbarui data")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun deleteSakit(id: Int, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.deleteSakit(id)
                if (response.isSuccessful) {
                    fetchSakit() // Refresh list
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menghapus data")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }

    fun markAsSembuh(id: Int, onSuccess: () -> Unit, onError: (String) -> Unit) {
        viewModelScope.launch {
            try {
                val response = apiService.markAsSembuh(id)
                if (response.isSuccessful) {
                    fetchSakit() // Refresh list
                    onSuccess()
                } else {
                    onError(response.message() ?: "Gagal menandai sembuh")
                }
            } catch (e: Exception) {
                onError(e.message ?: "Terjadi kesalahan")
            }
        }
    }
    fun fetchDiagnosis() {
        viewModelScope.launch {
            try {
                val response = apiService.getDiagnosis()
                if (response.isSuccessful) {
                    _diagnosisList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {}
        }
    }

    fun fetchObat() {
        viewModelScope.launch {
            try {
                val response = apiService.getObat(all = true) // I should add 'all' param or just use getObat
                if (response.isSuccessful) {
                    _obatList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {}
        }
    }

    fun clearDetail() {
        _sakitDetail.value = null
    }

    fun clearMessage() {
        _message.value = null
    }
}