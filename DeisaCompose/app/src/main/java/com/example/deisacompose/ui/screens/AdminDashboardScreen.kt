package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
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
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.DashboardData
import com.example.deisacompose.ui.components.* 
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AdminViewModel
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.DashboardState
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun AdminDashboardScreen(
    navController: NavController,
    adminViewModel: AdminViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val dashboardState by adminViewModel.dashboardState.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        adminViewModel.loadDashboard()
    }

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                drawerContainerColor = DeisaSoftNavy,
                drawerContentColor = Color.White
            ) {
                StitchDrawerContent(
                    userName = currentUser?.name ?: "Admin",
                    onLogout = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    },
                    navController = navController,
                    currentRoute = "admin_dashboard"
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Health Dashboard",
                    onMenuClick = {
                        scope.launch { drawerState.open() }
                    },
                    onNotificationClick = { navController.navigate("notifications") }
                )
            }
        ) { padding ->
            when (val state = dashboardState) {
                is DashboardState.Loading -> {
                    Box(
                        modifier = Modifier
                            .fillMaxSize()
                            .padding(padding),
                        contentAlignment = Alignment.Center
                    ) {
                        CircularProgressIndicator(color = DeisaBlue, strokeWidth = 3.dp)
                    }
                }
                is DashboardState.Success -> {
                    DashboardContent(
                        data = state.data,
                        userName = currentUser?.name ?: "Admin",
                        navController = navController,
                        modifier = Modifier.padding(padding)
                    )
                }
                is DashboardState.Error -> {
                    if (state.message == "SESI_HABIS") {
                        LaunchedEffect(Unit) {
                            authViewModel.logout()
                            navController.navigate("login") {
                                popUpTo(0) { inclusive = true }
                            }
                        }
                    } else {
                        ErrorState(state.message) { adminViewModel.loadDashboard() }
                    }
                }
            }
        }
    }
}

@Composable
fun DashboardContent(
    data: DashboardData,
    userName: String,
    navController: NavController,
    modifier: Modifier = Modifier
) {
    LazyColumn(
        modifier = modifier
            .fillMaxSize(),
        contentPadding = PaddingValues(24.dp),
        verticalArrangement = Arrangement.spacedBy(24.dp)
    ) {
        // Welcome Header
        item {
            Column {
                Text(
                    "Selamat datang kembali,",
                    style = MaterialTheme.typography.labelMedium,
                    color = Color.Gray,
                    fontWeight = FontWeight.Medium
                )
                Text(
                    userName,
                    style = MaterialTheme.typography.headlineMedium,
                    fontWeight = FontWeight.Bold,
                    color = Color.White
                )
            }
        }

        // 2x2 Grid Stats
        item {
            Column(verticalArrangement = Arrangement.spacedBy(12.dp)) {
                Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                    GridStatCard(
                        title = "Santri Sakit",
                        value = data.stats.totalSakit.toString(),
                        change = if (data.stats.totalSakit > 10) "Tinggi" else "Normal",
                        icon = Icons.Default.Sick,
                        color = DangerRed,
                        modifier = Modifier.weight(1f)
                    )
                    GridStatCard(
                        title = "Obat Terpakai",
                        value = data.stats.totalObat.toString(),
                        change = "Stok: ${data.stats.totalObat}",
                        icon = Icons.Default.Medication,
                        color = SuccessGreen,
                        modifier = Modifier.weight(1f)
                    )
                }
                Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                    GridStatCard(
                        title = "Total Santri",
                        value = data.stats.totalSantri.toString(),
                        change = "Aktif",
                        icon = Icons.Default.Groups,
                        color = DeisaBlue,
                        modifier = Modifier.weight(1f)
                    )
                    GridStatCard(
                        title = "Hampir Habis",
                        value = data.stats.obatHampirHabis.toString(),
                        change = if (data.stats.obatHampirHabis > 0) "Warning" else "Aman",
                        icon = Icons.Default.Warning,
                        color = if (data.stats.obatHampirHabis > 0) WarningOrange else DeisaPurple,
                        modifier = Modifier.weight(1f)
                    )
                }
            }
        }

        // Activity Overview Chart Placeholder
        item {
            PremiumCard(backgroundColor = DeisaSoftNavy, accentColor = DeisaBlue) {
                Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.SpaceBetween,
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Text(
                            "Tren Kesehatan Mingguan",
                            style = MaterialTheme.typography.titleSmall,
                            fontWeight = FontWeight.Bold,
                            color = Color.White
                        )
                        Text(
                            "7 Hari Terakhir",
                            style = MaterialTheme.typography.labelSmall,
                            color = DeisaBlue,
                            fontWeight = FontWeight.Bold
                        )
                    }
                    
                    // Improved Bar Chart Visualization with Real Data
                    if (data.chartData.isEmpty()) {
                        Box(
                            modifier = Modifier.fillMaxWidth().height(140.dp),
                            contentAlignment = Alignment.Center
                        ) {
                            Text("Belum ada data tren", color = Color.Gray, style = MaterialTheme.typography.bodySmall)
                        }
                    } else {
                        Row(
                            modifier = Modifier
                                .fillMaxWidth()
                                .height(140.dp)
                                .padding(top = 16.dp),
                            horizontalArrangement = Arrangement.SpaceBetween,
                            verticalAlignment = Alignment.Bottom
                        ) {
                            val maxCount = data.chartData.maxOf { it.count }.coerceAtLeast(1)
                            
                            data.chartData.forEach { point ->
                                val heightFactor = point.count.toFloat() / maxCount
                                Column(
                                    horizontalAlignment = Alignment.CenterHorizontally,
                                    verticalArrangement = Arrangement.spacedBy(8.dp)
                                ) {
                                    Box(
                                        modifier = Modifier
                                            .width(16.dp)
                                            .fillMaxHeight(heightFactor.coerceAtLeast(0.05f))
                                            .background(
                                                brush = Brush.verticalGradient(
                                                    colors = listOf(
                                                        if (heightFactor > 0.7f) DangerRed else DeisaBlue,
                                                        if (heightFactor > 0.7f) DangerRed.copy(alpha = 0.3f) else DeisaBlue.copy(alpha = 0.3f)
                                                    )
                                                ),
                                                shape = RoundedCornerShape(topStart = 8.dp, topEnd = 8.dp)
                                            )
                                    )
                                    Text(
                                        text = point.label,
                                        style = MaterialTheme.typography.labelSmall,
                                        color = Color.White,
                                        fontSize = 9.sp
                                    )
                                }
                            }
                        }
                    }
                }
            }
        }

        // Recent Cases
        item {
            Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.SpaceBetween,
                    verticalAlignment = Alignment.CenterVertically
                ) {
                    Text(
                        "KASUS TERBARU",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Bold,
                        color = Color.Gray,
                        letterSpacing = 2.sp
                    )
                    Text(
                        "Lihat Semua",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Bold,
                        color = DeisaBlue,
                        modifier = Modifier.clickable { navController.navigate("history") }
                    )
                }
                
                if (data.recentActivities.isEmpty()) {
                    PremiumCard(backgroundColor = DeisaSoftNavy, accentColor = DeisaBlue) {
                        Text(
                            "Belum ada aktivitas terbaru",
                            style = MaterialTheme.typography.bodySmall,
                            color = Color.Gray,
                            modifier = Modifier.fillMaxWidth().padding(16.dp),
                            textAlign = androidx.compose.ui.text.style.TextAlign.Center
                        )
                    }
                } else {
                    data.recentActivities.take(5).forEach { activity ->
                        RecentCaseRow(activity)
                    }
                }
            }
        }
    }
}

@Composable
fun GridStatCard(
    title: String,
    value: String,
    change: String,
    icon: ImageVector,
    color: Color,
    modifier: Modifier = Modifier
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = modifier,
        backgroundColor = DeisaSoftNavy,
        accentColor = color
    ) {
        Column {
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Icon(icon, null, tint = color, modifier = Modifier.size(24.dp))
                Box(
                    modifier = Modifier
                        .background(color.copy(alpha = 0.1f), RoundedCornerShape(4.dp))
                        .padding(horizontal = 6.dp, vertical = 2.dp)
                ) {
                    Text(
                        change,
                        fontSize = 10.sp,
                        fontWeight = FontWeight.Bold,
                        color = color
                    )
                }
            }
            Spacer(modifier = Modifier.height(12.dp))
            Text(
                title,
                fontSize = 11.sp,
                fontWeight = FontWeight.Medium,
                color = Color.Gray,
                letterSpacing = 0.5.sp
            )
            Text(
                value,
                fontSize = 24.sp,
                fontWeight = FontWeight.Bold,
                color = Color.White
            )
        }
    }
}

@Composable
fun RecentCaseRow(activity: com.example.deisacompose.data.models.ActivityItem) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.fillMaxWidth(),
        backgroundColor = DeisaSoftNavy,
        accentColor = if (activity.description.contains("Critical", true)) DangerRed else DeisaBlue
    ) {
        Row(
            modifier = Modifier.fillMaxWidth(),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Box(
                modifier = Modifier
                    .size(40.dp)
                    .background(Color.White.copy(alpha = 0.05f), RoundedCornerShape(10.dp)),
                contentAlignment = Alignment.Center
            ) {
                Icon(Icons.Default.Person, null, tint = Color.Gray, modifier = Modifier.size(20.dp))
            }
            Spacer(modifier = Modifier.width(12.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(
                    activity.userName,
                    style = MaterialTheme.typography.bodySmall,
                    fontWeight = FontWeight.Bold,
                    color = Color.White
                )
                Text(
                    activity.description,
                    style = MaterialTheme.typography.labelSmall,
                    color = Color.Gray
                )
            }
            Column(horizontalAlignment = Alignment.End) {
                Text(
                    "10:30", // Placeholder time
                    style = MaterialTheme.typography.labelSmall,
                    color = Color.Gray
                )
                Spacer(modifier = Modifier.height(4.dp))
                Box(
                    modifier = Modifier
                        .background(DangerRed.copy(alpha = 0.1f), RoundedCornerShape(4.dp))
                        .padding(horizontal = 8.dp, vertical = 2.dp)
                ) {
                    Text(
                        "HIGH",
                        fontSize = 9.sp,
                        fontWeight = FontWeight.Bold,
                        color = DangerRed
                    )
                }
            }
        }
    }
}

// StitchDrawerContent and DrawerItem removed, moved to common Drawer.kt

@Composable
fun ErrorState(message: String, onRetry: () -> Unit) {
    Box(
        modifier = Modifier.fillMaxSize(),
        contentAlignment = Alignment.Center
    ) {
        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
            modifier = Modifier.padding(32.dp)
        ) {
            Icon(
                Icons.Default.ErrorOutline,
                contentDescription = null,
                modifier = Modifier.size(80.dp),
                tint = DangerRed.copy(alpha = 0.5f)
            )
            Spacer(modifier = Modifier.height(24.dp))
            Text(
                "Oops! Terjadi Kesalahan",
                style = MaterialTheme.typography.titleLarge,
                fontWeight = FontWeight.Bold,
                color = Color.White
            )
            Text(
                message,
                style = MaterialTheme.typography.bodyMedium,
                color = Color.Gray,
                textAlign = androidx.compose.ui.text.style.TextAlign.Center,
                modifier = Modifier.padding(top = 8.dp)
            )
            Spacer(modifier = Modifier.height(32.dp))
            PremiumGradientButton(
                text = "Coba Lagi",
                onClick = onRetry
            )
        }
    }
}
