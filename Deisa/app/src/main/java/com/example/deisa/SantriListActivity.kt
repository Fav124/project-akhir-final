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
import com.example.deisa.adapters.SantriAdapter
import com.example.deisa.models.Santri
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.*

class SantriListActivity : AppCompatActivity() {

    private lateinit var rvSantri: RecyclerView
    private lateinit var etSearch: EditText
    private lateinit var adapter: SantriAdapter
    private val prefs by lazy { getSharedPreferences("app_prefs", MODE_PRIVATE) }

    private var allData: List<Santri> = listOf()
    private var searchJob: Job? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_santri_list)

        rvSantri = findViewById(R.id.rvSantri)
        etSearch = findViewById(R.id.etSearch)
        
        rvSantri.layoutManager = LinearLayoutManager(this)
        adapter = SantriAdapter { santri ->
            val intent = Intent(this, SantriDetailActivity::class.java)
            intent.putExtra("SANTRI_ID", santri.id)
            startActivity(intent)
        }
        rvSantri.adapter = adapter

        // Realtime search
        etSearch.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable?) {
                searchJob?.cancel()
                searchJob = CoroutineScope(Dispatchers.Main).launch {
                    delay(300) // Debounce
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
                it.displayName().contains(query, ignoreCase = true) ||
                it.nis?.contains(query, ignoreCase = true) == true ||
                it.displayKelas().contains(query, ignoreCase = true)
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
                        Toast.makeText(this@SantriListActivity, "Not authenticated", Toast.LENGTH_SHORT).show()
                    }
                    return@launch
                }

                val response = RetrofitClient.instance.getSantri("Bearer $token")

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        allData = response.body()!!.data
                        adapter.setData(allData)
                    } else {
                        Toast.makeText(this@SantriListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@SantriListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    override fun onResume() {
        super.onResume()
        fetchData()
    }
}
