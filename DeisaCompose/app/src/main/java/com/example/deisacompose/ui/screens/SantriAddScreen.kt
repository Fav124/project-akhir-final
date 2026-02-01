package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()
    val kelasList by resourceViewModel.kelasList.collectAsState()
    val jurusanList by resourceViewModel.jurusanList.collectAsState()

    var namaLengkap by remember { mutableStateOf("") }
    var nis by remember { mutableStateOf("") }
    var jenisKelamin by remember { mutableStateOf("L") }
    var tempatLahir by remember { mutableStateOf("") }
    var tanggalLahir by remember { mutableStateOf("") }
    var alamat by remember { mutableStateOf("") }
    var noHpWali by remember { mutableStateOf("") }
    var selectedKelasId by remember { mutableStateOf<Int?>(null) }
    var selectedJurusanId by remember { mutableStateOf<Int?>(null) }

    var expandedKelas by remember { mutableStateOf(false) }
    var expandedJurusan by remember { mutableStateOf(false) }

    var showError by remember { mutableStateOf(false) }
    var errorMessage by remember { mutableStateOf("") }

    LaunchedEffect(Unit) {
        resourceViewModel.loadKelas()
        resourceViewModel.loadJurusan()
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
                errorMessage = state.message
                showError = true
                delay(3000)
                showError = false
                resourceViewModel.resetState()
            }
            else -> {}
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Tambah Santri") },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, "Kembali")
                    }
                }
            )
        }
    ) { padding ->
        Box(modifier = Modifier.fillMaxSize()) {
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(padding)
                    .verticalScroll(rememberScrollState())
                    .padding(16.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                OutlinedTextField(
                    value = namaLengkap,
                    onValueChange = { namaLengkap = it },
                    label = { Text("Nama Lengkap") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true
                )

                OutlinedTextField(
                    value = nis,
                    onValueChange = { nis = it },
                    label = { Text("NIS") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true,
                    keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                )

                // Gender Selection
                Column {
                    Text("Jenis Kelamin", style = MaterialTheme.typography.bodyMedium)
                    Row(verticalAlignment = Alignment.CenterVertically) {
                        RadioButton(
                            selected = jenisKelamin == "L",
                            onClick = { jenisKelamin = "L" }
                        )
                        Text("Laki-laki")
                        Spacer(modifier = Modifier.width(16.dp))
                        RadioButton(
                            selected = jenisKelamin == "P",
                            onClick = { jenisKelamin = "P" }
                        )
                        Text("Perempuan")
                    }
                }

                Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                    OutlinedTextField(
                        value = tempatLahir,
                        onValueChange = { tempatLahir = it },
                        label = { Text("Tempat Lahir") },
                        modifier = Modifier.weight(1f),
                        singleLine = true
                    )
                    OutlinedTextField(
                        value = tanggalLahir,
                        onValueChange = { tanggalLahir = it }, // TODO: DatePicker
                        label = { Text("Tanggal Lahir (YYYY-MM-DD)") },
                        modifier = Modifier.weight(1f),
                        singleLine = true
                    )
                }

                OutlinedTextField(
                    value = alamat,
                    onValueChange = { alamat = it },
                    label = { Text("Alamat") },
                    modifier = Modifier.fillMaxWidth(),
                    minLines = 3
                )

                OutlinedTextField(
                    value = noHpWali,
                    onValueChange = { noHpWali = it },
                    label = { Text("No. HP Wali") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true,
                    keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Phone)
                )

                // Kelas Dropdown
                ExposedDropdownMenuBox(
                    expanded = expandedKelas,
                    onExpandedChange = { expandedKelas = !expandedKelas }
                ) {
                    OutlinedTextField(
                        value = kelasList.find { it.id == selectedKelasId }?.nama_kelas ?: "",
                        onValueChange = {},
                        readOnly = true,
                        label = { Text("Kelas") },
                        trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedKelas) },
                        modifier = Modifier.fillMaxWidth().menuAnchor()
                    )
                    ExposedDropdownMenu(
                        expanded = expandedKelas,
                        onDismissRequest = { expandedKelas = false }
                    ) {
                        kelasList.forEach { kelas ->
                            DropdownMenuItem(
                                text = { Text(kelas.nama_kelas) },
                                onClick = {
                                    selectedKelasId = kelas.id
                                    expandedKelas = false
                                }
                            )
                        }
                    }
                }

                // Jurusan Dropdown
                ExposedDropdownMenuBox(
                    expanded = expandedJurusan,
                    onExpandedChange = { expandedJurusan = !expandedJurusan }
                ) {
                    OutlinedTextField(
                        value = jurusanList.find { it.id == selectedJurusanId }?.nama_jurusan ?: "",
                        onValueChange = {},
                        readOnly = true,
                        label = { Text("Jurusan") },
                        trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedJurusan) },
                        modifier = Modifier.fillMaxWidth().menuAnchor()
                    )
                    ExposedDropdownMenu(
                        expanded = expandedJurusan,
                        onDismissRequest = { expandedJurusan = false }
                    ) {
                        jurusanList.forEach { jurusan ->
                            DropdownMenuItem(
                                text = { Text(jurusan.nama_jurusan) },
                                onClick = {
                                    selectedJurusanId = jurusan.id
                                    expandedJurusan = false
                                }
                            )
                        }
                    }
                }

                Spacer(modifier = Modifier.height(16.dp))

                Button(
                    onClick = {
                        if (namaLengkap.isNotBlank() && nis.isNotBlank() && 
                            selectedKelasId != null && selectedJurusanId != null) {
                            val santriData = mapOf(
                                "nama_lengkap" to namaLengkap,
                                "nis" to nis,
                                "jenis_kelamin" to jenisKelamin,
                                "tempat_lahir" to tempatLahir,
                                "tanggal_lahir" to tanggalLahir,
                                "alamat" to alamat,
                                "nama_wali" to "Wali $namaLengkap", // Simplified
                                "no_hp_wali" to noHpWali,
                                "kelas_id" to selectedKelasId!!,
                                "jurusan_id" to selectedJurusanId!!,
                                "status" to "Aktif"
                            )
                            resourceViewModel.createSantri(santriData)
                        } else {
                            errorMessage = "Mohon lengkapi data wajib (Nama, NIS, Kelas, Jurusan)"
                            showError = true
                        }
                    },
                    modifier = Modifier.fillMaxWidth().height(56.dp),
                    enabled = uiState !is ResourceUiState.Loading,
                    shape = RoundedCornerShape(16.dp)
                ) {
                    if (uiState is ResourceUiState.Loading) {
                        CircularProgressIndicator(color = MaterialTheme.colorScheme.onPrimary)
                    } else {
                        Text("Simpan Data")
                    }
                }
            }
            
            // Error Snackbar
            AnimatedVisibility(
                visible = showError,
                modifier = Modifier.align(Alignment.BottomCenter).padding(16.dp)
            ) {
                Snackbar(
                    containerColor = MaterialTheme.colorScheme.errorContainer,
                    contentColor = MaterialTheme.colorScheme.onErrorContainer
                ) {
                    Text(errorMessage)
                }
            }
        }
    }
}
