package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LoginRequest
import com.example.deisacompose.data.models.RegisterRequest
import com.example.deisacompose.data.models.User
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class AuthViewModel(application: Application) : AndroidViewModel(application) {

    private val _isLoading = MutableLiveData(false)
    val isLoading: LiveData<Boolean> = _isLoading

    private val _error = MutableLiveData<String?>()
    val error: LiveData<String?> = _error

    private val _user = MutableLiveData<User?>()
    val user: LiveData<User?> = _user

    private val _authSuccess = MutableLiveData<Boolean>()
    val authSuccess: LiveData<Boolean> = _authSuccess
    
    private val _registrationSuccess = MutableLiveData<String?>()
    val registrationSuccess: LiveData<String?> = _registrationSuccess

    fun login(email: String, password: String) {
        _isLoading.value = true
        _error.value = null
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.login(LoginRequest(email, password))
                if (response.isSuccessful && response.body() != null) {
                   val loginData = response.body()!!.data
                   _user.value = loginData.user
                   
                   // Save token in Prefs
                   val prefs = getApplication<Application>().getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
                   prefs.edit().putString("token", loginData.token).apply()
                   
                   _authSuccess.value = true
                } else {
                    _error.value = response.message() ?: "Login Failed"
                }
            } catch (e: Exception) {
                _error.value = e.message ?: "Unknown Error"
            } finally {
                _isLoading.value = false
            }
        }
    }

    fun register(name: String, email: String, password: String) {
         _isLoading.value = true
        _error.value = null
        viewModelScope.launch {
            try {
                val request = RegisterRequest(name, email, password)
                val response = RetrofitClient.instance.register(request)
                if (response.isSuccessful && response.body()?.success == true) {
                    _registrationSuccess.value = response.body()?.message ?: "Registration Request Submitted"
                } else {
                    val err = response.errorBody()?.string() ?: "Registration Failed"
                     _error.value = err
                }
            } catch (e: Exception) {
                 _error.value = e.message
            } finally {
                 _isLoading.value = false
            }
        }
    }
    
    // Placeholder for Google Auth logic calling API
    fun registerGoogle(name: String, email: String, googleId: String, avatar: String?) {
        _isLoading.value = true
        viewModelScope.launch {
            try {
                 val request = RegisterRequest(
                        name = name,
                        email = email,
                        password = "", 
                        googleId = googleId,
                        avatar = avatar
                    )
                val response = RetrofitClient.instance.register(request)
                 if (response.isSuccessful && response.body()?.success == true) {
                    _registrationSuccess.value = response.body()?.message ?: "Registration Request Submitted"
                } else {
                     val err = response.errorBody()?.string() ?: "Registration Failed"
                     _error.value = err
                }
            } catch (e: Exception) {
                _error.value = e.message
            } finally {
                _isLoading.value = false
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
