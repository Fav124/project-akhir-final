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

class SantriDetailActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_santri_detail)

        val santriId = intent.getIntExtra("SANTRI_ID", -1)
        if (santriId != -1) {
            fetchDetail(santriId)
        }
    }

    private fun fetchDetail(id: Int) {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
                val token = prefs.getString("token", "") ?: ""

                val response = RetrofitClient.instance.getSantriDetail("Bearer $token", id)

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        val data = response.body()!!.data
                        val santri = data.santri
                        
                        findViewById<TextView>(R.id.tvDetailName).text = santri.displayName()
                        findViewById<TextView>(R.id.tvDetailNis).text = "NIS: ${santri.nis ?: "-"}"
                        findViewById<TextView>(R.id.tvDetailKelas).text = santri.displayKelas()
                        findViewById<TextView>(R.id.tvDetailStatus).text = santri.statusKesehatan ?: "Sehat"
                        
                        val stats = data.statistics
                        if (stats != null) {
                            findViewById<TextView>(R.id.tvSickCount).text = "${stats.totalSickRecords}x Sakit"
                        }
                    } else {
                        Toast.makeText(this@SantriDetailActivity, "Failed to load detail", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@SantriDetailActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
