package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LaporanData
import kotlinx.coroutines.launch

class LaporanViewModel : BaseViewModel() {

    private val _laporanData = MutableLiveData<LaporanData?>()
    val laporanData: LiveData<LaporanData?> = _laporanData

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchLaporan() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getLaporanSummary()
                if (response.isSuccessful) {
                    _laporanData.postValue(response.body()?.data)
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

    fun clearMessage() {
        _message.value = null
    }
}
