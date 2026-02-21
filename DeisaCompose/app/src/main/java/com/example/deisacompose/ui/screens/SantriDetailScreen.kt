package com.example.deisacompose.ui.screens

import androidx.compose.foundation.BorderStroke
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
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.ui.theme.SuccessGreen
import com.example.deisacompose.ui.theme.WarningOrange
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

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
    val isAdmin by authViewModel.isAdmin.collectAsState()

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
        } else if (uiState is ResourceUiState.Error && (uiState as ResourceUiState.Error).message == "SESI_HABIS") {
            authViewModel.logout()
            navController.navigate("login") {
                popUpTo(0) { inclusive = true }
            }
        }
    }

    if (santri == null) {
        Box(modifier = Modifier.fillMaxSize().background(DeisaNavy), contentAlignment = Alignment.Center) {
            CircularProgressIndicator(color = DeisaBlue)
        }
        return
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Profil Santri",
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
            // Immersive Profile Header (v9 Style)
            Column(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(vertical = 32.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Box(
                    modifier = Modifier
                        .size(100.dp)
                        .clip(RoundedCornerShape(30.dp))
                        .background(DeisaSoftNavy)
                        .border(1.dp, Color.White.copy(alpha = 0.1f), RoundedCornerShape(30.dp)),
                    contentAlignment = Alignment.Center
                ) {
                    Text(
                        text = santri.nama_lengkap.take(1).uppercase(),
                        style = MaterialTheme.typography.displaySmall,
                        fontWeight = FontWeight.Bold,
                        color = DeisaBlue
                    )
                }
                
                Spacer(modifier = Modifier.height(16.dp))
                
                Text(
                    text = santri.nama_lengkap,
                    style = MaterialTheme.typography.headlineSmall,
                    fontWeight = FontWeight.ExtraBold,
                    color = Color.White
                )
                
                Text(
                    text = "NIS: ${santri.nis}",
                    style = MaterialTheme.typography.bodyMedium,
                    color = Color.Gray
                )

                Spacer(modifier = Modifier.height(24.dp))

                // Quick Stats Row
                Row(
                    modifier = Modifier
                        .fillMaxWidth()
                        .padding(horizontal = 24.dp),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    StatBadge(label = "KELAS", value = santri.kelas?.nama_kelas ?: "-", color = DeisaBlue, modifier = Modifier.weight(1f))
                    StatBadge(label = "STATUS", value = santri.status.uppercase(), color = SuccessGreen, modifier = Modifier.weight(1f))
                    StatBadge(label = "JENIS KELAMIN", value = if (santri.jenis_kelamin == "L") "LAKI-LAKI" else "PEREMPUAN", color = WarningOrange, modifier = Modifier.weight(1f))
                }
            }

            // Detailed Information
            Column(
                modifier = Modifier.padding(horizontal = 24.dp, vertical = 8.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                InfoSection(
                    title = "Informasi Pribadi",
                    icon = Icons.Default.Person,
                    items = listOf(
                        "Tempat Lahir" to santri.tempat_lahir,
                        "Tanggal Lahir" to santri.tanggal_lahir,
                        "Gol. Darah" to (santri.golonganDarah ?: "-"),
                        "Tahun Masuk" to (santri.tahun_masuk?.toString() ?: "-"),
                        "Alamat" to santri.alamat
                    )
                )

                InfoSection(
                    title = "Data Wali",
                    icon = Icons.Default.Groups,
                    items = listOf(
                        "Nama Wali" to santri.nama_wali,
                        "Nomor HP" to santri.no_hp_wali
                    )
                )

                InfoSection(
                    title = "Kondisi Kesehatan",
                    icon = Icons.Default.MedicalServices,
                    items = listOf(
                        "Riwayat Alergi" to (santri.riwayatAlergi ?: "Tidak ada"),
                        "Catatan Medis" to (santri.catatanMedis ?: "-")
                    )
                )

                if (isAdmin) {
                    Spacer(modifier = Modifier.height(16.dp))
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        Button(
                            onClick = { /* TODO */ },
                            modifier = Modifier.weight(1f).height(50.dp),
                            colors = ButtonDefaults.buttonColors(containerColor = DeisaSoftNavy),
                            shape = RoundedCornerShape(14.dp),
                            border = BorderStroke(1.dp, Color.White.copy(alpha = 0.05f))
                        ) {
                            Icon(Icons.Default.Edit, contentDescription = null, modifier = Modifier.size(18.dp))
                            Spacer(Modifier.width(8.dp))
                            Text("Edit Profil")
                        }
                        Button(
                            onClick = { showDeleteDialog = true },
                            modifier = Modifier.weight(1f).height(50.dp),
                            colors = ButtonDefaults.buttonColors(containerColor = DangerRed.copy(alpha = 0.1f)),
                            shape = RoundedCornerShape(14.dp),
                            border = BorderStroke(1.dp, DangerRed.copy(alpha = 0.2f))
                        ) {
                            Icon(Icons.Default.Delete, contentDescription = null, tint = DangerRed, modifier = Modifier.size(18.dp))
                            Spacer(Modifier.width(8.dp))
                            Text("Hapus", color = DangerRed)
                        }
                    }
                }
                
                Spacer(modifier = Modifier.height(32.dp))
            }
        }
    }

    if (showDeleteDialog) {
        AlertDialog(
            onDismissRequest = { showDeleteDialog = false },
            containerColor = DeisaSoftNavy,
            titleContentColor = Color.White,
            textContentColor = Color.Gray,
            title = { Text("Hapus Data Santri?", fontWeight = FontWeight.Bold) },
            text = { Text("Apakah Anda yakin ingin menghapus data santri ini? Tindakan ini tidak dapat dibatalkan.") },
            confirmButton = {
                TextButton(onClick = {
                    resourceViewModel.deleteSantri(santri.id)
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

@Composable
fun StatBadge(label: String, value: String, color: Color, modifier: Modifier = Modifier) {
    Column(
        modifier = modifier
            .clip(RoundedCornerShape(16.dp))
            .background(DeisaSoftNavy)
            .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(16.dp))
            .padding(12.dp),
        horizontalAlignment = Alignment.CenterHorizontally
    ) {
        Text(label, style = MaterialTheme.typography.labelSmall, color = Color.Gray, fontWeight = FontWeight.Bold, letterSpacing = 1.sp)
        Spacer(modifier = Modifier.height(4.dp))
        Text(value, style = MaterialTheme.typography.bodySmall, color = color, fontWeight = FontWeight.ExtraBold)
    }
}

@Composable
fun InfoSection(title: String, icon: androidx.compose.ui.graphics.vector.ImageVector, items: List<Pair<String, String>>) {
    Column(
        modifier = Modifier
            .fillMaxWidth()
            .clip(RoundedCornerShape(20.dp))
            .background(DeisaSoftNavy)
            .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(20.dp))
            .padding(20.dp)
    ) {
        Row(verticalAlignment = Alignment.CenterVertically) {
            Icon(icon, contentDescription = null, tint = DeisaBlue, modifier = Modifier.size(20.dp))
            Spacer(modifier = Modifier.width(12.dp))
            Text(title, style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold, color = Color.White)
        }
        
        Spacer(modifier = Modifier.height(16.dp))
        
        items.forEach { (label, value) ->
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(vertical = 8.dp),
                horizontalArrangement = Arrangement.SpaceBetween
            ) {
                Text(label, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                Text(value, style = MaterialTheme.typography.bodySmall, color = Color.White, fontWeight = FontWeight.Medium)
            }
            if (label != items.last().first) {
                Divider(color = Color.White.copy(alpha = 0.05f), thickness = 0.5.dp)
            }
        }
    }
}
