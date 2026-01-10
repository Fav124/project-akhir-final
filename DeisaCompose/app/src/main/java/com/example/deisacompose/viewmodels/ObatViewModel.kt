package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.data.models.ObatRequest
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class ObatViewModel(application: Application) : AndroidViewModel(application) {
    private val _obatList = MutableLiveData<List<Obat>>()
    val obatList: LiveData<List<Obat>> = _obatList
    
    private val _obatDetail = MutableLiveData<Obat?>() // Assuming we can iterate local list or fetch
    val obatDetail: LiveData<Obat?> = _obatDetail

    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading

    private fun getToken(): String = "Bearer " + getApplication<Application>()
        .getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        .getString("token", "")

    fun fetchObat() {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getObat(getToken())
                if (response.isSuccessful) {
                    _obatList.value = response.body()?.data ?: emptyList()
                }
            } catch (e: Exception) {}
            finally { _isLoading.value = false }
        }
    }
    
    // Simplification: We don't have getObatDetail API yet, so we filter from list if available, or just fetch list and find
    fun getObatById(id: Int) {
        val current = _obatList.value?.find { it.id == id }
        if (current != null) {
            _obatDetail.value = current
        } else {
            // Ideally call API, but for now reuse fetch
             viewModelScope.launch {
                fetchObat() // Refresh
                _obatDetail.value = _obatList.value?.find { it.id == id }
            }
        }
    }
    
    fun createObat(request: ObatRequest, onSuccess: () -> Unit) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.storeObat(getToken(), request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun updateObat(id: Int, request: ObatRequest, onSuccess: () -> Unit) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.updateObat(getToken(), id, request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
    
    fun deleteObat(id: Int) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.deleteObat(getToken(), id)
                if (response.isSuccessful) fetchObat()
            } catch (e: Exception) { }
        }
    }
    
    fun clearDetail() { _obatDetail.value = null }
}
