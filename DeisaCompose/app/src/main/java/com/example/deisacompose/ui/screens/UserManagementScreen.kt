package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.PendingUser
import com.example.deisacompose.viewmodels.ActionState
import com.example.deisacompose.viewmodels.AdminViewModel
import com.example.deisacompose.ui.theme.*
import androidx.compose.ui.graphics.Color
import com.example.deisacompose.ui.components.StitchNavBar
import com.example.deisacompose.ui.components.StitchTopBar
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun UserManagementScreen(
    navController: NavController,
    adminViewModel: AdminViewModel = viewModel()
) {
    val pendingUsers by adminViewModel.pendingUsers.collectAsState()
    val actionState by adminViewModel.actionState.collectAsState()

    var showSuccess by remember { mutableStateOf(false) }
    var showError by remember { mutableStateOf(false) }
    var message by remember { mutableStateOf("") }

    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()

    LaunchedEffect(Unit) {
        adminViewModel.loadPendingUsers()
    }

    LaunchedEffect(actionState) {
        if (actionState is ActionState.Success) {
            adminViewModel.resetActionState()
        }
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Manajemen Pengguna",
                onMenuClick = { navController.navigateUp() },
                showMenu = false
            )
        },
        bottomBar = {
            StitchNavBar(navController)
        },
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Box(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
        ) {
            if (pendingUsers.isEmpty()) {
                Box(
                    modifier = Modifier.fillMaxSize(),
                    contentAlignment = Alignment.Center
                ) {
                    Column(
                        horizontalAlignment = Alignment.CenterHorizontally,
                        modifier = Modifier.padding(32.dp)
                    ) {
                        Box(
                            modifier = Modifier
                                .size(120.dp)
                                .clip(RoundedCornerShape(40.dp))
                                .background(DeisaSoftNavy)
                                .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(40.dp)),
                            contentAlignment = Alignment.Center
                        ) {
                            Icon(
                                Icons.Default.ManageAccounts,
                                contentDescription = null,
                                modifier = Modifier.size(64.dp),
                                tint = DeisaBlue.copy(alpha = 0.5f)
                            )
                        }
                        Spacer(modifier = Modifier.height(32.dp))
                        Text(
                            "Semua Terkendali",
                            style = MaterialTheme.typography.headlineSmall,
                            fontWeight = FontWeight.Black,
                            color = Color.White
                        )
                        Text(
                            "Tidak ada permintaan akses pengguna baru yang perlu disetujui saat ini.",
                            style = MaterialTheme.typography.bodyMedium,
                            color = Color.Gray,
                            textAlign = androidx.compose.ui.text.style.TextAlign.Center,
                            modifier = Modifier.padding(top = 8.dp)
                        )
                    }
                }
            } else {
                LazyColumn(
                    contentPadding = PaddingValues(24.dp),
                    verticalArrangement = Arrangement.spacedBy(16.dp)
                ) {
                    item {
                        Text(
                            "Menunggu Persetujuan (${pendingUsers.size})",
                            style = MaterialTheme.typography.titleMedium,
                            fontWeight = FontWeight.Bold,
                            color = DeisaBlue
                        )
                    }

                    items(pendingUsers) { user ->
                        PendingUserCard(
                            user = user,
                            onApprove = { adminViewModel.approveUser(user.id) },
                            onReject = { adminViewModel.deleteUser(user.id) }
                        )
                    }
                }
            }

            if (actionState is ActionState.Loading) {
                Box(
                    modifier = Modifier
                        .fillMaxSize()
                        .background(Color.Black.copy(alpha = 0.5f)),
                    contentAlignment = Alignment.Center
                ) {
                    CircularProgressIndicator(color = DeisaBlue)
                }
            }

            if (actionState is ActionState.Loading) {
                Box(
                    modifier = Modifier
                        .fillMaxSize()
                        .background(Color.Black.copy(alpha = 0.5f)),
                    contentAlignment = Alignment.Center
                ) {
                    CircularProgressIndicator(color = DeisaBlue)
                }
            }
        }
    }
}

@Composable
fun PendingUserCard(
    user: PendingUser,
    onApprove: () -> Unit,
    onReject: () -> Unit
) {
    var showRejectDialog by remember { mutableStateOf(false) }

    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.fillMaxWidth(),
        backgroundColor = DeisaSoftNavy,
        accentColor = DeisaBlue
    ) {
        Column {
            Row(verticalAlignment = Alignment.CenterVertically) {
                Box(
                    modifier = Modifier
                        .size(56.dp)
                        .clip(CircleShape)
                        .background(DeisaBlue.copy(alpha = 0.1f)),
                    contentAlignment = Alignment.Center
                ) {
                    Text(
                        user.name.first().uppercase(),
                        fontWeight = FontWeight.Black,
                        style = MaterialTheme.typography.headlineSmall,
                        color = DeisaBlue
                    )
                }
                Spacer(modifier = Modifier.width(16.dp))
                Column(modifier = Modifier.weight(1f)) {
                    Text(user.name, fontWeight = FontWeight.ExtraBold, fontSize = 18.sp, color = Color.White)
                    Text(user.email, style = MaterialTheme.typography.bodyMedium, color = Color.Gray)
                    Spacer(modifier = Modifier.height(4.dp))
                    Surface(
                        color = DeisaNavy,
                        shape = RoundedCornerShape(8.dp),
                        border = androidx.compose.foundation.BorderStroke(1.dp, Color.White.copy(alpha = 0.05f))
                    ) {
                        Row(
                            modifier = Modifier.padding(horizontal = 8.dp, vertical = 4.dp),
                            verticalAlignment = Alignment.CenterVertically
                        ) {
                            Icon(Icons.Default.Person, null, modifier = Modifier.size(14.dp), tint = DeisaBlue)
                            Spacer(modifier = Modifier.width(4.dp))
                            Text("Pendaftar Baru", style = MaterialTheme.typography.labelSmall, color = DeisaBlue, fontWeight = FontWeight.Bold)
                        }
                    }
                }
            }

            Spacer(modifier = Modifier.height(20.dp))

            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.spacedBy(12.dp)
            ) {
                OutlinedButton(
                    onClick = { showRejectDialog = true },
                    modifier = Modifier.weight(1f).height(48.dp),
                    shape = RoundedCornerShape(12.dp),
                    colors = ButtonDefaults.outlinedButtonColors(contentColor = DangerRed),
                    border = androidx.compose.foundation.BorderStroke(1.dp, DangerRed.copy(alpha = 0.5f))
                ) {
                    Text("Tolak", fontWeight = FontWeight.Bold)
                }

                Button(
                    onClick = onApprove,
                    modifier = Modifier.weight(1f).height(48.dp),
                    shape = RoundedCornerShape(12.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen)
                ) {
                    Text("Setujui", fontWeight = FontWeight.Bold, color = Color.White)
                }
            }
        }
    }

    if (showRejectDialog) {
        AlertDialog(
            onDismissRequest = { showRejectDialog = false },
            title = { Text("Tolak Registrasi", fontWeight = FontWeight.Bold) },
            text = { Text("Apakah Anda yakin ingin menolak dan menghapus pendaftaran ${user.name}?") },
            confirmButton = {
                TextButton(
                    onClick = {
                        onReject()
                        showRejectDialog = false
                    },
                    colors = ButtonDefaults.textButtonColors(contentColor = DangerRed)
                ) {
                    Text("Tolak & Hapus", fontWeight = FontWeight.ExtraBold)
                }
            },
            dismissButton = {
                TextButton(onClick = { showRejectDialog = false }) {
                    Text("Batal")
                }
            }
        )
    }
}
