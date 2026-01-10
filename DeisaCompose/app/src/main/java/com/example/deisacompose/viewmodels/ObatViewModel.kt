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
    
    fun createObat(request: ObatRequest, onSuccess: () -> Unit) {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.storeObat(getToken(), request)
                if (response.isSuccessful) onSuccess()
            } catch (e: Exception) { }
        }
    }
}
