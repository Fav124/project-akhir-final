package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import com.example.deisacompose.data.network.ApiClient

open class BaseViewModel : ViewModel() {
    protected val apiService = ApiClient.instance
}
