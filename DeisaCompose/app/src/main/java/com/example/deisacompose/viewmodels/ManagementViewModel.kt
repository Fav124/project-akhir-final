package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.*
import kotlinx.coroutines.launch

class ManagementViewModel : BaseViewModel() {

    private val _userList = MutableLiveData<List<User>>()
    val userList: LiveData<List<User>> = _userList

    private val _kelasList = MutableLiveData<List<Kelas>>()
    val kelasList: LiveData<List<Kelas>> = _kelasList

    private val _jurusanList = MutableLiveData<List<Jurusan>>()
    val jurusanList: LiveData<List<Jurusan>> = _jurusanList

    private val _diagnosisList = MutableLiveData<List<Diagnosis>>()
    val diagnosisList: LiveData<List<Diagnosis>> = _diagnosisList

    private val _historyList = MutableLiveData<List<ActivityLog>>()
    val historyList: LiveData<List<ActivityLog>> = _historyList

    fun fetchUsers() {
        viewModelScope.launch {
            try {
                val response = apiService.getUsers()
                if (response.isSuccessful) {
                    _userList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun deleteUser(id: Int) {
        viewModelScope.launch {
            try {
                apiService.deleteUser(id)
                fetchUsers()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun fetchKelas() {
        viewModelScope.launch {
            try {
                val response = apiService.getKelas()
                if (response.isSuccessful) {
                    _kelasList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun addKelas(nama: String) {
        viewModelScope.launch {
            try {
                apiService.addKelas(KelasRequest(nama))
                fetchKelas()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun deleteKelas(id: Int) {
        viewModelScope.launch {
            try {
                apiService.deleteKelas(id)
                fetchKelas()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun fetchJurusan() {
        viewModelScope.launch {
            try {
                val response = apiService.getJurusan()
                if (response.isSuccessful) {
                    _jurusanList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun addJurusan(nama: String) {
        viewModelScope.launch {
            try {
                apiService.addJurusan(JurusanRequest(nama))
                fetchJurusan()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun deleteJurusan(id: Int) {
        viewModelScope.launch {
            try {
                apiService.deleteJurusan(id)
                fetchJurusan()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun fetchDiagnosis() {
        viewModelScope.launch {
            try {
                val response = apiService.getDiagnosis()
                if (response.isSuccessful) {
                    _diagnosisList.postValue(response.body()?.data)
                }
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun addDiagnosis(nama: String, deskripsi: String?) {
        viewModelScope.launch {
            try {
                apiService.addDiagnosis(DiagnosisRequest(nama, deskripsi))
                fetchDiagnosis()
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun fetchHistory() {
        viewModelScope.launch {
            try {
                val response = apiService.getHistory()
                if (response.isSuccessful) {
                    _historyList.postValue(response.body()?.data?.data)
                }
            } catch (e: Exception) {
                // Handle error
            }
        }
    }
}