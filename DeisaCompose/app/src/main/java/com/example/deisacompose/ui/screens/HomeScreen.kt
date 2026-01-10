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
import com.example.deisacompose.viewmodels.MainViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HomeScreen(navController: NavController, viewModel: MainViewModel = viewModel()) {
    
    val user by viewModel.currentUser.observeAsState()
    
    LaunchedEffect(Unit) {
        viewModel.fetchUser()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Santri Health Dashboard") },
                colors = TopAppBarDefaults.topAppBarColors(
                    containerColor = Color.White
                ),
                actions = {
                     // Logout Button
                     TextButton(onClick = {
                         viewModel.logout()
                         navController.navigate("login") {
                             popUpTo("home") { inclusive = true }
                         }
                     }) {
                         Text("Logout", color = Color.Red)
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
                StatsCard("12", "Sick Today", Color(0xFFFEE2E2), Modifier.weight(1f))
                StatsCard("5", "Low Stock", Color(0xFFFEF3C7), Modifier.weight(1f))
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            Text("Management", style = MaterialTheme.typography.titleMedium)
            
            Spacer(modifier = Modifier.height(16.dp))
            
            // Core Features (Everyone)
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                ActionCard("Sick Records", "View Logs", Modifier.weight(1f), onClick = { navController.navigate("sakit_list") })
                ActionCard("Medicine", "Inventory", Modifier.weight(1f), onClick = { navController.navigate("obat_list") })
            }
             Spacer(modifier = Modifier.height(16.dp))
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                ActionCard("Santri", "View All", Modifier.weight(1f), onClick = { navController.navigate("santri_list") })
                ActionCard("Reports", "Summary", Modifier.weight(1f), onClick = { navController.navigate("laporan") })
            }
            
            // Admin Only Features
            if (user?.isAdmin == true || user?.role == "admin") {
                Spacer(modifier = Modifier.height(16.dp))
                Text("Admin Area", style = MaterialTheme.typography.titleSmall, color = Color.Gray)
                Spacer(modifier = Modifier.height(8.dp))
                
                 Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                    ActionCard("Kelas", "Manage", Modifier.weight(1f), onClick = { navController.navigate("manage/kelas") })
                    ActionCard("Jurusan", "Manage", Modifier.weight(1f), onClick = { navController.navigate("manage/jurusan") })
                }
                 Spacer(modifier = Modifier.height(16.dp))
                 Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                    ActionCard("Diagnosis", "Ref Data", Modifier.weight(1f), onClick = { navController.navigate("manage/diagnosis") })
                    ActionCard("History", "Audit Logs", Modifier.weight(1f), onClick = { navController.navigate("manage/history") })
                }
                 Spacer(modifier = Modifier.height(16.dp))
                 Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                    ActionCard("Users", "Manage", Modifier.weight(1f), onClick = { navController.navigate("manage/users") })
                    // Empty spacer
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
