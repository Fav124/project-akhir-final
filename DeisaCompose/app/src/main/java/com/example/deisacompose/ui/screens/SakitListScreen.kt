package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel
import com.example.deisacompose.ui.components.PremiumFilterChip
import com.example.deisacompose.ui.components.PremiumCard
import com.example.deisacompose.ui.components.StitchDrawerContent
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.ui.theme.SuccessGreen
import com.example.deisacompose.ui.theme.WarningOrange
import com.example.deisacompose.viewmodels.ResourceUiState
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitListScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val sakitList by resourceViewModel.sakitList.collectAsState()
    val isLoading by resourceViewModel.isLoading.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()

    var searchQuery by remember { mutableStateOf("") }
    var statusFilter by remember { mutableStateOf<String?>(null) }

    val isAdmin by authViewModel.isAdmin.collectAsState()
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        resourceViewModel.loadSakit()
    }

    // Handle session timeout globally from ResourceViewModel
    LaunchedEffect(uiState) {
        if (uiState is ResourceUiState.Error && (uiState as ResourceUiState.Error).message == "SESI_HABIS") {
            authViewModel.logout()
            navController.navigate("login") {
                popUpTo(0) { inclusive = true }
            }
        }
    }

    LaunchedEffect(searchQuery, statusFilter) {
        delay(300)
        resourceViewModel.loadSakit(
            status = statusFilter,
            search = searchQuery.ifBlank { null }
        )
    }

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                drawerContainerColor = DeisaSoftNavy,
                drawerContentColor = Color.White
            ) {
                StitchDrawerContent(
                    userName = currentUser?.name ?: "User",
                    onLogout = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    },
                    navController = navController,
                    currentRoute = "sakit_list"
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Catatan Kesehatan",
                    onMenuClick = { scope.launch { drawerState.open() } },
                    showMenu = true
                )
            },
            floatingActionButton = {
                if (isAdmin) {
                    FloatingActionButton(
                        onClick = { navController.navigate("sakit_add") },
                        containerColor = DeisaBlue,
                        contentColor = Color.White
                    ) {
                        Icon(Icons.Default.Add, "Tambah Data")
                    }
                }
            }
        ) { padding ->
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(padding)
            ) {
                // Search Area (v7 Style)
                Column(modifier = Modifier.padding(horizontal = 24.dp, vertical = 16.dp)) {
                    OutlinedTextField(
                        value = searchQuery,
                        onValueChange = { searchQuery = it },
                        modifier = Modifier.fillMaxWidth(),
                        placeholder = { Text("Cari berdasarkan nama santri...", color = Color.Gray) },
                        leadingIcon = { Icon(Icons.Default.Search, null, tint = Color.Gray) },
                        trailingIcon = {
                            if (searchQuery.isNotEmpty()) {
                                IconButton(onClick = { searchQuery = "" }) {
                                    Icon(Icons.Default.Close, null, tint = Color.Gray)
                                }
                            }
                        },
                        shape = RoundedCornerShape(14.dp),
                        singleLine = true,
                        colors = OutlinedTextFieldDefaults.colors(
                            focusedContainerColor = DeisaSoftNavy,
                            unfocusedContainerColor = DeisaSoftNavy,
                            focusedBorderColor = DeisaBlue,
                            unfocusedBorderColor = Color.White.copy(alpha = 0.05f),
                            focusedTextColor = Color.White,
                            unfocusedTextColor = Color.White
                        )
                    )

                    Spacer(modifier = Modifier.height(16.dp))

                    // Horizontal Filter Chips
                    androidx.compose.foundation.lazy.LazyRow(
                        horizontalArrangement = Arrangement.spacedBy(8.dp),
                        contentPadding = PaddingValues(bottom = 8.dp)
                    ) {
                        item {
                            PremiumFilterChip(
                                selected = statusFilter == null,
                                onClick = { statusFilter = null },
                                label = "Semua"
                            )
                        }
                        item {
                            PremiumFilterChip(
                                selected = statusFilter == "Sakit",
                                onClick = { statusFilter = "Sakit" },
                                label = "Sakit",
                                activeColor = DangerRed
                            )
                        }
                        item {
                            PremiumFilterChip(
                                selected = statusFilter == "Sembuh",
                                onClick = { statusFilter = "Sembuh" },
                                label = "Sembuh",
                                activeColor = SuccessGreen
                            )
                        }
                    }
                }

                // Content
                if (isLoading && sakitList.isEmpty()) {
                    Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                        CircularProgressIndicator(color = DeisaBlue)
                    }
                } else if (sakitList.isEmpty()) {
                    EmptyHealthState()
                } else {
                    LazyColumn(
                        contentPadding = PaddingValues(start = 24.dp, end = 24.dp, bottom = 80.dp),
                        verticalArrangement = Arrangement.spacedBy(16.dp)
                    ) {
                        items(sakitList) { sakit ->
                            SakitRow(
                                sakit = sakit,
                                onClick = { navController.navigate("sakit_detail/${sakit.id}") }
                            )
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SakitRow(sakit: Sakit, onClick: () -> Unit) {
    val statusColor = if (sakit.status == "Sakit") DangerRed else SuccessGreen

    PremiumCard(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        accentColor = if (sakit.status == "Sakit") WarningOrange else SuccessGreen
    ) {
        Column {
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Column(modifier = Modifier.weight(1f)) {
                    Text(
                        text = sakit.santri.nama_lengkap,
                        color = Color.White,
                        style = MaterialTheme.typography.titleMedium,
                        fontWeight = FontWeight.Bold
                    )
                    Text(
                        text = "Kelas: ${sakit.santri.kelas?.nama_kelas ?: "-"}",
                        color = Color.Gray,
                        style = MaterialTheme.typography.labelSmall
                    )
                }

                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(8.dp))
                        .background(statusColor.copy(alpha = 0.1f))
                        .padding(horizontal = 8.dp, vertical = 4.dp)
                ) {
                    Text(
                        text = sakit.status.uppercase(),
                        color = statusColor,
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.ExtraBold
                    )
                }
            }

            Spacer(modifier = Modifier.height(16.dp))
            Divider(color = Color.White.copy(alpha = 0.05f))
            Spacer(modifier = Modifier.height(16.dp))

            Row(verticalAlignment = Alignment.CenterVertically) {
                Icon(
                    Icons.Default.LocalHospital,
                    contentDescription = null,
                    tint = DeisaBlue,
                    modifier = Modifier.size(16.dp)
                )
                Spacer(modifier = Modifier.width(8.dp))
                Text(
                    text = sakit.diagnosis_utama,
                    color = Color.White,
                    style = MaterialTheme.typography.bodyMedium,
                    fontWeight = FontWeight.Medium
                )
            }

            if (!sakit.gejala.isNullOrBlank()) {
                Text(
                    text = sakit.gejala,
                    color = Color.Gray,
                    style = MaterialTheme.typography.bodySmall,
                    modifier = Modifier.padding(start = 24.dp, top = 4.dp),
                    maxLines = 1,
                    overflow = androidx.compose.ui.text.style.TextOverflow.Ellipsis
                )
            }

            Spacer(modifier = Modifier.height(16.dp))

            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Icon(
                        Icons.Default.Event,
                        contentDescription = null,
                        tint = Color.Gray,
                        modifier = Modifier.size(14.dp)
                    )
                    Spacer(modifier = Modifier.width(4.dp))
                    Text(
                        text = sakit.tanggal_masuk_human ?: "-",
                        color = Color.Gray,
                        style = MaterialTheme.typography.labelSmall
                    )
                }

                Icon(
                    Icons.Default.ChevronRight,
                    contentDescription = null,
                    tint = Color.Gray.copy(alpha = 0.3f),
                    modifier = Modifier.size(20.dp)
                )
            }
        }
    }
}

@Composable
fun EmptyHealthState() {
    Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            Icon(
                Icons.Default.HealthAndSafety,
                contentDescription = null,
                modifier = Modifier.size(64.dp),
                tint = Color.Gray.copy(alpha = 0.2f)
            )
            Spacer(modifier = Modifier.height(16.dp))
            Text("Data kesehatan tidak ditemukan", color = Color.Gray)
        }
    }
}
