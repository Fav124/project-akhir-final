package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.EditText
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.adapters.SakitAdapter
import com.example.deisa.models.Sakit
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.*

class SakitListActivity : AppCompatActivity() {

    private lateinit var rvSakit: RecyclerView
    private lateinit var etSearch: EditText
    private lateinit var adapter: SakitAdapter
    private val prefs by lazy { getSharedPreferences("app_prefs", MODE_PRIVATE) }
    
    private var allData: List<Sakit> = listOf()
    private var currentFilter: String? = null
    private var searchJob: Job? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_sakit_list)

        rvSakit = findViewById(R.id.rvSakit)
        etSearch = findViewById(R.id.etSearch)
        
        rvSakit.layoutManager = LinearLayoutManager(this)
        adapter = SakitAdapter { sakit ->
            val intent = Intent(this, DetailSakitActivity::class.java)
            intent.putExtra("SAKIT_ID", sakit.id)
            startActivity(intent)
        }
        rvSakit.adapter = adapter

        // Add button
        findViewById<ImageView>(R.id.btnAdd).setOnClickListener {
            startActivity(Intent(this, AddEditSakitActivity::class.java))
        }

        // Realtime search
        etSearch.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable?) {
                searchJob?.cancel()
                searchJob = CoroutineScope(Dispatchers.Main).launch {
                    delay(300)
                    applyFilters(s.toString())
                }
            }
        })

        // Filter chips
        setupFilterChips()

        fetchData()
    }

    private fun setupFilterChips() {
        val chipAll = findViewById<TextView>(R.id.chipAll)
        val chipRingan = findViewById<TextView>(R.id.chipRingan)
        val chipSedang = findViewById<TextView>(R.id.chipSedang)
        val chipBerat = findViewById<TextView>(R.id.chipBerat)

        val chips = listOf(chipAll to null, chipRingan to "ringan", chipSedang to "sedang", chipBerat to "berat")

        chips.forEach { (chip, filter) ->
            chip.setOnClickListener {
                currentFilter = filter
                updateChipUI(chips, chip)
                applyFilters(etSearch.text.toString())
            }
        }
    }

    private fun updateChipUI(chips: List<Pair<TextView, String?>>, activeChip: TextView) {
        chips.forEach { (chip, _) ->
            if (chip == activeChip) {
                chip.setBackgroundResource(R.drawable.bg_chip_active)
                chip.setTextColor(getColor(android.R.color.black))
            } else {
                chip.setBackgroundResource(R.drawable.bg_chip)
                chip.setTextColor(getColor(android.R.color.darker_gray))
            }
        }
    }

    private fun applyFilters(searchQuery: String) {
        var filtered = allData

        // Apply tingkat filter
        if (currentFilter != null) {
            filtered = filtered.filter { it.tingkatKondisi?.lowercase() == currentFilter }
        }

        // Apply search
        if (searchQuery.isNotEmpty()) {
            filtered = filtered.filter {
                it.santri?.displayName()?.contains(searchQuery, ignoreCase = true) == true ||
                it.keluhan?.contains(searchQuery, ignoreCase = true) == true ||
                it.diagnosis?.contains(searchQuery, ignoreCase = true) == true
            }
        }

        adapter.setData(filtered)
    }

    private fun fetchData() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""

                if (token.isEmpty()) {
                    withContext(Dispatchers.Main) {
                        Toast.makeText(this@SakitListActivity, "Not authenticated", Toast.LENGTH_SHORT).show()
                    }
                    return@launch
                }

                val response = RetrofitClient.instance.getSakit("Bearer $token")

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        allData = response.body()!!.data
                        adapter.setData(allData)
                    } else {
                        Toast.makeText(this@SakitListActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@SakitListActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    override fun onResume() {
        super.onResume()
        fetchData()
    }
}
