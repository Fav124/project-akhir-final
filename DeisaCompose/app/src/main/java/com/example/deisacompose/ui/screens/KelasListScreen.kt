package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material.icons.filled.School
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.StitchDrawerContent
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun KelasListScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel(),
    resourceViewModel: ResourceViewModel = viewModel()
) {
    val kelasList by resourceViewModel.kelasList.collectAsState()
    val uiState by resourceViewModel.uiState.collectAsState()
    val isAdmin by authViewModel.isAdmin.collectAsState()

    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()
    val currentUser by authViewModel.currentUser.collectAsState()

    var showAddDialog by remember { mutableStateOf(false) }
    var showEditDialog by remember { mutableStateOf(false) }
    var showDeleteDialog by remember { mutableStateOf(false) }
    var selectedKelas by remember { mutableStateOf<com.example.deisacompose.data.models.Kelas?>(null) }
    var kelasNameInput by remember { mutableStateOf("") }
    
    val snackbarHostState = remember { SnackbarHostState() }

    LaunchedEffect(Unit) {
        resourceViewModel.loadKelas()
    }

    LaunchedEffect(uiState) {
        if (uiState is ResourceUiState.Success) {
            scope.launch {
                snackbarHostState.showSnackbar((uiState as ResourceUiState.Success).message)
            }
            resourceViewModel.resetState()
        } else if (uiState is ResourceUiState.Error) {
            val message = (uiState as ResourceUiState.Error).message
            if (message == "SESI_HABIS") {
                authViewModel.logout()
                navController.navigate("login") {
                    popUpTo(0) { inclusive = true }
                }
            } else {
                scope.launch {
                    snackbarHostState.showSnackbar(message)
                }
            }
            resourceViewModel.resetState()
        }
    }

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                drawerContainerColor = DeisaSoftNavy,
                drawerContentColor = Color.White
            ) {
                StitchDrawerContent(
                    userName = currentUser?.name ?: "User",
                    onLogout = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    },
                    navController = navController,
                    currentRoute = "kelas_list"
                )
            }
        }
    ) {
        // CRUD Dialogs
        if (showAddDialog) {
            AlertDialog(
                onDismissRequest = { showAddDialog = false },
                title = { Text("Tambah Kelas Baru", color = Color.White) },
                text = {
                    Column {
                        Text("Masukkan nama kelas:", color = Color.Gray, style = MaterialTheme.typography.bodySmall)
                        Spacer(modifier = Modifier.height(8.dp))
                        TextField(
                            value = kelasNameInput,
                            onValueChange = { kelasNameInput = it },
                            placeholder = { Text("Contoh: X RPL 1") },
                            modifier = Modifier.fillMaxWidth(),
                            colors = TextFieldDefaults.colors(
                                focusedContainerColor = DeisaSoftNavy,
                                unfocusedContainerColor = DeisaSoftNavy,
                                focusedTextColor = Color.White,
                                unfocusedTextColor = Color.White
                            )
                        )
                    }
                },
                confirmButton = {
                    TextButton(onClick = {
                        if (kelasNameInput.isNotBlank()) {
                            resourceViewModel.createKelas(kelasNameInput)
                            kelasNameInput = ""
                            showAddDialog = false
                        }
                    }) {
                        Text("SIMPAN", color = DeisaBlue, fontWeight = FontWeight.Bold)
                    }
                },
                dismissButton = {
                    TextButton(onClick = { showAddDialog = false; kelasNameInput = "" }) {
                        Text("BATAL", color = Color.Gray)
                    }
                },
                containerColor = DeisaNavy
            )
        }

        if (showEditDialog && selectedKelas != null) {
            AlertDialog(
                onDismissRequest = { showEditDialog = false },
                title = { Text("Ubah Nama Kelas", color = Color.White) },
                text = {
                    Column {
                        Text("Masukkan nama kelas baru:", color = Color.Gray, style = MaterialTheme.typography.bodySmall)
                        Spacer(modifier = Modifier.height(8.dp))
                        TextField(
                            value = kelasNameInput,
                            onValueChange = { kelasNameInput = it },
                            modifier = Modifier.fillMaxWidth(),
                            colors = TextFieldDefaults.colors(
                                focusedContainerColor = DeisaSoftNavy,
                                unfocusedContainerColor = DeisaSoftNavy,
                                focusedTextColor = Color.White,
                                unfocusedTextColor = Color.White
                            )
                        )
                    }
                },
                confirmButton = {
                    TextButton(onClick = {
                        if (kelasNameInput.isNotBlank()) {
                            resourceViewModel.updateKelas(selectedKelas!!.id, kelasNameInput)
                            showEditDialog = false
                        }
                    }) {
                        Text("UPDATE", color = DeisaBlue, fontWeight = FontWeight.Bold)
                    }
                },
                dismissButton = {
                    TextButton(onClick = { showEditDialog = false }) {
                        Text("BATAL", color = Color.Gray)
                    }
                },
                containerColor = DeisaNavy
            )
        }

        if (showDeleteDialog && selectedKelas != null) {
            AlertDialog(
                onDismissRequest = { showDeleteDialog = false },
                title = { Text("Hapus Kelas", color = Color.White) },
                text = {
                    Text("Apakah Anda yakin ingin menghapus kelas '${selectedKelas!!.nama_kelas}'? Tindakan ini tidak dapat dibatalkan.", color = Color.Gray)
                },
                confirmButton = {
                    TextButton(onClick = {
                        resourceViewModel.deleteKelas(selectedKelas!!.id)
                        showDeleteDialog = false
                    }) {
                        Text("HAPUS", color = DangerRed, fontWeight = FontWeight.Bold)
                    }
                },
                dismissButton = {
                    TextButton(onClick = { showDeleteDialog = false }) {
                        Text("BATAL", color = Color.Gray)
                    }
                },
                containerColor = DeisaNavy
            )
        }
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Data Kelas",
                    onMenuClick = {
                        scope.launch { drawerState.open() }
                    },
                    showMenu = true
                )
            },
            floatingActionButton = {
                if (isAdmin) {
                    FloatingActionButton(
                        onClick = { showAddDialog = true },
                        containerColor = DeisaBlue,
                        contentColor = Color.White
                    ) {
                        Icon(Icons.Default.Add, contentDescription = "Tambah Kelas Baru")
                    }
                }
            },
            snackbarHost = { SnackbarHost(snackbarHostState) }
        ) { padding ->
            Box(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(padding)
            ) {
                when {
                    uiState is ResourceUiState.Loading && kelasList.isEmpty() -> {
                        CircularProgressIndicator(
                            modifier = Modifier.align(Alignment.Center),
                            color = DeisaBlue
                        )
                    }
                    uiState is ResourceUiState.Error && kelasList.isEmpty() -> {
                        Text(
                            (uiState as ResourceUiState.Error).message,
                            color = DangerRed,
                            modifier = Modifier
                                .align(Alignment.Center)
                                .padding(24.dp)
                        )
                    }
                    kelasList.isEmpty() -> {
                        Column(
                            modifier = Modifier.align(Alignment.Center),
                            horizontalAlignment = Alignment.CenterHorizontally
                        ) {
                            Icon(Icons.Default.School, contentDescription = null, tint = Color.Gray, modifier = Modifier.size(64.dp))
                            Spacer(modifier = Modifier.height(16.dp))
                            Text(
                                "Belum ada kelas",
                                style = MaterialTheme.typography.titleMedium,
                                color = Color.White
                            )
                            Text(
                                "Kelas yang ditambahkan akan muncul di sini.",
                                style = MaterialTheme.typography.bodyMedium,
                                color = Color.Gray
                            )
                        }
                    }
                    else -> {
                        LazyColumn(
                            modifier = Modifier.fillMaxSize(),
                            contentPadding = PaddingValues(top = 16.dp, bottom = 80.dp) // extra bottom padding for FAB
                        ) {
                            items(kelasList) { kelas ->
                                com.example.deisacompose.ui.components.PremiumCard(
                                    modifier = Modifier
                                        .fillMaxWidth()
                                        .padding(horizontal = 24.dp, vertical = 8.dp),
                                    accentColor = DeisaBlue
                                ) {
                                    Row(
                                        modifier = Modifier.fillMaxWidth(),
                                        verticalAlignment = Alignment.CenterVertically
                                    ) {
                                        Box(
                                            modifier = Modifier
                                                .size(48.dp)
                                                .background(DeisaBlue.copy(alpha = 0.1f), shape = MaterialTheme.shapes.small),
                                            contentAlignment = Alignment.Center
                                        ) {
                                            Icon(
                                                Icons.Default.School,
                                                contentDescription = null,
                                                tint = DeisaBlue
                                            )
                                        }
                                        Spacer(modifier = Modifier.width(16.dp))
                                        Column(modifier = Modifier.weight(1f)) {
                                            Text(
                                                text = kelas.nama_kelas,
                                                style = MaterialTheme.typography.titleMedium,
                                                fontWeight = FontWeight.Bold,
                                                color = Color.White
                                            )
                                        }

                                        if (isAdmin) {
                                            IconButton(onClick = {
                                                selectedKelas = kelas
                                                kelasNameInput = kelas.nama_kelas
                                                showEditDialog = true
                                            }) {
                                                Icon(Icons.Default.Edit, "Edit", tint = DeisaBlue, modifier = Modifier.size(20.dp))
                                            }
                                            IconButton(onClick = {
                                                selectedKelas = kelas
                                                showDeleteDialog = true
                                            }) {
                                                Icon(Icons.Default.Delete, "Delete", tint = DangerRed, modifier = Modifier.size(20.dp))
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
