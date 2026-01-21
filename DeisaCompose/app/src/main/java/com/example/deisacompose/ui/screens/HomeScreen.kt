package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.HomeViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HomeScreen(
    navController: NavHostController,
    viewModel: HomeViewModel = viewModel()
) {
    val stats by viewModel.stats.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)

    val swipeRefreshState = com.google.accompanist.swiperefresh.rememberSwipeRefreshState(isRefreshing = isLoading)

    // Auto-refresh every 30 seconds
    LaunchedEffect(Unit) {
        while(true) {
            viewModel.fetchStats()
            kotlinx.coroutines.delay(30_000)
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = {
                    Column {
                        Text(
                            text = "Deisa Health",
                            style = MaterialTheme.typography.titleLarge,
                            fontWeight = FontWeight.Bold,
                            color = MaterialTheme.colorScheme.primary
                        )
                        Text(
                            text = "Admin Dashboard",
                            style = MaterialTheme.typography.bodySmall,
                            color = Slate500
                        )
                    }
                },
                actions = {
                    IconButton(onClick = { navController.navigate("profile") }) {
                        Surface(
                            shape = CircleShape,
                            color = MaterialTheme.colorScheme.primary.copy(alpha = 0.1f),
                            modifier = Modifier.size(40.dp)
                        ) {
                            Box(contentAlignment = Alignment.Center) {
                                Icon(
                                    Icons.Default.Person,
                                    contentDescription = "Profile",
                                    tint = MaterialTheme.colorScheme.primary
                                )
                            }
                        }
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(containerColor = Color.White)
            )
        },
        containerColor = Slate50
    ) { padding ->
        com.google.accompanist.swiperefresh.SwipeRefresh(
            state = swipeRefreshState,
            onRefresh = { viewModel.fetchStats() },
            modifier = Modifier.padding(padding)
        ) {
            Column(
                modifier = Modifier
                    .padding(16.dp)
                    .fillMaxSize()
            ) {
                // Stats Row
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    StatCard(
                        title = "Sedang Sakit",
                        value = if (isLoading && stats == null) "-" else (stats?.currentlySick?.toString() ?: "0"),
                        icon = Icons.Default.MedicalServices,
                        color = DangerRed,
                        modifier = Modifier.weight(1f)
                    )
                    StatCard(
                        title = "Obat",
                        value = if (isLoading && stats == null) "-" else (stats?.obatCount?.toString() ?: "0"),
                        icon = Icons.Default.Inventory,
                        color = SuccessGreen,
                        modifier = Modifier.weight(1f)
                    )
                    StatCard(
                        title = "Santri",
                        value = if (isLoading && stats == null) "-" else (stats?.santriCount?.toString() ?: "0"),
                        icon = Icons.Default.Groups,
                        color = DeisaBlue,
                        modifier = Modifier.weight(1f)
                    )
                }

                Spacer(modifier = Modifier.height(24.dp))

                Text(
                    text = "Main Menu",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    color = Slate900
                )

                Spacer(modifier = Modifier.height(16.dp))

                val menuItems = listOf(
                    MenuItem("Santri", "Master Data Santri", Icons.Default.Groups, "santri", DeisaBlue),
                    MenuItem("Sakit", "Data Santri Sakit", Icons.Default.Sick, "sakit", DangerRed),
                    MenuItem("Obat", "Inventory & Stok Obat", Icons.Default.Medication, "obat", SuccessGreen),
                    MenuItem("Laporan", "Statistik & Laporan", Icons.Default.Assessment, "laporan", WarningOrange),
                    MenuItem("Management", "Pengaturan App", Icons.Default.Settings, "management_list", Slate700),
                    MenuItem("Users", "User Management", Icons.Default.ManageAccounts, "admin_users", Color.DarkGray)
                )

                LazyVerticalGrid(
                    columns = GridCells.Fixed(2),
                    horizontalArrangement = Arrangement.spacedBy(16.dp),
                    verticalArrangement = Arrangement.spacedBy(16.dp),
                    modifier = Modifier.fillMaxSize()
                ) {
                    items(menuItems) { item ->
                        MenuCard(item) {
                            navController.navigate(item.route)
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun StatCard(
    title: String,
    value: String,
    icon: ImageVector,
    color: Color,
    modifier: Modifier = Modifier
) {
    Card(
        modifier = modifier,
        shape = RoundedCornerShape(16.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Column(
            modifier = Modifier.padding(12.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Icon(
                icon,
                contentDescription = null,
                tint = color,
                modifier = Modifier.size(24.dp)
            )
            Spacer(modifier = Modifier.height(8.dp))
            Text(text = value, fontWeight = FontWeight.Bold, fontSize = 20.sp, color = Slate900)
            Text(text = title, fontSize = 12.sp, color = Slate500)
        }
    }
}

@Composable
fun MenuCard(item: MenuItem, onClick: () -> Unit) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        shape = RoundedCornerShape(20.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 4.dp)
    ) {
        Column(
            modifier = Modifier.padding(16.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Surface(
                shape = RoundedCornerShape(12.dp),
                color = item.color.copy(alpha = 0.1f),
                modifier = Modifier.size(48.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(item.icon, contentDescription = null, tint = item.color)
                }
            }
            Spacer(modifier = Modifier.height(12.dp))
            Text(text = item.title, fontWeight = FontWeight.Bold, fontSize = 16.sp, color = Slate900)
            Text(text = item.subtitle, fontSize = 10.sp, color = Slate500)
        }
    }
}

data class MenuItem(
    val title: String,
    val subtitle: String,
    val icon: ImageVector,
    val route: String,
    val color: Color
)
