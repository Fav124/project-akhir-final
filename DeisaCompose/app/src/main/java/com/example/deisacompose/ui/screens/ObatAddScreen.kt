package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.PremiumGradientButton
import com.example.deisacompose.ui.components.PremiumTextField
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: com.example.deisacompose.viewmodels.AuthViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()

    var kodeObat by remember { mutableStateOf("") }
    var namaObat by remember { mutableStateOf("") }
    var kategori by remember { mutableStateOf("Tablet") }
    var deskripsi by remember { mutableStateOf("") }
    var stok by remember { mutableStateOf("") }
    var stokMinimum by remember { mutableStateOf("5") }
    var satuan by remember { mutableStateOf("pcs") }
    var tglKadaluarsa by remember { mutableStateOf("") }
    var lokasiPenyimpanan by remember { mutableStateOf("") }
    
    var expandedKategori by remember { mutableStateOf(false) }

    // Validation States
    var nameError by remember { mutableStateOf<String?>(null) }
    var stokError by remember { mutableStateOf<String?>(null) }
    var globalError by remember { mutableStateOf<String?>(null) }

    LaunchedEffect(Unit) {
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
        if (namaObat.isBlank()) {
            nameError = "Nama obat wajib diisi"
            isValid = false
        } else {
            nameError = null
        }
        if (stok.isBlank()) {
            stokError = "Stok wajib diisi"
            isValid = false
        } else if (stok.toIntOrNull() == null) {
            stokError = "Harus berupa angka"
            isValid = false
        } else {
            stokError = null
        }
        return isValid
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Obat Baru",
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
                    "Inventaris Obat",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    color = Color.White
                )
                Text(
                    "Tambahkan obat baru ke daftar stok",
                    style = MaterialTheme.typography.labelSmall,
                    color = Color.Gray
                )
            }

            PremiumTextField(
                value = kodeObat,
                onValueChange = { kodeObat = it },
                label = "Kode Obat (Opsional)",
                placeholder = "Contoh: P001",
                leadingIcon = Icons.Default.QrCode
            )

            PremiumTextField(
                value = namaObat,
                onValueChange = { 
                    namaObat = it
                    if (nameError != null) nameError = null
                },
                label = "Nama Obat",
                placeholder = "Contoh: Paracetamol",
                leadingIcon = Icons.Default.MedicalServices,
                error = nameError
            )

            Box {
                ExposedDropdownMenuBox(
                    expanded = expandedKategori,
                    onExpandedChange = { expandedKategori = !expandedKategori }
                ) {
                    PremiumTextField(
                        value = kategori,
                        onValueChange = {},
                        label = "Kategori",
                        placeholder = "Pilih kategori",
                        leadingIcon = Icons.Default.Category,
                        modifier = Modifier.menuAnchor(),
                        error = null
                    )
                    ExposedDropdownMenu(
                        expanded = expandedKategori,
                        onDismissRequest = { expandedKategori = false },
                        modifier = Modifier.background(DeisaSoftNavy)
                    ) {
                        listOf("Tablet", "Kapsul", "Sirup", "Salep", "Injeksi", "Lainnya").forEach { item ->
                            DropdownMenuItem(
                                text = { Text(item, color = Color.White) },
                                onClick = {
                                    kategori = item
                                    expandedKategori = false
                                },
                                modifier = Modifier.background(DeisaSoftNavy)
                            )
                        }
                    }
                }
            }

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                PremiumTextField(
                    value = stok,
                    onValueChange = { 
                        stok = it
                        if (stokError != null) stokError = null
                    },
                    label = "Stok Awal",
                    placeholder = "0",
                    leadingIcon = Icons.Default.Inventory,
                    modifier = Modifier.weight(1f),
                    error = stokError
                )
                PremiumTextField(
                    value = satuan,
                    onValueChange = { satuan = it },
                    label = "Satuan",
                    placeholder = "pcs",
                    leadingIcon = Icons.Default.Straighten,
                    modifier = Modifier.weight(1f)
                )
            }

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                PremiumTextField(
                    value = stokMinimum,
                    onValueChange = { stokMinimum = it },
                    label = "Stok Minimum",
                    placeholder = "10",
                    leadingIcon = Icons.Default.Report,
                    modifier = Modifier.weight(1f)
                )
                PremiumTextField(
                    value = tglKadaluarsa,
                    onValueChange = { tglKadaluarsa = it },
                    label = "Exp. Date",
                    placeholder = "YYYY-MM-DD",
                    leadingIcon = Icons.Default.Event,
                    modifier = Modifier.weight(1f)
                )
            }

            PremiumTextField(
                value = lokasiPenyimpanan,
                onValueChange = { lokasiPenyimpanan = it },
                label = "Lokasi Penyimpanan",
                placeholder = "Contoh: Rak A1",
                leadingIcon = Icons.Default.Place
            )

            PremiumTextField(
                value = deskripsi,
                onValueChange = { deskripsi = it },
                label = "Deskripsi / Catatan",
                placeholder = "Info dosis atau efek samping...",
                leadingIcon = Icons.Default.Note
            )

            AnimatedVisibility(visible = globalError != null) {
                Text(
                    globalError ?: "",
                    color = DangerRed,
                    style = MaterialTheme.typography.labelSmall,
                    modifier = Modifier.padding(start = 4.dp)
                )
            }

            Spacer(modifier = Modifier.height(16.dp))

            PremiumGradientButton(
                text = "Simpan Obat",
                onClick = {
                    if (validate()) {
                        val obatData = mapOf(
                            "kode_obat" to kodeObat,
                            "nama_obat" to namaObat,
                            "kategori" to kategori,
                            "deskripsi" to deskripsi,
                            "stok" to (stok.toIntOrNull() ?: 0),
                            "stok_awal" to (stok.toIntOrNull() ?: 0),
                            "stok_minimum" to (stokMinimum.toIntOrNull() ?: 10),
                            "satuan" to satuan,
                            "tgl_kadaluarsa" to (if (tglKadaluarsa.isEmpty()) "2026-12-31" else tglKadaluarsa),
                            "lokasi_penyimpanan" to lokasiPenyimpanan
                        )
                        resourceViewModel.createObat(obatData)
                    }
                },
                isLoading = uiState is ResourceUiState.Loading
            )
            
            Spacer(modifier = Modifier.height(32.dp))
        }
    }
}
