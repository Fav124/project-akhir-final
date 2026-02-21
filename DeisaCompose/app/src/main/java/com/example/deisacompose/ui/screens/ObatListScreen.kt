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
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Obat
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
import com.example.deisacompose.viewmodels.ResourceUiState
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatListScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val obatList by resourceViewModel.obatList.collectAsState()
    val isLoading by resourceViewModel.isLoading.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()

    var searchQuery by remember { mutableStateOf("") }
    var showLowStockOnly by remember { mutableStateOf(false) }

    val isAdmin by authViewModel.isAdmin.collectAsState()
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        resourceViewModel.loadObat()
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

    LaunchedEffect(searchQuery, showLowStockOnly) {
        delay(300)
        resourceViewModel.loadObat(
            search = searchQuery.ifBlank { null },
            lowStock = if (showLowStockOnly) true else null
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
                    currentRoute = "obat_list"
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Stok Obat",
                    onMenuClick = { scope.launch { drawerState.open() } },
                    showMenu = true
                )
            },
            floatingActionButton = {
                if (isAdmin) {
                    FloatingActionButton(
                        onClick = { navController.navigate("obat_add") },
                        containerColor = DeisaBlue,
                        contentColor = Color.White,
                    ) {
                        Icon(Icons.Default.Add, "Tambah Obat")
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
                        placeholder = { Text("Cari berdasarkan nama obat...", color = Color.Gray) },
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

                    // Low Stock Toggle
                    PremiumFilterChip(
                        selected = showLowStockOnly,
                        onClick = { showLowStockOnly = !showLowStockOnly },
                        label = "Hanya Stok Sedikit",
                        activeColor = DangerRed
                    )
                }

                // Content
                if (isLoading && obatList.isEmpty()) {
                    Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                        CircularProgressIndicator(color = DeisaBlue)
                    }
                } else if (obatList.isEmpty()) {
                    EmptyObatState()
                } else {
                    LazyColumn(
                        contentPadding = PaddingValues(start = 24.dp, end = 24.dp, bottom = 80.dp),
                        verticalArrangement = Arrangement.spacedBy(16.dp)
                    ) {
                        items(obatList) { obat ->
                            ObatRow(
                                obat = obat,
                                onClick = { navController.navigate("obat_detail/${obat.id}") }
                            )
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun ObatRow(obat: Obat, onClick: () -> Unit) {
    val isLowStock = obat.is_low_stock
    val statusColor = if (isLowStock) DangerRed else SuccessGreen

    PremiumCard(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        accentColor = if (isLowStock) DangerRed else DeisaBlue
    ) {
        Column {
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Column(modifier = Modifier.weight(1f)) {
                    Text(
                        text = obat.nama_obat,
                        color = Color.White,
                        style = MaterialTheme.typography.titleMedium,
                        fontWeight = FontWeight.Bold
                    )
                    Text(
                        text = "Kategori: ${obat.kategori ?: "-"}",
                        color = Color.Gray,
                        style = MaterialTheme.typography.labelSmall
                    )
                }

                if (isLowStock) {
                    Box(
                        modifier = Modifier
                            .clip(RoundedCornerShape(8.dp))
                            .background(DangerRed.copy(alpha = 0.1f))
                            .padding(horizontal = 8.dp, vertical = 4.dp)
                    ) {
                        Text(
                            text = "STOK SEDIKIT",
                            color = DangerRed,
                            style = MaterialTheme.typography.labelSmall,
                            fontWeight = FontWeight.Black
                        )
                    }
                }
            }

            Spacer(modifier = Modifier.height(16.dp))
            Divider(color = Color.White.copy(alpha = 0.05f))
            Spacer(modifier = Modifier.height(16.dp))

            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.Bottom
            ) {
                Column {
                    Text(
                        text = "LEVEL STOK",
                        style = MaterialTheme.typography.labelSmall,
                        color = Color.Gray,
                        fontWeight = FontWeight.Bold,
                        letterSpacing = 1.sp
                    )
                    Text(
                        text = "${obat.stok} ${obat.satuan}",
                        style = MaterialTheme.typography.headlineSmall,
                        fontWeight = FontWeight.ExtraBold,
                        color = statusColor
                    )
                }

                Box(
                    modifier = Modifier
                        .size(40.dp)
                        .clip(RoundedCornerShape(12.dp))
                        .background(DeisaNavy)
                        .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(12.dp)),
                    contentAlignment = Alignment.Center
                ) {
                    Icon(
                        Icons.Default.ChevronRight,
                        contentDescription = null,
                        tint = Color.Gray,
                        modifier = Modifier.size(20.dp)
                    )
                }
            }
        }
    }
}

@Composable
fun EmptyObatState() {
    Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            Icon(
                Icons.Default.Inventory2,
                contentDescription = null,
                modifier = Modifier.size(64.dp),
                tint = Color.Gray.copy(alpha = 0.2f)
            )
            Spacer(modifier = Modifier.height(16.dp))
            Text("Data obat tidak ditemukan", color = Color.Gray)
        }
    }
}
