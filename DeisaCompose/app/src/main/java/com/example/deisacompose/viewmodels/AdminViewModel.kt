package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.DashboardData
import com.example.deisacompose.data.models.PendingUser
import com.example.deisacompose.data.repository.AdminRepository
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch

class AdminViewModel : ViewModel() {
    private val repository = AdminRepository()

    private val _dashboardState = MutableStateFlow<DashboardState>(DashboardState.Loading)
    val dashboardState: StateFlow<DashboardState> = _dashboardState.asStateFlow()

    private val _pendingUsers = MutableStateFlow<List<PendingUser>>(emptyList())
    val pendingUsers: StateFlow<List<PendingUser>> = _pendingUsers.asStateFlow()

    private val _actionState = MutableStateFlow<ActionState>(ActionState.Idle)
    val actionState: StateFlow<ActionState> = _actionState.asStateFlow()

    fun loadDashboard() {
        viewModelScope.launch {
            _dashboardState.value = DashboardState.Loading
            repository.getDashboard()
                .onSuccess { data ->
                    _dashboardState.value = DashboardState.Success(data)
                }
                .onFailure { error ->
                    _dashboardState.value = DashboardState.Error(error.message ?: "Gagal memuat dashboard")
                }
        }
    }

    fun loadPendingUsers() {
        viewModelScope.launch {
            repository.getPendingUsers()
                .onSuccess { users ->
                    _pendingUsers.value = users
                }
                .onFailure { error ->
                    _actionState.value = ActionState.Error(error.message ?: "Gagal memuat pending users")
                }
        }
    }

    fun approveUser(id: Int) {
        viewModelScope.launch {
            _actionState.value = ActionState.Loading
            repository.approveUser(id)
                .onSuccess { message ->
                    _actionState.value = ActionState.Success(message)
                    loadPendingUsers() // Refresh list
                    loadDashboard() // Refresh dashboard
                }
                .onFailure { error ->
                    _actionState.value = ActionState.Error(error.message ?: "Gagal menyetujui user")
                }
        }
    }

    fun deleteUser(id: Int) {
        viewModelScope.launch {
            _actionState.value = ActionState.Loading
            repository.deleteUser(id)
                .onSuccess { message ->
                    _actionState.value = ActionState.Success(message)
                    loadPendingUsers() // Refresh list
                }
                .onFailure { error ->
                    _actionState.value = ActionState.Error(error.message ?: "Gagal menghapus user")
                }
        }
    }

    fun resetActionState() {
        _actionState.value = ActionState.Idle
    }
}

sealed class DashboardState {
    object Loading : DashboardState()
    data class Success(val data: DashboardData) : DashboardState()
    data class Error(val message: String) : DashboardState()
}

sealed class ActionState {
    object Idle : ActionState()
    object Loading : ActionState()
    data class Success(val message: String) : ActionState()
    data class Error(val message: String) : ActionState()
}
