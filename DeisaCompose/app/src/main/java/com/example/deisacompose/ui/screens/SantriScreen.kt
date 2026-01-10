package com.example.deisacompose.ui.screens

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
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
    mainViewModel: MainViewModel = viewModel() // To check role
) {
    val santriList by viewModel.santriList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val user by mainViewModel.currentUser.observeAsState()
    
    // Fetch on enter
    LaunchedEffect(Unit) {
        viewModel.fetchSantri()
        mainViewModel.fetchUser()
    }

    Scaffold(
        topBar = { DeisaTopBar("Data Santri") },
        floatingActionButton = {
            if (user?.isAdmin == true || user?.role == "admin") {
                DeisaFab(onClick = { /* Navigate to Add Santri */ })
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
                        SantriItem(santri, onClick = { /* Navigate to Detail */ })
                    }
                }
            }
        }
    }
}

@Composable
fun SantriItem(santri: Santri, onClick: () -> Unit) {
    DeisaCard(onClick = onClick) {
        Column {
            Text(santri.displayName(), style = MaterialTheme.typography.titleMedium)
            Text("Kelas: ${santri.displayKelas()}", style = MaterialTheme.typography.bodyMedium, color = Color.Gray)
            Text("NIS: ${santri.nis ?: "-"}", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
        }
    }
}
