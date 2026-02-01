package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitDetailScreen(
    navController: NavController,
    sakitId: Int,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val sakitList by resourceViewModel.sakitList.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()
    
    val sakit = sakitList.find { it.id == sakitId }
    val isAdmin = currentUser?.role == "admin"

    // Edit states
    var isEditing by remember { mutableStateOf(false) }
    var editStatus by remember { mutableStateOf("") }
    var showDeleteDialog by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        if (sakit == null) {
            resourceViewModel.loadSakit() 
        }
    }
    
    LaunchedEffect(sakit) {
        sakit?.let { editStatus = it.status }
    }

    LaunchedEffect(uiState) {
        if (uiState is ResourceUiState.Success) {
            delay(1000)
            if (isEditing) isEditing = false
            else navController.navigateUp() // If delete success
            resourceViewModel.resetState()
        }
    }

    if (sakit == null) {
        Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
            CircularProgressIndicator()
        }
        return
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Detail Data Sakit") },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, "Kembali")
                    }
                },
                actions = {
                    if (isAdmin || currentUser?.role == "petugas") {
                        if (isEditing) {
                            IconButton(onClick = { 
                                resourceViewModel.updateSakit(sakit.id, mapOf("status" to editStatus))
                            }) {
                                Icon(Icons.Default.Save, "Simpan")
                            }
                        } else {
                            IconButton(onClick = { isEditing = true }) {
                                Icon(Icons.Default.Edit, "Edit Status")
                            }
                        }
                        
                        if (isAdmin) {
                            IconButton(onClick = { showDeleteDialog = true }) {
                                Icon(Icons.Default.Delete, "Hapus", tint = MaterialTheme.colorScheme.error)
                            }
                        }
                    }
                }
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(16.dp),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            Card(
                modifier = Modifier.fillMaxWidth(),
                colors = CardDefaults.cardColors(containerColor = MaterialTheme.colorScheme.surfaceVariant)
            ) {
                Column(modifier = Modifier.padding(16.dp)) {
                    Text("Informasi Santri", style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold)
                    Spacer(modifier = Modifier.height(8.dp))
                    DetailItem("Nama", sakit.santri.nama_lengkap)
                    DetailItem("Kelas", sakit.santri.kelas?.nama_kelas ?: "-")
                }
            }

            Card(
                modifier = Modifier.fillMaxWidth(),
                colors = CardDefaults.cardColors(containerColor = MaterialTheme.colorScheme.surfaceVariant)
            ) {
                Column(modifier = Modifier.padding(16.dp)) {
                    Text("Informasi Kesehatan", style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold)
                    Spacer(modifier = Modifier.height(8.dp))
                    DetailItem("Diagnosis Utama", sakit.diagnosis_utama)
                    DetailItem("Keluhan", sakit.keluhan ?: "-")
                    DetailItem("Tanggal Masuk", sakit.tanggal_masuk_human ?: "-")
                    
                    Spacer(modifier = Modifier.height(8.dp))
                    Text("Status", style = MaterialTheme.typography.bodySmall, color = MaterialTheme.colorScheme.onSurfaceVariant)
                    if (isEditing) {
                        Row(verticalAlignment = Alignment.CenterVertically) {
                            RadioButton(
                                selected = editStatus == "Sakit",
                                onClick = { editStatus = "Sakit" }
                            )
                            Text("Sakit")
                            Spacer(modifier = Modifier.width(16.dp))
                            RadioButton(
                                selected = editStatus == "Sembuh",
                                onClick = { editStatus = "Sembuh" }
                            )
                            Text("Sembuh")
                        }
                    } else {
                        AssistChip(
                            onClick = {},
                            label = { Text(sakit.status) },
                            colors = AssistChipDefaults.assistChipColors(
                                containerColor = if (sakit.status == "Sakit") MaterialTheme.colorScheme.errorContainer else MaterialTheme.colorScheme.primaryContainer,
                                labelColor = if (sakit.status == "Sakit") MaterialTheme.colorScheme.error else MaterialTheme.colorScheme.primary
                            )
                        )
                    }
                }
            }
        }
    }

    if (showDeleteDialog) {
        AlertDialog(
            onDismissRequest = { showDeleteDialog = false },
            title = { Text("Hapus Data") },
            text = { Text("Yakin ingin menghapus catatan sakit ini?") },
            confirmButton = {
                TextButton(
                    onClick = {
                        resourceViewModel.deleteSakit(sakit.id)
                        showDeleteDialog = false
                    },
                    colors = ButtonDefaults.textButtonColors(contentColor = MaterialTheme.colorScheme.error)
                ) {
                    Text("Hapus")
                }
            },
            dismissButton = {
                TextButton(onClick = { showDeleteDialog = false }) {
                    Text("Batal")
                }
            }
        )
    }
}
