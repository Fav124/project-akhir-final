package com.example.deisacompose.ui.screens

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
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
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriScreen(navController: NavController, viewModel: SantriViewModel = viewModel()) {

    val santriList by viewModel.santriList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val message by viewModel.message.observeAsState()

    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        viewModel.fetchSantri()
    }

    LaunchedEffect(message) {
        message?.let {
            snackbarHostState.showSnackbar(it)
            viewModel.clearMessage()
        }
    }

    Scaffold(
        topBar = { DeisaTopBar("Data Santri") },
        snackbarHost = { SnackbarHost(snackbarHostState) },
        floatingActionButton = {
            DeisaFab(onClick = { navController.navigate("santri_form") })
        }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
            if (isLoading) {
                LoadingScreen()
            } else {
                LazyColumn(modifier = Modifier.padding(16.dp)) {
                    items(santriList) { santri ->
                        SantriItem(
                            santri = santri, 
                            onEdit = { navController.navigate("santri_form?id=${santri.id}") },
                            onDelete = { 
                                viewModel.deleteSantri(santri.id, 
                                    onSuccess = { scope.launch { snackbarHostState.showSnackbar("Santri berhasil dihapus") } },
                                    onError = { error -> scope.launch { snackbarHostState.showSnackbar(error) } }
                                )
                            },
                            onClick = { navController.navigate("santri_detail/${santri.id}") }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun SantriItem(
    santri: Santri,
    onClick: () -> Unit,
    onEdit: () -> Unit,
    onDelete: () -> Unit
) {
    DeisaCard(onClick = onClick) {
        Row(verticalAlignment = Alignment.CenterVertically) {
            Column(modifier = Modifier.weight(1f)) {
                Text(santri.displayName(), style = MaterialTheme.typography.titleMedium)
                Text(santri.displayKelas(), style = MaterialTheme.typography.bodySmall, color = Color.Gray)
            }
            IconButton(onClick = onEdit) {
                Icon(Icons.Default.Edit, contentDescription = "Edit", tint = MaterialTheme.colorScheme.primary)
            }
            IconButton(onClick = onDelete) {
                Icon(Icons.Default.Delete, contentDescription = "Hapus", tint = Color.Red)
            }
        }
    }
}
