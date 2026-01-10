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
import com.example.deisacompose.data.models.ObatRequest
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.ObatViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatFormScreen(
    navController: NavController,
    viewModel: ObatViewModel = viewModel(),
    obatId: Int? = null
) {
    var namaObat by remember { mutableStateOf("") }
    var deskripsi by remember { mutableStateOf("") }
    var stok by remember { mutableStateOf("") }
    var satuan by remember { mutableStateOf("") }
    
    var isLoading by remember { mutableStateOf(false) }
    
    val obatDetail by viewModel.obatDetail.observeAsState()

    LaunchedEffect(obatId) {
        if (obatId != null) {
            viewModel.getObatById(obatId)
        } else {
            viewModel.clearDetail()
        }
    }
    
    LaunchedEffect(obatDetail) {
        obatDetail?.let {
            namaObat = it.namaObat
            deskripsi = it.deskripsi ?: ""
            stok = it.stok.toString()
            satuan = it.satuan ?: ""
        }
    }

    Scaffold(
        topBar = { DeisaTopBar(if (obatId == null) "Tambah Obat" else "Edit Obat") }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {
            DeisaTextField(value = namaObat, onValueChange = { namaObat = it }, label = "Nama Obat")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = deskripsi, onValueChange = { deskripsi = it }, label = "Deskripsi")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = stok, onValueChange = { stok = it }, label = "Stok", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number))
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = satuan, onValueChange = { satuan = it }, label = "Satuan (e.g., Strip, Botol)")
            
            Spacer(modifier = Modifier.height(24.dp))
            
            DeisaButton(
                text = if (obatId == null) "Simpan Data" else "Update Data",
                onClick = {
                    isLoading = true
                    val request = ObatRequest(
                        namaObat = namaObat,
                        deskripsi = deskripsi,
                        stok = stok.toIntOrNull() ?: 0,
                        satuan = satuan
                    )
                    
                     if (obatId == null) {
                        viewModel.createObat(request) {
                            isLoading = false
                            navController.popBackStack()
                        }
                    } else {
                        viewModel.updateObat(obatId, request) {
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
