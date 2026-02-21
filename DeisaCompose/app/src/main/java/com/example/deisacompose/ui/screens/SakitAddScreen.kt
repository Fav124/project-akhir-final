package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.PremiumTextField
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.BlueGradient
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.ui.theme.SuccessGreen
import com.example.deisacompose.ui.theme.WarningOrange
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: com.example.deisacompose.viewmodels.AuthViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()
    val santriList by resourceViewModel.santriList.collectAsState()

    var selectedSantriId by remember { mutableStateOf<Int?>(null) }
    var diagnosisUtama by remember { mutableStateOf("") }
    var gejala by remember { mutableStateOf("") }
    var tindakan by remember { mutableStateOf("") }
    var catatan by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Sakit") }
    var jenisPerawatan by remember { mutableStateOf("UKS") }
    var tujuanRujukan by remember { mutableStateOf("") }
    var tglMasuk by remember { mutableStateOf(java.text.SimpleDateFormat("yyyy-MM-dd", java.util.Locale.getDefault()).format(java.util.Date())) }
    
    var expandedSantri by remember { mutableStateOf(false) }
    var expandedTreatment by remember { mutableStateOf(false) }

    // Validation States
    var diagnosisError by remember { mutableStateOf<String?>(null) }
    var keluhanError by remember { mutableStateOf<String?>(null) }
    var globalError by remember { mutableStateOf<String?>(null) }

    LaunchedEffect(Unit) {
        resourceViewModel.loadSantri()
        resourceViewModel.resetState()
    }

    LaunchedEffect(uiState) {
        when (val state = uiState) {
            is ResourceUiState.Success -> {
                delay(1000)
                navController.navigateUp()
                resourceViewModel.resetState()
            }
            is ResourceUiState.Error -> {
                if (state.message == "SESI_HABIS") {
                    authViewModel.logout()
                    navController.navigate("login") {
                        popUpTo(0) { inclusive = true }
                    }
                } else {
                    globalError = state.message
                    delay(3000)
                    globalError = null
                }
                resourceViewModel.resetState()
            }
            else -> {}
        }
    }

    fun validate(): Boolean {
        var isValid = true
        if (selectedSantriId == null) {
            globalError = "Mohon pilih santri"
            isValid = false
        }
        if (diagnosisUtama.isBlank()) {
            diagnosisError = "Diagnosis wajib diisi"
            isValid = false
        } else {
            diagnosisError = null
        }
        if (gejala.isBlank()) {
            keluhanError = "Gejala wajib diisi"
            isValid = false
        } else {
            keluhanError = null
        }
        return isValid
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Rekam Medis Baru",
                onMenuClick = { navController.navigateUp() },
                showMenu = true,
                navigationIcon = Icons.Default.ArrowBack
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(24.dp),
            verticalArrangement = Arrangement.spacedBy(24.dp)
        ) {
            // Header Info
            Column {
                Text(
                    "Informasi Medis",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    color = Color.White
                )
                Text(
                    "Catat masalah kesehatan baru untuk santri",
                    style = MaterialTheme.typography.labelSmall,
                    color = Color.Gray
                )
            }

            // Santri Selection
            Box {
                ExposedDropdownMenuBox(
                    expanded = expandedSantri,
                    onExpandedChange = { expandedSantri = !expandedSantri }
                ) {
                    PremiumTextField(
                        value = santriList.find { it.id == selectedSantriId }?.nama_lengkap ?: "",
                        onValueChange = {},
                        label = "Pilih Santri",
                        placeholder = "Cari nama santri...",
                        leadingIcon = Icons.Default.Person,
                        modifier = Modifier.menuAnchor(),
                        error = null
                    )
                    ExposedDropdownMenu(
                        expanded = expandedSantri,
                        onDismissRequest = { expandedSantri = false },
                        modifier = Modifier.background(DeisaSoftNavy).heightIn(max = 280.dp)
                    ) {
                        santriList.forEach { santri ->
                            DropdownMenuItem(
                                text = { 
                                    Column {
                                        Text(santri.nama_lengkap, color = Color.White, fontWeight = FontWeight.Bold)
                                        Text(santri.kelas?.nama_kelas ?: "-", style = MaterialTheme.typography.labelSmall, color = Color.Gray)
                                    }
                                },
                                onClick = {
                                    selectedSantriId = santri.id
                                    expandedSantri = false
                                }
                            )
                        }
                    }
                }
            }

            PremiumTextField(
                value = diagnosisUtama,
                onValueChange = { diagnosisUtama = it },
                label = "Diagnosis Utama",
                placeholder = "Contoh: Flu",
                leadingIcon = Icons.Default.LocalHospital,
                error = diagnosisError
            )

            PremiumTextField(
                value = gejala,
                onValueChange = { 
                    gejala = it
                    if (keluhanError != null) keluhanError = null
                },
                label = "Gejala / Keluhan",
                placeholder = "Jelaskan apa yang dirasakan santri...",
                leadingIcon = Icons.Default.Sick,
                error = keluhanError
            )

            PremiumTextField(
                value = tindakan,
                onValueChange = { tindakan = it },
                label = "Tindakan Medis",
                placeholder = "Contoh: Pemberian paracetamol",
                leadingIcon = Icons.Default.MedicalInformation
            )

            PremiumTextField(
                value = catatan,
                onValueChange = { catatan = it },
                label = "Catatan Tambahan",
                placeholder = "Contoh: Pasien harus istirahat total",
                leadingIcon = Icons.Default.Note
            )

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                Box(modifier = Modifier.weight(1f)) {
                    ExposedDropdownMenuBox(
                        expanded = expandedTreatment,
                        onExpandedChange = { expandedTreatment = !expandedTreatment }
                    ) {
                        PremiumTextField(
                            value = jenisPerawatan,
                            onValueChange = {},
                            label = "Fasilitas Perawatan",
                            placeholder = "Pilih...",
                            leadingIcon = Icons.Default.Hotel,
                            modifier = Modifier.menuAnchor(),
                            error = null
                        )
                        ExposedDropdownMenu(
                            expanded = expandedTreatment,
                            onDismissRequest = { expandedTreatment = false },
                            modifier = Modifier.background(DeisaSoftNavy)
                        ) {
                            listOf("UKS", "Rumah Sakit", "Pulang").forEach { item ->
                                DropdownMenuItem(
                                    text = { Text(item, color = Color.White) },
                                    onClick = {
                                        jenisPerawatan = item
                                        expandedTreatment = false
                                    }
                                )
                            }
                        }
                    }
                }
                Box(modifier = Modifier.weight(1f)) {
                    PremiumTextField(
                        value = tglMasuk,
                        onValueChange = { tglMasuk = it },
                        label = "Tgl Masuk",
                        placeholder = "YYYY-MM-DD",
                        leadingIcon = Icons.Default.Event
                    )
                }
            }

            if (jenisPerawatan == "Rumah Sakit") {
                PremiumTextField(
                    value = tujuanRujukan,
                    onValueChange = { tujuanRujukan = it },
                    label = "Nama Rumah Sakit",
                    placeholder = "Contoh: RSUD Bhakti Dharma",
                    leadingIcon = Icons.Default.Business
                )
            }

            // Status Selection
            Column {
                Text(
                    "STATUS AWAL",
                    style = MaterialTheme.typography.labelSmall,
                    fontWeight = FontWeight.Bold,
                    color = Color.Gray,
                    modifier = Modifier.padding(start = 4.dp, bottom = 8.dp)
                )
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    listOf("Sakit" to "Masih Sakit", "Sembuh" to "Sembuh").forEach { (code, label) ->
                        Box(
                            modifier = Modifier
                                .weight(1f)
                                .height(56.dp)
                                .clip(RoundedCornerShape(16.dp))
                                .background(if (status == code) (if (code == "Sakit") WarningOrange else SuccessGreen).copy(alpha = 0.1f) else DeisaSoftNavy)
                                .border(
                                    1.dp, 
                                    if (status == code) (if (code == "Sakit") WarningOrange else SuccessGreen) else Color.White.copy(alpha = 0.05f),
                                    RoundedCornerShape(16.dp)
                                )
                                .clickable { status = code },
                            contentAlignment = Alignment.Center
                        ) {
                            Text(
                                label,
                                color = if (status == code) (if (code == "Sakit") WarningOrange else SuccessGreen) else Color.White,
                                fontWeight = FontWeight.Bold
                            )
                        }
                    }
                }
            }

            AnimatedVisibility(visible = globalError != null) {
                Text(
                    globalError ?: "",
                    color = DangerRed,
                    style = MaterialTheme.typography.labelSmall,
                    modifier = Modifier.padding(start = 4.dp)
                )
            }

            Spacer(modifier = Modifier.height(16.dp))

            com.example.deisacompose.ui.components.PremiumGradientButton(
                text = "Simpan Rekam Medis",
                onClick = {
                    if (validate()) {
                        val sakitData = mapOf(
                            "santri_id" to selectedSantriId!!,
                            "diagnosis_utama" to diagnosisUtama,
                            "gejala" to gejala,
                            "tindakan" to tindakan,
                            "catatan" to catatan,
                            "status" to status,
                            "jenis_perawatan" to jenisPerawatan,
                            "tujuan_rujukan" to tujuanRujukan,
                            "tgl_masuk" to tglMasuk
                        )
                        resourceViewModel.createSakit(sakitData)
                    }
                },
                isLoading = uiState is ResourceUiState.Loading,
                gradientColors = if (status == "Sakit") listOf(WarningOrange, Color(0xFFF59E0B)) else BlueGradient
            )
            
            Spacer(modifier = Modifier.height(32.dp))
        }
    }
}
