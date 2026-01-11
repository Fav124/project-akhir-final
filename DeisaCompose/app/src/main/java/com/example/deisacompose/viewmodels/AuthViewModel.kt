package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LoginRequest
import com.example.deisacompose.data.models.RegisterRequest
import com.example.deisacompose.data.network.ApiClient
import kotlinx.coroutines.launch

class AuthViewModel : ViewModel() {

    private val apiService = ApiClient.instance

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _error = MutableLiveData<String?>()
    val error: LiveData<String?> = _error

    private val _authSuccess = MutableLiveData<Boolean>()
    val authSuccess: LiveData<Boolean> = _authSuccess

    private val _registrationSuccess = MutableLiveData<String?>()
    val registrationSuccess: LiveData<String?> = _registrationSuccess

    fun login(email: String, password: String) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val request = LoginRequest(email, password)
                val response = apiService.login(request)

                if (response.isSuccessful) {
                    _authSuccess.postValue(true)
                } else {
                    _error.postValue(response.body()?.message ?: "Login failed")
                }
            } catch (e: Exception) {
                _error.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun logout() {
        viewModelScope.launch {
            try {
                apiService.logout()
            } catch (e: Exception) {
                // Even if logout fails on server, client should still log out
            }
            _authSuccess.postValue(false)
        }
    }

    fun register(name: String, email: String, password: String) {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val request = RegisterRequest(name, email, password)
                val response = apiService.register(request)

                if (response.isSuccessful) {
                    _registrationSuccess.postValue(response.body()?.message)
                } else {
                    _error.postValue(response.body()?.message ?: "Registration failed")
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

    fun resetRegistrationSuccess() {
        _registrationSuccess.value = null
    }
}