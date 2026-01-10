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
import com.example.deisa.adapters.JurusanAdapter
import com.example.deisa.models.Jurusan
import com.example.deisa.network.RetrofitClient
import com.google.android.material.floatingactionbutton.FloatingActionButton
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class JurusanListActivity : AppCompatActivity() {

    private lateinit var rvJurusan: RecyclerView
    private lateinit var adapter: JurusanAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView
    private lateinit var fabAdd: FloatingActionButton

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_jurusan_list)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        rvJurusan = findViewById(R.id.rvJurusan)
        progressBar = findViewById(R.id.progressBar)
        tvEmpty = findViewById(R.id.tvEmpty)
        fabAdd = findViewById(R.id.fabAdd)

        adapter = JurusanAdapter(
            emptyList(),
            onEdit = { jurusan ->
                val intent = Intent(this, AddEditJurusanActivity::class.java)
                intent.putExtra("id", jurusan.id)
                intent.putExtra("nama_jurusan", jurusan.namaJurusan)
                startActivity(intent)
            },
            onDelete = { jurusan ->
                confirmDelete(jurusan)
            }
        )

        rvJurusan.layoutManager = LinearLayoutManager(this)
        rvJurusan.adapter = adapter

        fabAdd.setOnClickListener {
            startActivity(Intent(this, AddEditJurusanActivity::class.java))
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
                val response = RetrofitClient.instance.getJurusan("Bearer $token")
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful && response.body() != null) {
                        val list = response.body()!!.data
                        adapter.updateList(list)
                        tvEmpty.isVisible = list.isEmpty()
                    } else {
                        Toast.makeText(this@JurusanListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@JurusanListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun confirmDelete(jurusan: Jurusan) {
        AlertDialog.Builder(this)
            .setTitle("Hapus Jurusan")
            .setMessage("Apakah anda yakin ingin menghapus jurusan ${jurusan.namaJurusan}?")
            .setPositiveButton("Hapus") { _, _ -> deleteJurusan(jurusan.id) }
            .setNegativeButton("Batal", null)
            .show()
    }

    private fun deleteJurusan(id: Int) {
        progressBar.isVisible = true
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val token = prefs.getString("token", "") ?: ""

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.deleteJurusan("Bearer $token", id)
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful) {
                        Toast.makeText(this@JurusanListActivity, "Jurusan berhasil dihapus", Toast.LENGTH_SHORT).show()
                        loadData()
                    } else {
                        Toast.makeText(this@JurusanListActivity, "Gagal menghapus jurusan", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@JurusanListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
