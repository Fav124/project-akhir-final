package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.RegistrationRequest
import com.example.deisacompose.data.models.User
import kotlinx.coroutines.launch

class AdminViewModel : BaseViewModel() {

    private val _registrationList = MutableLiveData<List<RegistrationRequest>>()
    val registrationList: LiveData<List<RegistrationRequest>> = _registrationList

    private val _userList = MutableLiveData<List<User>>()
    val userList: LiveData<List<User>> = _userList

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchPendingRegistrations() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getPendingRegistrations()
                if (response.isSuccessful) {
                    _registrationList.postValue(response.body()?.data)
                } else {
                    _message.postValue("Failed to fetch registrations: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun fetchUsers() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getUsers()
                if (response.isSuccessful) {
                    _userList.postValue(response.body()?.data)
                } else {
                    _message.postValue("Failed to fetch users: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun approveRegistration(id: Int) {
        viewModelScope.launch {
            try {
                val response = apiService.approveRegistration(id)
                if (response.isSuccessful) {
                    _message.postValue("Registration approved successfully")
                    fetchPendingRegistrations() // Refresh list
                } else {
                    _message.postValue("Failed to approve: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            }
        }
    }

    fun rejectRegistration(id: Int) {
        viewModelScope.launch {
            try {
                val response = apiService.rejectRegistration(id)
                if (response.isSuccessful) {
                    _message.postValue("Registration rejected successfully")
                    fetchPendingRegistrations() // Refresh list
                } else {
                    _message.postValue("Failed to reject: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            }
        }
    }

    fun deleteUser(id: Int) {
        viewModelScope.launch {
            try {
                val response = apiService.deleteUser(id)
                if (response.isSuccessful) {
                    _message.postValue("User deleted successfully")
                    fetchUsers() // Refresh list
                } else {
                    _message.postValue("Failed to delete user: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            }
        }
    }

    fun clearMessage() {
        _message.value = null
    }
}