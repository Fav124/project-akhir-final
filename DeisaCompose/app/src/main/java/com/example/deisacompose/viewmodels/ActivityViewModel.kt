package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.ActivityLog
import com.example.deisacompose.data.models.HistorySummary
import kotlinx.coroutines.launch

class ActivityViewModel : BaseViewModel() {

    private val _logs = MutableLiveData<List<ActivityLog>>()
    val logs: LiveData<List<ActivityLog>> = _logs

    private val _summary = MutableLiveData<HistorySummary?>()
    val summary: LiveData<HistorySummary?> = _summary

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _error = MutableLiveData<String?>()
    val error: LiveData<String?> = _error

    fun fetchActivityLogs() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getActivityLogs()
                if (response.isSuccessful) {
                    val historyResponse = response.body()
                    _logs.postValue(historyResponse?.data?.data ?: emptyList())
                    _summary.postValue(historyResponse?.summary)
                    _error.postValue(null)
                } else {
                    _error.postValue("Error: ${response.message()}")
                }
            } catch (e: Exception) {
                _error.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun clearError() {
        _error.value = null
    }
}
