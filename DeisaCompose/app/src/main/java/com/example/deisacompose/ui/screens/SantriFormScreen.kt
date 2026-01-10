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

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriFormScreen(
    navController: NavController,
    viewModel: SantriViewModel = viewModel(),
    santriId: Int? = null
) {
    // States
    var nis by remember { mutableStateOf("") }
    var nama by remember { mutableStateOf("") }
    var kelasId by remember { mutableStateOf("") }
    var jurusanId by remember { mutableStateOf("") }
    var jenisKelamin by remember { mutableStateOf("L") }
    var tempatLahir by remember { mutableStateOf("") }
    var tanggalLahir by remember { mutableStateOf("") }
    var alamat by remember { mutableStateOf("") }
    var namaWali by remember { mutableStateOf("") }
    var noTelpWali by remember { mutableStateOf("") }
    
    var isLoading by remember { mutableStateOf(false) }
    
    val santriDetail by viewModel.santriDetail.observeAsState()

    // Fetch if Edit Mode
    LaunchedEffect(santriId) {
        if (santriId != null) {
            viewModel.fetchSantriById(santriId)
        } else {
            viewModel.clearDetail()
        }
    }
    
    // Populate Fields
    LaunchedEffect(santriDetail) {
        santriDetail?.let {
            nis = it.nis ?: ""
            nama = it.namaLengkap ?: ""
            kelasId = it.kelasId?.toString() ?: ""
            jurusanId = it.jurusanId?.toString() ?: ""
            jenisKelamin = it.jenisKelamin ?: "L"
            tempatLahir = it.tempatLahir ?: ""
            tanggalLahir = it.tanggalLahir ?: ""
            alamat = it.alamat ?: ""
            namaWali = it.namaWali ?: ""
            noTelpWali = it.noTelpWali ?: ""
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
            DeisaTextField(value = kelasId, onValueChange = { kelasId = it }, label = "ID Kelas (Int)")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = jurusanId, onValueChange = { jurusanId = it }, label = "ID Jurusan (Int)")
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaDropdown(
                label = "Jenis Kelamin",
                options = listOf("Laki-laki", "Perempuan"),
                selectedOption = if(jenisKelamin == "L") "Laki-laki" else "Perempuan",
                onOptionSelected = { jenisKelamin = if(it == "Laki-laki") "L" else "P" }
            )
            Spacer(modifier = Modifier.height(8.dp))

            DeisaTextField(value = tempatLahir, onValueChange = { tempatLahir = it }, label = "Tempat Lahir")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaDatePickerField(value = tanggalLahir, onValueChange = { tanggalLahir = it }, label = "Tanggal Lahir")
            
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = alamat, onValueChange = { alamat = it }, label = "Alamat")
            
            Spacer(modifier = Modifier.height(16.dp))
            Text("Data Wali", style = MaterialTheme.typography.titleMedium)
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = namaWali, onValueChange = { namaWali = it }, label = "Nama Wali")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = noTelpWali, onValueChange = { noTelpWali = it }, label = "No Telp Wali", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Phone)) 

            Spacer(modifier = Modifier.height(24.dp))
            
            DeisaButton(
                text = if (santriId == null) "Simpan Data" else "Update Data",
                onClick = {
                    isLoading = true
                    val request = SantriRequest(
                        nis = nis,
                        namaLengkap = nama,
                        kelasId = kelasId.toIntOrNull() ?: 0,
                        jurusanId = jurusanId.toIntOrNull() ?: 0,
                        jenisKelamin = jenisKelamin,
                        tempatLahir = tempatLahir,
                        tanggalLahir = tanggalLahir,
                        alamat = alamat,
                        namaWali = namaWali,
                        noTelpWali = noTelpWali
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
        }
    }
}
