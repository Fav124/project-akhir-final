package com.example.deisa

import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.ProgressBar
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class AddEditKelasActivity : AppCompatActivity() {

    private lateinit var etNamaKelas: EditText
    private lateinit var btnSave: Button
    private lateinit var progressBar: ProgressBar
    
    private var isEdit = false
    private var kelasId = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_edit_kelas)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        etNamaKelas = findViewById(R.id.etNamaKelas)
        btnSave = findViewById(R.id.btnSave)
        progressBar = findViewById(R.id.progressBar)

        if (intent.hasExtra("id")) {
            isEdit = true
            kelasId = intent.getIntExtra("id", -1)
            etNamaKelas.setText(intent.getStringExtra("nama_kelas"))
            supportActionBar?.title = "Edit Kelas"
        }

        btnSave.setOnClickListener {
            saveData()
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    private fun saveData() {
        val namaKelas = etNamaKelas.text.toString()
        if (namaKelas.isEmpty()) {
            etNamaKelas.error = "Nama kelas wajib diisi"
            return
        }

        progressBar.isVisible = true
        btnSave.isEnabled = false
        
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = if (isEdit) {
                    RetrofitClient.instance.updateKelas("Bearer $token", kelasId, namaKelas)
                } else {
                    RetrofitClient.instance.storeKelas("Bearer $token", namaKelas)
                }

                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    
                    if (response.isSuccessful) {
                        Toast.makeText(this@AddEditKelasActivity, "Berhasil disimpan", Toast.LENGTH_SHORT).show()
                        finish()
                    } else {
                        Toast.makeText(this@AddEditKelasActivity, "Gagal menyimpan: ${response.message()}", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    Toast.makeText(this@AddEditKelasActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
