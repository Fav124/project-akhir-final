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
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.data.models.ObatRequest
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.ObatViewModel
import com.example.deisacompose.ui.components.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatScreen(
    navController: NavHostController,
    viewModel: ObatViewModel = viewModel()
) {
    var searchQuery by remember { mutableStateOf("") }
    val obatList by viewModel.obatList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)

    LaunchedEffect(Unit) {
        viewModel.fetchObat()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Inventaris Obat", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        floatingActionButton = {
            FloatingActionButton(
                onClick = { navController.navigate("obat_form") },
                containerColor = SuccessGreen,
                contentColor = Color.White
            ) {
                Icon(Icons.Default.Add, contentDescription = "Add Obat")
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
                    viewModel.fetchObat(it)
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(16.dp),
                placeholder = { Text("Cari nama obat...") },
                leadingIcon = { Icon(Icons.Default.Search, contentDescription = null) },
                shape = RoundedCornerShape(12.dp),
                colors = OutlinedTextFieldDefaults.colors(
                    unfocusedBorderColor = Color.Transparent,
                    focusedBorderColor = SuccessGreen,
                    unfocusedContainerColor = Color.White,
                    focusedContainerColor = Color.White
                ),
                singleLine = true
            )

            if (isLoading) {
                CircularProgressIndicator()
            } else if (obatList.isEmpty()) {
                Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                    Text("Tidak ada data obat", color = Slate500)
                }
            } else {
                LazyColumn(
                    modifier = Modifier.fillMaxSize(),
                    contentPadding = PaddingValues(16.dp),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    items(obatList) { obat ->
                        ObatItem(obat) {
                            navController.navigate("obat_form?id=${obat.id}")
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun ObatItem(obat: Obat, onClick: () -> Unit) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        shape = RoundedCornerShape(16.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Row(
            modifier = Modifier.padding(16.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Surface(
                shape = RoundedCornerShape(12.dp),
                color = SuccessGreen.copy(alpha = 0.1f),
                modifier = Modifier.size(48.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(Icons.Default.Medication, contentDescription = null, tint = SuccessGreen)
                }
            }
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(
                    text = obat.namaObat,
                    fontWeight = FontWeight.Bold,
                    fontSize = 16.sp,
                    color = Slate900
                )
                Text(
                    text = "Stok: ${obat.stok} ${obat.satuan ?: ""}",
                    fontSize = 13.sp,
                    color = if (obat.stok <= (obat.stokMinimum ?: 0)) DangerRed else Slate500
                )
            }
            if (obat.stok <= (obat.stokMinimum ?: 0)) {
                Icon(Icons.Default.Warning, contentDescription = "Low Stock", tint = DangerRed, modifier = Modifier.size(20.dp))
            }
            Icon(Icons.Default.ChevronRight, contentDescription = null, tint = Slate500)
        }
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatFormScreen(
    navController: NavHostController,
    obatId: Int? = null,
    viewModel: ObatViewModel = viewModel()
) {
    val context = androidx.compose.ui.platform.LocalContext.current
    val obatDetail by viewModel.obatDetail.observeAsState()

    // Stepper State
    var currentStep by remember { mutableIntStateOf(1) }

    // Form Data
    var namaObat by remember { mutableStateOf("") }
    var kategori by remember { mutableStateOf("Tablet") }
    var stok by remember { mutableStateOf("") }
    var satuan by remember { mutableStateOf("Tablet") }
    var stokMinimum by remember { mutableStateOf("10") }
    var deskripsi by remember { mutableStateOf("") }
    var harga by remember { mutableStateOf("") }
    var kadaluarsa by remember { mutableStateOf("") }
    var lokasi by remember { mutableStateOf("") }

    // Photo
    var selectedImageUri by remember { mutableStateOf<android.net.Uri?>(null) }
    var photoFile by remember { mutableStateOf<java.io.File?>(null) }

    val photoLauncher = androidx.activity.compose.rememberLauncherForActivityResult(
        contract = androidx.activity.result.contract.ActivityResultContracts.PickVisualMedia(),
        onResult = { uri ->
            uri?.let {
                selectedImageUri = it
                // Convert Uri to File
                val inputStream = context.contentResolver.openInputStream(it)
                val file = java.io.File(context.cacheDir, "temp_obat_${System.currentTimeMillis()}.jpg")
                inputStream?.use { input ->
                    file.outputStream().use { output ->
                        input.copyTo(output)
                    }
                }
                photoFile = file
            }
        }
    )

    // Dropdowns
    var expandedKategori by remember { mutableStateOf(false) }
    var expandedSatuan by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        if (obatId != null) {
            viewModel.getObatById(obatId)
        } else {
            viewModel.clearDetail()
        }
    }

    LaunchedEffect(obatDetail) {
        obatDetail?.let {
            namaObat = it.namaObat
            kategori = it.kategori ?: "Tablet"
            stok = it.stok.toString()
            satuan = it.satuan ?: "Tablet"
            stokMinimum = it.stokMinimum?.toString() ?: "10"
            deskripsi = it.deskripsi ?: ""
            harga = it.harga?.toString() ?: ""
            kadaluarsa = it.tglKadaluarsa ?: ""
            lokasi = it.lokasiPenyimpanan ?: ""
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text(if (obatId == null) "Tambah Obat" else "Edit Obat", fontWeight = FontWeight.Bold) },
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
                .fillMaxSize()
        ) {
            // Stepper Indicator
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(16.dp),
                verticalAlignment = Alignment.CenterVertically
            ) {
                StepIndicator(step = 1, currentStep = currentStep, label = "Info Obat")
                HorizontalDivider(modifier = Modifier.weight(1f).padding(horizontal = 8.dp), color = Slate100)
                StepIndicator(step = 2, currentStep = currentStep, label = "Detail & Stok")
            }

            Column(
                modifier = Modifier
                    .weight(1f)
                    .verticalScroll(rememberScrollState())
                    .padding(horizontal = 16.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                if (currentStep == 1) {
                    // === STEP 1: INFO UTAMA & FOTO ===
                    
                    Box(
                        modifier = Modifier
                            .fillMaxWidth()
                            .padding(vertical = 8.dp),
                        contentAlignment = Alignment.Center
                    ) {
                        Column(horizontalAlignment = Alignment.CenterHorizontally) {
                            Surface(
                                shape = RoundedCornerShape(16.dp),
                                color = Slate100,
                                modifier = Modifier
                                    .size(100.dp)
                                    .clickable {
                                        photoLauncher.launch(
                                            androidx.activity.result.PickVisualMediaRequest(
                                                androidx.activity.result.contract.ActivityResultContracts.PickVisualMedia.ImageOnly
                                            )
                                        )
                                    },
                                border = BorderStroke(2.dp, SuccessGreen)
                            ) {
                                if (selectedImageUri != null) {
                                    coil.compose.AsyncImage(
                                        model = selectedImageUri,
                                        contentDescription = "Selected Photo",
                                        contentScale = androidx.compose.ui.layout.ContentScale.Crop,
                                        modifier = Modifier.fillMaxSize()
                                    )
                                } else if (obatDetail?.foto != null) {
                                    coil.compose.AsyncImage(
                                        model = "http://10.0.2.2:8000/storage/${obatDetail?.foto}",
                                        contentDescription = "Current Photo",
                                        contentScale = androidx.compose.ui.layout.ContentScale.Crop,
                                        modifier = Modifier.fillMaxSize()
                                    )
                                } else {
                                    Box(contentAlignment = Alignment.Center) {
                                        Icon(Icons.Default.AddPhotoAlternate, contentDescription = null, tint = Slate500, modifier = Modifier.size(32.dp))
                                    }
                                }
                            }
                            Text("Foto Obat", fontSize = 12.sp, color = Slate500, modifier = Modifier.padding(top = 8.dp))
                        }
                    }

                    OutlinedTextField(
                        value = namaObat,
                        onValueChange = { namaObat = it },
                        label = { Text("Nama Obat") },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp)
                    )

                    ExposedDropdownMenuBox(
                        expanded = expandedKategori,
                        onExpandedChange = { expandedKategori = !expandedKategori }
                    ) {
                        OutlinedTextField(
                            value = kategori,
                            onValueChange = {},
                            readOnly = true,
                            label = { Text("Kategori") },
                            trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedKategori) },
                            modifier = Modifier.menuAnchor().fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp)
                        )
                        ExposedDropdownMenu(
                            expanded = expandedKategori,
                            onDismissRequest = { expandedKategori = false }
                        ) {
                            listOf("Tablet", "Sirup", "Kapsul", "Alkes", "Lainnya").forEach { k ->
                                DropdownMenuItem(text = { Text(k) }, onClick = { kategori = k; expandedKategori = false })
                            }
                        }
                    }

                    OutlinedTextField(
                        value = deskripsi,
                        onValueChange = { deskripsi = it },
                        label = { Text("Deskripsi") },
                        modifier = Modifier.fillMaxWidth().height(100.dp),
                        shape = RoundedCornerShape(12.dp),
                        maxLines = 3
                    )
                } else {
                    // === STEP 2: DETAILS ===
                    
                    Text("Manajemen Stok", fontWeight = FontWeight.Bold, color = SuccessGreen)

                    Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                        OutlinedTextField(
                            value = stok,
                            onValueChange = { stok = it },
                            label = { Text("Stok Sekarang") },
                            modifier = Modifier.weight(1f),
                            shape = RoundedCornerShape(12.dp),
                            keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                        )
                        
                        ExposedDropdownMenuBox(
                            expanded = expandedSatuan,
                            onExpandedChange = { expandedSatuan = !expandedSatuan },
                            modifier = Modifier.weight(1f)
                        ) {
                            OutlinedTextField(
                                value = satuan,
                                onValueChange = {},
                                readOnly = true,
                                label = { Text("Satuan") },
                                trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedSatuan) },
                                modifier = Modifier.menuAnchor().fillMaxWidth(),
                                shape = RoundedCornerShape(12.dp)
                            )
                            ExposedDropdownMenu(
                                expanded = expandedSatuan,
                                onDismissRequest = { expandedSatuan = false }
                            ) {
                                listOf("Tablet", "Kapsul", "Botol", "Strip", "Box", "Pcs").forEach { s ->
                                    DropdownMenuItem(text = { Text(s) }, onClick = { satuan = s; expandedSatuan = false })
                                }
                            }
                        }
                    }

                    OutlinedTextField(
                        value = stokMinimum,
                        onValueChange = { stokMinimum = it },
                        label = { Text("Stok Minimum Alert") },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp),
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                    )
                    
                    HorizontalDivider(color = Slate100)
                    Text("Info Tambahan", fontWeight = FontWeight.Bold, color = SuccessGreen)

                    OutlinedTextField(
                        value = harga,
                        onValueChange = { harga = it },
                        label = { Text("Harga Satuan (Rp)") },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp),
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                    )

                    OutlinedTextField(
                        value = kadaluarsa,
                        onValueChange = { kadaluarsa = it },
                        label = { Text("Tgl Kadaluarsa (YYYY-MM-DD)") },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp),
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                    )

                    OutlinedTextField(
                        value = lokasi,
                        onValueChange = { lokasi = it },
                        label = { Text("Lokasi Penyimpanan") },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp)
                    )
                }
                
                Spacer(modifier = Modifier.height(24.dp))
            }

            // Buttons
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(16.dp),
                horizontalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                if (currentStep > 1) {
                    OutlinedButton(
                        onClick = { currentStep-- },
                        modifier = Modifier
                            .weight(1f)
                            .height(56.dp),
                         shape = RoundedCornerShape(12.dp),
                         border = BorderStroke(1.dp, SuccessGreen)
                    ) {
                        Text("KEMBALI")
                    }
                }
                
                Button(
                    onClick = {
                        if (currentStep < 2) {
                            if (namaObat.isBlank()) return@Button
                            currentStep++
                        } else {
                            val request = ObatRequest(
                                namaObat = namaObat,
                                kategori = kategori,
                                stok = stok.toIntOrNull() ?: 0,
                                stokAwal = if (obatId == null) (stok.toIntOrNull() ?: 0) else null,
                                satuan = satuan,
                                stokMinimum = stokMinimum.toIntOrNull(),
                                deskripsi = deskripsi,
                                harga = harga.toDoubleOrNull(),
                                tglKadaluarsa = kadaluarsa,
                                lokasiPenyimpanan = lokasi
                            )
                            if (obatId == null) {
                                viewModel.createObat(request, photoFile, { navController.navigateUp() }, {})
                            } else {
                                viewModel.updateObat(obatId, request, photoFile, { navController.navigateUp() }, {})
                            }
                        }
                    },
                    modifier = Modifier
                        .weight(1f)
                        .height(56.dp),
                    shape = RoundedCornerShape(12.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen)
                ) {
                    Text(if (currentStep < 2) "LANJUT" else "SIMPAN")
                }
            }
        }
    }
}
