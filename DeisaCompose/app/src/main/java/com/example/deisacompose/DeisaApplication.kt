package com.example.deisacompose

import android.app.Application
import com.example.deisacompose.data.network.ApiClient

class DeisaApplication : Application() {
    override fun onCreate() {
        super.onCreate()
        ApiClient.initialize(this)
    }
}
