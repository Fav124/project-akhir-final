package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.SantriRequest
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.SantriViewModel
import com.example.deisacompose.viewmodels.ManagementViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriFormScreen(
    navController: NavController,
    viewModel: SantriViewModel = viewModel(),
    mgmtViewModel: ManagementViewModel = viewModel(),
    santriId: Int? = null
) {
    // States
    var nis by remember { mutableStateOf("") }
    var nama by remember { mutableStateOf("") }
    var selectedKelasId by remember { mutableStateOf<Int?>(null) }
    var selectedJurusanId by remember { mutableStateOf<Int?>(null) }
    var jenisKelamin by remember { mutableStateOf("L") }
    var tempatLahir by remember { mutableStateOf("") }
    var tanggalLahir by remember { mutableStateOf("") }
    var alamat by remember { mutableStateOf("") }
    var golonganDarah by remember { mutableStateOf("A") }
    
    // Wali
    var namaWali by remember { mutableStateOf("") }
    var hubunganWali by remember { mutableStateOf("Ayah") }
    var noHpWali by remember { mutableStateOf("") }
    
    var isLoading by remember { mutableStateOf(false) }
    
    val santriDetail by viewModel.santriDetail.observeAsState()
    val kelasList by mgmtViewModel.kelasList.observeAsState(emptyList())
    val jurusanList by mgmtViewModel.jurusanList.observeAsState(emptyList())

    // Initial Fetch
    LaunchedEffect(Unit) {
        mgmtViewModel.fetchKelas()
        mgmtViewModel.fetchJurusan()
    }

    // Fetch if Edit Mode
    LaunchedEffect(santriId) {
        if (santriId != null) {
            viewModel.fetchSantriById(santriId)
        } else {
            viewModel.clearDetail()
        }
    }
    
    // Populate Fields on Edit
    LaunchedEffect(santriDetail) {
        santriDetail?.let {
            nis = it.nis ?: ""
            nama = it.namaLengkap ?: ""
            selectedKelasId = it.kelasId
            selectedJurusanId = it.jurusanId
            jenisKelamin = it.jenisKelamin ?: "L"
            tempatLahir = it.tempatLahir ?: ""
            tanggalLahir = it.tanggalLahir ?: ""
            alamat = it.alamat ?: ""
            golonganDarah = it.golonganDarah ?: "A"
            
            it.wali?.let { w ->
                namaWali = w.namaWali
                hubunganWali = w.hubungan
                noHpWali = w.noHp
            }
        }
    }

    Scaffold(
        topBar = { DeisaTopBar(if (santriId == null) "Tambah Data Santri" else "Edit Data Santri") }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {
            DeisaTextField(value = nis, onValueChange = { nis = it }, label = "NIS")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = nama, onValueChange = { nama = it }, label = "Nama Lengkap")
            Spacer(modifier = Modifier.height(8.dp))
            
            // Kelas Dropdown
            DeisaDropdown(
                label = "Kelas",
                options = kelasList.map { it.namaKelas ?: "Unknown" },
                selectedOption = kelasList.find { it.id == selectedKelasId }?.namaKelas ?: "Pilih Kelas",
                onOptionSelected = { name -> 
                    selectedKelasId = kelasList.find { it.namaKelas == name }?.id
                }
            )
            Spacer(modifier = Modifier.height(8.dp))
            
            // Jurusan Dropdown
            DeisaDropdown(
                label = "Jurusan",
                options = jurusanList.map { it.namaJurusan ?: "Unknown" },
                selectedOption = jurusanList.find { it.id == selectedJurusanId }?.namaJurusan ?: "Pilih Jurusan",
                onOptionSelected = { name -> 
                    selectedJurusanId = jurusanList.find { it.namaJurusan == name }?.id
                }
            )
            Spacer(modifier = Modifier.height(8.dp))
            
            Row(modifier = Modifier.fillMaxWidth()) {
                Box(modifier = Modifier.weight(1f)) {
                    DeisaDropdown(
                        label = "Jenis Kelamin",
                        options = listOf("Laki-laki", "Perempuan"),
                        selectedOption = if(jenisKelamin == "L") "Laki-laki" else "Perempuan",
                        onOptionSelected = { jenisKelamin = if(it == "Laki-laki") "L" else "P" }
                    )
                }
                Spacer(modifier = Modifier.width(8.dp))
                Box(modifier = Modifier.weight(1f)) {
                    DeisaDropdown(
                        label = "Gol. Darah",
                        options = listOf("A", "B", "AB", "O"),
                        selectedOption = golonganDarah,
                        onOptionSelected = { golonganDarah = it }
                    )
                }
            }
            
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = tempatLahir, onValueChange = { tempatLahir = it }, label = "Tempat Lahir")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaDatePickerField(value = tanggalLahir, onValueChange = { tanggalLahir = it }, label = "Tanggal Lahir")
            
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = alamat, onValueChange = { alamat = it }, label = "Alamat")
            
            Spacer(modifier = Modifier.height(16.dp))
            HorizontalDivider()
            Spacer(modifier = Modifier.height(16.dp))
            Text("Data Wali Santri", style = MaterialTheme.typography.titleMedium)
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaTextField(value = namaWali, onValueChange = { namaWali = it }, label = "Nama Wali")
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaDropdown(
                label = "Hubungan",
                options = listOf("Ayah", "Ibu", "Kakek", "Nenek", "Paman", "Bibi", "Wali"),
                selectedOption = hubunganWali,
                onOptionSelected = { hubunganWali = it }
            )
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaTextField(
                value = noHpWali, 
                onValueChange = { noHpWali = it }, 
                label = "No. HP Wali", 
                keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Phone)
            ) 

            Spacer(modifier = Modifier.height(32.dp))
            
            DeisaButton(
                text = if (santriId == null) "Simpan Data" else "Update Data",
                onClick = {
                    if (selectedKelasId == null || selectedJurusanId == null) return@DeisaButton
                    
                    isLoading = true
                    val request = SantriRequest(
                        nis = nis,
                        namaLengkap = nama,
                        kelasId = selectedKelasId!!,
                        jurusanId = selectedJurusanId!!,
                        jenisKelamin = jenisKelamin,
                        tempatLahir = tempatLahir,
                        tanggalLahir = tanggalLahir,
                        alamat = alamat,
                        namaWali = namaWali,
                        hubunganWali = hubunganWali,
                        noHpWali = noHpWali
                    )
                    
                    if (santriId == null) {
                        viewModel.createSantri(request) {
                            isLoading = false
                            navController.popBackStack()
                        }
                    } else {
                        viewModel.updateSantri(santriId, request) {
                            isLoading = false
                            navController.popBackStack()
                        }
                    }
                },
                modifier = Modifier.fillMaxWidth(),
                isLoading = isLoading
            )
            Spacer(modifier = Modifier.height(32.dp))
        }
    }
}
