package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
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
import com.example.deisacompose.ui.global.*
import com.example.deisacompose.ui.theme.*
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
                    viewModel.fetchSantri(query.ifBlank { null })
                },
                modifier = Modifier.padding(16.dp),
                focusedBorderColor = DeisaBlue
            )

            SwipeRefresh(
                state = swipeRefreshState,
                onRefresh = { viewModel.fetchSantri() }
            ) {
                if (isLoading && santriList.isEmpty()) {
                    ListSkeleton(
                        itemCount = 5,
                        modifier = Modifier
                            .fillMaxSize()
                            .padding(horizontal = 16.dp, vertical = 8.dp)
                    )
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
    val santriDetail by viewModel.santriDetail.observeAsState()
    val kelasList by mgmtViewModel.kelasList.observeAsState(emptyList())
    val jurusanList by mgmtViewModel.jurusanList.observeAsState(emptyList())

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
    var tahunMasuk by remember { mutableStateOf<Int?>(null) }

    var expandedKelas by remember { mutableStateOf(false) }
    var expandedJurusan by remember { mutableStateOf(false) }
    var expandedGender by remember { mutableStateOf(false) }
    var expandedStatus by remember { mutableStateOf(false) }
    var expandedHubungan by remember { mutableStateOf(false) }
    var expandedTahunMasuk by remember { mutableStateOf(false) }
    
    val currentYear = java.util.Calendar.getInstance().get(java.util.Calendar.YEAR)
    val tahunMasukOptions = (2010..currentYear).toList().reversed()

    LaunchedEffect(Unit) {
        mgmtViewModel.fetchKelas()
        mgmtViewModel.fetchJurusan()
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
            tahunMasuk = it.tahunMasuk

            // From Wali
            it.wali?.let { w ->
                namaWali = w.namaWali
                hubunganWali = w.hubungan
                noTelpWali = w.noHp
            }
        }
    }

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
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .fillMaxSize()
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
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
                // Gender Selection
                ExposedDropdownMenuBox(
                    expanded = expandedGender,
                    onExpandedChange = { expandedGender = !expandedGender },
                    modifier = Modifier.weight(1f)
                ) {
                    OutlinedTextField(
                        value = if (jenisKelamin == "L") "Laki-laki" else "Perempuan",
                        onValueChange = {},
                        readOnly = true,
                        label = { Text("Jenis Kelamin") },
                        trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedGender) },
                        modifier = Modifier.menuAnchor().fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp)
                    )
                    ExposedDropdownMenu(
                        expanded = expandedGender,
                        onDismissRequest = { expandedGender = false }
                    ) {
                        DropdownMenuItem(
                            text = { Text("Laki-laki") },
                            onClick = {
                                jenisKelamin = "L"
                                expandedGender = false
                            }
                        )
                        DropdownMenuItem(
                            text = { Text("Perempuan") },
                            onClick = {
                                jenisKelamin = "P"
                                expandedGender = false
                            }
                        )
                    }
                }

                // Status Selection
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
                        modifier = Modifier.menuAnchor().fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp)
                    )
                    ExposedDropdownMenu(
                        expanded = expandedStatus,
                        onDismissRequest = { expandedStatus = false }
                    ) {
                        listOf("Sehat", "Sakit", "Pemulihan").forEach { s ->
                            DropdownMenuItem(
                                text = { Text(s) },
                                onClick = {
                                    statusKesehatan = s
                                    expandedStatus = false
                                }
                            )
                        }
                    }
                }
            }

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
                    label = { Text("Tgl Lahir (YYYY-MM-DD)") },
                    modifier = Modifier.weight(1f),
                    shape = RoundedCornerShape(12.dp),
                    keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                )
            }

            // Kelas Selection
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
                    modifier = Modifier.menuAnchor().fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp)
                )
                ExposedDropdownMenu(
                    expanded = expandedKelas,
                    onDismissRequest = { expandedKelas = false }
                ) {
                    kelasList.forEach { kelas ->
                        DropdownMenuItem(
                            text = { Text(kelas.namaKelas ?: "-") },
                            onClick = {
                                selectedKelasId = kelas.id
                                expandedKelas = false
                            }
                        )
                    }
                }
            }

            // Jurusan Selection
            ExposedDropdownMenuBox(
                expanded = expandedJurusan,
                onExpandedChange = { expandedJurusan = !expandedJurusan }
            ) {
                OutlinedTextField(
                    value = jurusanList.find { it.id == selectedJurusanId }?.namaJurusan ?: "",
                    onValueChange = {},
                    readOnly = true,
                    label = { Text("Pilih Jurusan (Opsional)") },
                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedJurusan) },
                    modifier = Modifier.menuAnchor().fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp)
                )
                ExposedDropdownMenu(
                    expanded = expandedJurusan,
                    onDismissRequest = { expandedJurusan = false }
                ) {
                    jurusanList.forEach { jurusan ->
                        DropdownMenuItem(
                            text = { Text(jurusan.namaJurusan ?: "-") },
                            onClick = {
                                selectedJurusanId = jurusan.id
                                expandedJurusan = false
                            }
                        )
                    }
                }
            }

            // Tahun Masuk Selection
            ExposedDropdownMenuBox(
                expanded = expandedTahunMasuk,
                onExpandedChange = { expandedTahunMasuk = !expandedTahunMasuk }
            ) {
                OutlinedTextField(
                    value = tahunMasuk?.toString() ?: "Pilih Tahun Masuk",
                    onValueChange = {},
                    readOnly = true,
                    label = { Text("Tahun Masuk (Angkatan)") },
                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedTahunMasuk) },
                    modifier = Modifier.menuAnchor().fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp)
                )
                ExposedDropdownMenu(
                    expanded = expandedTahunMasuk,
                    onDismissRequest = { expandedTahunMasuk = false }
                ) {
                    tahunMasukOptions.forEach { year ->
                        DropdownMenuItem(
                            text = { Text(year.toString()) },
                            onClick = {
                                tahunMasuk = year
                                expandedTahunMasuk = false
                            }
                        )
                    }
                }
            }

            OutlinedTextField(
                value = riwayatAlergi,
                onValueChange = { riwayatAlergi = it },
                label = { Text("Riwayat Alergi") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            OutlinedTextField(
                value = alamat,
                onValueChange = { alamat = it },
                label = { Text("Alamat") },
                modifier = Modifier.fillMaxWidth().height(100.dp),
                shape = RoundedCornerShape(12.dp),
                maxLines = 3
            )

            HorizontalDivider(modifier = Modifier.padding(vertical = 8.dp))
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
                        modifier = Modifier.menuAnchor().fillMaxWidth(),
                        shape = RoundedCornerShape(12.dp)
                    )
                    ExposedDropdownMenu(
                        expanded = expandedHubungan,
                        onDismissRequest = { expandedHubungan = false }
                    ) {
                        listOf("Ayah", "Ibu", "Wali", "Saudara").forEach { h ->
                            DropdownMenuItem(
                                text = { Text(h) },
                                onClick = {
                                    hubunganWali = h
                                    expandedHubungan = false
                                }
                            )
                        }
                    }
                }

                OutlinedTextField(
                    value = noTelpWali,
                    onValueChange = { noTelpWali = it },
                    label = { Text("No. HP Wali") },
                    modifier = Modifier.weight(1f),
                    shape = RoundedCornerShape(12.dp),
                    keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Phone)
                )
            }

            OutlinedTextField(
                value = pekerjaanWali,
                onValueChange = { pekerjaanWali = it },
                label = { Text("Pekerjaan Wali") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            OutlinedTextField(
                value = alamatWali,
                onValueChange = { alamatWali = it },
                label = { Text("Alamat Wali (Jika Beda)") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            Spacer(modifier = Modifier.height(24.dp))

            Button(
                onClick = {
                    if (nis.isBlank() || namaLengkap.isBlank() || selectedKelasId == null) {
                        // Show error or toast
                        return@Button
                    }
                    val request = SantriRequest(
                        nis = nis,
                        namaLengkap = namaLengkap,
                        kelasId = selectedKelasId ?: 0,
                        jurusanId = selectedJurusanId,
                        tahunMasuk = tahunMasuk,
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
                        viewModel.createSantri(request, { navController.navigateUp() }, {})
                    } else {
                        viewModel.updateSantri(santriId, request, { navController.navigateUp() }, {})
                    }
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(56.dp),
                shape = RoundedCornerShape(12.dp),
                colors = ButtonDefaults.buttonColors(containerColor = DeisaBlue)
            ) {
                Text("SIMPAN", fontWeight = FontWeight.Bold)
            }
        }
    }
}
