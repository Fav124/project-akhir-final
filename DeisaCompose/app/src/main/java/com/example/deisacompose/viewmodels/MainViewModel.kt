package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.User
import kotlinx.coroutines.launch

class MainViewModel : BaseViewModel() {

    private val _user = MutableLiveData<User?>()
    val user: LiveData<User?> = _user

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    private val _message = MutableLiveData<String?>()
    val message: LiveData<String?> = _message

    fun fetchProfile() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                val response = apiService.getProfile()
                if (response.isSuccessful) {
                    _user.postValue(response.body()?.data)
                } else {
                    _message.postValue("Error: ${response.message()}")
                }
            } catch (e: Exception) {
                _message.postValue(e.message ?: "An unknown error occurred")
            } finally {
                _isLoading.postValue(false)
            }
        }
    }

    fun clearMessage() {
        _message.value = null
    }
}
