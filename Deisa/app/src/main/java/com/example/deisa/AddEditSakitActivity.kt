package com.example.deisa

import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.example.deisa.models.Santri
import com.example.deisa.models.SakitRequest
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import java.text.SimpleDateFormat
import java.util.*

class AddEditSakitActivity : AppCompatActivity() {

    private val prefs by lazy { getSharedPreferences("app_prefs", MODE_PRIVATE) }
    private var sakitId: Int = -1
    private var isEditMode = false
    private var selectedTingkat = "ringan"
    private var santriList: List<Santri> = listOf()
    private var selectedSantriId: Int = -1

    private lateinit var spSantri: Spinner
    private lateinit var etTanggal: EditText
    private lateinit var etDiagnosis: EditText
    private lateinit var etGejala: EditText
    private lateinit var etTindakan: EditText
    private lateinit var btnRingan: TextView
    private lateinit var btnSedang: TextView
    private lateinit var btnBerat: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_edit_sakit)

        sakitId = intent.getIntExtra("SAKIT_ID", -1)
        isEditMode = intent.getStringExtra("MODE") == "edit"

        initViews()
        setupTingkatButtons()
        setupButtons()
        loadSantriList()

        if (isEditMode && sakitId != -1) {
            findViewById<TextView>(R.id.tvTitle).text = "Edit Data Sakit"
            loadSakitData()
        } else {
            // Set default date to today
            val sdf = SimpleDateFormat("yyyy-MM-dd", Locale.getDefault())
            etTanggal.setText(sdf.format(Date()))
        }
    }

    private fun initViews() {
        spSantri = findViewById(R.id.spSantri)
        etTanggal = findViewById(R.id.etTanggal)
        etDiagnosis = findViewById(R.id.etDiagnosis)
        etGejala = findViewById(R.id.etGejala)
        etTindakan = findViewById(R.id.etTindakan)
        btnRingan = findViewById(R.id.btnRingan)
        btnSedang = findViewById(R.id.btnSedang)
        btnBerat = findViewById(R.id.btnBerat)
    }

    private fun setupTingkatButtons() {
        val buttons = listOf(btnRingan to "ringan", btnSedang to "sedang", btnBerat to "berat")
        
        buttons.forEach { (btn, tingkat) ->
            btn.setOnClickListener {
                selectedTingkat = tingkat
                updateTingkatUI()
            }
        }
    }

    private fun updateTingkatUI() {
        val buttons = listOf(btnRingan to "ringan", btnSedang to "sedang", btnBerat to "berat")
        buttons.forEach { (btn, tingkat) ->
            if (tingkat == selectedTingkat) {
                btn.setBackgroundResource(R.drawable.bg_chip_active)
                btn.setTextColor(getColor(android.R.color.black))
            } else {
                btn.setBackgroundResource(R.drawable.bg_chip)
                btn.setTextColor(getColor(android.R.color.darker_gray))
            }
        }
    }

    private fun setupButtons() {
        findViewById<Button>(R.id.btnCancel).setOnClickListener { finish() }
        findViewById<Button>(R.id.btnSubmit).setOnClickListener { submitForm() }
    }

    private fun loadSantriList() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""
                val response = RetrofitClient.instance.getSantri("Bearer $token")

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        santriList = response.body()!!.data
                        val names = santriList.map { it.displayName() }
                        val adapter = ArrayAdapter(this@AddEditSakitActivity, android.R.layout.simple_spinner_item, names)
                        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
                        spSantri.adapter = adapter
                        
                        spSantri.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
                            override fun onItemSelected(parent: AdapterView<*>?, view: android.view.View?, position: Int, id: Long) {
                                selectedSantriId = santriList[position].id
                            }
                            override fun onNothingSelected(parent: AdapterView<*>?) {}
                        }
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@AddEditSakitActivity, "Failed to load santri list", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun loadSakitData() {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""
                val response = RetrofitClient.instance.getSakitDetail("Bearer $token", sakitId)

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful && response.body() != null) {
                        val sakit = response.body()!!.data
                        etTanggal.setText(sakit.displayDate())
                        etDiagnosis.setText(sakit.diagnosis ?: "")
                        etGejala.setText(sakit.gejala ?: "")
                        etTindakan.setText(sakit.tindakan ?: "")
                        selectedTingkat = sakit.tingkatKondisi ?: "ringan"
                        selectedSantriId = sakit.santriId
                        updateTingkatUI()
                        
                        // Set spinner to correct santri
                        val idx = santriList.indexOfFirst { it.id == selectedSantriId }
                        if (idx >= 0) spSantri.setSelection(idx)
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@AddEditSakitActivity, "Failed to load data", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    private fun submitForm() {
        val tanggal = etTanggal.text.toString()
        val diagnosis = etDiagnosis.text.toString()
        val gejala = etGejala.text.toString()
        val tindakan = etTindakan.text.toString()

        if (selectedSantriId == -1 || tanggal.isEmpty() || diagnosis.isEmpty() || gejala.isEmpty() || tindakan.isEmpty()) {
            Toast.makeText(this, "Harap lengkapi semua field", Toast.LENGTH_SHORT).show()
            return
        }

        val request = SakitRequest(
            santriId = selectedSantriId,
            tanggalMulaiSakit = tanggal,
            keluhan = gejala,
            tingkatKondisi = selectedTingkat,
            diagnosis = diagnosis,
            gejala = gejala,
            tindakan = tindakan,
            status = "sakit"
        )

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val token = prefs.getString("token", "") ?: ""
                val response = if (isEditMode) {
                    RetrofitClient.instance.updateSakit("Bearer $token", sakitId, request)
                } else {
                    RetrofitClient.instance.storeSakit("Bearer $token", request)
                }

                withContext(Dispatchers.Main) {
                    if (response.isSuccessful) {
                        Toast.makeText(this@AddEditSakitActivity, "Data berhasil disimpan", Toast.LENGTH_SHORT).show()
                        finish()
                    } else {
                        Toast.makeText(this@AddEditSakitActivity, "Gagal menyimpan data", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    Toast.makeText(this@AddEditSakitActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
