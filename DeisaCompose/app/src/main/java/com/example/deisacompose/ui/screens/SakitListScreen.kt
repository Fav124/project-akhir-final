package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel
import com.example.deisacompose.ui.components.PremiumFilterChip
import com.example.deisacompose.ui.components.PremiumCard
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitListScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val sakitList by resourceViewModel.sakitList.collectAsState()
    val isLoading by resourceViewModel.isLoading.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()

    var searchQuery by remember { mutableStateOf("") }
    var statusFilter by remember { mutableStateOf<String?>(null) }

    val isAdmin = currentUser?.role == "admin"

    LaunchedEffect(Unit) {
        resourceViewModel.loadSakit()
    }

    LaunchedEffect(searchQuery, statusFilter) {
        delay(300)
        resourceViewModel.loadSakit(
            status = statusFilter,
            search = searchQuery.ifBlank { null }
        )
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Kesehatan Santri", fontWeight = FontWeight.ExtraBold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, "Kembali")
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(
                    containerColor = MaterialTheme.colorScheme.background
                )
            )
        },
        floatingActionButton = {
            FloatingActionButton(
                onClick = { navController.navigate("sakit_add") },
                containerColor = Color(0xFF0B63D6),
                contentColor = Color.White,
                shape = RoundedCornerShape(16.dp)
            ) {
                Icon(Icons.Default.Add, "Tambah Data Sakit")
            }
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .background(MaterialTheme.colorScheme.background)
                .padding(padding)
        ) {
            // Search & Filter Section
            Column(
                modifier = Modifier.padding(16.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                OutlinedTextField(
                    value = searchQuery,
                    onValueChange = { searchQuery = it },
                    modifier = Modifier.fillMaxWidth(),
                    placeholder = { Text("Cari nama santri...") },
                    leadingIcon = { Icon(Icons.Default.Search, null, tint = Color(0xFF0B63D6)) },
                    trailingIcon = {
                        if (searchQuery.isNotEmpty()) {
                            IconButton(onClick = { searchQuery = "" }) {
                                Icon(Icons.Default.Close, "Clear")
                            }
                        }
                    },
                    singleLine = true,
                    shape = RoundedCornerShape(20.dp),
                    colors = OutlinedTextFieldDefaults.colors(
                        focusedBorderColor = Color(0xFF0B63D6),
                        unfocusedBorderColor = Color.Gray.copy(alpha = 0.3f),
                        unfocusedContainerColor = Color.White,
                        focusedContainerColor = Color.White
                    )
                )

                Row(
                    horizontalArrangement = Arrangement.spacedBy(8.dp),
                    modifier = Modifier.fillMaxWidth()
                ) {
                    PremiumFilterChip(
                        selected = statusFilter == null,
                        onClick = { statusFilter = null },
                        label = "Semua"
                    )
                    PremiumFilterChip(
                        selected = statusFilter == "Sakit",
                        onClick = { statusFilter = "Sakit" },
                        label = "Sakit",
                        activeColor = Color(0xFFEF4444)
                    )
                    PremiumFilterChip(
                        selected = statusFilter == "Sembuh",
                        onClick = { statusFilter = "Sembuh" },
                        label = "Sembuh",
                        activeColor = Color(0xFF10B981)
                    )
                }
            }

            // Content
            when {
                isLoading && sakitList.isEmpty() -> {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        CircularProgressIndicator(strokeWidth = 3.dp, color = Color(0xFF0B63D6))
                    }
                }
                sakitList.isEmpty() -> {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        Column(horizontalAlignment = Alignment.CenterHorizontally) {
                            Icon(
                                Icons.Default.Inventory2,
                                contentDescription = null,
                                modifier = Modifier.size(80.dp),
                                tint = MaterialTheme.colorScheme.outline.copy(alpha = 0.3f)
                            )
                            Spacer(modifier = Modifier.height(16.dp))
                            Text(
                                "Tidak ada rekaman kesehatan",
                                style = MaterialTheme.typography.bodyLarge,
                                color = MaterialTheme.colorScheme.onSurfaceVariant
                            )
                        }
                    }
                }
                else -> {
                    LazyColumn(
                        contentPadding = PaddingValues(16.dp),
                        verticalArrangement = Arrangement.spacedBy(16.dp)
                    ) {
                        items(sakitList) { sakit ->
                            SakitCard(
                                sakit = sakit,
                                onClick = { navController.navigate("sakit_detail/${sakit.id}") },
                                isAdmin = isAdmin
                            )
                        }
                        item { Spacer(modifier = Modifier.height(80.dp)) }
                    }
                }
            }
        }
    }
}

@Composable
fun PremiumFilterChip(
    selected: Boolean,
    onClick: () -> Unit,
    label: String,
    activeColor: Color = Color(0xFF0B63D6)
) {
    Surface(
        onClick = onClick,
        color = if (selected) activeColor else Color.White,
        contentColor = if (selected) Color.White else Color.Gray,
        shape = RoundedCornerShape(12.dp),
        border = if (selected) null else androidx.compose.foundation.BorderStroke(1.dp, Color.Gray.copy(alpha = 0.2f)),
        shadowElevation = if (selected) 4.dp else 0.dp
    ) {
        Text(
            text = label,
            modifier = Modifier.padding(horizontal = 16.dp, vertical = 8.dp),
            style = MaterialTheme.typography.labelLarge,
            fontWeight = if (selected) FontWeight.Bold else FontWeight.Medium
        )
    }
}

@Composable
fun SakitCard(
    sakit: Sakit,
    onClick: () -> Unit,
    isAdmin: Boolean
) {
    val statusColor = if (sakit.status == "Sakit") Color(0xFFEF4444) else Color(0xFF10B981)
    
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.fillMaxWidth(),
        onClick = onClick,
        accentColor = statusColor
    ) {
        Column {
            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.Top
            ) {
                Column(modifier = Modifier.weight(1f)) {
                    Text(
                        text = sakit.santri.nama_lengkap,
                        style = MaterialTheme.typography.titleLarge,
                        fontWeight = FontWeight.ExtraBold,
                        color = Color(0xFF1E293B)
                    )
                    Text(
                        text = "Kelas: ${sakit.santri.kelas?.nama_kelas ?: "-"}",
                        style = MaterialTheme.typography.bodyMedium,
                        color = Color.Gray
                    )
                }
                
                Surface(
                    color = statusColor.copy(alpha = 0.1f),
                    contentColor = statusColor,
                    shape = RoundedCornerShape(8.dp)
                ) {
                    Text(
                        text = sakit.status.uppercase(),
                        modifier = Modifier.padding(horizontal = 8.dp, vertical = 4.dp),
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black
                    )
                }
            }

            Spacer(modifier = Modifier.height(16.dp))
            
            Divider(color = Color.Gray.copy(alpha = 0.1f))
            
            Spacer(modifier = Modifier.height(16.dp))

            Row(verticalAlignment = Alignment.CenterVertically) {
                Icon(
                    Icons.Default.Sick,
                    contentDescription = null,
                    modifier = Modifier.size(20.dp),
                    tint = Color(0xFF0B63D6)
                )
                Spacer(modifier = Modifier.width(12.dp))
                Column {
                    Text(
                        text = sakit.diagnosis_utama,
                        style = MaterialTheme.typography.bodyLarge,
                        fontWeight = FontWeight.Bold,
                        color = Color(0xFF334155)
                    )
                    sakit.keluhan?.let {
                        Text(
                            text = it,
                            style = MaterialTheme.typography.bodySmall,
                            color = Color.Gray
                        )
                    }
                }
            }

            Spacer(modifier = Modifier.height(16.dp))

            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Icon(
                        Icons.Default.Event,
                        contentDescription = null,
                        modifier = Modifier.size(16.dp),
                        tint = Color.Gray
                    )
                    Spacer(modifier = Modifier.width(4.dp))
                    Text(
                        text = sakit.tanggal_masuk_human ?: "-",
                        style = MaterialTheme.typography.bodySmall,
                        color = Color.Gray
                    )
                }
                
                Icon(
                    Icons.Default.ChevronRight,
                    contentDescription = null,
                    tint = Color.Gray.copy(alpha = 0.5f)
                )
            }
        }
    }
}
