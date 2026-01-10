package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LaporanData
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class LaporanViewModel(application: Application) : AndroidViewModel(application) {
    
    private val _laporanData = MutableLiveData<LaporanData?>()
    val laporanData: LiveData<LaporanData?> = _laporanData
    
    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading

    private fun getToken(): String = "Bearer " + getApplication<Application>()
        .getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        .getString("token", "")

    fun fetchReport(startDate: String?, endDate: String?) {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getLaporanSummary(getToken(), startDate, endDate)
                if (response.isSuccessful) {
                    _laporanData.value = response.body()?.data
                }
            } catch (e: Exception) {
                // handle error
            } finally {
                _isLoading.value = false
            }
        }
    }
}
