package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.HomeViewModel

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SettingsScreen(
    navController: NavHostController,
    viewModel: HomeViewModel = viewModel()
) {
    var threshold by remember { mutableStateOf(viewModel.sickThreshold.toFloat()) }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Settings", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back")
                    }
                }
            )
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(24.dp)
                .fillMaxSize(),
            verticalArrangement = Arrangement.spacedBy(24.dp)
        ) {
            Text(
                "Notification Thresholds",
                style = MaterialTheme.typography.titleMedium,
                fontWeight = FontWeight.Bold,
                color = Slate900
            )

            Card(
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(20.dp),
                colors = CardDefaults.cardColors(containerColor = Color.White),
                elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
            ) {
                Column(modifier = Modifier.padding(16.dp)) {
                    Text(
                        "Sick Outbreak Threshold",
                        fontWeight = FontWeight.Bold,
                        fontSize = 16.sp
                    )
                    Text(
                        "Notifikasi akan muncul jika jumlah santri sakit melebihi atau sama dengan angka ini.",
                        fontSize = 12.sp,
                        color = Slate500
                    )
                    
                    Spacer(modifier = Modifier.height(24.dp))
                    
                    Row(verticalAlignment = Alignment.CenterVertically) {
                        Slider(
                            value = threshold,
                            onValueChange = { threshold = it },
                            valueRange = 1f..10f,
                            steps = 8,
                            modifier = Modifier.weight(1f),
                            colors = SliderDefaults.colors(
                                thumbColor = DeisaBlue,
                                activeTrackColor = DeisaBlue
                            )
                        )
                        Spacer(modifier = Modifier.width(16.dp))
                        Text(
                            text = threshold.toInt().toString(),
                            fontWeight = FontWeight.Bold,
                            fontSize = 20.sp,
                            color = DeisaBlue
                        )
                    }
                }
            }

            Button(
                onClick = {
                    viewModel.setSickThreshold(threshold.toInt())
                    navController.navigateUp()
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(56.dp),
                shape = RoundedCornerShape(12.dp),
                colors = ButtonDefaults.buttonColors(containerColor = DeisaBlue)
            ) {
                Text("SAVE SETTINGS", fontWeight = FontWeight.Bold)
            }
        }
    }
}
