package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.RegistrationRequest
import com.example.deisacompose.ui.components.DeisaBadge
import com.example.deisacompose.ui.components.DeisaCard
import com.example.deisacompose.ui.components.DeisaTopBar
import com.example.deisacompose.ui.components.LoadingScreen
import com.example.deisacompose.viewmodels.AdminViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun AdminRegistrationsScreen(
    navController: NavController,
    viewModel: AdminViewModel = viewModel()
) {
    val requests by viewModel.pendingRequests.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val message by viewModel.message.observeAsState()

    val snackbarHostState = remember { SnackbarHostState() }

    LaunchedEffect(Unit) {
        viewModel.fetchPendingRegistrations()
    }

    LaunchedEffect(message) {
        message?.let {
            snackbarHostState.showSnackbar(it)
            viewModel.clearMessage()
        }
    }

    Scaffold(
        topBar = { DeisaTopBar("Persetujuan Petugas") },
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Box(modifier = Modifier.padding(padding)) {
            if (isLoading) {
                LoadingScreen()
            } else if (requests.isEmpty()) {
                Box(Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                    Text("Tidak ada permintaan baru", style = MaterialTheme.typography.bodyLarge)
                }
            } else {
                LazyColumn(modifier = Modifier.padding(16.dp)) {
                    items(requests) { request ->
                        RegistrationItem(
                            request = request,
                            onApprove = { viewModel.approveRegistration(request.id) },
                            onReject = { viewModel.rejectRegistration(request.id) }
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun RegistrationItem(
    request: RegistrationRequest,
    onApprove: () -> Unit,
    onReject: () -> Unit
) {
    DeisaCard {
        Column(modifier = Modifier.padding(8.dp)) {
            Row(verticalAlignment = Alignment.CenterVertically) {
                Column(modifier = Modifier.weight(1f)) {
                    Text(request.name, style = MaterialTheme.typography.titleMedium)
                    Text(request.email, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                }
                DeisaBadge("PENDING", containerColor = Color(0xFFFFF3E0), contentColor = Color(0xFFE65100))
            }
            
            Spacer(modifier = Modifier.height(16.dp))
            
            Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.End) {
                TextButton(onClick = onReject, colors = ButtonDefaults.textButtonColors(contentColor = Color.Red)) {
                    Text("Tolak")
                }
                Spacer(modifier = Modifier.width(8.dp))
                Button(onClick = onApprove, colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF10B981))) {
                    Text("Setujui")
                }
            }
        }
    }
}
