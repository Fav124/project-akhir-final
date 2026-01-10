package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class DetailSakitActivity : AppCompatActivity() {

    private val prefs by lazy { getSharedPreferences("app_prefs", MODE_PRIVATE) }
    private var sakitId: Int = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_detail_sakit)

        sakitId = intent.getIntExtra("SAKIT_ID", -1)
        
        // Show delete button only for admin
        val isAdmin = prefs.getBoolean("is_admin", false)
        findViewById<ImageView>(R.id.btnDelete).isVisible = isAdmin

        setupButtons()
        
        if (sakitId != -1) {
            fetchDetail(sakitId)
        }
    }

    private fun setupButtons() {
        findViewById<ImageView>(R.id.btnEdit).setOnClickListener {
            val intent = Intent(this, AddEditSakitActivity::class.java)
            intent.putExtra("SAKIT_ID", sakitId)
            intent.putExtra("MODE", "edit")
            startActivity(intent)
        }

        findViewById<ImageView>(R.id.btnDelete).setOnClickListener {
            showDeleteConfirmation()
        }

        findViewById<Button>(R.id.btnMarkRecovered).setOnClickListener {
            markRecovered()
        }
    }

    private fun showDeleteConfirmation() {
        AlertDialog.Builder(this)
            .setTitle("Hapus Data")
            .setMessage("Apakah Anda yakin ingin menghapus data ini?")
            .setPositiveButton("Hapus") { _, _ -> deleteSakit() }
            .setNegativeButton("Batal", null)
            .show()
    }

    private fun deleteSakit() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""
                val response = RetrofitClient.instance.deleteSakit("Bearer $token", sakitId)

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful) {
                        Toast.makeText(this@DetailSakitActivity, "Data berhasil dihapus", Toast.LENGTH_SHORT).show()
                        finish()
                    } else {
                        Toast.makeText(this@DetailSakitActivity, "Gagal menghapus data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@DetailSakitActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun markRecovered() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""
                val response = RetrofitClient.instance.markRecovered("Bearer $token", sakitId)

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful) {
                        Toast.makeText(this@DetailSakitActivity, "Status diubah menjadi sembuh", Toast.LENGTH_SHORT).show()
                        fetchDetail(sakitId) // Refresh
                    } else {
                        Toast.makeText(this@DetailSakitActivity, "Gagal mengubah status", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@DetailSakitActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun fetchDetail(id: Int) {
        CoroutineScope(Dispatchers.IO).launch {
             try {
                val token = prefs.getString("token", "") ?: ""

                val response = RetrofitClient.instance.getSakitDetail("Bearer $token", id)
                 withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        val sakit = response.body()!!.data
                        findViewById<TextView>(R.id.tvDetailName).text = sakit.santri?.displayName() ?: ""
                        findViewById<TextView>(R.id.tvDetailNis).text = "NIS: ${sakit.santri?.nis ?: "-"}"
                        findViewById<TextView>(R.id.tvDetailStatus).text = sakit.status ?: "Sakit"
                        findViewById<TextView>(R.id.tvDetailDate).text = sakit.displayDate()
                        findViewById<TextView>(R.id.tvDetailTingkat).text = sakit.tingkatKondisi ?: "-"
                        findViewById<TextView>(R.id.tvDetailDiagnosis).text = sakit.diagnosis ?: "-"
                        findViewById<TextView>(R.id.tvDetailKeluhan).text = sakit.keluhan ?: "-"
                        
                        // Hide recovered button if already sembuh
                        findViewById<Button>(R.id.btnMarkRecovered).isVisible = sakit.status != "sembuh"
                    } else {
                        Toast.makeText(this@DetailSakitActivity, "Failed to load detail", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@DetailSakitActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    override fun onResume() {
        super.onResume()
        if (sakitId != -1) {
            fetchDetail(sakitId)
        }
    }
}
