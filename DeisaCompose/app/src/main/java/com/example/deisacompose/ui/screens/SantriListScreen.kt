package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
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
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.data.models.Santri
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriListScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: AuthViewModel = viewModel()
) {
    val santriList by resourceViewModel.santriList.collectAsState()
    val kelasList by resourceViewModel.kelasList.collectAsState()
    val jurusanList by resourceViewModel.jurusanList.collectAsState()
    val isLoading by resourceViewModel.isLoading.collectAsState()
    val currentUser by authViewModel.currentUser.collectAsState()

    var searchQuery by remember { mutableStateOf("") }
    var selectedKelas by remember { mutableStateOf<Int?>(null) }
    var selectedJurusan by remember { mutableStateOf<Int?>(null) }
    var showFilterDialog by remember { mutableStateOf(false) }

    val isAdmin = currentUser?.role == "admin"

    LaunchedEffect(Unit) {
        resourceViewModel.loadSantri()
        resourceViewModel.loadKelas()
        resourceViewModel.loadJurusan()
    }

    LaunchedEffect(searchQuery, selectedKelas, selectedJurusan) {
        delay(300)
        resourceViewModel.loadSantri(
            search = searchQuery.ifBlank { null },
            kelasId = selectedKelas,
            jurusanId = selectedJurusan
        )
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Database Santri", fontWeight = FontWeight.ExtraBold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, "Kembali")
                    }
                },
                actions = {
                    IconButton(onClick = { showFilterDialog = true }) {
                        Box {
                            Icon(Icons.Default.FilterList, "Filter")
                            if (selectedKelas != null || selectedJurusan != null) {
                                Box(
                                    modifier = Modifier
                                        .size(10.dp)
                                        .clip(CircleShape)
                                        .background(Color(0xFFEF4444))
                                        .align(Alignment.TopEnd)
                                )
                            }
                        }
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(
                    containerColor = MaterialTheme.colorScheme.background
                )
            )
        },
        floatingActionButton = {
            if (isAdmin) {
                FloatingActionButton(
                    onClick = { navController.navigate("santri_add") },
                    containerColor = Color(0xFF0B63D6),
                    contentColor = Color.White,
                    shape = RoundedCornerShape(16.dp)
                ) {
                    Icon(Icons.Default.Add, "Tambah Santri")
                }
            }
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .background(MaterialTheme.colorScheme.background)
                .padding(padding)
        ) {
            // Search Bar
            OutlinedTextField(
                value = searchQuery,
                onValueChange = { searchQuery = it },
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(16.dp),
                placeholder = { Text("Cari nama atau NIS...") },
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

            // Content
            when {
                isLoading && santriList.isEmpty() -> {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        CircularProgressIndicator(strokeWidth = 3.dp, color = Color(0xFF0B63D6))
                    }
                }
                santriList.isEmpty() -> {
                    Box(
                        modifier = Modifier.fillMaxSize(),
                        contentAlignment = Alignment.Center
                    ) {
                        Column(horizontalAlignment = Alignment.CenterHorizontally) {
                            Icon(
                                Icons.Default.Groups,
                                contentDescription = null,
                                modifier = Modifier.size(80.dp),
                                tint = MaterialTheme.colorScheme.outline.copy(alpha = 0.3f)
                            )
                            Spacer(modifier = Modifier.height(16.dp))
                            Text(
                                "Tidak ada data santri",
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
                        items(santriList) { santri ->
                            SantriCard(
                                santri = santri,
                                onClick = { navController.navigate("santri_detail/${santri.id}") },
                                isAdmin = isAdmin
                            )
                        }
                        item { Spacer(modifier = Modifier.height(80.dp)) }
                    }
                }
            }
        }
    }

    // Filter Dialog (Simplified for brevity, but could be enhanced)
    if (showFilterDialog) {
        AlertDialog(
            onDismissRequest = { showFilterDialog = false },
            title = { Text("Filter Berdasarkan", fontWeight = FontWeight.Bold) },
            text = {
                Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                    Text("Kelas", style = MaterialTheme.typography.labelLarge, color = Color.Gray)
                    FlowRow(mainAxisSpacing = 8.dp, crossAxisSpacing = 8.dp) {
                        PremiumFilterChip(
                            selected = selectedKelas == null,
                            onClick = { selectedKelas = null },
                            label = "Semua"
                        )
                        kelasList.forEach { kelas ->
                            PremiumFilterChip(
                                selected = selectedKelas == kelas.id,
                                onClick = { selectedKelas = kelas.id },
                                label = kelas.nama_kelas
                            )
                        }
                    }
                }
            },
            confirmButton = {
                TextButton(onClick = { showFilterDialog = false }) {
                    Text("Terapkan", fontWeight = FontWeight.Bold, color = Color(0xFF0B63D6))
                }
            }
        )
    }
}

@Composable
fun FlowRow(
    mainAxisSpacing: androidx.compose.ui.unit.Dp,
    crossAxisSpacing: androidx.compose.ui.unit.Dp,
    content: @Composable () -> Unit
) {
    androidx.compose.ui.layout.Layout(content) { measurables, constraints ->
        val chipSpacing = mainAxisSpacing.roundToPx()
        val lineSpacing = crossAxisSpacing.roundToPx()
        val placeables = measurables.map { it.measure(constraints.copy(minWidth = 0)) }
        
        layout(constraints.maxWidth, constraints.maxHeight) {
            var x = 0
            var y = 0
            var lineHeight = 0
            
            placeables.forEach { placeable ->
                if (x + placeable.width > constraints.maxWidth) {
                    x = 0
                    y += lineHeight + lineSpacing
                    lineHeight = 0
                }
                placeable.place(x, y)
                x += placeable.width + chipSpacing
                lineHeight = maxOf(lineHeight, placeable.height)
            }
        }
    }
}

@Composable
fun SantriCard(
    santri: Santri,
    onClick: () -> Unit,
    isAdmin: Boolean
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.fillMaxWidth(),
        onClick = onClick,
        accentColor = Color(0xFF0B63D6)
    ) {
        Row(
            verticalAlignment = Alignment.CenterVertically
        ) {
            // Premium Avatar
            Box(
                modifier = Modifier
                    .size(60.dp)
                    .clip(RoundedCornerShape(16.dp))
                    .background(
                        Brush.linearGradient(
                            colors = listOf(Color(0xFF0B63D6).copy(alpha = 0.1f), Color(0xFF0B63D6).copy(alpha = 0.05f))
                        )
                    )
                    .border(1.dp, Color(0xFF0B63D6).copy(alpha = 0.1f), RoundedCornerShape(16.dp)),
                contentAlignment = Alignment.Center
            ) {
                Text(
                    text = santri.nama_lengkap.take(1).uppercase(),
                    style = MaterialTheme.typography.headlineSmall,
                    fontWeight = FontWeight.Bold,
                    color = Color(0xFF0B63D6)
                )
            }

            Spacer(modifier = Modifier.width(16.dp))

            Column(modifier = Modifier.weight(1f)) {
                Text(
                    text = santri.nama_lengkap,
                    style = MaterialTheme.typography.titleLarge,
                    fontWeight = FontWeight.ExtraBold,
                    color = Color(0xFF1E293B)
                )
                Text(
                    text = "NIS: ${santri.nis}",
                    style = MaterialTheme.typography.bodyMedium,
                    color = Color.Gray
                )
                
                Spacer(modifier = Modifier.height(8.dp))
                
                Row(horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                    santri.kelas?.let {
                        Surface(
                            color = Color(0xFFF1F5F9),
                            shape = RoundedCornerShape(6.dp)
                        ) {
                            Text(
                                text = it.nama_kelas,
                                modifier = Modifier.padding(horizontal = 6.dp, vertical = 2.dp),
                                style = MaterialTheme.typography.labelSmall,
                                fontWeight = FontWeight.Bold,
                                color = Color(0xFF475569)
                            )
                        }
                    }
                    santri.jurusan?.let {
                        Surface(
                            color = Color(0xFFF1F5F9),
                            shape = RoundedCornerShape(6.dp)
                        ) {
                            Text(
                                text = it.nama_jurusan,
                                modifier = Modifier.padding(horizontal = 6.dp, vertical = 2.dp),
                                style = MaterialTheme.typography.labelSmall,
                                fontWeight = FontWeight.Bold,
                                color = Color(0xFF475569)
                            )
                        }
                    }
                }
            }

            Icon(
                Icons.Default.ChevronRight,
                contentDescription = null,
                tint = Color.Gray.copy(alpha = 0.5f)
            )
        }
    }
}
