package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()
    val santriList by resourceViewModel.santriList.collectAsState()

    var selectedSantriId by remember { mutableStateOf<Int?>(null) }
    var diagnosis by remember { mutableStateOf("") }
    var keluhan by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Sakit") }
    
    var expandedSantri by remember { mutableStateOf(false) }
    var showError by remember { mutableStateOf(false) }
    var errorMessage by remember { mutableStateOf("") }

    LaunchedEffect(Unit) {
        resourceViewModel.loadSantri() // Reload to ensure full list
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
                title = { Text("Input Data Sakit") },
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
                // Santri Selection
                ExposedDropdownMenuBox(
                    expanded = expandedSantri,
                    onExpandedChange = { expandedSantri = !expandedSantri }
                ) {
                    OutlinedTextField(
                        value = santriList.find { it.id == selectedSantriId }?.nama_lengkap ?: "",
                        onValueChange = {},
                        readOnly = true,
                        label = { Text("Pilih Santri") },
                        trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedSantri) },
                        modifier = Modifier.fillMaxWidth().menuAnchor()
                    )
                    ExposedDropdownMenu(
                        expanded = expandedSantri,
                        onDismissRequest = { expandedSantri = false },
                        modifier = Modifier.heightIn(max = 200.dp)
                    ) {
                        santriList.forEach { santri ->
                            DropdownMenuItem(
                                text = { 
                                    Column {
                                        Text(santri.nama_lengkap)
                                        Text(santri.kelas?.nama_kelas ?: "-", style = MaterialTheme.typography.bodySmall)
                                    }
                                },
                                onClick = {
                                    selectedSantriId = santri.id
                                    expandedSantri = false
                                }
                            )
                        }
                    }
                }

                OutlinedTextField(
                    value = diagnosis,
                    onValueChange = { diagnosis = it },
                    label = { Text("Diagnosis Utama") },
                    modifier = Modifier.fillMaxWidth(),
                    singleLine = true
                )

                OutlinedTextField(
                    value = keluhan,
                    onValueChange = { keluhan = it },
                    label = { Text("Keluhan") },
                    modifier = Modifier.fillMaxWidth(),
                    minLines = 3
                )

                // Status Radio
                Column(modifier = Modifier.padding(vertical = 8.dp)) {
                    Text("Status", style = MaterialTheme.typography.bodyMedium)
                    Row(verticalAlignment = Alignment.CenterVertically) {
                        RadioButton(
                            selected = status == "Sakit",
                            onClick = { status = "Sakit" }
                        )
                        Text("Sakit")
                        Spacer(modifier = Modifier.width(16.dp))
                        RadioButton(
                            selected = status == "Sembuh",
                            onClick = { status = "Sembuh" }
                        )
                        Text("Sembuh")
                    }
                }

                Spacer(modifier = Modifier.height(16.dp))

                Button(
                    onClick = {
                        if (selectedSantriId != null && diagnosis.isNotBlank()) {
                            val sakitData = mapOf(
                                "santri_id" to selectedSantriId!!,
                                "diagnosis_utama" to diagnosis,
                                "keluhan" to keluhan,
                                "status" to status,
                                "tanggal_masuk" to java.time.LocalDate.now().toString()
                            )
                            resourceViewModel.createSakit(sakitData)
                        } else {
                            errorMessage = "Pilih Santri dan isi Diagnosis"
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
