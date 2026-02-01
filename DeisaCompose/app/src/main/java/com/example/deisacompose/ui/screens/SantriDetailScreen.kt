package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.foundation.border
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriDetailScreen(
    navController: NavController,
    santriId: Int,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val santriList by resourceViewModel.santriList.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()
    
    val santri = santriList.find { it.id == santriId }
    val isAdmin = currentUser?.role == "admin"

    var showDeleteDialog by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        if (santri == null) {
            resourceViewModel.loadSantri()
        }
    }

    LaunchedEffect(uiState) {
        if (uiState is ResourceUiState.Success) {
            delay(1000)
            navController.navigateUp()
            resourceViewModel.resetState()
        }
    }

    if (santri == null) {
        Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
            CircularProgressIndicator(color = Color(0xFF0B63D6))
        }
        return
    }

    Scaffold(
        topBar = {
            CenterAlignedTopAppBar(
                title = { Text("Profil Santri", fontWeight = FontWeight.ExtraBold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, "Kembali")
                    }
                },
                actions = {
                    if (isAdmin) {
                        IconButton(onClick = { /* TODO: Navigate to Edit */ }) {
                            Icon(Icons.Default.Edit, "Edit", tint = Color(0xFF0B63D6))
                        }
                        IconButton(onClick = { showDeleteDialog = true }) {
                            Icon(Icons.Default.Delete, "Hapus", tint = Color(0xFFEF4444))
                        }
                    }
                },
                colors = TopAppBarDefaults.centerAlignedTopAppBarColors(
                    containerColor = MaterialTheme.colorScheme.background
                )
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .background(MaterialTheme.colorScheme.background)
                .padding(padding)
                .verticalScroll(rememberScrollState())
        ) {
            // Profile Header
            Box(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(24.dp),
                contentAlignment = Alignment.Center
            ) {
                Column(horizontalAlignment = Alignment.CenterHorizontally) {
                    Box(
                        modifier = Modifier
                            .size(100.dp)
                            .clip(CircleShape)
                            .background(
                                Brush.linearGradient(
                                    colors = listOf(Color(0xFF0B63D6), Color(0xFF6366F1))
                                )
                            ),
                        contentAlignment = Alignment.Center
                    ) {
                        Text(
                            text = santri.nama_lengkap.take(1).uppercase(),
                            style = MaterialTheme.typography.displaySmall,
                            fontWeight = FontWeight.Black,
                            color = Color.White
                        )
                    }
                    Spacer(modifier = Modifier.height(16.dp))
                    Text(
                        text = santri.nama_lengkap,
                        style = MaterialTheme.typography.headlineMedium,
                        fontWeight = FontWeight.ExtraBold,
                        color = Color(0xFF1E293B)
                    )
                    Text(
                        text = "NIS: ${santri.nis}",
                        style = MaterialTheme.typography.bodyLarge,
                        color = Color.Gray
                    )
                }
            }

            Column(
                modifier = Modifier.padding(16.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                com.example.deisacompose.ui.components.PremiumCard(
                    modifier = Modifier.fillMaxWidth(),
                    accentColor = Color(0xFF0B63D6)
                ) {
                    Column {
                        DetailHeader("Informasi Pribadi", Icons.Default.Person)
                        DetailItem("Jenis Kelamin", if (santri.jenis_kelamin == "L") "Laki-laki" else "Perempuan")
                        DetailItem("Tempat, Tgl Lahir", "${santri.tempat_lahir}, ${santri.tanggal_lahir}")
                        DetailItem("Alamat", santri.alamat)
                    }
                }

                com.example.deisacompose.ui.components.PremiumCard(
                    modifier = Modifier.fillMaxWidth(),
                    accentColor = Color(0xFF10B981)
                ) {
                    Column {
                        DetailHeader("Akademik", Icons.Default.School)
                        DetailItem("Kelas", santri.kelas?.nama_kelas ?: "-")
                        DetailItem("Jurusan", santri.jurusan?.nama_jurusan ?: "-")
                        DetailItem("Status", santri.status)
                    }
                }

                com.example.deisacompose.ui.components.PremiumCard(
                    modifier = Modifier.fillMaxWidth(),
                    accentColor = Color(0xFFF59E0B)
                ) {
                    Column {
                        DetailHeader("Kontak Wali", Icons.Default.ContactPhone)
                        DetailItem("Nama Wali", santri.nama_wali)
                        DetailItem("No. HP Wali", santri.no_hp_wali)
                    }
                }
                
                Spacer(modifier = Modifier.height(32.dp))
            }
        }
    }

    if (showDeleteDialog) {
        AlertDialog(
            onDismissRequest = { showDeleteDialog = false },
            title = { Text("Hapus Data Santri", fontWeight = FontWeight.Bold) },
            text = { Text("Apakah Anda yakin ingin menghapus data santri ini? Tindakan ini tidak dapat dibatalkan.") },
            confirmButton = {
                TextButton(
                    onClick = {
                        resourceViewModel.deleteSantri(santri.id)
                        showDeleteDialog = false
                    },
                    colors = ButtonDefaults.textButtonColors(contentColor = Color(0xFFEF4444))
                ) {
                    Text("Hapus", fontWeight = FontWeight.Bold)
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

@Composable
private fun DetailHeader(title: String, icon: androidx.compose.ui.graphics.vector.ImageVector) {
    Row(
        verticalAlignment = Alignment.CenterVertically,
        modifier = Modifier.padding(bottom = 12.dp)
    ) {
        Icon(icon, null, modifier = Modifier.size(20.dp), tint = Color(0xFF0B63D6))
        Spacer(modifier = Modifier.width(8.dp))
        Text(title, style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Black, color = Color(0xFF334155))
    }
    Divider(color = Color.Gray.copy(alpha = 0.1f), modifier = Modifier.padding(bottom = 12.dp))
}

@Composable
private fun DetailItem(label: String, value: String) {
    Column(modifier = Modifier.padding(vertical = 8.dp)) {
        Text(label, style = MaterialTheme.typography.labelMedium, color = Color.Gray)
        Text(value, style = MaterialTheme.typography.bodyLarge, fontWeight = FontWeight.Medium, color = Color(0xFF1E293B))
    }
}
