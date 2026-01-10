package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.adapters.ObatAdapter
import com.example.deisa.models.Obat
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.*

class ObatListActivity : AppCompatActivity() {

    private lateinit var rvObat: RecyclerView
    private lateinit var etSearch: EditText
    private lateinit var adapter: ObatAdapter
    private val prefs by lazy { getSharedPreferences("app_prefs", MODE_PRIVATE) }

    private var allData: List<Obat> = listOf()
    private var searchJob: Job? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_obat_list)

        rvObat = findViewById(R.id.rvObat)
        etSearch = findViewById(R.id.etSearch)
        
        rvObat.layoutManager = LinearLayoutManager(this)
        adapter = ObatAdapter { obat ->
            Toast.makeText(this, "Detail: ${obat.namaObat}", Toast.LENGTH_SHORT).show()
            // Future: Navigate to ObatDetailActivity
        }
        rvObat.adapter = adapter

        // Realtime search
        etSearch.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable?) {
                searchJob?.cancel()
                searchJob = CoroutineScope(Dispatchers.Main).launch {
                    delay(300)
                    filterData(s.toString())
                }
            }
        })

        fetchData()
    }

    private fun filterData(query: String) {
        if (query.isEmpty()) {
            adapter.setData(allData)
        } else {
            val filtered = allData.filter {
                it.namaObat.contains(query, ignoreCase = true) ||
                it.deskripsi?.contains(query, ignoreCase = true) == true
            }
            adapter.setData(filtered)
        }
    }

    private fun fetchData() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""

                if (token.isEmpty()) {
                    withContext(Dispatchers.Main) {
                        Toast.makeText(this@ObatListActivity, "Not authenticated", Toast.LENGTH_SHORT).show()
                    }
                    return@launch
                }

                val response = RetrofitClient.instance.getObats("Bearer $token")

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        allData = response.body()!!.data
                        adapter.setData(allData)
                    } else {
                        Toast.makeText(this@ObatListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@ObatListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    override fun onResume() {
        super.onResume()
        fetchData()
    }
}
