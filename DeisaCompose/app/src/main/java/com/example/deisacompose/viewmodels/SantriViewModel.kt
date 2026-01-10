package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.data.models.SantriRequest
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class SantriViewModel(application: Application) : AndroidViewModel(application) {
    private val _santriList = MutableLiveData<List<Santri>>()
    val santriList: LiveData<List<Santri>> = _santriList

    private val _santriDetail = MutableLiveData<Santri?>()
    val santriDetail: LiveData<Santri?> = _santriDetail

    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading

    private fun getToken(): String {
        val prefs = getApplication<Application>().getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        return "Bearer " + (prefs.getString("token", "") ?: "")
    }

    fun fetchSantri() {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getSantri(getToken())
                if (response.isSuccessful) {
                    _santriList.value = response.body()?.data ?: emptyList()
                }
            } catch (e: Exception) {
            } finally {
                _isLoading.value = false
            }
        }
    }
    
    fun fetchSantriById(id: Int) {
         _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getSantriDetail(getToken(), id)
                if (response.isSuccessful) {
                    _santriDetail.value = response.body()?.data
                }
            } catch (e: Exception) {
            } finally {
                _isLoading.value = false
            }
        }
    }

    fun createSantri(request: SantriRequest, onSuccess: () -> Unit) {
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.storeSantri(getToken(), request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun updateSantri(id: Int, request: SantriRequest, onSuccess: () -> Unit) {
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.updateSantri(getToken(), id, request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun deleteSantri(id: Int) {
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.deleteSantri(getToken(), id)
                if (response.isSuccessful) fetchSantri()
            } catch (e: Exception) { }
        }
    }
    
    fun clearDetail() {
        _santriDetail.value = null
    }
}
