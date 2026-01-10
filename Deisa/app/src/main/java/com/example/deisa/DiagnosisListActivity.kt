package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.adapters.DiagnosisAdapter
import com.example.deisa.models.Diagnosis
import com.example.deisa.network.RetrofitClient
import com.google.android.material.floatingactionbutton.FloatingActionButton
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class DiagnosisListActivity : AppCompatActivity() {

    private lateinit var rvDiagnosis: RecyclerView
    private lateinit var adapter: DiagnosisAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var fabAdd: FloatingActionButton

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_diagnosis_list)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        rvDiagnosis = findViewById(R.id.rvDiagnosis)
        progressBar = findViewById(R.id.progressBar)
        tvEmpty = findViewById(R.id.tvEmpty)
        fabAdd = findViewById(R.id.fabAdd)

        adapter = DiagnosisAdapter(
            emptyList(),
            onEdit = { diagnosis ->
                val intent = Intent(this, AddEditDiagnosisActivity::class.java)
                intent.putExtra("id", diagnosis.id)
                intent.putExtra("nama_penyakit", diagnosis.namaPenyakit)
                startActivity(intent)
            },
            onDelete = { diagnosis ->
                confirmDelete(diagnosis)
            }
        )

        rvDiagnosis.layoutManager = LinearLayoutManager(this)
        rvDiagnosis.adapter = adapter

        fabAdd.setOnClickListener {
            startActivity(Intent(this, AddEditDiagnosisActivity::class.java))
        }
    }

    override fun onResume() {
        super.onResume()
        loadData()
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    private fun loadData() {
        progressBar.isVisible = true
        tvEmpty.isVisible = false
        
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.getDiagnosis("Bearer $token")
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful && response.body() != null) {
                        val list = response.body()!!.data
                        adapter.updateList(list)
                        tvEmpty.isVisible = list.isEmpty()
                    } else {
                        Toast.makeText(this@DiagnosisListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@DiagnosisListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun confirmDelete(diagnosis: Diagnosis) {
        AlertDialog.Builder(this)
            .setTitle("Hapus Diagnosis")
            .setMessage("Apakah anda yakin ingin menghapus ${diagnosis.namaPenyakit}?")
            .setPositiveButton("Hapus") { _, _ -> deleteDiagnosis(diagnosis.id) }
            .setNegativeButton("Batal", null)
            .show()
    }

    private fun deleteDiagnosis(id: Int) {
        progressBar.isVisible = true
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.deleteDiagnosis("Bearer $token", id)
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful) {
                        Toast.makeText(this@DiagnosisListActivity, "Diagnosis berhasil dihapus", Toast.LENGTH_SHORT).show()
                        loadData()
                    } else {
                        Toast.makeText(this@DiagnosisListActivity, "Gagal menghapus diagnosis", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@DiagnosisListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
