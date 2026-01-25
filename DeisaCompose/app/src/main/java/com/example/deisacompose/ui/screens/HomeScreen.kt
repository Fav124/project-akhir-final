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
    viewModel: HomeViewModel = viewModel()
) {
    val context = androidx.compose.ui.platform.LocalContext.current
    val stats by viewModel.stats.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)

    // Notification Logic (Simple Polling)
    LaunchedEffect(Unit) {
        // Notification Channel Logic should be here/MainActivity
        while(true) {
            viewModel.fetchStats()
            // Check threshold for sickness
            stats?.let {
                if (it.currentlySick > 3) {
                     // Trigger manual notification if permissions allow
                     // For now just Log or Snackbar logic could be here
                }
            }
            kotlinx.coroutines.delay(30_000)
        }
    }
    
    // Animation State
    var visible by remember { mutableStateOf(false) }
    LaunchedEffect(Unit) {
        visible = true
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(Color.White)
    ) {
        // Background Gradient Blob
        Box(
            modifier = Modifier
                .offset(x = (-100).dp, y = (-100).dp)
                .size(300.dp)
                .background(BlueStart.copy(alpha = 0.2f), CircleShape)
        )
         Box(
            modifier = Modifier
                .align(Alignment.BottomEnd)
                .offset(x = 100.dp, y = 100.dp)
                .size(300.dp)
                .background(PurpleStart.copy(alpha = 0.2f), CircleShape)
        )

        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(24.dp)
                .verticalScroll(rememberScrollState())
        ) {
            // Header
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Column {
                    Text(
                        text = "Hello, Admin",
                        style = MaterialTheme.typography.headlineMedium,
                        fontWeight = FontWeight.Bold,
                        color = Slate900
                    )
                    Text(
                        text = "Selamat Datang di Deisa Health",
                        style = MaterialTheme.typography.bodyMedium,
                        color = Slate500
                    )
                }
                
                Surface(
                    shape = CircleShape,
                    color = Slate100,
                    modifier = Modifier.size(50.dp).clickable { navController.navigate("profile") },
                    border = androidx.compose.foundation.BorderStroke(2.dp, Color.White),
                    shadowElevation = 4.dp
                ) {
                   Box(contentAlignment = Alignment.Center) {
                        if (isLoading) {
                            CircularProgressIndicator(modifier = Modifier.size(24.dp), strokeWidth = 2.dp)
                        } else {
                            Icon(Icons.Default.Person, contentDescription = null, tint = Slate500)
                        }
                   }
                }
            }
            
            Spacer(modifier = Modifier.height(32.dp))

            // Alerts Section
            if (stats != null && (stats!!.pendingApprovalCount > 0 || stats!!.currentlySick >= viewModel.sickThreshold)) {
                Text("Active Alerts", style = MaterialTheme.typography.titleMedium, color = DangerRed, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(12.dp))
                
                if (stats!!.pendingApprovalCount > 0) {
                    AlertCard(
                        title = "Persetujuan User",
                        desc = "${stats!!.pendingApprovalCount} user baru menunggu persetujuan",
                        icon = Icons.Default.PersonAdd,
                        color = PurpleStart,
                        onClick = { navController.navigate("admin_users") }
                    )
                    Spacer(modifier = Modifier.height(12.dp))
                }

                if (stats!!.currentlySick >= viewModel.sickThreshold) {
                    AlertCard(
                        title = "Outbreak Warning!",
                        desc = "${stats!!.currentlySick} santri sedang sakit hari ini",
                        icon = Icons.Default.Warning,
                        color = DangerRed,
                        onClick = { navController.navigate("sakit") }
                    )
                    Spacer(modifier = Modifier.height(24.dp))
                }
            }
            
            // Stats Section
            AnimatedVisibility(
                visible = visible,
                enter = fadeIn() + slideInVertically { it / 2 }
            ) {
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    GradientCard(
                        modifier = Modifier.weight(1f).height(140.dp),
                        colors = if (stats != null && stats!!.currentlySick >= viewModel.sickThreshold) 
                                    listOf(DangerRed, Color(0xFF991B1B)) 
                                 else listOf(DangerRed, OrangeEnd),
                        onClick = { navController.navigate("sakit") }
                    ) {
                        Icon(Icons.Default.LocalHospital, contentDescription = null, tint = Color.White, modifier = Modifier.size(32.dp))
                        Spacer(modifier = Modifier.weight(1f))
                        Text("Sedang Sakit", color = Color.White.copy(alpha = 0.8f), fontSize = 12.sp)
                        AnimatedNumber(
                            number = stats?.currentlySick ?: 0,
                            style = MaterialTheme.typography.displaySmall,
                            color = Color.White
                        )
                    }

                    GradientCard(
                        modifier = Modifier.weight(1f).height(140.dp),
                        colors = listOf(BlueStart, BlueEnd),
                        onClick = { navController.navigate("santri") }
                    ) {
                        Icon(Icons.Default.School, contentDescription = null, tint = Color.White, modifier = Modifier.size(32.dp))
                        Spacer(modifier = Modifier.weight(1f))
                        Text("Total Santri", color = Color.White.copy(alpha = 0.8f), fontSize = 12.sp)
                        AnimatedNumber(
                            number = stats?.santriCount ?: 0,
                            style = MaterialTheme.typography.displaySmall,
                            color = Color.White
                        )
                    }
                }
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            Text("Main Menu", style = MaterialTheme.typography.titleLarge, fontWeight = FontWeight.Bold)
            Spacer(modifier = Modifier.height(16.dp))

            // Menu Grid
             val menuItems = listOf(
                MenuItem("Obat", "Stok & Inventory", Icons.Default.Medication, "obat", SuccessGreen),
                MenuItem("Laporan", "Analisa Data", Icons.Default.Analytics, "laporan", WarningOrange),
                MenuItem("Manajemen", "Data Master", Icons.Default.Settings, "management_list", Slate700),
                MenuItem("Settings", "Threshold & App", Icons.Default.Tune, "settings", PurpleStart)
            )

            AnimatedVisibility(
                visible = visible,
                enter = fadeIn(animationSpec = tween(delayMillis = 300))
            ) {
                Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                    Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                        MenuCardPremium(menuItems[0], Modifier.weight(1f)) { navController.navigate(menuItems[0].route) }
                        MenuCardPremium(menuItems[1], Modifier.weight(1f)) { navController.navigate(menuItems[1].route) }
                    }
                    Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                        MenuCardPremium(menuItems[2], Modifier.weight(1f)) { navController.navigate(menuItems[2].route) }
                        MenuCardPremium(menuItems[3], Modifier.weight(1f)) { navController.navigate(menuItems[3].route) }
                    }
                }
            }
            
            Spacer(modifier = Modifier.height(30.dp))
        }

        if (isLoading && stats == null) {
            PulsingLoader()
        }
    }
}

@Composable
fun AlertCard(
    title: String,
    desc: String,
    icon: ImageVector,
    color: Color,
    onClick: () -> Unit
) {
    Surface(
        onClick = onClick,
        modifier = Modifier.fillMaxWidth(),
        shape = RoundedCornerShape(20.dp),
        color = color.copy(alpha = 0.1f),
        border = androidx.compose.foundation.BorderStroke(1.dp, color.copy(alpha = 0.2f))
    ) {
        Row(
            modifier = Modifier.padding(16.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Icon(icon, contentDescription = null, tint = color, modifier = Modifier.size(24.dp))
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(text = title, fontWeight = FontWeight.Bold, color = color, fontSize = 14.sp)
                Text(text = desc, color = color.copy(alpha = 0.8f), fontSize = 12.sp)
            }
            Icon(Icons.Default.ChevronRight, contentDescription = null, tint = color)
        }
    }
}

@Composable
fun MenuCardPremium(item: MenuItem, modifier: Modifier = Modifier, onClick: () -> Unit) {
    Surface(
        onClick = onClick,
        modifier = modifier.height(120.dp),
        shape = RoundedCornerShape(24.dp),
        color = Slate50,
        shadowElevation = 2.dp, // Subtle shadow, simpler look
        border = androidx.compose.foundation.BorderStroke(1.dp, Slate100)
    ) {
        Column(
            modifier = Modifier.padding(16.dp),
            verticalArrangement = Arrangement.Center,
            horizontalAlignment = Alignment.Start
        ) {
            Surface(
                shape = CircleShape,
                color = item.color.copy(alpha = 0.1f),
                modifier = Modifier.size(40.dp)
            ) {
                 Box(contentAlignment = Alignment.Center) {
                    Icon(item.icon, contentDescription = null, tint = item.color)
                 }
            }
            Spacer(modifier = Modifier.height(12.dp))
            Text(item.title, fontWeight = FontWeight.Bold, fontSize = 16.sp, color = Slate900)
            Text(item.subtitle, fontSize = 11.sp, color = Slate500, lineHeight = 12.sp)
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
