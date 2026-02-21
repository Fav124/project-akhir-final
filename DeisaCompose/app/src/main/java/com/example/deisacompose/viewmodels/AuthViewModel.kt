package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LoginData
import com.example.deisacompose.data.models.User
import com.example.deisacompose.data.repository.AuthRepository
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.flow.map
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch

class AuthViewModel : ViewModel() {
    private val authRepository = AuthRepository()

    private val _currentUser = MutableStateFlow<User?>(null)
    val currentUser: StateFlow<User?> = _currentUser

    val isAdmin: StateFlow<Boolean> = currentUser.map { it?.role == "admin" }
        .stateIn(viewModelScope, SharingStarted.Lazily, false)

    // Alert State
    private val _alertMessage = MutableStateFlow<String?>(null)
    val alertMessage: StateFlow<String?> = _alertMessage.asStateFlow()

    private val _alertType = MutableStateFlow<String>("success") // success, error
    val alertType: StateFlow<String> = _alertType.asStateFlow()

    fun showAlert(message: String, type: String = "success") {
        _alertMessage.value = message
        _alertType.value = type
    }

    fun clearAlert() {
        _alertMessage.value = null
    }

    init {
        getCurrentUser()
    }

    fun getCurrentUser() {
        viewModelScope.launch {
            val result = authRepository.getCurrentUser()
            _currentUser.value = result.getOrNull()
        }
    }

    fun login(email: String, password: String, onResult: (Result<LoginData>) -> Unit) {
        viewModelScope.launch {
            val result = authRepository.login(email, password)
            if (result.isSuccess) {
                val data = result.getOrNull()
                _currentUser.value = data?.user
                showAlert("Selamat datang, ${data?.user?.name}!", "success")
            } else {
                val error = result.exceptionOrNull()?.message ?: "Login gagal"
                showAlert(error, "error")
            }
            onResult(result)
        }
    }

    fun register(
        name: String,
        email: String,
        password: String,
        passwordConfirmation: String,
        role: String,
        onResult: (Result<String>) -> Unit
    ) {
        viewModelScope.launch {
            val result = authRepository.register(name, email, password, passwordConfirmation, role)
            if (result.isSuccess) {
                showAlert(result.getOrNull() ?: "Registrasi berhasil", "success")
            } else {
                val error = result.exceptionOrNull()?.message ?: "Registrasi gagal"
                showAlert(error, "error")
            }
            onResult(result)
        }
    }

    fun forgotPassword(email: String, onResult: (Result<String>) -> Unit) {
        viewModelScope.launch {
            val result = authRepository.forgotPassword(email)
            if (result.isSuccess) {
                showAlert("Instruksi reset sandi telah dikirim ke email", "success")
            } else {
                val error = result.exceptionOrNull()?.message ?: "Gagal mengirim email reset"
                showAlert(error, "error")
            }
            onResult(result)
        }
    }

    fun logout() {
        viewModelScope.launch {
            authRepository.logout()
            _currentUser.value = null
        }
    }
}