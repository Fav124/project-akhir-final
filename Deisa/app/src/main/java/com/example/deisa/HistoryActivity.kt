package com.example.deisa

import android.os.Bundle
import android.widget.ProgressBar
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.adapters.HistoryAdapter
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class HistoryActivity : AppCompatActivity() {

    private lateinit var rvHistory: RecyclerView
    private lateinit var adapter: HistoryAdapter
    private lateinit var progressBar: ProgressBar
    private lateinit var tvEmpty: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_history)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        rvHistory = findViewById(R.id.rvHistory)
        progressBar = findViewById(R.id.progressBar)
        tvEmpty = findViewById(R.id.tvEmpty)

        adapter = HistoryAdapter(emptyList())
        rvHistory.layoutManager = LinearLayoutManager(this)
        rvHistory.adapter = adapter

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
                val response = RetrofitClient.instance.getHistory("Bearer $token")
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    if (response.isSuccessful && response.body() != null) {
                        val list = response.body()!!.data
                        adapter.updateList(list)
                        tvEmpty.isVisible = list.isEmpty()
                    } else {
                        Toast.makeText(this@HistoryActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    Toast.makeText(this@HistoryActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
