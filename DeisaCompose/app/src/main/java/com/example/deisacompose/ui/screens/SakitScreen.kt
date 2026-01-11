package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.SakitViewModel
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitScreen(navController: NavController, viewModel: SakitViewModel = viewModel()) {

    val sakitList by viewModel.sakitList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val message by viewModel.message.observeAsState()

    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        viewModel.fetchSakit()
    }

    LaunchedEffect(message) {
        message?.let {
            snackbarHostState.showSnackbar(it)
            viewModel.clearMessage()
        }
    }

    Scaffold(
        topBar = { DeisaTopBar("Riwayat Sakit Santri") },
        snackbarHost = { SnackbarHost(snackbarHostState) },
        floatingActionButton = {
            DeisaFab(onClick = { navController.navigate("sakit_form") })
        }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
            if (isLoading) {
                LoadingScreen()
            } else if (sakitList.isEmpty()) {
                EmptyState("Belum ada data santri sakit")
            } else {
                LazyColumn(modifier = Modifier.padding(16.dp)) {
                    items(sakitList) { sakit ->
                        SakitItem(
                            sakit = sakit, 
                            onEdit = { navController.navigate("sakit_form?id=${sakit.id}") },
                            onDelete = { 
                                viewModel.deleteSakit(sakit.id, 
                                    onSuccess = { scope.launch { snackbarHostState.showSnackbar("Data berhasil dihapus") } },
                                    onError = { error -> scope.launch { snackbarHostState.showSnackbar(error) } }
                                )
                            },
                            onMarkSembuh = { 
                                viewModel.markAsSembuh(sakit.id,
                                    onSuccess = { scope.launch { snackbarHostState.showSnackbar("Santri ditandai sembuh") } },
                                    onError = { error -> scope.launch { snackbarHostState.showSnackbar(error) } }
                                )
                            }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun SakitItem(
    sakit: Sakit,
    onEdit: () -> Unit,
    onDelete: () -> Unit,
    onMarkSembuh: () -> Unit,
) {
    DeisaCard(onClick = onEdit) {
        Column {
            Text(sakit.santri?.displayName() ?: "-", style = MaterialTheme.typography.titleMedium)
            Text(sakit.displayDate(), style = MaterialTheme.typography.bodySmall, color = Color.Gray)
            Spacer(modifier = Modifier.height(8.dp))
            Text(sakit.keluhan ?: "", style = MaterialTheme.typography.bodyMedium)
            Spacer(modifier = Modifier.height(8.dp))
            Row {
                DeisaBadge(sakit.displayStatus())
                Spacer(modifier = Modifier.width(8.dp))
                DeisaBadge(sakit.diagnosis ?: "-", containerColor = Color.LightGray.copy(alpha = 0.3f), contentColor = Color.DarkGray)
            }
            Spacer(modifier = Modifier.height(8.dp))
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.End) {
                if (sakit.status?.lowercase() != "sembuh") {
                    TextButton(onClick = onMarkSembuh) {
                        Text("Tandai Sembuh")
                    }
                }
                TextButton(onClick = onEdit) {
                    Text("Edit")
                }
                TextButton(onClick = onDelete, colors = ButtonDefaults.textButtonColors(contentColor = Color.Red)) {
                    Text("Hapus")
                }
            }
        }
    }
}