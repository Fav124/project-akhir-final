package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.LaporanViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun LaporanScreen(
    navController: NavController,
    viewModel: LaporanViewModel = viewModel()
) {
    var startDate by remember { mutableStateOf("") }
    var endDate by remember { mutableStateOf("") }
    
    val data by viewModel.laporanData.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)

    Scaffold(
        topBar = { DeisaTopBar("Laporan & Statistik") }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .verticalScroll(rememberScrollState())
        ) {
            // Date Filter Section
            DeisaCard {
                Column {
                    Text("Filter Periode", style = MaterialTheme.typography.titleSmall)
                    Spacer(modifier = Modifier.height(8.dp))
                    
                    DeisaDatePickerField(
                        value = startDate, 
                        onValueChange = { startDate = it },
                        label = "Tanggal Mulai"
                    )
                    Spacer(modifier = Modifier.height(8.dp))
                    
                    DeisaDatePickerField(
                        value = endDate, 
                        onValueChange = { endDate = it },
                        label = "Tanggal Akhir"
                    )
                    
                    Spacer(modifier = Modifier.height(16.dp))
                    DeisaButton(
                        text = "Tampilkan Laporan",
                        onClick = { viewModel.fetchReport(startDate, endDate) },
                        modifier = Modifier.fillMaxWidth(),
                        isLoading = isLoading
                    )
                }
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            if (data != null) {
                Text("Ringkasan Statistik", style = MaterialTheme.typography.titleMedium)
                Spacer(modifier = Modifier.height(12.dp))
                
                Row(horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                     StatsCard("${data!!.summary.totalSakit}", "Total Sakit", Color(0xFFE8F5E9), Modifier.weight(1f))
                     StatsCard("${data!!.summary.uniqueSantriSakit}", "Santri Unik", Color(0xFFFFF3E0), Modifier.weight(1f))
                }
                
                Spacer(modifier = Modifier.height(24.dp))
                Text("Santri Paling Sering Sakit", style = MaterialTheme.typography.titleMedium)
                Spacer(modifier = Modifier.height(8.dp))
                
                data!!.topSantri.forEach { santri ->
                    DeisaCard {
                        Row(horizontalArrangement = Arrangement.SpaceBetween, modifier = Modifier.fillMaxWidth()) {
                            Text(santri.namaLengkap)
                            DeisaBadge(
                                text = "${santri.sakitCount}x",
                                containerColor = Color(0xFFFFEBEE),
                                contentColor = Color.Red
                            )
                        }
                    }
                }
            }
        }
    }
}
