package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.data.models.SakitRequest
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class SakitViewModel(application: Application) : AndroidViewModel(application) {
    private val _sakitList = MutableLiveData<List<Sakit>>()
    val sakitList: LiveData<List<Sakit>> = _sakitList
    
    private val _sakitDetail = MutableLiveData<Sakit?>()
    val sakitDetail: LiveData<Sakit?> = _sakitDetail

    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading

    private fun getToken(): String = "Bearer " + getApplication<Application>()
        .getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        .getString("token", "")

    fun fetchSakit() {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getSakit(getToken())
                if (response.isSuccessful) {
                   _sakitList.value = response.body()?.data ?: emptyList()
                }
            } catch (e: Exception) {} 
            finally { _isLoading.value = false }
        }
    }
    
    fun getSakitById(id: Int) {
         _isLoading.value = true
        viewModelScope.launch {
            // Check if we have getSakitDetail endpoint, if not filter from list
             try {
                val response = RetrofitClient.instance.getSakitDetail(getToken(), id)
                if (response.isSuccessful) {
                   _sakitDetail.value = response.body()?.data
                }
            } catch (e: Exception) {
                 // Fallback
                 _sakitDetail.value = _sakitList.value?.find { it.id == id }
            } 
            finally { _isLoading.value = false }
        }
    }

    fun submitSakit(request: SakitRequest, onSuccess: () -> Unit) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.storeSakit(getToken(), request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun updateSakit(id: Int, request: SakitRequest, onSuccess: () -> Unit) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.updateSakit(getToken(), id, request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun deleteSakit(id: Int) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.deleteSakit(getToken(), id)
                if (response.isSuccessful) fetchSakit()
            } catch (e: Exception) { }
        }
    }
    
    fun clearDetail() { _sakitDetail.value = null }
}
