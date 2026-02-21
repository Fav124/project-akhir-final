package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
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
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.SuccessGreen
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.sp
import androidx.compose.foundation.BorderStroke
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.ui.theme.WarningOrange
import com.example.deisacompose.ui.components.StitchTopBar

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
    val isAdmin by authViewModel.isAdmin.collectAsState()

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
            else navController.navigateUp()
            resourceViewModel.resetState()
        } else if (uiState is ResourceUiState.Error && (uiState as ResourceUiState.Error).message == "SESI_HABIS") {
            authViewModel.logout()
            navController.navigate("login") {
                popUpTo(0) { inclusive = true }
            }
        }
    }

    if (sakit == null) {
        Box(modifier = Modifier.fillMaxSize().background(DeisaNavy), contentAlignment = Alignment.Center) {
            CircularProgressIndicator(color = DeisaBlue)
        }
        return
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Rekam Medis",
                onMenuClick = { navController.navigateUp() },
                showMenu = true,
                navigationIcon = Icons.Default.ArrowBack
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
        ) {
            // Immersive Medical Header
            Column(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(vertical = 32.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                val statusColor = if (sakit.status == "Sakit") DangerRed else SuccessGreen
                
                Box(
                    modifier = Modifier
                        .size(100.dp)
                        .clip(RoundedCornerShape(30.dp))
                        .background(DeisaSoftNavy)
                        .border(1.dp, Color.White.copy(alpha = 0.1f), RoundedCornerShape(30.dp)),
                    contentAlignment = Alignment.Center
                ) {
                    Icon(
                        Icons.Default.LocalHospital,
                        contentDescription = null,
                        modifier = Modifier.size(48.dp),
                        tint = statusColor
                    )
                }
                
                Spacer(modifier = Modifier.height(16.dp))
                
                Text(
                    text = sakit.diagnosis_utama,
                    style = MaterialTheme.typography.headlineSmall,
                    fontWeight = FontWeight.ExtraBold,
                    color = Color.White
                )
                
                Text(
                    text = sakit.santri.nama_lengkap,
                    style = MaterialTheme.typography.bodyLarge,
                    color = Color.Gray
                )

                Spacer(modifier = Modifier.height(24.dp))

                // Quick Status Badge
                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(12.dp))
                        .background(statusColor.copy(alpha = 0.1f))
                        .padding(horizontal = 16.dp, vertical = 8.dp)
                ) {
                    Text(
                        text = sakit.status.uppercase(),
                        color = statusColor,
                        style = MaterialTheme.typography.labelMedium,
                        fontWeight = FontWeight.Black,
                        letterSpacing = 1.sp
                    )
                }
            }

            // Detailed Content
            Column(
                modifier = Modifier.padding(horizontal = 24.dp, vertical = 8.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                // Patient Info Card
                InfoSection(
                    title = "Detail Pasien",
                    icon = Icons.Default.Person,
                    items = listOf(
                        "Nama Santri" to sakit.santri.nama_lengkap,
                        "Kelas" to (sakit.santri.kelas?.nama_kelas ?: "-")
                    )
                )

                // Clinical Info Card
                InfoSection(
                    title = "Catatan Klinis",
                    icon = Icons.Default.HistoryEdu,
                    items = listOf(
                        "Diagnosis Utama" to sakit.diagnosis_utama,
                        "Gejala" to (sakit.gejala ?: "-"),
                        "Tanggal Lapor" to (sakit.tanggal_masuk_human ?: "-")
                    )
                )

                InfoSection(
                    title = "Penanganan & Rujukan",
                    icon = Icons.Default.MedicalInformation,
                    items = listOf(
                        "Tindakan" to (sakit.tindakan ?: "-"),
                        "Fasilitas" to (sakit.jenisPerawatan ?: "UKS"),
                        "Tujuan Rujukan" to (sakit.tujuanRujukan ?: "-")
                    )
                )

                InfoSection(
                    title = "Catatan Tambahan",
                    icon = Icons.Default.Note,
                    items = listOf(
                        "Catatan" to (sakit.catatan ?: "Tidak ada catatan tambahan.")
                    )
                )

                // Edit/Action Section
                if (isAdmin || currentUser?.role == "petugas") {
                    Spacer(modifier = Modifier.height(8.dp))
                    
                    if (isEditing) {
                        Column(
                            modifier = Modifier
                                .fillMaxWidth()
                                .clip(RoundedCornerShape(20.dp))
                                .background(DeisaSoftNavy)
                                .padding(20.dp)
                        ) {
                            Text(
                                "PERBARUI STATUS",
                                style = MaterialTheme.typography.labelSmall,
                                fontWeight = FontWeight.Bold,
                                color = Color.Gray
                            )
                            Spacer(modifier = Modifier.height(16.dp))
                            Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                                listOf("Sakit" to "Masih Sakit", "Sembuh" to "Sembuh").forEach { (code, label) ->
                                    Box(
                                        modifier = Modifier
                                            .weight(1f)
                                            .height(50.dp)
                                            .clip(RoundedCornerShape(14.dp))
                                            .background(if (editStatus == code) (if (code == "Sakit") WarningOrange else SuccessGreen).copy(alpha = 0.1f) else DeisaNavy)
                                            .border(1.dp, if (editStatus == code) (if (code == "Sakit") WarningOrange else SuccessGreen) else Color.White.copy(alpha = 0.05f), RoundedCornerShape(14.dp))
                                            .clickable { editStatus = code },
                                        contentAlignment = Alignment.Center
                                    ) {
                                        Text(label, color = if (editStatus == code) (if (code == "Sakit") WarningOrange else SuccessGreen) else Color.White, fontWeight = FontWeight.Bold)
                                    }
                                }
                            }
                            Spacer(modifier = Modifier.height(20.dp))
                            com.example.deisacompose.ui.components.PremiumGradientButton(
                                text = "Simpan",
                                onClick = { resourceViewModel.updateSakit(sakit.id, mapOf("status" to editStatus)) },
                                isLoading = uiState is ResourceUiState.Loading
                            )
                            TextButton(
                                onClick = { isEditing = false },
                                modifier = Modifier.fillMaxWidth()
                            ) {
                                Text("Batal", color = Color.Gray)
                            }
                        }
                    } else {
                        Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                            Button(
                                onClick = { isEditing = true },
                                modifier = Modifier.weight(1f).height(50.dp),
                                colors = ButtonDefaults.buttonColors(containerColor = DeisaSoftNavy),
                                shape = RoundedCornerShape(14.dp),
                                border = BorderStroke(1.dp, Color.White.copy(alpha = 0.05f))
                            ) {
                                Icon(
                                    imageVector = Icons.Default.Edit,
                                    contentDescription = null,
                                    modifier = Modifier.size(18.dp)
                                )
                                Spacer(Modifier.width(8.dp))
                                Text("Perbarui Status")
                            }
                            if (isAdmin) {
                                Button(
                                    onClick = { showDeleteDialog = true },
                                    modifier = Modifier.weight(0.4f).height(50.dp),
                                    colors = ButtonDefaults.buttonColors(containerColor = DangerRed.copy(alpha = 0.1f)),
                                    shape = RoundedCornerShape(14.dp),
                                    border = BorderStroke(1.dp, DangerRed.copy(alpha = 0.2f))
                                ) {
                                    Icon(
                                        imageVector = Icons.Default.Delete,
                                        contentDescription = null,
                                        tint = DangerRed,
                                        modifier = Modifier.size(18.dp)
                                    )
                                }
                            }
                        }
                    }
                }
                
                Spacer(modifier = Modifier.height(40.dp))
            }
        }
    }

    if (showDeleteDialog) {
        AlertDialog(
            onDismissRequest = { showDeleteDialog = false },
            containerColor = DeisaSoftNavy,
            titleContentColor = Color.White,
            textContentColor = Color.Gray,
            title = { Text("Hapus Rekam Medis Ini?", fontWeight = FontWeight.Bold) },
            text = { Text("Apakah Anda yakin ingin menghapus rekam medis ini? Tindakan ini tidak dapat dibatalkan.") },
            confirmButton = {
                TextButton(onClick = {
                    resourceViewModel.deleteSakit(sakit.id)
                    showDeleteDialog = false
                }) {
                    Text("Hapus", color = DangerRed, fontWeight = FontWeight.Bold)
                }
            },
            dismissButton = {
                TextButton(onClick = { showDeleteDialog = false }) {
                    Text("Batal", color = Color.Gray)
                }
            }
        )
    }
}
