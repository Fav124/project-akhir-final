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
import androidx.compose.animation.*
import androidx.compose.animation.core.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.runtime.*
import com.example.deisacompose.ui.components.*
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.HomeViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HomeScreen(
    navController: NavHostController,
    viewModel: HomeViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    val stats by viewModel.stats.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)
    val user by mainViewModel.user.observeAsState()
    val isAdmin = user?.isAdmin ?: false
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    LaunchedEffect(Unit) {
        mainViewModel.fetchProfile()
        while(true) {
            viewModel.fetchStats()
            kotlinx.coroutines.delay(30_000)
        }
    }
    
    DeisaComposeTheme(primaryColor = primaryColor) {
        Scaffold(
            bottomBar = {
                // BottomNavigation would typically be in NavHost, but keeping single screen focused here
            },
            floatingActionButton = {
                FloatingActionButton(
                    onClick = { /* Action */ },
                    containerColor = MaterialTheme.colorScheme.primary,
                    contentColor = Color.White,
                    shape = RoundedCornerShape(20.dp)
                ) {
                    Icon(Icons.Default.Add, contentDescription = "Add")
                }
            }
        ) { padding ->
            Box(
                modifier = Modifier
                    .fillMaxSize()
                    .background(Slate50)
                    .padding(padding)
            ) {
                Column(
                    modifier = Modifier
                        .fillMaxSize()
                        .verticalScroll(rememberScrollState())
                        .padding(20.dp)
                ) {
                    // Modern Header
                    Row(
                        modifier = Modifier.fillMaxWidth().padding(vertical = 12.dp),
                        horizontalArrangement = Arrangement.SpaceBetween,
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Column {
                            Text(
                                text = "Eco Dashboard",
                                style = MaterialTheme.typography.headlineLarge,
                                fontWeight = FontWeight.Black,
                                color = Slate950,
                                letterSpacing = (-1).sp
                            )
                            Text(
                                text = "Morning, ${user?.name?.split(" ")?.firstOrNull() ?: "Petugas"}",
                                style = MaterialTheme.typography.labelLarge,
                                color = Slate500,
                                fontWeight = FontWeight.Bold,
                                letterSpacing = 2.sp
                            )
                        }
                        Surface(
                            onClick = { navController.navigate("profile") },
                            shape = RoundedCornerShape(16.dp),
                            color = Color.White,
                            shadowElevation = 2.dp,
                            modifier = Modifier.size(50.dp)
                        ) {
                            Box(contentAlignment = Alignment.Center) {
                                Icon(Icons.Default.Person, contentDescription = null, tint = Slate400)
                            }
                        }
                    }

                    Spacer(modifier = Modifier.height(24.dp))

                    // Hero Stat Widget (Mirroring React Mobile Hero)
                    ElevatedCard(
                        modifier = Modifier.fillMaxWidth().height(180.dp),
                        shape = RoundedCornerShape(32.dp),
                        colors = CardDefaults.elevatedCardColors(containerColor = MaterialTheme.colorScheme.primary)
                    ) {
                        Box(modifier = Modifier.fillMaxSize()) {
                            // Abstract Circle Overlay
                            Box(modifier = Modifier.align(Alignment.TopEnd).offset(x = 20.dp, y = (-20).dp).size(120.dp).background(Color.White.copy(alpha = 0.1f), CircleShape))
                            
                            Column(modifier = Modifier.padding(28.dp).fillMaxSize(), verticalArrangement = Arrangement.SpaceBetween) {
                                Row(verticalAlignment = Alignment.CenterVertically, horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                                     Icon(Icons.Default.CheckCircle, contentDescription = null, tint = Color.White.copy(alpha = 0.6f), modifier = Modifier.size(16.dp))
                                     Text("PATIENT RECOVERY INDEX", color = Color.White.copy(alpha = 0.6f), style = MaterialTheme.typography.labelSmall, fontWeight = FontWeight.Black, letterSpacing = 1.sp)
                                }
                                Text("92.4%", color = Color.White, style = MaterialTheme.typography.displayMedium, fontWeight = FontWeight.Black)
                                Text("12 Cases • 8 Recoveries Today", color = Color.White.copy(alpha = 0.8f), style = MaterialTheme.typography.bodySmall, fontWeight = FontWeight.Bold)
                            }
                        }
                    }

                    Spacer(modifier = Modifier.height(32.dp))

                    // Immersive Mode Shortcut
                    Text("Immersive Experience", color = Slate900, fontWeight = FontWeight.Black, style = MaterialTheme.typography.titleMedium)
                    Spacer(modifier = Modifier.height(16.dp))
                    
                    Surface(
                        onClick = { navController.navigate("focus_mode") },
                        color = Slate950,
                        shape = RoundedCornerShape(24.dp),
                        modifier = Modifier.fillMaxWidth()
                    ) {
                        Row(modifier = Modifier.padding(20.dp), verticalAlignment = Alignment.CenterVertically) {
                            Surface(color = MaterialTheme.colorScheme.primary.copy(alpha = 0.2f), shape = CircleShape, modifier = Modifier.size(44.dp)) {
                                Box(contentAlignment = Alignment.Center) {
                                    Icon(Icons.Default.FlashOn, contentDescription = null, tint = MaterialTheme.colorScheme.primary)
                                }
                            }
                            Spacer(modifier = Modifier.width(16.dp))
                            Column(modifier = Modifier.weight(1f)) {
                                Text("Focus Mode", color = Color.White, fontWeight = FontWeight.Bold)
                                Text("Zero Latency Entry Mode", color = Slate500, fontSize = 11.sp)
                            }
                            Icon(Icons.Default.ChevronRight, contentDescription = null, tint = Slate700)
                        }
                    }

                    Spacer(modifier = Modifier.height(32.dp))

                    // Adaptive Actions
                    Text("Operations", color = Slate900, fontWeight = FontWeight.Black, style = MaterialTheme.typography.titleMedium)
                    Spacer(modifier = Modifier.height(16.dp))
                    
                    val menuItems = if (isAdmin) {
                        listOf(
                            MenuItem("Stok Obat", "Inventory Control", Icons.Default.Medication, "obat", SuccessGreen),
                            MenuItem("Laporan", "Analisis Data", Icons.Default.Analytics, "laporan", WarningOrange),
                            MenuItem("Data Master", "Global Config", Icons.Default.Settings, "management_list", Slate700),
                            MenuItem("System", "App Settings", Icons.Default.Tune, "settings", PurpleStart)
                        )
                    } else {
                        listOf(
                            MenuItem("Input Sakit", "New Patient Record", Icons.Default.AddBox, "sakit_form", DangerRed),
                            MenuItem("Riwayat", "Daily Summary", Icons.Default.History, "history", BlueStart),
                            MenuItem("Inventory", "Check Medicine", Icons.Default.Inventory, "obat", SuccessGreen),
                            MenuItem("Laporan", "Analysis View", Icons.Default.Assessment, "laporan", WarningOrange)
                        )
                    }

                    Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                        Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                            MenuCard(menuItems[0], navController, Modifier.weight(1f))
                            MenuCard(menuItems[1], navController, Modifier.weight(1f))
                        }
                        Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                            MenuCard(menuItems[2], navController, Modifier.weight(1f))
                            MenuCard(menuItems[3], navController, Modifier.weight(1f))
                        }
                    }
                    
                    Spacer(modifier = Modifier.height(40.dp))
                }
            }
        }
    }
}

@Composable
fun MenuCard(item: MenuItem, navController: NavHostController, modifier: Modifier = Modifier) {
    ElevatedCard(
        onClick = { navController.navigate(item.route) },
        modifier = modifier.height(130.dp),
        shape = RoundedCornerShape(28.dp),
        colors = CardDefaults.elevatedCardColors(containerColor = Color.White)
    ) {
        Column(modifier = Modifier.padding(20.dp), verticalArrangement = Arrangement.Center) {
            Surface(color = item.color.copy(alpha = 0.1f), shape = RoundedCornerShape(12.dp), modifier = Modifier.size(36.dp)) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(item.icon, contentDescription = null, tint = item.color, modifier = Modifier.size(20.dp))
                }
            }
            Spacer(modifier = Modifier.height(16.dp))
            Text(item.title, fontWeight = FontWeight.ExtraBold, color = Slate900, fontSize = 14.sp)
            Text(item.subtitle, color = Slate400, fontSize = 10.sp, fontWeight = FontWeight.Bold)
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
