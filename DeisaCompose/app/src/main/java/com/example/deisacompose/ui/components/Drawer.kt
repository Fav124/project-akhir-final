package com.example.deisacompose.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.navigation.NavController
import com.example.deisacompose.ui.theme.*

@Composable
fun StitchDrawerContent(
    userName: String,
    onLogout: () -> Unit,
    navController: NavController,
    currentRoute: String
) {
    Column(
        modifier = Modifier
            .fillMaxHeight()
            .width(280.dp)
            .background(DeisaNavy)
            .padding(24.dp)
    ) {
        Column(modifier = Modifier.padding(bottom = 32.dp)) {
            Text(
                "Santri Health",
                style = MaterialTheme.typography.headlineSmall,
                fontWeight = FontWeight.ExtraBold,
                color = Color.White
            )
            Text(
                "Manajemen Kesehatan Pesantren",
                style = MaterialTheme.typography.labelSmall,
                color = Color.Gray
            )
        }

        Spacer(modifier = Modifier.height(24.dp))
        
        DrawerItem("Dashboard", Icons.Default.Dashboard, currentRoute == "admin_dashboard") { 
            navController.navigate("admin_dashboard") {
                popUpTo("admin_dashboard") { inclusive = true }
            }
        }
        DrawerItem("Data Santri", Icons.Default.Groups, currentRoute == "santri_list") { navController.navigate("santri_list") }
        DrawerItem("Data Kelas", Icons.Default.Class, currentRoute == "kelas_list") { navController.navigate("kelas_list") }
        DrawerItem("Data Jurusan", Icons.Default.Category, currentRoute == "jurusan_list") { navController.navigate("jurusan_list") }
        DrawerItem("Data Sakit", Icons.Default.Sick, currentRoute == "sakit_list") { navController.navigate("sakit_list") }
        DrawerItem("Stok Obat", Icons.Default.Medication, currentRoute == "obat_list") { navController.navigate("obat_list") }
        DrawerItem("Riwayat Izin", Icons.Filled.MedicalServices, currentRoute == "history") { navController.navigate("history") }

        Spacer(modifier = Modifier.weight(1f))
        
        Divider(color = Color.White.copy(alpha = 0.05f))
        DrawerItem("Pengaturan", Icons.Default.Settings, currentRoute == "settings") { navController.navigate("settings") }
        DrawerItem("Keluar", Icons.Default.Logout, false, color = DangerRed) { onLogout() }
    }
}

@Composable
private fun DrawerItem(
    label: String,
    icon: ImageVector,
    selected: Boolean,
    color: Color = Color.White,
    onClick: () -> Unit
) {
    Row(
        modifier = Modifier
            .fillMaxWidth()
            .clip(RoundedCornerShape(12.dp))
            .background(if (selected) DeisaBlue.copy(alpha = 0.1f) else Color.Transparent)
            .clickable(onClick = onClick)
            .padding(horizontal = 16.dp, vertical = 12.dp),
        verticalAlignment = Alignment.CenterVertically
    ) {
        Icon(
            icon,
            contentDescription = null,
            tint = if (selected) DeisaBlue else color.copy(alpha = 0.7f),
            modifier = Modifier.size(20.dp)
        )
        Spacer(modifier = Modifier.width(16.dp))
        Text(
            label,
            style = MaterialTheme.typography.bodyMedium,
            fontWeight = if (selected) FontWeight.Bold else FontWeight.Medium,
            color = if (selected) DeisaBlue else color
        )
    }
}
