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
import com.example.deisacompose.data.models.SakitRequest
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.SakitViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitFormScreen(
    navController: NavController,
    viewModel: SakitViewModel = viewModel(),
    sakitId: Int? = null
) {
    var santriId by remember { mutableStateOf("") }
    var tglSakit by remember { mutableStateOf("") }
    var keluhan by remember { mutableStateOf("") }
    var diagnosis by remember { mutableStateOf("") }
    var tindakan by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Ringan") }
    
    var isLoading by remember { mutableStateOf(false) }
    
    val sakitDetail by viewModel.sakitDetail.observeAsState()

    LaunchedEffect(sakitId) {
        if (sakitId != null) {
            viewModel.getSakitById(sakitId)
        } else {
            viewModel.clearDetail()
        }
    }
    
    LaunchedEffect(sakitDetail) {
        sakitDetail?.let {
            santriId = it.santriId.toString()
            tglSakit = it.tanggalMulaiSakit ?: it.tanggalSakit ?: ""
            keluhan = it.gejala ?: ""
            diagnosis = it.diagnosis ?: ""
            tindakan = it.tindakan ?: ""
            status = it.tingkatKondisi ?: "Ringan"
        }
    }

    Scaffold(
        topBar = { DeisaTopBar(if (sakitId == null) "Catat Sakit" else "Edit Data Sakit") }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {
            DeisaTextField(value = santriId, onValueChange = { santriId = it }, label = "ID Santri (Int)", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number))
            
            Spacer(modifier = Modifier.height(16.dp))
            
            DeisaDatePickerField(value = tglSakit, onValueChange = { tglSakit = it }, label = "Tanggal Sakit")
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaTextField(value = keluhan, onValueChange = { keluhan = it }, label = "Gejala / Keluhan")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = diagnosis, onValueChange = { diagnosis = it }, label = "Diagnosis Awal")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = tindakan, onValueChange = { tindakan = it }, label = "Tindakan")
            
            Spacer(modifier = Modifier.height(8.dp))
            DeisaDropdown(
                label = "Tingkat Keparahan",
                options = listOf("Ringan", "Sedang", "Berat"),
                selectedOption = status,
                onOptionSelected = { status = it }
            )

            Spacer(modifier = Modifier.height(24.dp))
            
            DeisaButton(
                text = if (sakitId == null) "Simpan Data" else "Update Data",
                onClick = {
                    isLoading = true
                    val request = SakitRequest(
                        santriId = santriId.toIntOrNull() ?: 0,
                        tanggalMulaiSakit = tglSakit,
                        gejala = keluhan,
                        diagnosis = diagnosis,
                        tindakan = tindakan,
                        tingkatKondisi = status
                    )
                    
                     if (sakitId == null) {
                        viewModel.submitSakit(request) {
                             isLoading = false
                             navController.popBackStack()
                        }
                    } else {
                         viewModel.updateSakit(sakitId, request) {
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
