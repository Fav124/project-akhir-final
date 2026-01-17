package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
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
                title = { Text("Laporan & Statistik", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        containerColor = Slate50
    ) { padding ->
        if (isLoading) {
            Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                CircularProgressIndicator(color = DeisaBlue)
            }
        } else {
            Column(
                modifier = Modifier
                    .padding(padding)
                    .padding(16.dp)
                    .fillMaxSize()
                    .verticalScroll(rememberScrollState()),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                laporanData?.let { data ->
                    SummaryCard(data.summary.totalSakit, "Total Kasus Sakit", DeisaBlue)
                    SummaryCard(data.summary.currentlySick, "Sedang Sakit", DangerRed)
                    SummaryCard(data.summary.uniqueSantriSakit, "Santri Pernah Sakit", WarningOrange)

                    Spacer(modifier = Modifier.height(16.dp))
                    Text("Top 5 Penyakit", fontWeight = FontWeight.Bold, fontSize = 18.sp, color = Slate900)
                    
                    // Visual Mockup of Top Diseases
                    Card(
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(16.dp),
                        colors = CardDefaults.cardColors(containerColor = Color.White)
                    ) {
                        Column(modifier = Modifier.padding(16.dp)) {
                            listOf("Demam", "Flu", "Batuk", "Pusing", "Maag").forEach { disease ->
                                Row(
                                    modifier = Modifier
                                        .fillMaxWidth()
                                        .padding(vertical = 8.dp),
                                    horizontalArrangement = Arrangement.SpaceBetween
                                ) {
                                    Text(disease, color = Slate700)
                                    Icon(Icons.Default.TrendingUp, null, tint = SuccessGreen)
                                }
                                Divider(color = Slate100)
                            }
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SummaryCard(value: Int, title: String, color: Color) {
    Card(
        modifier = Modifier.fillMaxWidth(),
        shape = RoundedCornerShape(20.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Row(
            modifier = Modifier.padding(20.dp),
            verticalAlignment = Alignment.CenterVertically
        ) {
            Column(modifier = Modifier.weight(1f)) {
                Text(text = title, color = Slate500, fontSize = 14.sp)
                Text(text = value.toString(), color = color, fontSize = 32.sp, fontWeight = FontWeight.Bold)
            }
            Surface(
                shape = RoundedCornerShape(12.dp),
                color = color.copy(alpha = 0.1f),
                modifier = Modifier.size(56.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(Icons.Default.TrendingUp, contentDescription = null, tint = color)
                }
            }
        }
    }
}
