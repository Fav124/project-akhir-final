package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.RegistrationRequest
import com.example.deisacompose.data.models.User
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class AdminViewModel : ViewModel() {
    private val apiService = RetrofitClient.apiService

    private val _pendingRequests = MutableLiveData<List<RegistrationRequest>>()
    val pendingRequests: LiveData<List<RegistrationRequest>> = _pendingRequests

    private val _users = MutableLiveData<List<User>>()
    val users: LiveData<List<User>> = _users

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchPendingRegistrations() {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = apiService.getPendingRegistrations()
                if (response.isSuccessful) {
                    _pendingRequests.value = response.body()?.data ?: emptyList()
                }
            } catch (e: Exception) {
                _message.value = "Error fetching registrations: ${e.message}"
            } finally {
                _isLoading.value = false
            }
        }
    }

    fun approveRegistration(id: Int) {
        viewModelScope.launch {
            try {
                val response = apiService.approveRegistration(id)
                if (response.isSuccessful) {
                    _message.value = "User approved successfully"
                    fetchPendingRegistrations()
                }
            } catch (e: Exception) {
                _message.value = "Error: ${e.message}"
            }
        }
    }

    fun rejectRegistration(id: Int) {
        viewModelScope.launch {
            try {
                val response = apiService.rejectRegistration(id)
                if (response.isSuccessful) {
                    _message.value = "User rejected"
                    fetchPendingRegistrations()
                }
            } catch (e: Exception) {
                _message.value = "Error: ${e.message}"
            }
        }
    }

    fun fetchUsers() {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                val response = apiService.getUsers()
                if (response.isSuccessful) {
                    _users.value = response.body()?.data ?: emptyList()
                }
            } catch (e: Exception) {
                _message.value = "Error fetching users: ${e.message}"
            } finally {
                _isLoading.value = false
            }
        }
    }

    fun clearMessage() { _message.value = null }
}
