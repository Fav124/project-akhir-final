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
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.DashboardData
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.PremiumGradientButton
import com.example.deisacompose.viewmodels.AdminViewModel
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.DashboardState

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun AdminDashboardScreen(
    navController: NavController,
    adminViewModel: AdminViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val dashboardState by adminViewModel.dashboardState.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()

    LaunchedEffect(Unit) {
        adminViewModel.loadDashboard()
    }

    Scaffold(
        topBar = {
            CenterAlignedTopAppBar(
                title = {
                    Row(verticalAlignment = Alignment.CenterVertically) {
                        DeisaLogo(size = LogoSize.SM)
                        Spacer(modifier = Modifier.width(12.dp))
                        Text(
                            "Deisa Admin",
                            fontWeight = FontWeight.ExtraBold,
                            fontSize = 20.sp,
                            letterSpacing = (-0.5).sp
                        )
                    }
                },
                actions = {
                    IconButton(onClick = { navController.navigate("notifications") }) {
                        Icon(Icons.Default.Notifications, "Notifikasi")
                    }
                    IconButton(onClick = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    }) {
                        Icon(Icons.Default.Logout, "Keluar", tint = MaterialTheme.colorScheme.error)
                    }
                },
                colors = TopAppBarDefaults.centerAlignedTopAppBarColors(
                    containerColor = MaterialTheme.colorScheme.background
                )
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
                    CircularProgressIndicator(strokeWidth = 3.dp)
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
                Box(
                    modifier = Modifier
                        .fillMaxSize()
                        .padding(padding),
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
                            tint = MaterialTheme.colorScheme.error.copy(alpha = 0.5f)
                        )
                        Spacer(modifier = Modifier.height(24.dp))
                        Text(
                            "Oops! Terjadi Kesalahan",
                            style = MaterialTheme.typography.titleLarge,
                            fontWeight = FontWeight.Bold
                        )
                        Text(
                            state.message,
                            style = MaterialTheme.typography.bodyMedium,
                            color = MaterialTheme.colorScheme.onSurfaceVariant,
                            textAlign = androidx.compose.ui.text.style.TextAlign.Center,
                            modifier = Modifier.padding(top = 8.dp)
                        )
                        Spacer(modifier = Modifier.height(32.dp))
                        PremiumGradientButton(
                            text = "Coba Lagi",
                            onClick = { adminViewModel.loadDashboard() }
                        )
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
            .fillMaxSize()
            .background(MaterialTheme.colorScheme.background),
        contentPadding = PaddingValues(bottom = 32.dp),
        verticalArrangement = Arrangement.spacedBy(24.dp)
    ) {
        // Hero Header
        item {
            Box(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(horizontal = 16.dp, vertical = 8.dp)
            ) {
                Column {
                    Text(
                        "Halo, $userName!",
                        style = MaterialTheme.typography.headlineMedium,
                        fontWeight = FontWeight.ExtraBold,
                        color = MaterialTheme.colorScheme.onBackground
                    )
                    Text(
                        "Berikut adalah ringkasan hari ini.",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant
                    )
                }
            }
        }

        // Stats Selection (Horizontal)
        item {
            androidx.compose.foundation.lazy.LazyRow(
                contentPadding = PaddingValues(horizontal = 16.dp),
                horizontalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                item {
                    StatCardLarge(
                        title = "Total Santri",
                        value = data.stats.totalSantri.toString(),
                        icon = Icons.Default.People,
                        color = Color(0xFF0B63D6)
                    )
                }
                item {
                    StatCardLarge(
                        title = "Sedang Sakit",
                        value = data.stats.totalSakit.toString(),
                        icon = Icons.Default.LocalHospital,
                        color = Color(0xFFDC2626)
                    )
                }
                item {
                    StatCardLarge(
                        title = "Stok Obat",
                        value = data.stats.totalObat.toString(),
                        icon = Icons.Default.Medication,
                        color = Color(0xFF10B981)
                    )
                }
            }
        }

        // Action Menu Grid
        item {
            Column(modifier = Modifier.padding(horizontal = 16.dp)) {
                Text(
                    "Manajemen Utama",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    modifier = Modifier.padding(bottom = 16.dp, start = 4.dp)
                )
                
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    ActionMenuCard(
                        title = "Santri",
                        subtitle = "Kelola data",
                        icon = Icons.Default.Groups,
                        color = Color(0xFF6366F1),
                        onClick = { navController.navigate("santri_list") },
                        modifier = Modifier.weight(1f)
                    )
                    ActionMenuCard(
                        title = "Kesehatan",
                        subtitle = "Catat sakit",
                        icon = Icons.Default.HealthAndSafety,
                        color = Color(0xFFF43F5E),
                        onClick = { navController.navigate("sakit_list") },
                        modifier = Modifier.weight(1f)
                    )
                }
                Spacer(modifier = Modifier.height(16.dp))
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    ActionMenuCard(
                        title = "Apotek",
                        subtitle = "Stok obat",
                        icon = Icons.Default.MedicalInformation,
                        color = Color(0xFF10B981),
                        onClick = { navController.navigate("obat_list") },
                        modifier = Modifier.weight(1f)
                    )
                    ActionMenuCard(
                        title = "Log",
                        subtitle = "Aktivitas",
                        icon = Icons.Default.HistoryEdu,
                        color = Color(0xFF64748B),
                        onClick = { navController.navigate("activities") },
                        modifier = Modifier.weight(1f)
                    )
                }
            }
        }

        // Recent Activity Section
        if (data.recentActivities.isNotEmpty()) {
            item {
                Column(modifier = Modifier.padding(horizontal = 16.dp)) {
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.SpaceBetween,
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Text(
                            "Aktivitas Terkini",
                            style = MaterialTheme.typography.titleMedium,
                            fontWeight = FontWeight.Bold
                        )
                        TextButton(onClick = { navController.navigate("activities") }) {
                            Text("Lihat Semua")
                        }
                    }
                    
                    data.recentActivities.take(5).forEach { activity ->
                        ActivityRow(activity)
                        Spacer(modifier = Modifier.height(12.dp))
                    }
                }
            }
        }
    }
}

@Composable
fun StatCardLarge(
    title: String,
    value: String,
    icon: ImageVector,
    color: Color
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.width(160.dp),
        backgroundColor = MaterialTheme.colorScheme.surface,
        accentColor = color
    ) {
        Column {
            Box(
                modifier = Modifier
                    .size(48.dp)
                    .clip(RoundedCornerShape(12.dp))
                    .background(color.copy(alpha = 0.1f)),
                contentAlignment = Alignment.Center
            ) {
                Icon(icon, null, tint = color, modifier = Modifier.size(28.dp))
            }
            Spacer(modifier = Modifier.height(20.dp))
            Text(
                value,
                style = MaterialTheme.typography.headlineLarge,
                fontWeight = FontWeight.ExtraBold,
                letterSpacing = (-1).sp
            )
            Text(
                title,
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                fontWeight = FontWeight.Medium
            )
        }
    }
}

@Composable
fun ActionMenuCard(
    title: String,
    subtitle: String,
    icon: ImageVector,
    color: Color,
    onClick: () -> Unit,
    modifier: Modifier = Modifier
) {
    Surface(
        onClick = onClick,
        modifier = modifier.height(110.dp),
        shape = RoundedCornerShape(20.dp),
        color = MaterialTheme.colorScheme.surface,
        tonalElevation = 2.dp,
        shadowElevation = 4.dp
    ) {
        Column(
            modifier = Modifier.padding(16.dp),
            verticalArrangement = Arrangement.Center
        ) {
            Icon(icon, null, tint = color, modifier = Modifier.size(28.dp))
            Spacer(modifier = Modifier.height(12.dp))
            Text(title, fontWeight = FontWeight.Bold, fontSize = 16.sp)
            Text(subtitle, style = MaterialTheme.typography.bodySmall, color = MaterialTheme.colorScheme.onSurfaceVariant)
        }
    }
}

@Composable
fun ActivityRow(activity: com.example.deisacompose.data.models.ActivityItem) {
    Row(
        modifier = Modifier
            .fillMaxWidth()
            .clip(RoundedCornerShape(16.dp))
            .background(MaterialTheme.colorScheme.surfaceVariant.copy(alpha = 0.3f))
            .padding(16.dp),
        verticalAlignment = Alignment.CenterVertically
    ) {
        Box(
            modifier = Modifier
                .size(40.dp)
                .clip(CircleShape)
                .background(MaterialTheme.colorScheme.primary.copy(alpha = 0.1f)),
            contentAlignment = Alignment.Center
        ) {
            Text(
                activity.userName.take(1).uppercase(),
                fontWeight = FontWeight.Bold,
                color = MaterialTheme.colorScheme.primary
            )
        }
        Spacer(modifier = Modifier.width(16.dp))
        Column(modifier = Modifier.weight(1f)) {
            Text(activity.description, style = MaterialTheme.typography.bodyMedium, fontWeight = FontWeight.Medium)
            Text(
                "${activity.userName} • ${activity.createdAt}",
                style = MaterialTheme.typography.bodySmall,
                color = MaterialTheme.colorScheme.onSurfaceVariant
            )
        }
    }
}
