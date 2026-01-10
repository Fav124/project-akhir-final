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
import com.example.deisa.adapters.KelasAdapter
import com.example.deisa.models.Kelas
import com.example.deisa.network.RetrofitClient
import com.google.android.material.floatingactionbutton.FloatingActionButton
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class KelasListActivity : AppCompatActivity() {

    private lateinit var rvKelas: RecyclerView
    private lateinit var adapter: KelasAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var fabAdd: FloatingActionButton

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_kelas_list)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        rvKelas = findViewById(R.id.rvKelas)
        progressBar = findViewById(R.id.progressBar)
        tvEmpty = findViewById(R.id.tvEmpty)
        fabAdd = findViewById(R.id.fabAdd)

        adapter = KelasAdapter(
            emptyList(),
            onEdit = { kelas ->
                val intent = Intent(this, AddEditKelasActivity::class.java)
                intent.putExtra("id", kelas.id)
                intent.putExtra("nama_kelas", kelas.namaKelas)
                startActivity(intent)
            },
            onDelete = { kelas ->
                confirmDelete(kelas)
            }
        )

        rvKelas.layoutManager = LinearLayoutManager(this)
        rvKelas.adapter = adapter

        fabAdd.setOnClickListener {
            startActivity(Intent(this, AddEditKelasActivity::class.java))
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
                val response = RetrofitClient.instance.getKelas("Bearer $token")
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful && response.body() != null) {
                        val list = response.body()!!.data
                        adapter.updateList(list)
                        tvEmpty.isVisible = list.isEmpty()
                    } else {
                        Toast.makeText(this@KelasListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@KelasListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun confirmDelete(kelas: Kelas) {
        AlertDialog.Builder(this)
            .setTitle("Hapus Kelas")
            .setMessage("Apakah anda yakin ingin menghapus kelas ${kelas.namaKelas}?")
            .setPositiveButton("Hapus") { _, _ -> deleteKelas(kelas.id) }
            .setNegativeButton("Batal", null)
            .show()
    }

    private fun deleteKelas(id: Int) {
        progressBar.isVisible = true
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.deleteKelas("Bearer $token", id)
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful) {
                        Toast.makeText(this@KelasListActivity, "Kelas berhasil dihapus", Toast.LENGTH_SHORT).show()
                        loadData()
                    } else {
                        Toast.makeText(this@KelasListActivity, "Gagal menghapus kelas", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@KelasListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
