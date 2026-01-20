package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.filled.Medication
import androidx.compose.material.icons.filled.People
import androidx.compose.material.icons.filled.TrendingUp
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.LaporanViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun LaporanScreen(
    navController: NavHostController,
    viewModel: LaporanViewModel = viewModel()
) {
    val laporanData by viewModel.laporanData.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)

    LaunchedEffect(Unit) {
        viewModel.fetchLaporan()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { 
                    Text(
                        "Laporan & Statistik",
                        fontWeight = FontWeight.Bold,
                        style = MaterialTheme.typography.titleLarge
                    ) 
                },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(containerColor = Color.White)
            )
        },
        containerColor = Slate50
    ) { padding ->
        if (isLoading) {
            Column(
                modifier = Modifier
                    .padding(padding)
                    .fillMaxSize()
                    .padding(16.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                repeat(3) {
                    CardSkeleton()
                }
                ListSkeleton(itemCount = 3)
            }
        } else {
            Column(
                modifier = Modifier
                    .padding(padding)
                    .padding(16.dp)
                    .fillMaxSize()
                    .verticalScroll(rememberScrollState()),
                verticalArrangement = Arrangement.spacedBy(20.dp)
            ) {
                laporanData?.let { data ->
                    // Summary Cards Row
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        SummaryCard(
                            value = data.summary.totalSakit,
                            title = "Total Kasus",
                            icon = Icons.Default.TrendingUp,
                            color = DeisaBlue,
                            modifier = Modifier.weight(1f)
                        )
                        SummaryCard(
                            value = data.summary.currentlySick,
                            title = "Sedang Sakit",
                            icon = Icons.Default.People,
                            color = DangerRed,
                            modifier = Modifier.weight(1f)
                        )
                    }
                    
                    SummaryCard(
                        value = data.summary.uniqueSantriSakit,
                        title = "Santri Pernah Sakit",
                        icon = Icons.Default.People,
                        color = WarningOrange,
                        modifier = Modifier.fillMaxWidth()
                    )

                    // Breakdown by Tingkat (Pie Chart)
                    val tingkatData = listOf(
                        "Ringan" to data.summary.byTingkat.ringan.toFloat(),
                        "Sedang" to data.summary.byTingkat.sedang.toFloat(),
                        "Berat" to data.summary.byTingkat.berat.toFloat()
                    ).filter { it.second > 0 }
                    
                    if (tingkatData.isNotEmpty()) {
                        PieChartPlaceholder(
                            title = "Distribusi Kasus Berdasarkan Tingkat",
                            data = tingkatData
                        )
                    }

                    // Top 5 Obat (Bar Chart)
                    val topObatData = data.topObat.take(5).map { obat ->
                        obat.namaObat to obat.timesUsed.toFloat()
                    }
                    
                    if (topObatData.isNotEmpty()) {
                        BarChartCard(
                            title = "Top 5 Obat Paling Banyak Digunakan",
                            data = topObatData,
                            color = SuccessGreen
                        )
                    }

                    // Monthly Trend Line Chart
                    data.monthlyTrend?.let { trend ->
                        if (trend.isNotEmpty()) {
                            val trendData = trend.map { it.month to it.count.toFloat() }
                            LineChartCard(
                                title = "Trend Kasus Sakit (6 Bulan Terakhir)",
                                data = trendData,
                                color = DeisaBlue
                            )
                        }
                    }
                    if (data.topSantri.isNotEmpty()) {
                        Card(
                            modifier = Modifier.fillMaxWidth(),
                            shape = androidx.compose.foundation.shape.RoundedCornerShape(16.dp),
                            colors = CardDefaults.cardColors(containerColor = Color.White),
                            elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
                        ) {
                            Column(
                                modifier = Modifier.padding(16.dp)
                            ) {
                                Text(
                                    text = "Top 10 Santri Paling Sering Sakit",
                                    style = MaterialTheme.typography.titleMedium,
                                    fontWeight = FontWeight.Bold,
                                    color = Slate900
                                )
                                
                                Spacer(modifier = Modifier.height(16.dp))
                                
                                data.topSantri.take(10).forEachIndexed { index, santri ->
                                    Row(
                                        modifier = Modifier
                                            .fillMaxWidth()
                                            .padding(vertical = 8.dp),
                                        horizontalArrangement = Arrangement.SpaceBetween,
                                        verticalAlignment = Alignment.CenterVertically
                                    ) {
                                        Row(
                                            verticalAlignment = Alignment.CenterVertically,
                                            horizontalArrangement = Arrangement.spacedBy(12.dp)
                                        ) {
                                            Surface(
                                                shape = androidx.compose.foundation.shape.CircleShape,
                                                color = DeisaBlue.copy(alpha = 0.1f),
                                                modifier = Modifier.size(32.dp)
                                            ) {
                                                Box(contentAlignment = Alignment.Center) {
                                                    Text(
                                                        text = "${index + 1}",
                                                        color = DeisaBlue,
                                                        fontWeight = FontWeight.Bold,
                                                        fontSize = 14.sp
                                                    )
                                                }
                                            }
                                            Column {
                                                Text(
                                                    text = santri.namaLengkap,
                                                    style = MaterialTheme.typography.bodyMedium,
                                                    fontWeight = FontWeight.Medium,
                                                    color = Slate900
                                                )
                                                santri.nis?.let {
                                                    Text(
                                                        text = "NIS: $it",
                                                        style = MaterialTheme.typography.bodySmall,
                                                        color = Slate500
                                                    )
                                                }
                                            }
                                        }
                                        Surface(
                                            shape = androidx.compose.foundation.shape.RoundedCornerShape(12.dp),
                                            color = DangerRed.copy(alpha = 0.1f)
                                        ) {
                                            Text(
                                                text = "${santri.sakitCount}x",
                                                modifier = Modifier.padding(horizontal = 12.dp, vertical = 6.dp),
                                                color = DangerRed,
                                                fontWeight = FontWeight.Bold,
                                                fontSize = 14.sp
                                            )
                                        }
                                    }
                                    
                                    if (index < data.topSantri.take(10).size - 1) {
                                        HorizontalDivider(
                                            modifier = Modifier.padding(vertical = 4.dp),
                                            color = Slate100
                                        )
                                    }
                                }
                            }
                        }
                    }
                } ?: run {
                    // Empty state
                    Box(
                        modifier = Modifier
                            .fillMaxSize()
                            .padding(32.dp),
                        contentAlignment = Alignment.Center
                    ) {
                        Column(
                            horizontalAlignment = Alignment.CenterHorizontally,
                            verticalArrangement = Arrangement.spacedBy(16.dp)
                        ) {
                            Icon(
                                Icons.Default.TrendingUp,
                                contentDescription = null,
                                modifier = Modifier.size(64.dp),
                                tint = Slate500
                            )
                            Text(
                                text = "Tidak ada data laporan",
                                color = Slate500,
                                style = MaterialTheme.typography.bodyLarge
                            )
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SummaryCard(
    value: Int,
    title: String,
    icon: androidx.compose.ui.graphics.vector.ImageVector,
    color: Color,
    modifier: Modifier = Modifier
) {
    Card(
        modifier = modifier,
        shape = androidx.compose.foundation.shape.RoundedCornerShape(20.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 4.dp)
    ) {
        Column(
            modifier = Modifier.padding(16.dp),
            verticalArrangement = Arrangement.spacedBy(12.dp)
        ) {
            Surface(
                shape = androidx.compose.foundation.shape.RoundedCornerShape(12.dp),
                color = color.copy(alpha = 0.1f),
                modifier = Modifier.size(48.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(icon, contentDescription = null, tint = color, modifier = Modifier.size(24.dp))
                }
            }
            Text(
                text = value.toString(),
                color = color,
                fontSize = 28.sp,
                fontWeight = FontWeight.Bold
            )
            Text(
                text = title,
                color = Slate500,
                fontSize = 12.sp,
                style = MaterialTheme.typography.bodySmall
            )
        }
    }
}
