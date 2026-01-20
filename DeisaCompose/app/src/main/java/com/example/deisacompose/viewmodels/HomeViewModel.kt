package com.example.deisacompose.viewmodels

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.launch

data class HomeStats(
    val santriCount: Int = 0,
    val sakitCount: Int = 0,
    val obatCount: Int = 0,
    val currentlySick: Int = 0
)

class HomeViewModel : BaseViewModel() {

    private val _stats = MutableLiveData<HomeStats>()
    val stats: LiveData<HomeStats> = _stats

    private val _isLoading = MutableLiveData<Boolean>()
    val isLoading: LiveData<Boolean> = _isLoading

    fun fetchStats() {
        _isLoading.postValue(true)
        viewModelScope.launch {
            try {
                // Fetch santri count
                val santriResponse = apiService.getSantri(page = 1, perPage = 1)
                val santriCount = santriResponse.body()?.meta?.total ?: 0

                // Fetch obat count
                val obatResponse = apiService.getObat(page = 1, perPage = 1)
                val obatCount = obatResponse.body()?.meta?.total ?: 0

                // Fetch laporan for sakit stats
                val laporanResponse = apiService.getLaporanSummary()
                val currentlySick = laporanResponse.body()?.data?.summary?.currentlySick ?: 0
                val totalSakit = laporanResponse.body()?.data?.summary?.totalSakit ?: 0

                _stats.postValue(
                    HomeStats(
                        santriCount = santriCount,
                        sakitCount = totalSakit,
                        obatCount = obatCount,
                        currentlySick = currentlySick
                    )
                )
            } catch (e: Exception) {
                // Default values on error
                _stats.postValue(HomeStats())
            } finally {
                _isLoading.postValue(false)
            }
        }
    }
}
