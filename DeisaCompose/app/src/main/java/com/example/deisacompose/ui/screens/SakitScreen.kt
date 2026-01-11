package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.CheckCircle
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
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.SakitViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitScreen(
    navController: NavController, 
    viewModel: SakitViewModel = viewModel()
) {
    val sakitList by viewModel.sakitList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    
    LaunchedEffect(Unit) {
        viewModel.fetchSakit()
    }

    Scaffold(
        topBar = { DeisaTopBar("Data Santri Sakit") },
        floatingActionButton = {
            DeisaFab(onClick = { navController.navigate("sakit_form") })
        }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
             if (isLoading) {
                LoadingScreen()
            } else if (sakitList.isEmpty()) {
                EmptyState("No Sick Records Found")
            } else {
                LazyColumn(modifier = Modifier.padding(16.dp)) {
                    items(sakitList) { sakit ->
                        SakitItem(
                            sakit = sakit,
                            onEdit = { navController.navigate("sakit_form?id=${sakit.id}") },
                            onDelete = { viewModel.deleteSakit(sakit.id) },
                            onMarkSembuh = { viewModel.markSembuh(sakit.id) { } }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun SakitItem(sakit: Sakit, onEdit: () -> Unit, onDelete: () -> Unit, onMarkSembuh: () -> Unit) {
    val statusColor = when (sakit.status) {
        "Sakit" -> Color(0xFFFFEBEE)
        "Pulang" -> Color(0xFFE3F2FD)
        "Sembuh" -> Color(0xFFE8F5E9)
        else -> Color.LightGray
    }
    
    val statusTextColor = when (sakit.status) {
        "Sakit" -> Color(0xFFC62828)
        "Pulang" -> Color(0xFF1565C0)
        "Sembuh" -> Color(0xFF2E7D32)
        else -> Color.DarkGray
    }

    DeisaCard(onClick = onEdit) {
        Row(
            modifier = Modifier.fillMaxWidth(),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.Top
        ) {
            Column(modifier = Modifier.weight(1f)) {
               Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(sakit.santri?.displayName() ?: "Unknown Santri", style = MaterialTheme.typography.titleMedium, modifier = Modifier.weight(1f, fill = false))
                    Spacer(modifier = Modifier.width(8.dp))
                    DeisaBadge(
                        text = sakit.status ?: "Unknown",
                        containerColor = statusColor,
                        contentColor = statusTextColor
                    )
                }
                Text("Tgl Masuk: ${sakit.displayDate()}", style = MaterialTheme.typography.bodyMedium)
                if (sakit.diagnosis != null) {
                    Text("Diagnosis: ${sakit.diagnosis}", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                }
                
                if (sakit.status != "Sembuh") {
                    Spacer(modifier = Modifier.height(8.dp))
                    OutlinedButton(
                        onClick = onMarkSembuh,
                        modifier = Modifier.height(36.dp),
                        contentPadding = PaddingValues(horizontal = 12.dp, vertical = 0.dp),
                        colors = ButtonDefaults.outlinedButtonColors(contentColor = Color(0xFF2E7D32))
                    ) {
                        Icon(Icons.Default.CheckCircle, contentDescription = null, modifier = Modifier.size(16.dp))
                        Spacer(modifier = Modifier.width(4.dp))
                        Text("Sembuh", style = MaterialTheme.typography.labelLarge)
                    }
                }
            }
            
            IconButton(onClick = onDelete) {
                Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red.copy(alpha = 0.6f))
            }
        }
    }
}
