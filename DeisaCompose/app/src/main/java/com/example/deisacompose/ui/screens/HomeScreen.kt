package com.example.deisacompose.ui.screens

import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.layout.* 
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import androidx.navigation.compose.currentBackStackEntryAsState
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.PremiumCard
import com.example.deisacompose.ui.components.StitchDrawerContent
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HomeScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()
    val currentUser by authViewModel.currentUser.collectAsState()
    val navBackStackEntry by navController.currentBackStackEntryAsState()
    val currentRoute = navBackStackEntry?.destination?.route ?: ""

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
                    currentRoute = currentRoute
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Santri Health",
                    onMenuClick = {
                        scope.launch { drawerState.open() }
                    },
                    showMenu = true
                )
            }
        ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Spacer(modifier = Modifier.height(32.dp))
            
            // Hero Section
            Box(
                modifier = Modifier
                    .size(80.dp)
                    .clip(RoundedCornerShape(24.dp))
                    .background(Color.White.copy(alpha = 0.05f))
                    .border(1.dp, Color.White.copy(alpha = 0.1f), RoundedCornerShape(24.dp)),
                contentAlignment = Alignment.Center
            ) {
                DeisaLogo(size = LogoSize.MD)
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            Text(
                "Selamat Datang",
                style = MaterialTheme.typography.displaySmall,
                fontWeight = FontWeight.Black,
                color = Color.White
            )
            Text(
                "Ekosistem Manajemen Kesehatan",
                style = MaterialTheme.typography.bodyLarge,
                color = Color.Gray,
                textAlign = androidx.compose.ui.text.style.TextAlign.Center
            )

            Spacer(modifier = Modifier.height(48.dp))

            // Featured Action Card
            PremiumCard(
                modifier = Modifier.fillMaxWidth(),
                accentColor = DeisaBlue,
                onClick = { navController.navigate("admin_dashboard") }
            ) {
                Column(modifier = Modifier.padding(8.dp)) {
                    Text(
                        "Ringkasan Kerja",
                        style = MaterialTheme.typography.titleLarge,
                        fontWeight = FontWeight.ExtraBold,
                        color = Color.White
                    )
                    Text(
                        "Akses metrik komprehensif dan kontrol sistem.",
                        style = MaterialTheme.typography.bodySmall,
                        color = Color.Gray,
                        modifier = Modifier.padding(top = 4.dp)
                    )
                }
            }

            Spacer(modifier = Modifier.height(24.dp))

            // Navigation Grid or List
            Column(
                modifier = Modifier.fillMaxWidth(),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                HomeMenuOption(
                    title = "Catatan Klinis",
                    subtitle = "Pemantauan kesehatan santri",
                    icon = Icons.Default.HealthAndSafety,
                    color = DangerRed,
                    onClick = { navController.navigate("sakit_list") }
                )
                HomeMenuOption(
                    title = "Inventaris Obat",
                    subtitle = "Kontrol stok obat-obatan",
                    icon = Icons.Default.MedicalInformation,
                    color = SuccessGreen,
                    onClick = { navController.navigate("obat_list") }
                )
                HomeMenuOption(
                    title = "Direktori Santri",
                    subtitle = "Demografi & profil santri",
                    icon = Icons.Default.Groups,
                    color = DeisaBlue,
                    onClick = { navController.navigate("santri_list") }
                )
            }
            
            Spacer(modifier = Modifier.height(48.dp))

            // Logout Action
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
                Text("Keluar dengan Aman", color = Color.Gray, fontWeight = FontWeight.Bold)
            }
        }
    }
    }
}

@Composable
fun HomeMenuOption(
    title: String,
    subtitle: String,
    icon: androidx.compose.ui.graphics.vector.ImageVector,
    color: Color,
    onClick: () -> Unit
) {
    PremiumCard(
        modifier = Modifier.fillMaxWidth(),
        accentColor = color,
        onClick = onClick
    ) {
        Row(
            verticalAlignment = Alignment.CenterVertically
        ) {
            Box(
                modifier = Modifier
                    .size(48.dp)
                    .clip(RoundedCornerShape(14.dp))
                    .background(color.copy(alpha = 0.1f)),
                contentAlignment = Alignment.Center
            ) {
                Icon(icon, null, tint = color, modifier = Modifier.size(24.dp))
            }
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(title, fontWeight = FontWeight.Bold, style = MaterialTheme.typography.bodyLarge, color = Color.White)
                Text(subtitle, style = MaterialTheme.typography.labelSmall, color = Color.Gray)
            }
            Icon(Icons.Default.ChevronRight, null, tint = Color.White.copy(alpha = 0.2f))
        }
    }
}
