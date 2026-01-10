package com.example.deisa

import android.os.Bundle
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class LaporanActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_laporan)

        fetchData()
    }

    private fun fetchData() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
                val token = prefs.getString("token", "") ?: ""

                if (token.isEmpty()) {
                    withContext(Dispatchers.Main) {
                        Toast.makeText(this@LaporanActivity, "Not authenticated", Toast.LENGTH_SHORT).show()
                    }
                    return@launch
                }

                val response = RetrofitClient.instance.getLaporanSummary("Bearer $token")

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        val data = response.body()!!.data
                        val summary = data.summary
                        
                        findViewById<TextView>(R.id.tvTotalSakit).text = summary.totalSakit.toString()
                        findViewById<TextView>(R.id.tvCurrentlySick).text = "+${summary.currentlySick} Hari ini"
                        
                        findViewById<TextView>(R.id.tvRingan).text = summary.byTingkat.ringan.toString()
                        findViewById<TextView>(R.id.tvSedang).text = summary.byTingkat.sedang.toString()
                        findViewById<TextView>(R.id.tvBerat).text = summary.byTingkat.berat.toString()
                        
                        val alerts = data.obatAlerts
                        findViewById<TextView>(R.id.tvLowStock).text = alerts.lowStock.toString()
                        findViewById<TextView>(R.id.tvExpiring).text = alerts.expiringSoon.toString()
                        
                    } else {
                        Toast.makeText(this@LaporanActivity, "Failed to load report", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@LaporanActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
