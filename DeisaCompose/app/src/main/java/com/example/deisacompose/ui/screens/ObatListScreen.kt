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
import com.example.deisacompose.data.models.Obat
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel
import com.example.deisacompose.ui.components.PremiumFilterChip
import com.example.deisacompose.ui.components.PremiumCard
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ObatListScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val obatList by resourceViewModel.obatList.collectAsState()
    val isLoading by resourceViewModel.isLoading.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()

    var searchQuery by remember { mutableStateOf("") }
    var showLowStockOnly by remember { mutableStateOf(false) }

    val isAdmin = currentUser?.role == "admin"

    LaunchedEffect(Unit) {
        resourceViewModel.loadObat()
    }

    LaunchedEffect(searchQuery, showLowStockOnly) {
        delay(300)
        resourceViewModel.loadObat(
            search = searchQuery.ifBlank { null },
            lowStock = if (showLowStockOnly) true else null
        )
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Inventaris Obat", fontWeight = FontWeight.ExtraBold) },
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
                onClick = { navController.navigate("obat_add") },
                containerColor = Color(0xFF0B63D6),
                contentColor = Color.White,
                shape = RoundedCornerShape(16.dp)
            ) {
                Icon(Icons.Default.Add, "Tambah Obat")
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
                    placeholder = { Text("Cari nama obat...") },
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

                PremiumFilterChip(
                    selected = showLowStockOnly,
                    onClick = { showLowStockOnly = !showLowStockOnly },
                    label = "Stok Menipis",
                    activeColor = Color(0xFFEF4444)
                )
            }

            // Content
            when {
                isLoading && obatList.isEmpty() -> {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        CircularProgressIndicator(strokeWidth = 3.dp, color = Color(0xFF0B63D6))
                    }
                }
                obatList.isEmpty() -> {
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
                                "Tidak ada data obat",
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
                        items(obatList) { obat ->
                            ObatCard(
                                obat = obat,
                                onClick = { navController.navigate("obat_detail/${obat.id}") },
                                onRestock = {
                                    // TODO: Show restock dialog
                                },
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
fun ObatCard(
    obat: Obat,
    onClick: () -> Unit,
    onRestock: () -> Unit,
    isAdmin: Boolean
) {
    val statusColor = if (obat.is_low_stock) Color(0xFFEF4444) else Color(0xFF10B981)
    
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
                        text = obat.nama_obat,
                        style = MaterialTheme.typography.titleLarge,
                        fontWeight = FontWeight.ExtraBold,
                        color = Color(0xFF1E293B)
                    )
                    Text(
                        text = "Jenis: ${obat.jenis}",
                        style = MaterialTheme.typography.bodyMedium,
                        color = Color.Gray
                    )
                }
                
                if (obat.is_low_stock) {
                    Surface(
                        color = statusColor.copy(alpha = 0.1f),
                        contentColor = statusColor,
                        shape = RoundedCornerShape(8.dp)
                    ) {
                        Row(
                            modifier = Modifier.padding(horizontal = 8.dp, vertical = 4.dp),
                            verticalAlignment = Alignment.CenterVertically
                        ) {
                            Icon(Icons.Default.Warning, null, modifier = Modifier.size(12.dp))
                            Spacer(modifier = Modifier.width(4.dp))
                            Text(
                                text = "STOK RENDAH",
                                style = MaterialTheme.typography.labelSmall,
                                fontWeight = FontWeight.Black
                            )
                        }
                    }
                }
            }

            Spacer(modifier = Modifier.height(16.dp))
            
            Divider(color = Color.Gray.copy(alpha = 0.1f))
            
            Spacer(modifier = Modifier.height(16.dp))

            Row(
                modifier = Modifier.fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Column {
                    Text(
                        text = "${obat.stok} ${obat.satuan}",
                        style = MaterialTheme.typography.headlineSmall,
                        fontWeight = FontWeight.Bold,
                        color = Color(0xFF334155)
                    )
                    Text(
                        text = "Stok Tersedia",
                        style = MaterialTheme.typography.labelMedium,
                        color = Color.Gray
                    )
                }
                
                Button(
                    onClick = onRestock,
                    shape = RoundedCornerShape(12.dp),
                    colors = ButtonDefaults.buttonColors(
                        containerColor = Color(0xFF0B63D6).copy(alpha = 0.1f),
                        contentColor = Color(0xFF0B63D6)
                    ),
                    modifier = Modifier.height(40.dp)
                ) {
                    Icon(Icons.Default.Add, null, modifier = Modifier.size(16.dp))
                    Spacer(modifier = Modifier.width(4.dp))
                    Text("Tambah", fontWeight = FontWeight.Bold)
                }
            }
        }
    }
}
