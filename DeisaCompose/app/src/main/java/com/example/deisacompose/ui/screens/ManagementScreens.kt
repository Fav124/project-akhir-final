package com.example.deisacompose.ui.screens

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.ManagementViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ManagementListScreen(navController: NavHostController) {
    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("App Management", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        containerColor = Slate50
    ) { padding ->
        LazyColumn(
            modifier = Modifier
                .padding(padding)
                .fillMaxSize(),
            contentPadding = PaddingValues(16.dp),
            verticalArrangement = Arrangement.spacedBy(16.dp)
        ) {
            item {
                ManagementMenuCard("Data Kelas", "Kelola data kelas santri", Icons.Default.School) {
                    navController.navigate("management_detail/kelas")
                }
            }
            item {
                ManagementMenuCard("Data Jurusan", "Kelola data jurusan santri", Icons.Default.Category) {
                    navController.navigate("management_detail/jurusan")
                }
            }
            item {
                ManagementMenuCard("Data Diagnosis", "Master data penyakit & diagnosis", Icons.Default.HealthAndSafety) {
                    navController.navigate("management_detail/diagnosis")
                }
            }
            item {
                ManagementMenuCard("Log Aktivitas", "Riwayat perubahan data", Icons.Default.History) {
                    navController.navigate("management_detail/history")
                }
            }
            item {
                ManagementMenuCard("Persetujuan Akun", "Approve pendaftaran user baru", Icons.Default.HowToReg) {
                    navController.navigate("admin_registrations")
                }
            }
        }
    }
}

@Composable
fun ManagementMenuCard(title: String, subtitle: String, icon: androidx.compose.ui.graphics.vector.ImageVector, onClick: () -> Unit) {
    Card(
        modifier = Modifier
            .fillMaxWidth()
            .clickable { onClick() },
        shape = RoundedCornerShape(16.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Row(
            modifier = Modifier.padding(16.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Surface(
                shape = RoundedCornerShape(12.dp),
                color = Slate100,
                modifier = Modifier.size(48.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(icon, contentDescription = null, tint = Slate700)
                }
            }
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(text = title, fontWeight = FontWeight.Bold, fontSize = 16.sp, color = Slate900)
                Text(text = subtitle, fontSize = 12.sp, color = Slate500)
            }
            Icon(Icons.Default.ChevronRight, contentDescription = null, tint = Slate500)
        }
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ManagementScreen(
    navController: NavHostController,
    type: String,
    viewModel: ManagementViewModel = viewModel()
) {
    var searchQuery by remember { mutableStateOf("") }
    val historyList by viewModel.historyList.observeAsState(emptyList())

    // Simple CRUD Lists
    val kelasList by viewModel.kelasList.observeAsState(emptyList())
    val jurusanList by viewModel.jurusanList.observeAsState(emptyList())
    val diagnosisList by viewModel.diagnosisList.observeAsState(emptyList())

    LaunchedEffect(type) {
        when (type) {
            "kelas" -> viewModel.fetchKelas()
            "jurusan" -> viewModel.fetchJurusan()
            "diagnosis" -> viewModel.fetchDiagnosis()
            "history" -> viewModel.fetchHistory()
        }
    }

    val filteredHistory = remember(historyList, searchQuery) {
        if (searchQuery.isBlank()) historyList
        else historyList.filter { 
            it.description?.contains(searchQuery, ignoreCase = true) == true || 
            it.action?.contains(searchQuery, ignoreCase = true) == true ||
            it.user?.name?.contains(searchQuery, ignoreCase = true) == true
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Kelola ${type.replaceFirstChar { it.uppercase() }}", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        floatingActionButton = {
            if (type != "history") {
                FloatingActionButton(onClick = { /* Add New Dialog */ }, containerColor = DeisaBlue, contentColor = Color.White) {
                    Icon(Icons.Default.Add, contentDescription = "Add")
                }
            }
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .fillMaxSize()
        ) {
            if (type == "history") {
                OutlinedTextField(
                    value = searchQuery,
                    onValueChange = { searchQuery = it },
                    modifier = Modifier
                        .fillMaxWidth()
                        .padding(16.dp),
                    placeholder = { Text("Cari aktivitas...") },
                    leadingIcon = { Icon(Icons.Default.Search, contentDescription = null) },
                    shape = RoundedCornerShape(12.dp),
                    colors = OutlinedTextFieldDefaults.colors(
                        unfocusedBorderColor = Color.Transparent,
                        focusedBorderColor = DeisaBlue,
                        unfocusedContainerColor = Color.White,
                        focusedContainerColor = Color.White
                    )
                )

                LazyColumn(
                    contentPadding = PaddingValues(horizontal = 16.dp, vertical = 8.dp),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    items(filteredHistory) { log ->
                        Card(
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp),
                            colors = CardDefaults.cardColors(containerColor = Color.White),
                            elevation = CardDefaults.cardElevation(defaultElevation = 1.dp)
                        ) {
                            Column(modifier = Modifier.padding(16.dp)) {
                                Row(verticalAlignment = Alignment.CenterVertically) {
                                    Surface(
                                        color = if (log.action == "CREATE") SuccessGreen.copy(alpha=0.1f) else DeisaBlue.copy(alpha=0.1f),
                                        shape = RoundedCornerShape(4.dp)
                                    ) {
                                        Text(
                                            text = log.action ?: "-",
                                            fontSize = 10.sp,
                                            fontWeight = FontWeight.Bold,
                                            color = if (log.action == "CREATE") SuccessGreen else DeisaBlue,
                                            modifier = Modifier.padding(horizontal = 6.dp, vertical = 2.dp)
                                        )
                                    }
                                    Spacer(modifier = Modifier.width(8.dp))
                                    Text(
                                        text = log.user?.name ?: "System",
                                        fontSize = 12.sp,
                                        color = Slate500
                                    )
                                    Spacer(modifier = Modifier.weight(1f))
                                    Text(
                                        text = log.createdAt ?: "-",
                                        fontSize = 10.sp,
                                        color = Slate500
                                    )
                                }
                                Spacer(modifier = Modifier.height(8.dp))
                                Text(
                                    text = log.description ?: "-",
                                    fontSize = 14.sp,
                                    color = Slate900
                                )
                            }
                        }
                    }
                }
            } else {
                // ... Existing logic for other types can be preserved or simplified ...
                // For brevity, using simple list for now
                val list = when (type) {
                    "kelas" -> kelasList.map { it.namaKelas ?: "" }
                    "jurusan" -> jurusanList.map { it.namaJurusan ?: "" }
                    "diagnosis" -> diagnosisList.map { it.namaPenyakit ?: "" }
                    else -> emptyList()
                }

                LazyColumn(
                    contentPadding = PaddingValues(16.dp),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    items(list) { item ->
                        Card(
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(12.dp),
                            colors = CardDefaults.cardColors(containerColor = Color.White)
                        ) {
                            Row(
                                modifier = Modifier.padding(16.dp),
                                verticalAlignment = Alignment.CenterVertically
                            ) {
                                Text(text = item, modifier = Modifier.weight(1f), fontWeight = FontWeight.Medium)
                                IconButton(onClick = { /* Delete Item */ }) {
                                    Icon(Icons.Default.Delete, contentDescription = "Delete", tint = DangerRed)
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
