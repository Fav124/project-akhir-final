package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.LoginData
import com.example.deisacompose.data.models.User
import com.example.deisacompose.data.repository.AuthRepository
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch

class AuthViewModel : ViewModel() {
    private val repository = AuthRepository()

    private val _uiState = MutableStateFlow<AuthUiState>(AuthUiState.Idle)
    val uiState: StateFlow<AuthUiState> = _uiState.asStateFlow()

    private val _currentUser = MutableStateFlow<User?>(null)
    val currentUser: StateFlow<User?> = _currentUser.asStateFlow()

    private val _isLoggedIn = MutableStateFlow(false)
    val isLoggedIn: StateFlow<Boolean> = _isLoggedIn.asStateFlow()

    private val _isLoading = MutableStateFlow(false)
    val isLoading: StateFlow<Boolean> = _isLoading.asStateFlow()

    fun login(email: String, password: String, remember: Boolean = false) {
        viewModelScope.launch {
            _uiState.value = AuthUiState.Loading
            _isLoading.value = true
            repository.login(email, password, remember)
                .onSuccess { authData ->
                    _currentUser.value = authData.user
                    _isLoggedIn.value = true
                    _uiState.value = AuthUiState.Success("Login berhasil", authData)
                }
                .onFailure { error ->
                    _uiState.value = AuthUiState.Error(error.message ?: "Login gagal")
                }
            _isLoading.value = false
        }
    }

    fun register(
        name: String,
        email: String,
        password: String,
        passwordConfirmation: String,
        role: String
    ) {
        viewModelScope.launch {
            _uiState.value = AuthUiState.Loading
            _isLoading.value = true
            repository.register(name, email, password, passwordConfirmation, role)
                .onSuccess { message ->
                    _uiState.value = AuthUiState.RegisterSuccess(message)
                }
                .onFailure { error ->
                    _uiState.value = AuthUiState.Error(error.message ?: "Registrasi gagal")
                }
            _isLoading.value = false
        }
    }

    fun logout() {
        viewModelScope.launch {
            repository.logout()
            _currentUser.value = null
            _isLoggedIn.value = false
            _uiState.value = AuthUiState.Idle
        }
    }

    fun forgotPassword(email: String) {
        viewModelScope.launch {
            _uiState.value = AuthUiState.Loading
            _isLoading.value = true
            repository.forgotPassword(email)
                .onSuccess { message ->
                    _uiState.value = AuthUiState.ForgotPasswordSuccess(message)
                }
                .onFailure { error ->
                    _uiState.value = AuthUiState.Error(error.message ?: "Gagal mengirim email")
                }
            _isLoading.value = false
        }
    }

    fun getCurrentUser() {
        viewModelScope.launch {
            _isLoading.value = true
            repository.getCurrentUser()
                .onSuccess { user ->
                    _currentUser.value = user
                    _isLoggedIn.value = true
                }
                .onFailure {
                    _currentUser.value = null
                    _isLoggedIn.value = false
                }
            _isLoading.value = false
        }
    }

    fun resetState() {
        _uiState.value = AuthUiState.Idle
    }
}

sealed class AuthUiState {
    object Idle : AuthUiState()
    object Loading : AuthUiState()
    data class Success(val message: String, val authData: LoginData) : AuthUiState()
    data class RegisterSuccess(val message: String) : AuthUiState()
    data class ForgotPasswordSuccess(val message: String) : AuthUiState()
    data class Error(val message: String) : AuthUiState()
}