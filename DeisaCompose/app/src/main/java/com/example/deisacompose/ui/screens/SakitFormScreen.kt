package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.ObatUsageRequest
import com.example.deisacompose.data.models.SakitRequest
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.*
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitFormScreen(
    navController: NavController,
    viewModel: SakitViewModel = viewModel(),
    santriViewModel: SantriViewModel = viewModel(),
    obatViewModel: ObatViewModel = viewModel(),
    mgmtViewModel: ManagementViewModel = viewModel(),
    sakitId: Int? = null
) {
    // Selection States
    var selectedSantriId by remember { mutableStateOf<Int?>(null) }
    var tglMasuk by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Sakit") }
    var jenisPerawatan by remember { mutableStateOf("UKS") }
    var tujuanRujukan by remember { mutableStateOf("") }
    var gejala by remember { mutableStateOf("") }
    var tindakan by remember { mutableStateOf("") }
    var catatan by remember { mutableStateOf("") }
    
    // Multi-select for Diagnosis
    var selectedDiagnosisIds by remember { mutableStateOf(setOf<Int>()) }
    
    // Multi-select for Obat
    var obatUsageList by remember { mutableStateOf(listOf<ObatUsageState>()) }
    
    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()
    
    var isLoading by remember { mutableStateOf(false) }
    
    val santriList by santriViewModel.santriList.observeAsState(emptyList())
    val diagnosisList by mgmtViewModel.diagnosisList.observeAsState(emptyList())
    val obatList by obatViewModel.obatList.observeAsState(emptyList())
    val sakitDetail by viewModel.sakitDetail.observeAsState()

    // Initial Fetch
    LaunchedEffect(Unit) {
        santriViewModel.fetchSantri()
        mgmtViewModel.fetchDiagnosis()
        obatViewModel.fetchObat()
    }

    LaunchedEffect(sakitId) {
        if (sakitId != null) viewModel.getSakitById(sakitId)
        else viewModel.clearDetail()
    }
    
    LaunchedEffect(sakitDetail) {
        sakitDetail?.let {
            selectedSantriId = it.santriId
            tglMasuk = it.tanggalMulaiSakit ?: it.tanggalSakit ?: ""
            status = it.status ?: "Sakit"
            gejala = it.gejala ?: ""
            tindakan = it.tindakan ?: ""
            catatan = it.catatan ?: ""
            // Pivot and medicines would need more logic if editing complex ones
        }
    }

    Scaffold(
        topBar = { DeisaTopBar(if (sakitId == null) "Catat Sakit" else "Edit Data Sakit") },
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {
            // Santri Selection
            DeisaDropdown(
                label = "Santri",
                options = santriList.map { it.displayName() },
                selectedOption = santriList.find { it.id == selectedSantriId }?.displayName() ?: "Pilih Santri",
                onOptionSelected = { name -> 
                    selectedSantriId = santriList.find { it.displayName() == name }?.id
                }
            )
            
            Spacer(modifier = Modifier.height(8.dp))
            DeisaDatePickerField(value = tglMasuk, onValueChange = { tglMasuk = it }, label = "Tanggal Masuk")
            
            Spacer(modifier = Modifier.height(8.dp))
            Row(modifier = Modifier.fillMaxWidth()) {
                Box(modifier = Modifier.weight(1f)) {
                    DeisaDropdown(
                        label = "Status",
                        options = listOf("Sakit", "Pulang"),
                        selectedOption = status,
                        onOptionSelected = { status = it }
                    )
                }
                Spacer(modifier = Modifier.width(8.dp))
                Box(modifier = Modifier.weight(1f)) {
                    DeisaDropdown(
                        label = "Jenis Perawatan",
                        options = listOf("UKS", "Rumah Sakit", "Pulang"),
                        selectedOption = jenisPerawatan,
                        onOptionSelected = { jenisPerawatan = it }
                    )
                }
            }
            
            if (jenisPerawatan == "Rumah Sakit") {
                Spacer(modifier = Modifier.height(8.dp))
                DeisaTextField(value = tujuanRujukan, onValueChange = { tujuanRujukan = it }, label = "Tujuan Rujukan (RS/Klinik)")
            }

            Spacer(modifier = Modifier.height(16.dp))
            DeisaTextField(value = gejala, onValueChange = { gejala = it }, label = "Gejala (Keluhan)")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = tindakan, onValueChange = { tindakan = it }, label = "Tindakan yang diberikan")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = catatan, onValueChange = { catatan = it }, label = "Catatan Lainnya")

            Spacer(modifier = Modifier.height(24.dp))
            Text("Diagnosis (Opsional)", style = MaterialTheme.typography.titleMedium)
            // Chip flow for Diagnosis (Multi-select)
            FlowRow(modifier = Modifier.fillMaxWidth()) {
                diagnosisList.forEach { diag -> 
                    FilterChip(
                        selected = selectedDiagnosisIds.contains(diag.id),
                        onClick = { 
                            selectedDiagnosisIds = if (selectedDiagnosisIds.contains(diag.id)) {
                                selectedDiagnosisIds - diag.id
                            } else {
                                selectedDiagnosisIds + diag.id
                            }
                        },
                        label = { Text(diag.namaPenyakit ?: "Unknown") },
                        modifier = Modifier.padding(end = 8.dp)
                    )
                }
            }

            Spacer(modifier = Modifier.height(24.dp))
            Row(verticalAlignment = Alignment.CenterVertically) {
                Text("Pemberian Obat", style = MaterialTheme.typography.titleMedium, modifier = Modifier.weight(1f))
                IconButton(onClick = { obatUsageList = obatUsageList + ObatUsageState() }) {
                    Icon(Icons.Default.Add, contentDescription = "Add Medicine", tint = MaterialTheme.colorScheme.primary)
                }
            }
            
            obatUsageList.forEachIndexed { index, usage ->
                Card(
                    modifier = Modifier.fillMaxWidth().padding(vertical = 4.dp),
                    colors = CardDefaults.cardColors(containerColor = MaterialTheme.colorScheme.surfaceVariant.copy(alpha = 0.5f))
                ) {
                    Row(
                        modifier = Modifier.padding(8.dp),
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Column(modifier = Modifier.weight(1f)) {
                             DeisaDropdown(
                                label = "Pilih Obat",
                                options = obatList.map { it.namaObat },
                                selectedOption = obatList.find { it.id == usage.obatId }?.namaObat ?: "Obat",
                                onOptionSelected = { name -> 
                                    val obat = obatList.find { it.namaObat == name }
                                    if (obat != null) {
                                        obatUsageList = obatUsageList.toMutableList().also {
                                            it[index] = it[index].copy(obatId = obat.id, name = name)
                                        }
                                    }
                                }
                            )
                        }
                        Spacer(modifier = Modifier.width(8.dp))
                        Box(modifier = Modifier.width(80.dp)) {
                             DeisaTextField(
                                value = usage.jumlah,
                                onValueChange = { qty -> 
                                    obatUsageList = obatUsageList.toMutableList().also {
                                        it[index] = it[index].copy(jumlah = qty)
                                    }
                                },
                                label = "Qty",
                                keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number)
                            )
                        }
                        IconButton(onClick = { 
                            obatUsageList = obatUsageList.toMutableList().also { it.removeAt(index) }
                        }) {
                            Icon(Icons.Default.Delete, contentDescription = "Remove", tint = Color.Red)
                        }
                    }
                }
            }

            Spacer(modifier = Modifier.height(32.dp))
            
            DeisaButton(
                text = if (sakitId == null) "Simpan Data" else "Update Data",
                onClick = {
                    if (selectedSantriId == null || tglMasuk.isEmpty()) {
                        scope.launch {
                            snackbarHostState.showSnackbar("Mohon isi Santri dan Tanggal Masuk")
                        }
                        return@DeisaButton
                    }
                    
                    isLoading = true
                    val request = SakitRequest(
                        santriId = selectedSantriId!!,
                        tglMasuk = tglMasuk,
                        status = status,
                        jenisPerawatan = jenisPerawatan,
                        tujuanRujukan = if(jenisPerawatan == "Rumah Sakit") tujuanRujukan else null,
                        gejala = gejala,
                        tindakan = tindakan,
                        catatan = catatan,
                        diagnosisIds = selectedDiagnosisIds.toList(),
                        obatUsage = obatUsageList.filter { it.obatId != null }.map { 
                            ObatUsageRequest(it.obatId!!, it.jumlah.toIntOrNull() ?: 0)
                        }
                    )
                    
                    val onSuccess: () -> Unit = {
                        isLoading = false
                        navController.popBackStack()
                    }
                    
                    val onError: (String) -> Unit = { error ->
                        isLoading = false
                        scope.launch {
                            snackbarHostState.showSnackbar(error)
                        }
                    }

                    if (sakitId == null) {
                        viewModel.submitSakit(request, onSuccess, onError)
                    } else {
                        viewModel.updateSakit(sakitId, request, onSuccess, onError)
                    }
                },
                modifier = Modifier.fillMaxWidth(),
                isLoading = isLoading
            )
            Spacer(modifier = Modifier.height(64.dp))
        }
    }
}

data class ObatUsageState(
    val obatId: Int? = null,
    val name: String = "",
    val jumlah: String = ""
)

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun FlowRow(
    modifier: Modifier = Modifier,
    content: @Composable () -> Unit
) {
    androidx.compose.foundation.layout.FlowRow(modifier = modifier) {
        content()
    }
}
