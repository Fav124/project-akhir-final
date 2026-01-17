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
                Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                    CircularProgressIndicator(color = SuccessGreen)
                }
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
    val obatDetail by viewModel.obatDetail.observeAsState()

    var namaObat by remember { mutableStateOf("") }
    var kategori by remember { mutableStateOf("") }
    var stok by remember { mutableStateOf("") }
    var satuan by remember { mutableStateOf("") }
    var stokMinimum by remember { mutableStateOf("") }
    var deskripsi by remember { mutableStateOf("") }
    var harga by remember { mutableStateOf("") }
    var kadaluarsa by remember { mutableStateOf("") }
    var lokasi by remember { mutableStateOf("") }

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
            kategori = it.kategori ?: ""
            stok = it.stok.toString()
            satuan = it.satuan ?: ""
            stokMinimum = it.stokMinimum?.toString() ?: ""
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
                .padding(16.dp)
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            OutlinedTextField(
                value = namaObat,
                onValueChange = { namaObat = it },
                label = { Text("Nama Obat") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            OutlinedTextField(
                value = kategori,
                onValueChange = { kategori = it },
                label = { Text("Kategori") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp)
            )

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                OutlinedTextField(
                    value = stok,
                    onValueChange = { stok = it },
                    label = { Text("Stok") },
                    modifier = Modifier.weight(1f),
                    shape = RoundedCornerShape(12.dp)
                )
                OutlinedTextField(
                    value = satuan,
                    onValueChange = { satuan = it },
                    label = { Text("Satuan") },
                    modifier = Modifier.weight(1f),
                    shape = RoundedCornerShape(12.dp)
                )
            }

            OutlinedTextField(
                value = stokMinimum,
                onValueChange = { stokMinimum = it },
                label = { Text("Stok Minimum") },
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(12.dp),
                keyboardOptions =
                    KeyboardOptions(keyboardType = KeyboardType.Number)
            )

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
                label = { Text("Tanggal Kadaluarsa (YYYY-MM-DD)") },
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

            OutlinedTextField(
                value = deskripsi,
                onValueChange = { deskripsi = it },
                label = { Text("Deskripsi") },
                modifier = Modifier.fillMaxWidth().height(100.dp),
                shape = RoundedCornerShape(12.dp),
                maxLines = 3
            )

            Spacer(modifier = Modifier.weight(1f))

            Button(
                onClick = {
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
                        viewModel.createObat(request, { navController.navigateUp() }, {})
                    } else {
                        viewModel.updateObat(obatId, request, { navController.navigateUp() }, {})
                    }
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(56.dp),
                shape = RoundedCornerShape(12.dp),
                colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen)
            ) {
                Text("SIMPAN", fontWeight = FontWeight.Bold)
            }
        }
    }
}
