package com.example.deisacompose.ui.screens

import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.AddAPhoto
import androidx.compose.material.icons.filled.ChevronRight
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.People
import androidx.compose.material3.Button
import androidx.compose.material3.ButtonDefaults
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.ExperimentalMaterial3Api
import androidx.compose.material3.ExposedDropdownMenuBox
import androidx.compose.material3.ExposedDropdownMenuDefaults
import androidx.compose.material3.FloatingActionButton
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.material3.TopAppBarDefaults
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.runtime.mutableIntStateOf
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.data.models.SantriRequest
import com.example.deisacompose.ui.components.AnimatedCardItem
import com.example.deisacompose.ui.components.PulsingLoader
import com.example.deisacompose.ui.components.RealtimeSearchBar
import com.example.deisacompose.ui.components.StepIndicator
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.Slate100
import com.example.deisacompose.ui.theme.Slate50
import com.example.deisacompose.ui.theme.Slate500
import com.example.deisacompose.ui.theme.Slate900
import com.example.deisacompose.viewmodels.ManagementViewModel
import com.example.deisacompose.viewmodels.SantriViewModel
import com.google.accompanist.swiperefresh.SwipeRefresh
import com.google.accompanist.swiperefresh.rememberSwipeRefreshState

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriScreen(
    navController: NavHostController,
    viewModel: SantriViewModel = viewModel()
) {
    val santriList by viewModel.santriList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val swipeRefreshState = rememberSwipeRefreshState(isLoading)

    LaunchedEffect(Unit) {
        viewModel.fetchSantri()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Data Santri", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back")
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(containerColor = Color.White)
            )
        },
        floatingActionButton = {
            FloatingActionButton(
                onClick = { navController.navigate("santri_form") },
                containerColor = DeisaBlue,
                contentColor = Color.White
            ) {
                Icon(Icons.Default.Add, contentDescription = "Add Santri")
            }
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .fillMaxSize()
        ) {
            // Realtime Search Bar with debounce
            RealtimeSearchBar(
                placeholder = "Cari nama atau NIS...",
                onSearchChange = { query ->
                    viewModel.fetchSantri(if (query.isBlank()) null else query)
                },
                modifier = Modifier.padding(16.dp),
                focusedBorderColor = DeisaBlue
            )

            SwipeRefresh(
                state = swipeRefreshState,
                onRefresh = { viewModel.fetchSantri() }
            ) {
                if (isLoading && santriList.isEmpty()) {
                    PulsingLoader()
                } else if (santriList.isEmpty()) {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        Column(
                            horizontalAlignment = Alignment.CenterHorizontally,
                            verticalArrangement = Arrangement.spacedBy(16.dp)
                        ) {
                            Icon(
                                Icons.Default.People,
                                contentDescription = null,
                                modifier = Modifier.size(64.dp),
                                tint = Slate500
                            )
                            Text(
                                text = "Tidak ada data santri",
                                color = Slate500,
                                style = MaterialTheme.typography.bodyLarge
                            )
                        }
                    }
                } else {
                    LazyColumn(
                        modifier = Modifier.fillMaxSize(),
                        contentPadding = PaddingValues(horizontal = 16.dp, vertical = 8.dp),
                        verticalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        items(
                            items = santriList,
                            key = { it.id }
                        ) { santri ->
                            AnimatedCardItem(
                                item = santri,
                                onClick = {
                                    navController.navigate("santri_form?id=${santri.id}")
                                }
                            ) {
                                SantriItemContent(santri = santri)
                            }
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SantriItemContent(santri: Santri) {
    Row(
        modifier = Modifier.padding(16.dp),
        verticalAlignment = Alignment.CenterVertically
    ) {
        Surface(
            shape = CircleShape,
            color = DeisaBlue.copy(alpha = 0.1f),
            modifier = Modifier.size(56.dp)
        ) {
            Box(contentAlignment = Alignment.Center) {
                Text(
                    text = (santri.displayName().firstOrNull() ?: '?').toString(),
                    color = DeisaBlue,
                    fontWeight = FontWeight.Bold,
                    fontSize = 20.sp
                )
            }
        }
        Spacer(modifier = Modifier.width(16.dp))
        Column(modifier = Modifier.weight(1f)) {
            Text(
                text = santri.displayName(),
                fontWeight = FontWeight.Bold,
                fontSize = 16.sp,
                color = Slate900,
                style = MaterialTheme.typography.titleMedium
            )
            Spacer(modifier = Modifier.height(4.dp))
            Row(
                horizontalArrangement = Arrangement.spacedBy(8.dp),
                verticalAlignment = Alignment.CenterVertically
            ) {
                Text(
                    text = "NIS: ${santri.nis ?: '-'}",
                    fontSize = 13.sp,
                    color = Slate500,
                    style = MaterialTheme.typography.bodySmall
                )
                santri.tahunMasuk?.let { tahun ->
                    Surface(
                        shape = RoundedCornerShape(4.dp),
                        color = DeisaBlue.copy(alpha = 0.1f)
                    ) {
                        Text(
                            text = "Angkatan $tahun",
                            fontSize = 10.sp,
                            color = DeisaBlue,
                            fontWeight = FontWeight.Medium,
                            modifier = Modifier.padding(horizontal = 6.dp, vertical = 2.dp)
                        )
                    }
                }
            }
            Spacer(modifier = Modifier.height(2.dp))
            Text(
                text = santri.displayKelas(),
                fontSize = 12.sp,
                color = DeisaBlue,
                fontWeight = FontWeight.Medium,
                style = MaterialTheme.typography.bodySmall
            )
        }
        Icon(
            Icons.Default.ChevronRight,
            contentDescription = null,
            tint = Slate500
        )
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriFormScreen(
    navController: NavHostController,
    santriId: Int? = null,
    viewModel: SantriViewModel = viewModel(),
    mgmtViewModel: ManagementViewModel = viewModel()
) {
    val context = androidx.compose.ui.platform.LocalContext.current
    val santriDetail by viewModel.santriDetail.observeAsState()
    val kelasList by mgmtViewModel.kelasList.observeAsState(emptyList())
    val jurusanList by mgmtViewModel.jurusanList.observeAsState(emptyList())
    val angkatanList by mgmtViewModel.angkatanList.observeAsState(emptyList())

    // Form States
    var currentStep by remember { mutableIntStateOf(1) }
    var nis by remember { mutableStateOf("") }
    var namaLengkap by remember { mutableStateOf("") }
    var selectedKelasId by remember { mutableStateOf<Int?>(null) }
    var selectedJurusanId by remember { mutableStateOf<Int?>(null) }
    var jenisKelamin by remember { mutableStateOf("L") }
    var statusKesehatan by remember { mutableStateOf("Sehat") }
    var tempatLahir by remember { mutableStateOf("") }
    var tanggalLahir by remember { mutableStateOf("") }
    var riwayatAlergi by remember { mutableStateOf("") }
    var alamat by remember { mutableStateOf("") }

    // Wali Data
    var namaWali by remember { mutableStateOf("") }
    var hubunganWali by remember { mutableStateOf("Ayah") }
    var noTelpWali by remember { mutableStateOf("") }
    var pekerjaanWali by remember { mutableStateOf("") }
    var alamatWali by remember { mutableStateOf("") }
    var tahunMasuk by remember { mutableStateOf<Int?>(null) } // This is now angkatan_id

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
                val file = java.io.File(context.cacheDir, "temp_image_${System.currentTimeMillis()}.jpg")
                inputStream?.use { input ->
                    file.outputStream().use { output ->
                        input.copyTo(output)
                    }
                }
                photoFile = file
            }
        }
    )

    // Dropdown States
    var expandedKelas by remember { mutableStateOf(false) }
    var expandedJurusan by remember { mutableStateOf(false) }
    var expandedGender by remember { mutableStateOf(false) }
    var expandedStatus by remember { mutableStateOf(false) }
    var expandedHubungan by remember { mutableStateOf(false) }
    var expandedTahunMasuk by remember { mutableStateOf(false) }

    // Removed old Year logic

    LaunchedEffect(Unit) {
        mgmtViewModel.fetchKelas()
        mgmtViewModel.fetchJurusan()
        mgmtViewModel.fetchAngkatan()
        if (santriId != null) {
            viewModel.fetchSantriById(santriId)
        } else {
            viewModel.clearDetail()
        }
    }
    LaunchedEffect(santriDetail) {
        santriDetail?.let {
            nis = it.nis ?: ""
            namaLengkap = it.namaLengkap ?: it.nama ?: ""
            selectedKelasId = it.kelasId
            selectedJurusanId = it.jurusanId
            jenisKelamin = it.jenisKelamin ?: "L"
            statusKesehatan = it.statusKesehatan ?: "Sehat"
            tempatLahir = it.tempatLahir ?: ""
            tanggalLahir = it.tanggalLahir ?: ""
            alamat = it.alamat ?: ""
            tahunMasuk = it.angkatanId

            // From Wali
            it.wali?.let { w ->
                namaWali = w.namaWali
                hubunganWali = w.hubungan
                noTelpWali = w.noHp
            }
        }
    }

    val isLoadingData = kelasList.isEmpty() || jurusanList.isEmpty() || angkatanList.isEmpty()

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text(if (santriId == null) "Tambah Santri" else "Edit Santri", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back")
                    }
                },
                actions = {
                    if (santriId != null) {
                        IconButton(onClick = {
                            viewModel.deleteSantri(santriId, { navController.navigateUp() }, {})
                        }) {
                            Icon(Icons.Default.Delete, contentDescription = "Delete", tint = DangerRed)
                        }
                    }
                }
            )
        }
    ) { padding ->
        if (isLoadingData) {
            Box(modifier = Modifier
                .fillMaxSize()
                .padding(padding), contentAlignment = Alignment.Center) {
                Column(horizontalAlignment = Alignment.CenterHorizontally) {
                    CircularProgressIndicator(modifier = Modifier.size(100.dp))
                    Text("Memuat data formulir...", color = Slate500, fontSize = 12.sp)
                    // Fallback refresh button if stuck
                    TextButton(onClick = {
                        mgmtViewModel.fetchKelas()
                        mgmtViewModel.fetchJurusan()
                        mgmtViewModel.fetchAngkatan()
                    }) {
                        Text("Refresh Data")
                    }
                }
            }
        } else {
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
                    StepIndicator(step = 1, currentStep = currentStep, label = "Data Diri")
                    HorizontalDivider(modifier = Modifier
                        .weight(1f)
                        .padding(horizontal = 8.dp), color = Slate100)
                    StepIndicator(step = 2, currentStep = currentStep, label = "Wali & Detail")
                }

                Column(
                    modifier = Modifier
                        .weight(1f)
                        .verticalScroll(rememberScrollState())
                        .padding(horizontal = 16.dp),
                    verticalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    if (currentStep == 1) {
                        // === STEP 1: BASIC INFO & PHOTO ===

                        // Photo Picker
                        Box(
                            modifier = Modifier
                                .fillMaxWidth()
                                .padding(vertical = 8.dp),
                            contentAlignment = Alignment.Center
                        ) {
                            Column(horizontalAlignment = Alignment.CenterHorizontally) {
                                Surface(
                                    shape = CircleShape,
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
                                    border = BorderStroke(2.dp, DeisaBlue)
                                ) {
                                    if (selectedImageUri != null) {
                                        coil.compose.AsyncImage(
                                            model = selectedImageUri,
                                            contentDescription = "Selected Photo",
                                            contentScale = androidx.compose.ui.layout.ContentScale.Crop,
                                            modifier = Modifier.fillMaxSize()
                                        )
                                    } else if (santriDetail?.foto != null) {
                                        coil.compose.AsyncImage(
                                            model = "http://10.0.2.2:8000/storage/${santriDetail?.foto}",
                                            contentDescription = "Current Photo",
                                            contentScale = androidx.compose.ui.layout.ContentScale.Crop,
                                            modifier = Modifier.fillMaxSize()
                                        )
                                    } else {
                                        Box(contentAlignment = Alignment.Center) {
                                            Icon(Icons.Default.AddAPhoto, contentDescription = null, tint = Slate500, modifier = Modifier.size(32.dp))
                                        }
                                    }
                                }
                                Text("Foto Santri", fontSize = 12.sp, color = Slate500, modifier = Modifier.padding(top = 8.dp))
                            }
                        }

                        OutlinedTextField(
                            value = nis,
                            onValueChange = { nis = it },
                            label = { Text("NIS") },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp),
                            keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number, imeAction = ImeAction.Next)
                        )

                        OutlinedTextField(
                            value = namaLengkap,
                            onValueChange = { namaLengkap = it },
                            label = { Text("Nama Lengkap") },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp),
                            keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Text, imeAction = ImeAction.Next)
                        )

                        Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                            ExposedDropdownMenuBox(
                                expanded = expandedGender,
                                onExpandedChange = { expandedGender = !expandedGender },
                                modifier = Modifier.weight(1f)
                            ) {
                                OutlinedTextField(
                                    value = if (jenisKelamin == "L") "Laki-laki" else "Perempuan",
                                    onValueChange = {},
                                    readOnly = true,
                                    label = { Text("JK") },
                                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedGender) },
                                    modifier = Modifier
                                        .menuAnchor()
                                        .fillMaxWidth(),
                                    shape = RoundedCornerShape(12.dp)
                                )
                                ExposedDropdownMenu(
                                    expanded = expandedGender,
                                    onDismissRequest = { expandedGender = false }
                                ) {
                                    DropdownMenuItem(text = { Text("Laki-laki") }, onClick = { jenisKelamin = "L"; expandedGender = false })
                                    DropdownMenuItem(text = { Text("Perempuan") }, onClick = { jenisKelamin = "P"; expandedGender = false })
                                }
                            }

                            ExposedDropdownMenuBox(
                                expanded = expandedStatus,
                                onExpandedChange = { expandedStatus = !expandedStatus },
                                modifier = Modifier.weight(1f)
                            ) {
                                OutlinedTextField(
                                    value = statusKesehatan,
                                    onValueChange = {},
                                    readOnly = true,
                                    label = { Text("Status") },
                                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedStatus) },
                                    modifier = Modifier
                                        .menuAnchor()
                                        .fillMaxWidth(),
                                    shape = RoundedCornerShape(12.dp)
                                )
                                ExposedDropdownMenu(
                                    expanded = expandedStatus,
                                    onDismissRequest = { expandedStatus = false }
                                ) {
                                    listOf("Sehat", "Sakit", "Pemulihan").forEach { s ->
                                        DropdownMenuItem(text = { Text(s) }, onClick = { statusKesehatan = s; expandedStatus = false })
                                    }
                                }
                            }
                        }

                        ExposedDropdownMenuBox(
                            expanded = expandedKelas,
                            onExpandedChange = { expandedKelas = !expandedKelas }
                        ) {
                            OutlinedTextField(
                                value = kelasList.find { it.id == selectedKelasId }?.namaKelas ?: "",
                                onValueChange = {},
                                readOnly = true,
                                label = { Text("Pilih Kelas") },
                                trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedKelas) },
                                modifier = Modifier
                                    .menuAnchor()
                                    .fillMaxWidth(),
                                shape = RoundedCornerShape(12.dp)
                            )
                            ExposedDropdownMenu(
                                expanded = expandedKelas,
                                onDismissRequest = { expandedKelas = false }
                            ) {
                                kelasList.forEach { kelas ->
                                    DropdownMenuItem(
                                        text = { Text(kelas.namaKelas ?: "-") },
                                        onClick = { selectedKelasId = kelas.id; expandedKelas = false }
                                    )
                                }
                            }
                        }

                        ExposedDropdownMenuBox(
                            expanded = expandedJurusan,
                            onExpandedChange = { expandedJurusan = !expandedJurusan }
                        ) {
                            OutlinedTextField(
                                value = jurusanList.find { it.id == selectedJurusanId }?.namaJurusan ?: "",
                                onValueChange = {},
                                readOnly = true,
                                label = { Text("Pilih Jurusan") },
                                trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedJurusan) },
                                modifier = Modifier
                                    .menuAnchor()
                                    .fillMaxWidth(),
                                shape = RoundedCornerShape(12.dp)
                            )
                            ExposedDropdownMenu(
                                expanded = expandedJurusan,
                                onDismissRequest = { expandedJurusan = false }
                            ) {
                                jurusanList.forEach { jurusan ->
                                    DropdownMenuItem(
                                        text = { Text(jurusan.namaJurusan ?: "-") },
                                        onClick = { selectedJurusanId = jurusan.id; expandedJurusan = false }
                                    )
                                }
                            }
                        }

                    } else {
                        // === STEP 2: DETAILS & WALI ===

                        Text("Detail Tanggal & Alamat", fontWeight = FontWeight.Bold, color = DeisaBlue)

                        Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                            OutlinedTextField(
                                value = tempatLahir,
                                onValueChange = { tempatLahir = it },
                                label = { Text("Tempat Lahir") },
                                modifier = Modifier.weight(1f),
                                shape = RoundedCornerShape(12.dp)
                            )
                            OutlinedTextField(
                                value = tanggalLahir,
                                onValueChange = { tanggalLahir = it },
                                label = { Text("Tgl Lahir") },
                                placeholder = { Text("YYYY-MM-DD") },
                                modifier = Modifier.weight(1f),
                                shape = RoundedCornerShape(12.dp)
                            )
                        }

                        ExposedDropdownMenuBox(
                            expanded = expandedTahunMasuk,
                            onExpandedChange = { expandedTahunMasuk = !expandedTahunMasuk }
                        ) {
                            OutlinedTextField(
                                value = angkatanList.find { it.id == tahunMasuk }?.let { "${it.namaAngkatan} (${it.tahun})" } ?: "",
                                onValueChange = {},
                                readOnly = true,
                                label = { Text("Pilih Angkatan") },
                                trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedTahunMasuk) },
                                modifier = Modifier
                                    .menuAnchor()
                                    .fillMaxWidth(),
                                shape = RoundedCornerShape(12.dp)
                            )
                            ExposedDropdownMenu(
                                expanded = expandedTahunMasuk,
                                onDismissRequest = { expandedTahunMasuk = false }
                            ) {
                                angkatanList.forEach { angkatan ->
                                    DropdownMenuItem(
                                        text = { Text("${angkatan.namaAngkatan} (${angkatan.tahun})") },
                                        onClick = {
                                            tahunMasuk = angkatan.id
                                            expandedTahunMasuk = false
                                        }
                                    )
                                }
                            }
                        }

                        OutlinedTextField(
                            value = alamat,
                            onValueChange = { alamat = it },
                            label = { Text("Alamat") },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp),
                            maxLines = 3
                        )

                        OutlinedTextField(
                            value = riwayatAlergi,
                            onValueChange = { riwayatAlergi = it },
                            label = { Text("Riwayat Alergi (Opsional)") },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp)
                        )

                        HorizontalDivider(color = Slate100)
                        Text("Data Wali", fontWeight = FontWeight.Bold, color = DeisaBlue)

                        OutlinedTextField(
                            value = namaWali,
                            onValueChange = { namaWali = it },
                            label = { Text("Nama Wali") },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp)
                        )

                        Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                            ExposedDropdownMenuBox(
                                expanded = expandedHubungan,
                                onExpandedChange = { expandedHubungan = !expandedHubungan },
                                modifier = Modifier.weight(1f)
                            ) {
                                OutlinedTextField(
                                    value = hubunganWali,
                                    onValueChange = {},
                                    readOnly = true,
                                    label = { Text("Hubungan") },
                                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedHubungan) },
                                    modifier = Modifier
                                        .menuAnchor()
                                        .fillMaxWidth(),
                                    shape = RoundedCornerShape(12.dp)
                                )
                                ExposedDropdownMenu(
                                    expanded = expandedHubungan,
                                    onDismissRequest = { expandedHubungan = false }
                                ) {
                                    listOf("Ayah", "Ibu", "Wali", "Saudara").forEach { h ->
                                        DropdownMenuItem(text = { Text(h) }, onClick = { hubunganWali = h; expandedHubungan = false })
                                    }
                                }
                            }

                            OutlinedTextField(
                                value = noTelpWali,
                                onValueChange = { noTelpWali = it },
                                label = { Text("No. HP") },
                                modifier = Modifier.weight(1f),
                                shape = RoundedCornerShape(12.dp),
                                keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Phone)
                            )
                        }

                        OutlinedTextField(
                            value = pekerjaanWali,
                            onValueChange = { pekerjaanWali = it },
                            label = { Text("Pekerjaan") },
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
                            border = BorderStroke(1.dp, DeisaBlue)
                        ) {
                            Text("KEMBALI")
                        }
                    }

                    Button(
                        onClick = {
                            if (currentStep < 2) {
                                // Validate Step 1
                                if (nis.isBlank() || namaLengkap.isBlank() || selectedKelasId == null) {
                                    // Add validation feedback here
                                    return@Button
                                }
                                currentStep++
                            } else {
                                // Submit
                                val request = SantriRequest(
                                    nis = nis,
                                    namaLengkap = namaLengkap,
                                    kelasId = selectedKelasId ?: 0,
                                    jurusanId = selectedJurusanId,
                                    angkatanId = tahunMasuk, // Changed param name
                                    jenisKelamin = jenisKelamin,
                                    statusKesehatan = statusKesehatan,
                                    tempatLahir = tempatLahir,
                                    tanggalLahir = tanggalLahir,
                                    riwayatAlergi = riwayatAlergi,
                                    alamat = alamat,
                                    namaWali = namaWali,
                                    hubunganWali = hubunganWali,
                                    noTelpWali = noTelpWali,
                                    pekerjaanWali = pekerjaanWali,
                                    alamatWali = alamatWali
                                )
                                if (santriId == null) {
                                    viewModel.createSantri(request, photoFile, { navController.navigateUp() }, {})
                                } else {
                                    viewModel.updateSantri(santriId, request, photoFile, { navController.navigateUp() }, {})
                                }
                            }
                        },
                        modifier = Modifier
                            .weight(1f)
                            .height(56.dp),
                        shape = RoundedCornerShape(12.dp),
                        colors = ButtonDefaults.buttonColors(containerColor = DeisaBlue)
                    ) {
                        Text(if (currentStep < 2) "LANJUT" else "SIMPAN")
                    }
                }
            }
        }
    }
}
