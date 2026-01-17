package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ProfileScreen(navController: NavHostController) {
    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Profile Saya", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .fillMaxSize(),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Spacer(modifier = Modifier.height(32.dp))
            
            // Profile Image Mockup
            Box(
                modifier = Modifier
                    .size(100.dp)
                    .background(DeisaBlue.copy(alpha = 0.1f), CircleShape),
                contentAlignment = Alignment.Center
            ) {
                Icon(Icons.Default.Person, contentDescription = null, modifier = Modifier.size(60.dp), tint = DeisaBlue)
            }
            
            Spacer(modifier = Modifier.height(16.dp))
            Text("Admin Deisa", fontWeight = FontWeight.Bold, fontSize = 24.sp, color = Slate900)
            Text("admin@deisa.id", color = Slate500, fontSize = 16.sp)
            
            Spacer(modifier = Modifier.height(32.dp))
            
            Card(
                modifier = Modifier
                    .padding(horizontal = 16.dp)
                    .fillMaxWidth(),
                shape = RoundedCornerShape(16.dp),
                colors = CardDefaults.cardColors(containerColor = Color.White)
            ) {
                Column {
                    ProfileMenuItem(Icons.Default.Settings, "Pengaturan Akun")
                    Divider(modifier = Modifier.padding(horizontal = 16.dp), color = Slate100)
                    ProfileMenuItem(Icons.Default.Info, "Tentang Aplikasi") {
                        navController.navigate("about")
                    }
                    Divider(modifier = Modifier.padding(horizontal = 16.dp), color = Slate100)
                    ProfileMenuItem(Icons.Default.Logout, "Keluar", color = DangerRed) {
                        navController.navigate("login") {
                            popUpTo(0)
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun ProfileMenuItem(icon: androidx.compose.ui.graphics.vector.ImageVector, title: String, color: Color = Slate700, onClick: () -> Unit = {}) {
    Row(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() }
            .padding(16.dp),
        verticalAlignment = Alignment.CenterVertically
    ) {
        Icon(icon, contentDescription = null, tint = color, modifier = Modifier.size(24.dp))
        Spacer(modifier = Modifier.width(16.dp))
        Text(text = title, color = color, fontSize = 16.sp, fontWeight = FontWeight.Medium)
        Spacer(modifier = Modifier.weight(1f))
        Icon(Icons.Default.ChevronRight, contentDescription = null, tint = Slate500.copy(alpha = 0.5f))
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun AboutScreen(navController: NavHostController) {
    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Tentang Deisa", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        containerColor = Color.White
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(24.dp)
                .fillMaxSize(),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Surface(
                shape = RoundedCornerShape(16.dp),
                color = DeisaBlue,
                modifier = Modifier.size(80.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Text("D", color = Color.White, fontWeight = FontWeight.Bold, fontSize = 48.sp)
                }
            }
            Spacer(modifier = Modifier.height(24.dp))
            Text("Deisa Health", fontWeight = FontWeight.Bold, fontSize = 24.sp, color = DeisaBlue)
            Text("v1.0.0 Stable", color = Slate500, fontSize = 14.sp)
            
            Spacer(modifier = Modifier.height(32.dp))
            Text(
                text = "Aplikasi manajemen kesehatan santri terpadu untuk pondok pesantren modern.",
                textAlign = androidx.compose.ui.text.style.TextAlign.Center,
                color = Slate700,
                lineHeight = 24.sp
            )
            
            Spacer(modifier = Modifier.weight(1f))
            Text("Build with ❤️ by Deisa Team", color = Slate500, fontSize = 12.sp)
            Spacer(modifier = Modifier.height(16.dp))
        }
    }
}


