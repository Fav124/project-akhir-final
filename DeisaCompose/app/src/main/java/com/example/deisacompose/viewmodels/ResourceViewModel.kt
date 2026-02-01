package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.*
import com.example.deisacompose.data.repository.ResourceRepository
import com.example.deisacompose.data.models.Sakit
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch

class ResourceViewModel : ViewModel() {
    private val repository = ResourceRepository()

    // Santri
    private val _santriList = MutableStateFlow<List<Santri>>(emptyList())
    val santriList: StateFlow<List<Santri>> = _santriList.asStateFlow()

    // Sakit
    private val _sakitList = MutableStateFlow<List<Sakit>>(emptyList())
    val sakitList: StateFlow<List<Sakit>> = _sakitList.asStateFlow()

    // Obat
    private val _obatList = MutableStateFlow<List<Obat>>(emptyList())
    val obatList: StateFlow<List<Obat>> = _obatList.asStateFlow()

    // Kelas & Jurusan
    private val _kelasList = MutableStateFlow<List<Kelas>>(emptyList())
    val kelasList: StateFlow<List<Kelas>> = _kelasList.asStateFlow()

    private val _jurusanList = MutableStateFlow<List<Jurusan>>(emptyList())
    val jurusanList: StateFlow<List<Jurusan>> = _jurusanList.asStateFlow()

    // UI State
    private val _uiState = MutableStateFlow<ResourceUiState>(ResourceUiState.Idle)
    val uiState: StateFlow<ResourceUiState> = _uiState.asStateFlow()

    private val _isLoading = MutableStateFlow(false)
    val isLoading: StateFlow<Boolean> = _isLoading.asStateFlow()

    // ================= SANTRI =================
    fun loadSantri(search: String? = null, kelasId: Int? = null, jurusanId: Int? = null) {
        viewModelScope.launch {
            _isLoading.value = true
            repository.getSantri(search, kelasId, jurusanId)
                .onSuccess { list ->
                    _santriList.value = list
                    _isLoading.value = false
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal memuat santri")
                    _isLoading.value = false
                }
        }
    }

    fun createSantri(santri: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.createSantri(santri)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSantri() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menambah santri")
                }
        }
    }

    fun updateSantri(id: Int, santri: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.updateSantri(id, santri)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSantri() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal mengupdate santri")
                }
        }
    }

    fun deleteSantri(id: Int) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.deleteSantri(id)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSantri() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menghapus santri")
                }
        }
    }

    // ================= SAKIT =================
    fun loadSakit(status: String? = null, search: String? = null) {
        viewModelScope.launch {
            _isLoading.value = true
            repository.getSakit(status, search)
                .onSuccess { list ->
                    _sakitList.value = list
                    _isLoading.value = false
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal memuat data sakit")
                    _isLoading.value = false
                }
        }
    }

    fun createSakit(sakit: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.createSakit(sakit)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSakit() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menambah data sakit")
                }
        }
    }

    fun updateSakit(id: Int, sakit: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.updateSakit(id, sakit)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSakit() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal mengupdate data sakit")
                }
        }
    }

    fun deleteSakit(id: Int) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.deleteSakit(id)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadSakit() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menghapus data sakit")
                }
        }
    }

    // ================= OBAT =================
    fun loadObat(search: String? = null, lowStock: Boolean? = null) {
        viewModelScope.launch {
            _isLoading.value = true
            repository.getObat(search, lowStock)
                .onSuccess { list ->
                    _obatList.value = list
                    _isLoading.value = false
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal memuat obat")
                    _isLoading.value = false
                }
        }
    }

    fun createObat(obat: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.createObat(obat)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadObat() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menambah obat")
                }
        }
    }

    fun updateObat(id: Int, obat: Map<String, Any>) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.updateObat(id, obat)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadObat() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal mengupdate obat")
                }
        }
    }

    fun restockObat(id: Int, jumlah: Int) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.restockObat(id, jumlah)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadObat() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal restock obat")
                }
        }
    }

    fun deleteObat(id: Int) {
        viewModelScope.launch {
            _uiState.value = ResourceUiState.Loading
            repository.deleteObat(id)
                .onSuccess { message ->
                    _uiState.value = ResourceUiState.Success(message)
                    loadObat() // Refresh
                }
                .onFailure { error ->
                    _uiState.value = ResourceUiState.Error(error.message ?: "Gagal menghapus obat")
                }
        }
    }

    // ================= KELAS & JURUSAN =================
    fun loadKelas() {
        viewModelScope.launch {
            repository.getKelas()
                .onSuccess { list ->
                    _kelasList.value = list
                }
                .onFailure { }
        }
    }

    fun loadJurusan() {
        viewModelScope.launch {
            repository.getJurusan()
                .onSuccess { list ->
                    _jurusanList.value = list
                }
                .onFailure { }
        }
    }

    fun resetState() {
        _uiState.value = ResourceUiState.Idle
    }
}

sealed class ResourceUiState {
    object Idle : ResourceUiState()
    object Loading : ResourceUiState()
    data class Success(val message: String) : ResourceUiState()
    data class Error(val message: String) : ResourceUiState()
}
