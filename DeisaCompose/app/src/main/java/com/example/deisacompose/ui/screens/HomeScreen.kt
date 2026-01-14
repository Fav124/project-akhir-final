package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.theme.PrimaryGreen
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.MainViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HomeScreen(navController: NavController, viewModel: MainViewModel = viewModel(), authViewModel: AuthViewModel = viewModel()) {
    
    val user by viewModel.user.observeAsState()
    
    LaunchedEffect(Unit) {
        viewModel.fetchProfile()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Dashboard Kesehatan Santri") },
                colors = TopAppBarDefaults.topAppBarColors(
                    containerColor = Color.White
                ),
                actions = {
                     // Logout Button
                     TextButton(onClick = {
                         authViewModel.logout()
                         navController.navigate("login") {
                             popUpTo("home") { inclusive = true }
                         }
                     }) {
                         Text("Keluar", color = Color.Red)
                     }
                }
            )
        }
    ) { paddingValues ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(paddingValues)
                .padding(16.dp)
        ) {
            Text("Selamat Datang, ${user?.name ?: "User"}", style = MaterialTheme.typography.titleMedium)
            Spacer(modifier = Modifier.height(16.dp))
            
            // Stats Row
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                StatsCard("12", "Sakit Hari Ini", Color(0xFFFEE2E2), Modifier.weight(1f))
                StatsCard("5", "Stok Menipis", Color(0xFFFEF3C7), Modifier.weight(1f))
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            Text("Manajemen Data", style = MaterialTheme.typography.titleMedium)
            
            Spacer(modifier = Modifier.height(16.dp))
            
            // Core Features (Everyone)
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                ActionCard("Data Sakit", "Lihat Catatan", Modifier.weight(1f), onClick = { navController.navigate("sakit") })
                ActionCard("Data Obat", "Kelola Stok", Modifier.weight(1f), onClick = { navController.navigate("obat") })
            }
             Spacer(modifier = Modifier.height(16.dp))
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                ActionCard("Data Santri", "Semua Santri", Modifier.weight(1f), onClick = { navController.navigate("santri") })
                ActionCard("Laporan", "Ringkasan", Modifier.weight(1f), onClick = { navController.navigate("laporan") })
            }
            
            // Admin Only Features
            if (user?.isAdmin == true || user?.role == "admin") {
                Spacer(modifier = Modifier.height(16.dp))
                Text("Area Administrator", style = MaterialTheme.typography.titleMedium)
                Spacer(modifier = Modifier.height(16.dp))
                
                Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                    ActionCard("Persetujuan", "Registrasi Akun", Modifier.weight(1f), onClick = { navController.navigate("admin_registrations") })
                    ActionCard("Petugas", "Kelola Akses", Modifier.weight(1f), onClick = { navController.navigate("admin_users") })
                }
                Spacer(modifier = Modifier.height(16.dp))
                Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                    ActionCard("Data Induk", "Master Data", Modifier.weight(1f), onClick = { navController.navigate("management_list") })
                    Spacer(modifier = Modifier.weight(1f))
                }
            }
        }
    }
}

@Composable
fun StatsCard(count: String, label: String, color: Color, modifier: Modifier = Modifier) {
    Card(
        modifier = modifier,
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Column(modifier = Modifier.padding(16.dp)) {
             Box(modifier = Modifier.size(32.dp).background(color, androidx.compose.foundation.shape.CircleShape))
             Spacer(modifier = Modifier.height(8.dp))
             Text(count, style = MaterialTheme.typography.titleLarge)
             Text(label, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
        }
    }
}

@Composable
fun ActionCard(title: String, subtitle: String, modifier: Modifier = Modifier, onClick: () -> Unit) {
    Card(
        modifier = modifier.height(100.dp),
         colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp),
        onClick = onClick
    ) {
         Column(
             modifier = Modifier.padding(16.dp).fillMaxSize(),
             verticalArrangement = Arrangement.Center
         ) {
             Text(title, style = MaterialTheme.typography.titleMedium)
             Text(subtitle, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
         }
    }
}
