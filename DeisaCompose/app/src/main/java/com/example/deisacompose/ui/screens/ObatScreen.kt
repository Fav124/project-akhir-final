package com.example.deisacompose.ui.screens

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
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.ObatViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatScreen(
    navController: NavController, 
    viewModel: ObatViewModel = viewModel()
) {
    val obatList by viewModel.obatList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    
    LaunchedEffect(Unit) {
        viewModel.fetchObat()
    }

    Scaffold(
        topBar = { DeisaTopBar("Data Obat") },
        floatingActionButton = {
            DeisaFab(onClick = { navController.navigate("obat_form") })
        }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
             if (isLoading) {
                LoadingScreen()
            } else if (obatList.isEmpty()) {
                EmptyState("No Medicine Found")
            } else {
                LazyColumn(modifier = Modifier.padding(HORIZONTAL_PADDING)) {
                    items(obatList) { obat ->
                         ObatItem(
                             obat = obat,
                             onEdit = { navController.navigate("obat_form?id=${obat.id}") },
                             onDelete = { viewModel.deleteObat(obat.id) }
                         )
                    }
                }
            }
        }
    }
}

private val HORIZONTAL_PADDING = 16.dp

@Composable
fun ObatItem(obat: Obat, onEdit: () -> Unit, onDelete: () -> Unit) {
    val isLowStock = obat.stok <= (obat.stokMinimum ?: 10)
    
    DeisaCard(onClick = onEdit) {
        Row(
            modifier = Modifier.fillMaxWidth(), 
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Column(modifier = Modifier.weight(1f)) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(obat.namaObat, style = MaterialTheme.typography.titleMedium, modifier = Modifier.weight(1f, fill = false))
                    if (obat.kategori != null) {
                        Spacer(modifier = Modifier.width(8.dp))
                        DeisaBadge(text = obat.kategori, containerColor = Color.LightGray.copy(alpha = 0.3f), contentColor = Color.DarkGray)
                    }
                }
                
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text("${obat.stok} ${obat.satuan ?: ""}", style = MaterialTheme.typography.bodyMedium, fontWeight = androidx.compose.ui.text.font.FontWeight.Bold)
                    if (isLowStock) {
                        Spacer(modifier = Modifier.width(8.dp))
                        DeisaBadge(text = "Low Stock", containerColor = Color(0xFFFFEBEE), contentColor = Color.Red)
                    }
                }
                
                if (obat.deskripsi != null) {
                    Text(obat.deskripsi, style = MaterialTheme.typography.bodySmall, color = Color.Gray, maxLines = 1)
                }
            }
            IconButton(onClick = onDelete) {
                Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
            }
        }
    }
}
