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
    var kategori by remember { mutableStateOf("Tablet") }
    var deskripsi by remember { mutableStateOf("") }
    var stok by remember { mutableStateOf("") }
    var stokMinimum by remember { mutableStateOf("10") }
    var satuan by remember { mutableStateOf("Strip") }
    var harga by remember { mutableStateOf("") }
    var tglKadaluarsa by remember { mutableStateOf("") }
    var lokasiPenyimpanan by remember { mutableStateOf("") }
    
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
            kategori = it.kategori ?: "Tablet"
            deskripsi = it.deskripsi ?: ""
            stok = it.stok.toString()
            stokMinimum = it.stokMinimum.toString()
            satuan = it.satuan ?: "Strip"
            harga = it.harga?.toString() ?: ""
            tglKadaluarsa = it.tglKadaluarsa ?: ""
            lokasiPenyimpanan = it.lokasiPenyimpanan ?: ""
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
            
            DeisaDropdown(
                label = "Kategori Obat",
                options = listOf("Tablet", "Kapsul", "Sirup", "Salep", "Injeksi", "Lainnya"),
                selectedOption = kategori,
                onOptionSelected = { kategori = it }
            )
            Spacer(modifier = Modifier.height(8.dp))
            
            DeisaTextField(value = deskripsi, onValueChange = { deskripsi = it }, label = "Deskripsi / Aturan Pakai")
            Spacer(modifier = Modifier.height(16.dp))
            
            Row(modifier = Modifier.fillMaxWidth()) {
                Box(modifier = Modifier.weight(1f)) {
                    DeisaTextField(value = stok, onValueChange = { stok = it }, label = "Stok Saat Ini", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number))
                }
                Spacer(modifier = Modifier.width(8.dp))
                Box(modifier = Modifier.weight(1f)) {
                    DeisaTextField(value = stokMinimum, onValueChange = { stokMinimum = it }, label = "Stok Minimum", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number))
                }
            }
            Spacer(modifier = Modifier.height(8.dp))
            
            Row(modifier = Modifier.fillMaxWidth()) {
                Box(modifier = Modifier.weight(1f)) {
                    DeisaTextField(value = satuan, onValueChange = { satuan = it }, label = "Satuan (Strip/Botol)")
                }
                Spacer(modifier = Modifier.width(8.dp))
                Box(modifier = Modifier.weight(1f)) {
                    DeisaTextField(value = harga, onValueChange = { harga = it }, label = "Harga Estimate", keyboardOptions = androidx.compose.foundation.text.KeyboardOptions(keyboardType = androidx.compose.ui.text.input.KeyboardType.Number))
                }
            }
            
            Spacer(modifier = Modifier.height(16.dp))
            DeisaDatePickerField(value = tglKadaluarsa, onValueChange = { tglKadaluarsa = it }, label = "Tanggal Kadaluarsa")
            Spacer(modifier = Modifier.height(8.dp))
            DeisaTextField(value = lokasiPenyimpanan, onValueChange = { lokasiPenyimpanan = it }, label = "Lokasi Penyimpanan (Box/Lemari)")

            Spacer(modifier = Modifier.height(32.dp))
            
            DeisaButton(
                text = if (obatId == null) "Simpan Data" else "Update Data",
                onClick = {
                    isLoading = true
                    val request = ObatRequest(
                        namaObat = namaObat,
                        kategori = kategori,
                        deskripsi = deskripsi,
                        stok = stok.toIntOrNull() ?: 0,
                        stokAwal = stok.toIntOrNull() ?: 0,
                        stokMinimum = stokMinimum.toIntOrNull() ?: 10,
                        satuan = satuan,
                        harga = harga.toDoubleOrNull(),
                        tglKadaluarsa = tglKadaluarsa,
                        lokasiPenyimpanan = lokasiPenyimpanan
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
            Spacer(modifier = Modifier.height(32.dp))
        }
    }
}
