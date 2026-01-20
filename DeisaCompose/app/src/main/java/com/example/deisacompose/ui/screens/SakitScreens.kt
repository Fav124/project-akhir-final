package com.example.deisacompose.ui.screens

import androidx.compose.foundation.*
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.data.models.SakitRequest
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.SakitViewModel
import com.example.deisacompose.viewmodels.SantriViewModel

@OptIn(ExperimentalMaterial3Api::class, ExperimentalLayoutApi::class)
@Composable
fun SakitScreen(
    navController: NavHostController,
    viewModel: SakitViewModel = viewModel()
) {
    var searchQuery by remember { mutableStateOf("") }
    val sakitList by viewModel.sakitList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)

    LaunchedEffect(Unit) {
        viewModel.fetchSakit()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Santri Sakit", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        floatingActionButton = {
            FloatingActionButton(
                onClick = { navController.navigate("sakit_form") },
                containerColor = DangerRed,
                contentColor = Color.White
            ) {
                Icon(Icons.Default.Add, contentDescription = "Report Sickness")
            }
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .fillMaxSize()
        ) {
            // Search Bar
            OutlinedTextField(
                value = searchQuery,
                onValueChange = { 
                    searchQuery = it
                    viewModel.fetchSakit(it)
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(16.dp),
                placeholder = { Text("Cari nama santri...") },
                leadingIcon = { Icon(Icons.Default.Search, contentDescription = null) },
                shape = RoundedCornerShape(12.dp),
                colors = OutlinedTextFieldDefaults.colors(
                    unfocusedBorderColor = Color.Transparent,
                    focusedBorderColor = DangerRed,
                    unfocusedContainerColor = Color.White,
                    focusedContainerColor = Color.White
                ),
                singleLine = true
            )

            if (isLoading) {
                Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                    CircularProgressIndicator(color = DangerRed)
                }
            } else if (sakitList.isEmpty()) {
                Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                    Text("Tidak ada data santri sakit", color = Slate500)
                }
            } else {
                LazyColumn(
                    modifier = Modifier.fillMaxSize(),
                    contentPadding = PaddingValues(16.dp),
                    verticalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    items(sakitList) { sakit ->
                        SakitItem(sakit, viewModel) {
                            navController.navigate("sakit_form?id=${sakit.id}")
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SakitItem(
    sakit: Sakit, 
    viewModel: SakitViewModel,
    onClick: () -> Unit
) {
    var showConfirmDialog by remember { mutableStateOf(false) }
    
    if (showConfirmDialog) {
        AlertDialog(
            onDismissRequest = { showConfirmDialog = false },
            title = { Text("Konfirmasi") },
            text = { Text("Tandai ${sakit.santri?.displayName() ?: "santri"} sebagai sembuh?") },
            confirmButton = {
                Button(
                    onClick = {
                        viewModel.markAsSembuh(sakit.id, {}, {})
                        showConfirmDialog = false
                    },
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen)
                ) {
                    Text("Ya, Sembuh")
                }
            },
            dismissButton = {
                TextButton(onClick = { showConfirmDialog = false }) {
                    Text("Batal")
                }
            }
        )
    }
    
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        shape = RoundedCornerShape(16.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Column(modifier = Modifier.padding(16.dp)) {
            Row(verticalAlignment = Alignment.CenterVertically) {
                Box(
                    modifier = Modifier
                        .size(40.dp)
                        .background(DangerRed.copy(alpha = 0.1f), CircleShape),
                    contentAlignment = Alignment.Center
                ) {
                    Icon(Icons.Default.Sick, contentDescription = null, tint = DangerRed, modifier = Modifier.size(20.dp))
                }
                Spacer(modifier = Modifier.width(12.dp))
                Column(modifier = Modifier.weight(1f)) {
                    Text(
                        text = sakit.santri?.displayName() ?: "Unknown Santri",
                        fontWeight = FontWeight.Bold,
                        fontSize = 16.sp,
                        color = Slate900
                    )
                    Text(
                        text = sakit.displayDate(),
                        fontSize = 12.sp,
                        color = Slate500
                    )
                }
                StatusBadge(sakit.displayStatus())
            }
            Spacer(modifier = Modifier.height(12.dp))
            Text(
                text = "Keluhan: ${sakit.keluhan ?: sakit.gejala ?: "-"}",
                fontSize = 14.sp,
                color = Slate700
            )
            if (sakit.status != "Sembuh" && sakit.tingkatKondisi != "Sembuh") {
                Spacer(modifier = Modifier.height(12.dp))
                Button(
                    onClick = { showConfirmDialog = true },
                    modifier = Modifier.fillMaxWidth(),
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen),
                    shape = RoundedCornerShape(8.dp),
                    contentPadding = PaddingValues(vertical = 8.dp)
                ) {
                    Icon(Icons.Default.CheckCircle, contentDescription = null, modifier = Modifier.size(16.dp))
                    Spacer(modifier = Modifier.width(8.dp))
                    Text("Tandai Sembuh", fontSize = 12.sp)
                }
            }
        }
    }
}

@Composable
fun StatusBadge(status: String) {
    val color = when (status.lowercase()) {
        "berat" -> DangerRed
        "sedang" -> WarningOrange
        "ringan" -> DeisaBlue
        "sembuh" -> SuccessGreen
        else -> Slate500
    }
    Surface(
        color = color.copy(alpha = 0.1f),
        shape = RoundedCornerShape(8.dp)
    ) {
        Text(
            text = status,
            color = color,
            fontSize = 10.sp,
            fontWeight = FontWeight.Bold,
            modifier = Modifier.padding(horizontal = 8.dp, vertical = 4.dp)
        )
    }
}

@OptIn(ExperimentalMaterial3Api::class, ExperimentalLayoutApi::class)
@Composable
fun SakitFormScreen(
    navController: NavHostController,
    sakitId: Int? = null,
    viewModel: SakitViewModel = viewModel(),
    santriViewModel: SantriViewModel = viewModel()
) {
    val sakitDetail by viewModel.sakitDetail.observeAsState()
    val santriList by santriViewModel.santriList.observeAsState(emptyList())
    val diagnosisList by viewModel.diagnosisList.observeAsState(emptyList())
    val obatList by viewModel.obatList.observeAsState(emptyList())

    var selectedSantriId by remember { mutableStateOf<Int?>(null) }
    var keluhan by remember { mutableStateOf("") }
    var gejala by remember { mutableStateOf("") }
    var tindakan by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Ringan") }
    var jenisPerawatan by remember { mutableStateOf("Rawat Inap") }
    var catatan by remember { mutableStateOf("") }
    
    // Selection states
    var selectedDiagnosisIds by remember { mutableStateOf(setOf<Int>()) }
    var selectedObatUsage by remember { mutableStateOf(mapOf<Int, Int>()) } // ID to Quantity

    var expandedSantri by remember { mutableStateOf(false) }
    var expandedDiagnosis by remember { mutableStateOf(false) }
    var expandedObat by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        santriViewModel.fetchSantri()
        viewModel.fetchDiagnosis()
        viewModel.fetchObat()
        if (sakitId != null) {
            viewModel.getSakitById(sakitId)
        } else {
            viewModel.clearDetail()
        }
    }

    LaunchedEffect(sakitDetail) {
        sakitDetail?.let {
            selectedSantriId = it.santriId
            keluhan = it.keluhan ?: ""
            gejala = it.gejala ?: ""
            tindakan = it.tindakan ?: ""
            status = it.tingkatKondisi ?: it.status ?: "Ringan"
            catatan = it.catatan ?: ""
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text(if (sakitId == null) "Catat Sakit" else "Edit Data Sakit", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            Text("Pilih Santri", fontWeight = FontWeight.Medium)
            ExposedDropdownMenuBox(
                expanded = expandedSantri,
                onExpandedChange = { expandedSantri = !expandedSantri }
            ) {
                OutlinedTextField(
                    value = santriList.find { it.id == selectedSantriId }?.displayName() ?: "Pilih Santri",
                    onValueChange = {},
                    readOnly = true,
                    modifier = Modifier.menuAnchor().fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp),
                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedSantri) }
                )
                ExposedDropdownMenu(
                    expanded = expandedSantri,
                    onDismissRequest = { expandedSantri = false }
                ) {
                    santriList.forEach { santri ->
                        DropdownMenuItem(
                            text = { Text(santri.displayName()) },
                            onClick = {
                                selectedSantriId = santri.id
                                expandedSantri = false
                            }
                        )
                    }
                }
            }

            OutlinedTextField(
                value = gejala,
                onValueChange = { gejala = it },
                label = { Text("Gejala / Keluhan") },
                modifier = Modifier.fillMaxWidth(),
                minLines = 3,
                shape = RoundedCornerShape(12.dp)
            )

            OutlinedTextField(
                value = tindakan,
                onValueChange = { tindakan = it },
                label = { Text("Tindakan") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            Text("Diagnosis", fontWeight = FontWeight.Medium)
            FlowRow(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.spacedBy(8.dp),
                verticalArrangement = Arrangement.spacedBy(8.dp)
            ) {
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
                        label = { Text(diag.namaPenyakit ?: "-") }
                    )
                }
            }

            Text("Tingkat Kondisi", fontWeight = FontWeight.Medium)
            Row(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                listOf("Ringan", "Sedang", "Berat").forEach { level ->
                    FilterChip(
                        selected = status == level,
                        onClick = { status = level },
                        label = { Text(level) }
                    )
                }
            }

            Text("Obat yang Digunakan", fontWeight = FontWeight.Medium)
            obatList.forEach { obat ->
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Checkbox(
                        checked = selectedObatUsage.containsKey(obat.id),
                        onCheckedChange = { checked ->
                            selectedObatUsage = if (checked) {
                                selectedObatUsage + (obat.id to 1)
                            } else {
                                selectedObatUsage - obat.id
                            }
                        }
                    )
                    Text(obat.namaObat, modifier = Modifier.weight(1f))
                    if (selectedObatUsage.containsKey(obat.id)) {
                        OutlinedTextField(
                            value = selectedObatUsage[obat.id].toString(),
                            onValueChange = { 
                                val qty = it.toIntOrNull() ?: 1
                                selectedObatUsage = selectedObatUsage + (obat.id to qty)
                            },
                            modifier = Modifier.width(60.dp),
                            keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                        )
                    }
                }
            }

            Spacer(modifier = Modifier.height(24.dp))

            Button(
                onClick = {
                    val request = SakitRequest(
                        santriId = selectedSantriId ?: 0,
                        tglMasuk = java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(java.util.Date()),
                        status = status,
                        jenisPerawatan = jenisPerawatan,
                        tujuanRujukan = null,
                        gejala = gejala,
                        tindakan = tindakan,
                        catatan = catatan,
                        diagnosisIds = selectedDiagnosisIds.toList(),
                        obatUsage = selectedObatUsage.map { 
                            com.example.deisacompose.data.models.ObatUsageRequest(it.key, it.value) 
                        }
                    )
                    if (sakitId == null) {
                        viewModel.submitSakit(request, { navController.navigateUp() }, {})
                    } else {
                        viewModel.updateSakit(sakitId, request, { navController.navigateUp() }, {})
                    }
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(56.dp),
                shape = RoundedCornerShape(12.dp),
                colors = ButtonDefaults.buttonColors(containerColor = DangerRed)
            ) {
                Text("LAPORKAN", fontWeight = FontWeight.Bold)
            }
        }
    }
}
