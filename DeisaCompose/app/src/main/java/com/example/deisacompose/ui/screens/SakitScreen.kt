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
                            onDelete = { viewModel.deleteSakit(sakit.id) }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun SakitItem(sakit: Sakit, onEdit: () -> Unit, onDelete: () -> Unit) {
    DeisaCard(onClick = onEdit) {
        Row(
            modifier = Modifier.fillMaxWidth(),
            horizontalArrangement = Arrangement.SpaceBetween
        ) {
            Column(modifier = Modifier.weight(1f)) {
               Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.SpaceBetween
                ) {
                    Text(sakit.santri?.displayName() ?: "Unknown Santri", style = MaterialTheme.typography.titleMedium)
                    Badge(sakit.displayStatus())
                }
                Spacer(modifier = Modifier.height(4.dp))
                Text("Sakit: ${sakit.displayDate()}", style = MaterialTheme.typography.bodyMedium)
                if (sakit.diagnosis != null) {
                    Text("Diagnosis: ${sakit.diagnosis}", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                }
            }
             IconButton(onClick = onDelete) {
                Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
            }
        }
    }
}

@Composable
fun Badge(text: String) {
    Surface(
        color = if(text.lowercase() == "berat") Color(0xFFFEE2E2) else Color(0xFFE0F2FE),
        shape = MaterialTheme.shapes.small
    ) {
        Text(
            text = text,
            modifier = Modifier.padding(horizontal = 8.dp, vertical = 2.dp),
            style = MaterialTheme.typography.labelSmall,
            color = Color.Black
        )
    }
}
