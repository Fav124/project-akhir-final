package com.example.deisacompose.ui.screens

import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.border
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
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.PremiumGradientButton
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@Composable
fun ObatDetailScreen(
    navController: NavController,
    obatId: Int,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val obatList by resourceViewModel.obatList.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()

    val obat = obatList.find { it.id == obatId }
    val isAdmin by authViewModel.isAdmin.collectAsState()

    var showRestockDialog by remember { mutableStateOf(false) }
    var restockAmount by remember { mutableStateOf("") }
    var showDeleteDialog by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        if (obat == null) resourceViewModel.loadObat()
    }

    LaunchedEffect(uiState) {
        if (uiState is ResourceUiState.Success) {
            delay(1000)
            if (showRestockDialog) showRestockDialog = false
            else navController.navigateUp()
            resourceViewModel.resetState()
        } else if (uiState is ResourceUiState.Error && (uiState as ResourceUiState.Error).message == "SESI_HABIS") {
            authViewModel.logout()
            navController.navigate("login") {
                popUpTo(0) { inclusive = true }
            }
        }
    }

    if (obat == null) {
        Box(
            modifier = Modifier.fillMaxSize().background(DeisaNavy),
            contentAlignment = Alignment.Center
        ) {
            CircularProgressIndicator(color = DeisaBlue)
        }
        return
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Detail Obat",
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

            val statusColor = if (obat.is_low_stock) DangerRed else SuccessGreen

            Column(
                modifier = Modifier.fillMaxWidth().padding(vertical = 32.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {

                Box(
                    modifier = Modifier
                        .size(100.dp)
                        .clip(RoundedCornerShape(30.dp))
                        .background(DeisaSoftNavy)
                        .border(1.dp, Color.White.copy(.1f), RoundedCornerShape(30.dp)),
                    contentAlignment = Alignment.Center
                ) {
                    Icon(
                        Icons.Default.Medication,
                        null,
                        modifier = Modifier.size(48.dp),
                        tint = statusColor
                    )
                }

                Spacer(Modifier.height(16.dp))

                Text(
                    obat.nama_obat,
                    style = MaterialTheme.typography.headlineSmall,
                    fontWeight = FontWeight.ExtraBold,
                    color = Color.White
                )

                Text(
                    "Kategori: ${obat.kategori ?: "-"}",
                    style = MaterialTheme.typography.bodyLarge,
                    color = Color.Gray
                )

                Spacer(Modifier.height(24.dp))

                Row(
                    horizontalArrangement = Arrangement.spacedBy(12.dp),
                    verticalAlignment = Alignment.CenterVertically
                ) {

                    Column(horizontalAlignment = Alignment.CenterHorizontally) {
                        Text(
                            "${obat.stok} ${obat.satuan}",
                            style = MaterialTheme.typography.titleLarge,
                            fontWeight = FontWeight.Black,
                            color = statusColor
                        )

                        Text(
                            "STOK TERSEDIA",
                            style = MaterialTheme.typography.labelSmall,
                            color = Color.Gray,
                            fontWeight = FontWeight.Bold,
                            letterSpacing = 1.sp
                        )
                    }

                    if (obat.is_low_stock) {
                        Divider(
                            Modifier.height(30.dp).width(1.dp),
                            color = Color.White.copy(.1f)
                        )

                        Box(
                            Modifier.clip(RoundedCornerShape(8.dp))
                                .background(DangerRed.copy(.1f))
                                .padding(horizontal = 8.dp, vertical = 4.dp)
                        ) {
                            Text(
                                "KRITIS",
                                color = DangerRed,
                                style = MaterialTheme.typography.labelSmall,
                                fontWeight = FontWeight.Black
                            )
                        }
                    }
                }
            }

            Column(
                modifier = Modifier.padding(horizontal = 24.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {

                DetailSectionCard(
                    "Spesifikasi",
                    Icons.Default.Settings,
                    listOf(
                        "Kategori" to (obat.kategori ?: "-"),
                        "Satuan" to obat.satuan,
                        "Kode" to (obat.kodeObat ?: "MED-${obat.id.toString().padStart(4,'0')}"),
                        "Stok Min." to (obat.stokMinimum?.toString() ?: "10"),
                        "Lokasi" to (obat.lokasiPenyimpanan ?: "-")
                    )
                )

                DetailSectionCard(
                    "Informasi Tambahan",
                    Icons.Default.Info,
                    listOf(
                        "Exp. Date" to (obat.tglKadaluarsa ?: "-")
                    )
                )

                DetailSectionCard(
                    "Catatan",
                    Icons.Default.Description,
                    listOf(
                        "Deskripsi" to (obat.deskripsi ?: "Tidak ada catatan tambahan.")
                    )
                )

                if (isAdmin) {

                    Spacer(Modifier.height(8.dp))

                    Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {

                        PremiumGradientButton(
                            text = "Tambah Stok",
                            onClick = { showRestockDialog = true },
                            modifier = Modifier.weight(1f).height(50.dp)
                        )

                        Button(
                            onClick = { showDeleteDialog = true },
                            modifier = Modifier.weight(.4f).height(50.dp),
                            colors = ButtonDefaults.buttonColors(DangerRed.copy(.1f)),
                            shape = RoundedCornerShape(14.dp),
                            border = BorderStroke(1.dp, DangerRed.copy(.2f))
                        ) {
                            Icon(Icons.Default.Delete,null,tint=DangerRed)
                        }
                    }
                }

                Spacer(Modifier.height(40.dp))
            }
        }
    }
}

@Composable
private fun DetailSectionCard(
    title: String,
    icon: ImageVector,
    items: List<Pair<String, String>>
) {
    Column {

        Row(
            verticalAlignment = Alignment.CenterVertically,
            modifier = Modifier.padding(bottom = 12.dp)
        ) {
            Icon(icon,null,Modifier.size(16.dp),tint=Color.Gray)
            Spacer(Modifier.width(8.dp))

            Text(
                title,
                style = MaterialTheme.typography.labelLarge,
                fontWeight = FontWeight.Bold,
                color = Color.White
            )
        }

        Card(
            modifier = Modifier.fillMaxWidth(),
            shape = RoundedCornerShape(16.dp),
            colors = CardDefaults.cardColors(containerColor = DeisaSoftNavy),
            border = BorderStroke(1.dp, Color.White.copy(.05f))
        ) {
            Column(Modifier.padding(16.dp)) {

                items.forEachIndexed { index, pair ->

                    Row(Modifier.padding(vertical = 8.dp)) {

                        Text(
                            pair.first,
                            style = MaterialTheme.typography.bodyMedium,
                            color = Color.Gray,
                            modifier = Modifier.weight(1f)
                        )

                        Text(
                            pair.second,
                            style = MaterialTheme.typography.bodyMedium,
                            color = Color.White,
                            fontWeight = FontWeight.SemiBold
                        )
                    }

                    if (index < items.lastIndex)
                        Divider(color = Color.White.copy(.05f))
                }
            }
        }
    }
}