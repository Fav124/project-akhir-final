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
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()

    var namaObat by remember { mutableStateOf("") }
    var jenis by remember { mutableStateOf("") }
    var stok by remember { mutableStateOf("") }
    var satuan by remember { mutableStateOf("pcs") }
    var keterangan by remember { mutableStateOf("") }
    
    var showError by remember { mutableStateOf(false) }
    var errorMessage by remember { mutableStateOf("") }

    LaunchedEffect(Unit) {
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
                title = { Text("Tambah Obat Baru") },
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
                    value = namaObat,
                    onValueChange = { namaObat = it },
                    label = { Text("Nama Obat") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true
                )

                OutlinedTextField(
                    value = jenis,
                    onValueChange = { jenis = it },
                    label = { Text("Jenis (e.g. Tablet, Sirup)") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true
                )

                Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                    OutlinedTextField(
                        value = stok,
                        onValueChange = { if (it.all { char -> char.isDigit() }) stok = it },
                        label = { Text("Stok Awal") },
                        modifier = Modifier.weight(1f),
                        singleLine = true,
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Number)
                    )
                    OutlinedTextField(
                        value = satuan,
                        onValueChange = { satuan = it },
                        label = { Text("Satuan") },
                        modifier = Modifier.weight(1f),
                        singleLine = true
                    )
                }

                OutlinedTextField(
                    value = keterangan,
                    onValueChange = { keterangan = it },
                    label = { Text("Keterangan (Optional)") },
                    modifier = Modifier.fillMaxWidth(),
                    minLines = 3
                )

                Spacer(modifier = Modifier.height(16.dp))

                Button(
                    onClick = {
                        if (namaObat.isNotBlank() && jenis.isNotBlank() && stok.isNotBlank()) {
                            val obatData = mapOf(
                                "nama_obat" to namaObat,
                                "jenis" to jenis,
                                "stok" to stok.toInt(),
                                "satuan" to satuan,
                                "keterangan" to keterangan
                            )
                            resourceViewModel.createObat(obatData)
                        } else {
                            errorMessage = "Mohon lengkapi Nama, Jenis, dan Stok"
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
