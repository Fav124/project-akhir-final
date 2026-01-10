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

class AddEditJurusanActivity : AppCompatActivity() {

    private lateinit var etNamaJurusan: EditText
    private lateinit var btnSave: Button
    private lateinit var progressBar: ProgressBar
    
    private var isEdit = false
    private var jurusanId = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_edit_jurusan)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        etNamaJurusan = findViewById(R.id.etNamaJurusan)
        btnSave = findViewById(R.id.btnSave)
        progressBar = findViewById(R.id.progressBar)

        if (intent.hasExtra("id")) {
            isEdit = true
            jurusanId = intent.getIntExtra("id", -1)
            etNamaJurusan.setText(intent.getStringExtra("nama_jurusan"))
            supportActionBar?.title = "Edit Jurusan"
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
        val namaJurusan = etNamaJurusan.text.toString()
        if (namaJurusan.isEmpty()) {
            etNamaJurusan.error = "Nama jurusan wajib diisi"
            return
        }

        progressBar.isVisible = true
        btnSave.isEnabled = false
        
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = if (isEdit) {
                    RetrofitClient.instance.updateJurusan("Bearer $token", jurusanId, namaJurusan)
                } else {
                    RetrofitClient.instance.storeJurusan("Bearer $token", namaJurusan)
                }

                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    
                    if (response.isSuccessful) {
                        Toast.makeText(this@AddEditJurusanActivity, "Berhasil disimpan", Toast.LENGTH_SHORT).show()
                        finish()
                    } else {
                        Toast.makeText(this@AddEditJurusanActivity, "Gagal menyimpan: ${response.message()}", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    Toast.makeText(this@AddEditJurusanActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
