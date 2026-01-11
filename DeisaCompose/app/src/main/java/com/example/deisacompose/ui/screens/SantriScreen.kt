package com.example.deisacompose.ui.screens

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.SantriViewModel
import com.example.deisacompose.viewmodels.MainViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriScreen(
    navController: NavController, 
    viewModel: SantriViewModel = viewModel(),
    mainViewModel: MainViewModel = viewModel()
) {
    val santriList by viewModel.santriList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val user by mainViewModel.currentUser.observeAsState()
    
    LaunchedEffect(Unit) {
        viewModel.fetchSantri()
        mainViewModel.fetchUser()
    }
    
    val isAdmin = user?.isAdmin == true || user?.role == "admin"

    Scaffold(
        topBar = { DeisaTopBar("Data Santri") },
        floatingActionButton = {
            if (isAdmin) {
                DeisaFab(onClick = { navController.navigate("santri_form") })
            }
        }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
            if (isLoading) {
                LoadingScreen()
            } else if (santriList.isEmpty()) {
                EmptyState("No Santri Data Found")
            } else {
                LazyColumn(modifier = Modifier.padding(16.dp)) {
                    items(santriList) { santri ->
                        SantriItem(
                            santri = santri,
                            canEdit = isAdmin,
                            onEdit = { navController.navigate("santri_form?id=${santri.id}") },
                            onDelete = { viewModel.deleteSantri(santri.id) }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun SantriItem(santri: Santri, canEdit: Boolean, onEdit: () -> Unit, onDelete: () -> Unit) {
    val statusColor = when (santri.statusKesehatan) {
        "Sehat" -> Color(0xFFE8F5E9)
        "Sakit" -> Color(0xFFFFEBEE)
        "Rawat Inap" -> Color(0xFFFFF3E0)
        "Pulang" -> Color(0xFFE3F2FD)
        else -> Color.LightGray
    }
    
    val statusTextColor = when (santri.statusKesehatan) {
        "Sehat" -> Color(0xFF2E7D32)
        "Sakit" -> Color(0xFFC62828)
        "Rawat Inap" -> Color(0xFFEF6C00)
        "Pulang" -> Color(0xFF1565C0)
        else -> Color.DarkGray
    }

    DeisaCard(onClick = onEdit) {
        Row(
            modifier = Modifier.fillMaxWidth(),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Column(modifier = Modifier.weight(1f)) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(santri.displayName(), style = MaterialTheme.typography.titleMedium, modifier = Modifier.weight(1f, fill = false))
                    Spacer(modifier = Modifier.width(8.dp))
                    DeisaBadge(
                        text = santri.statusKesehatan ?: "Unknown",
                        containerColor = statusColor,
                        contentColor = statusTextColor
                    )
                }
                Text("Kelas: ${santri.displayKelas()}", style = MaterialTheme.typography.bodyMedium, color = Color.Gray)
                Text("NIS: ${santri.nis ?: "-"}", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
            }
            if (canEdit) {
                 IconButton(onClick = onDelete) {
                    Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
                }
            }
        }
    }
}
