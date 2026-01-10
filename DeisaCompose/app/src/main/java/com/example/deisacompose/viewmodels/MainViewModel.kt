package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.User
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class MainViewModel(application: Application) : AndroidViewModel(application) {

    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading
    
    private val _error = MutableLiveData<String?>()
    val error: LiveData<String?> = _error

    private val _currentUser = MutableLiveData<User?>()
    val currentUser: LiveData<User?> = _currentUser

    private fun getToken(): String {
        val prefs = getApplication<Application>().getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""
        return "Bearer $token"
    }

    fun fetchUser() {
        viewModelScope.launch {
             try {
                val response = RetrofitClient.instance.getUser(getToken())
                if (response.isSuccessful) {
                    _currentUser.value = response.body()?.data
                }
            } catch (e: Exception) {
                // Ignore or handle
            }
        }
    }
    
    fun logout() {
        // Clear prefs
        val prefs = getApplication<Application>().getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        prefs.edit().clear().apply()
        _currentUser.value = null
    }
}
