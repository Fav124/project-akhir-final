package com.example.deisacompose.viewmodels

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.example.deisacompose.data.models.*
import com.example.deisacompose.data.network.RetrofitClient
import kotlinx.coroutines.launch

class ManagementViewModel(application: Application) : AndroidViewModel(application) {
    
    private fun getToken(): String = "Bearer " + getApplication<Application>()
        .getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
        .getString("token", "")

    // Users
    private val _userList = MutableLiveData<List<User>>()
    val userList: LiveData<List<User>> = _userList
    
    fun fetchUsers() {
        viewModelScope.launch {
            try {
                 val response = RetrofitClient.instance.getUsers(getToken())
                 if (response.isSuccessful) _userList.value = response.body() ?: emptyList()
            } catch(e: Exception) {}
        }
    }
    
    fun deleteUser(id: Int) {
        viewModelScope.launch {
            RetrofitClient.instance.deleteUser(getToken(), id)
            fetchUsers()
        }
    }

    // Kelas
    private val _kelasList = MutableLiveData<List<Kelas>>()
    val kelasList: LiveData<List<Kelas>> = _kelasList
    
    fun fetchKelas() {
        viewModelScope.launch {
             try {
                val response = RetrofitClient.instance.getKelas(getToken())
                if(response.isSuccessful) _kelasList.value = response.body()?.data ?: emptyList()
            } catch(e: Exception) {}
        }
    }
    
    fun addKelas(nama: String) {
        viewModelScope.launch {
            RetrofitClient.instance.storeKelas(getToken(), KelasRequest(nama))
            fetchKelas()
        }
    }
    
     fun deleteKelas(id: Int) {
        viewModelScope.launch {
            RetrofitClient.instance.deleteKelas(getToken(), id)
            fetchKelas()
        }
    }

    // Jurusan
    private val _jurusanList = MutableLiveData<List<Jurusan>>()
    val jurusanList: LiveData<List<Jurusan>> = _jurusanList
    
    fun fetchJurusan() {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getJurusan(getToken())
                if(response.isSuccessful) _jurusanList.value = response.body()?.data ?: emptyList()
            } catch(e: Exception) {}
        }
    }
    
     fun addJurusan(nama: String) {
        viewModelScope.launch {
            RetrofitClient.instance.storeJurusan(getToken(), JurusanRequest(nama))
            fetchJurusan()
        }
    }
    
    fun deleteJurusan(id: Int) {
        viewModelScope.launch {
            RetrofitClient.instance.deleteJurusan(getToken(), id)
            fetchJurusan()
        }
    }

    // Diagnosis
    private val _diagnosisList = MutableLiveData<List<Diagnosis>>()
    val diagnosisList: LiveData<List<Diagnosis>> = _diagnosisList
    
    fun fetchDiagnosis() {
         viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getDiagnosis(getToken())
                if(response.isSuccessful) _diagnosisList.value = response.body() ?: emptyList()
            } catch(e: Exception) {}
        }
    }
    
    fun addDiagnosis(nama: String, deskripsi: String?) {
         viewModelScope.launch {
            RetrofitClient.instance.storeDiagnosis(getToken(), DiagnosisRequest(nama, deskripsi))
            fetchDiagnosis()
        }
    }
    
    // History
    private val _historyList = MutableLiveData<List<ActivityLog>>()
    val historyList: LiveData<List<ActivityLog>> = _historyList
    
    fun fetchHistory() {
        viewModelScope.launch {
            try {
                val response = RetrofitClient.instance.getHistory(getToken())
                if(response.isSuccessful) _historyList.value = response.body()?.data?.data ?: emptyList()
            } catch(e: Exception) {}
        }
    }
}
