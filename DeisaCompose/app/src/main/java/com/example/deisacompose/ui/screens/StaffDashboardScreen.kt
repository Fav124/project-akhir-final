package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.animation.core.tween
import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import androidx.navigation.compose.currentBackStackEntryAsState
import com.example.deisacompose.data.network.ApiClient
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.StitchDrawerContent
import com.example.deisacompose.ui.components.StitchNavBar
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun StaffDashboardScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    val currentUser by authViewModel.currentUser.collectAsState()
    val resourceViewModel: ResourceViewModel = viewModel()
    val uiState by resourceViewModel.uiState.collectAsState()
    var visible by remember { mutableStateOf(false) }
    val navBackStackEntry by navController.currentBackStackEntryAsState()
    val currentRoute = navBackStackEntry?.destination?.route ?: ""

    // Get stored user name as fallback when currentUser is null (e.g., after app restart)
    val userName = currentUser?.name
        ?: ApiClient.getSessionManager().fetchUserName()
        ?: "Petugas"

    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        delay(100)
        visible = true
        // Optional: Pre-flight check or load some stats to trigger 401 if expired
        resourceViewModel.loadSantri() 
    }

    LaunchedEffect(uiState) {
        if (uiState is com.example.deisacompose.viewmodels.ResourceUiState.Error && (uiState as com.example.deisacompose.viewmodels.ResourceUiState.Error).message == "SESI_HABIS") {
            authViewModel.logout()
            navController.navigate("login") {
                popUpTo(0) { inclusive = true }
            }
        }
    }

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                drawerContainerColor = DeisaSoftNavy,
                drawerContentColor = Color.White
            ) {
                StitchDrawerContent(
                    userName = userName,
                    onLogout = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    },
                    navController = navController,
                    currentRoute = currentRoute
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Dashboard Petugas",
                    onMenuClick = {
                        scope.launch { drawerState.open() }
                    },
                    showMenu = true,
                    onNotificationClick = { navController.navigate("notifications") }
                )
            }
        ) { padding ->
            LazyColumn(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(padding),
                contentPadding = PaddingValues(24.dp),
                verticalArrangement = Arrangement.spacedBy(20.dp)
            ) {
                // Welcome Header
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn() + expandVertically()
                    ) {
                        Column(modifier = Modifier.fillMaxWidth()) {
                            Spacer(modifier = Modifier.height(8.dp))
                            Text(
                                text = "Selamat datang,",
                                style = MaterialTheme.typography.bodyLarge,
                                color = Color.Gray
                            )
                            Text(
                                text = userName,
                                style = MaterialTheme.typography.headlineMedium,
                                fontWeight = FontWeight.Black,
                                color = Color.White
                            )
                            Text(
                                text = "Petugas Kesehatan • Aktif",
                                style = MaterialTheme.typography.labelSmall,
                                color = SuccessGreen
                            )
                        }
                    }
                }

                // Quick Stats Row
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn(tween(300)) + slideInVertically(tween(300)) { it / 4 }
                    ) {
                        Row(
                            modifier = Modifier.fillMaxWidth(),
                            horizontalArrangement = Arrangement.spacedBy(12.dp)
                        ) {
                            QuickStatChip(
                                label = "Pasien",
                                value = "—",
                                icon = Icons.Default.HealthAndSafety,
                                color = DangerRed,
                                modifier = Modifier.weight(1f)
                            )
                            QuickStatChip(
                                label = "Stok Obat",
                                value = "—",
                                icon = Icons.Default.MedicalInformation,
                                color = SuccessGreen,
                                modifier = Modifier.weight(1f)
                            )
                            QuickStatChip(
                                label = "Santri",
                                value = "—",
                                icon = Icons.Default.Groups,
                                color = DeisaBlue,
                                modifier = Modifier.weight(1f)
                            )
                        }
                    }
                }

                // Section Header
                item {
                    Text(
                        "MENU AKSES",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.padding(start = 4.dp)
                    )
                }

                // Data Santri Card
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn(tween(400)) + slideInVertically(tween(400)) { it / 4 }
                    ) {
                        StaffMenuCard(
                            title = "Data Santri",
                            subtitle = "Lihat profil & informasi santri",
                            description = "Akses direktori lengkap santri Dar El-Ilmi.",
                            icon = Icons.Default.Groups,
                            accentColor = DeisaBlue,
                            badge = "Read-Only",
                            badgeColor = Color.Gray,
                            onClick = { navController.navigate("santri_list") }
                        )
                    }
                }

                // Data Kesehatan Card
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn(tween(500)) + slideInVertically(tween(500)) { it / 4 }
                    ) {
                        StaffMenuCard(
                            title = "Data Kesehatan",
                            subtitle = "Kelola santri sakit & rekam medis",
                            description = "Input dan pantau kondisi kesehatan santri secara real-time.",
                            icon = Icons.Default.HealthAndSafety,
                            accentColor = DangerRed,
                            badge = "Full Access",
                            badgeColor = DangerRed,
                            onClick = { navController.navigate("sakit_list") }
                        )
                    }
                }

                // Stok Obat Card
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn(tween(600)) + slideInVertically(tween(600)) { it / 4 }
                    ) {
                        StaffMenuCard(
                            title = "Stok Obat",
                            subtitle = "Pantau & kelola ketersediaan obat",
                            description = "Monitor inventaris obat dan input data baru.",
                            icon = Icons.Default.MedicalInformation,
                            accentColor = SuccessGreen,
                            badge = "Full Access",
                            badgeColor = SuccessGreen,
                            onClick = { navController.navigate("obat_list") }
                        )
                    }
                }

                // Admin-Only Notice
                item {
                    AnimatedVisibility(
                        visible = visible,
                        enter = fadeIn(tween(700))
                    ) {
                        Surface(
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(16.dp),
                            color = Color.White.copy(alpha = 0.03f),
                            border = BorderStroke(1.dp, WarningOrange.copy(alpha = 0.3f))
                        ) {
                            Row(
                                modifier = Modifier.padding(16.dp),
                                verticalAlignment = Alignment.CenterVertically
                            ) {
                                Icon(
                                    Icons.Default.Lock,
                                    null,
                                    tint = WarningOrange,
                                    modifier = Modifier.size(20.dp)
                                )
                                Spacer(modifier = Modifier.width(12.dp))
                                Column {
                                    Text(
                                        "Akses Admin Diperlukan",
                                        fontWeight = FontWeight.Bold,
                                        style = MaterialTheme.typography.bodySmall,
                                        color = WarningOrange
                                    )
                                    Text(
                                        "Manajemen pengguna dan laporan hanya tersedia untuk Admin.",
                                        style = MaterialTheme.typography.labelSmall,
                                        color = Color.Gray
                                    )
                                }
                            }
                        }
                    }
                }

                // Spacer + Logout
                item {
                    Spacer(modifier = Modifier.height(16.dp))
                    TextButton(
                        onClick = {
                            authViewModel.logout()
                            navController.navigate("login") {
                                popUpTo(0) { inclusive = true }
                            }
                        },
                        modifier = Modifier.fillMaxWidth()
                    ) {
                        Icon(Icons.Default.Logout, null, tint = Color.Gray, modifier = Modifier.size(18.dp))
                        Spacer(modifier = Modifier.width(8.dp))
                        Text("Keluar (Sign Out)", color = Color.Gray, fontWeight = FontWeight.Bold)
                    }
                    Spacer(modifier = Modifier.height(32.dp))
                }
            }
        }
    }
}

@Composable
private fun QuickStatChip(
    label: String,
    value: String,
    icon: ImageVector,
    color: Color,
    modifier: Modifier = Modifier
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = modifier,
        accentColor = color
    ) {
        Column(
            modifier = Modifier.fillMaxWidth(),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Icon(icon, null, tint = color, modifier = Modifier.size(22.dp))
            Spacer(modifier = Modifier.height(6.dp))
            Text(value, fontWeight = FontWeight.Black, color = Color.White, fontSize = 18.sp)
            Text(label, style = MaterialTheme.typography.labelSmall, color = Color.Gray)
        }
    }
}

@Composable
private fun StaffMenuCard(
    title: String,
    subtitle: String,
    description: String,
    icon: ImageVector,
    accentColor: Color,
    badge: String,
    badgeColor: Color,
    onClick: () -> Unit
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier
            .fillMaxWidth()
            .clickable(onClick = onClick),
        accentColor = accentColor
    ) {
        Row(
            verticalAlignment = Alignment.CenterVertically
        ) {
            // Accent Icon
            Box(
                modifier = Modifier
                    .size(56.dp)
                    .clip(RoundedCornerShape(16.dp))
                    .background(accentColor.copy(alpha = 0.1f)),
                contentAlignment = Alignment.Center
            ) {
                Icon(icon, null, tint = accentColor, modifier = Modifier.size(30.dp))
            }

            Spacer(modifier = Modifier.width(16.dp))

            Column(modifier = Modifier.weight(1f)) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(
                        title,
                        fontWeight = FontWeight.ExtraBold,
                        style = MaterialTheme.typography.bodyLarge,
                        color = Color.White
                    )
                    Spacer(modifier = Modifier.width(8.dp))
                    // Access Badge
                    Box(
                        modifier = Modifier
                            .clip(RoundedCornerShape(6.dp))
                            .background(badgeColor.copy(alpha = 0.12f))
                            .padding(horizontal = 6.dp, vertical = 2.dp)
                    ) {
                        Text(
                            badge,
                            style = MaterialTheme.typography.labelSmall,
                            color = badgeColor,
                            fontSize = 9.sp,
                            fontWeight = FontWeight.Black
                        )
                    }
                }
                Text(subtitle, style = MaterialTheme.typography.labelSmall, color = Color.Gray)
                Spacer(modifier = Modifier.height(6.dp))
                Text(description, style = MaterialTheme.typography.bodySmall, color = Color.White.copy(alpha = 0.5f))
            }

            Spacer(modifier = Modifier.width(8.dp))
            Icon(
                Icons.Default.ChevronRight,
                null,
                tint = Color.White.copy(alpha = 0.2f),
                modifier = Modifier.size(20.dp)
            )
        }
    }
}
