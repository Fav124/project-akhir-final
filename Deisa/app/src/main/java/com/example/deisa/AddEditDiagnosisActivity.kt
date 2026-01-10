package com.example.deisa

import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.ProgressBar
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import androidx.core.view.isVisible
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class AddEditDiagnosisActivity : AppCompatActivity() {

    private lateinit var etNamaPenyakit: EditText
    private lateinit var btnSave: Button
    private lateinit var progressBar: ProgressBar
    
    private var isEdit = false
    private var diagnosisId = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_edit_diagnosis)

        val toolbar: Toolbar = findViewById(R.id.toolbar)
        setSupportActionBar(toolbar)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        etNamaPenyakit = findViewById(R.id.etNamaPenyakit)
        btnSave = findViewById(R.id.btnSave)
        progressBar = findViewById(R.id.progressBar)

        if (intent.hasExtra("id")) {
            isEdit = true
            diagnosisId = intent.getIntExtra("id", -1)
            etNamaPenyakit.setText(intent.getStringExtra("nama_penyakit"))
            supportActionBar?.title = "Edit Diagnosis"
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
        val namaPenyakit = etNamaPenyakit.text.toString()
        if (namaPenyakit.isEmpty()) {
            etNamaPenyakit.error = "Nama penyakit wajib diisi"
            return
        }

        progressBar.isVisible = true
        btnSave.isEnabled = false
        
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = if (isEdit) {
                    RetrofitClient.instance.updateDiagnosis("Bearer $token", diagnosisId, namaPenyakit)
                } else {
                    RetrofitClient.instance.storeDiagnosis("Bearer $token", namaPenyakit)
                }

                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    
                    if (response.isSuccessful) {
                        Toast.makeText(this@AddEditDiagnosisActivity, "Berhasil disimpan", Toast.LENGTH_SHORT).show()
                        finish()
                    } else {
                        Toast.makeText(this@AddEditDiagnosisActivity, "Gagal menyimpan: ${response.message()}", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnSave.isEnabled = true
                    Toast.makeText(this@AddEditDiagnosisActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
