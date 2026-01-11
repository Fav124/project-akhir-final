package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.ExperimentalMaterial3Api
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.DeisaCard
import com.example.deisacompose.ui.components.DeisaTopBar

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ManagementListScreen(navController: NavController) {
    Scaffold(
        topBar = { DeisaTopBar(title = "Manajemen Data") }
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(16.dp)
                .fillMaxSize()
        ) {
            DeisaCard(onClick = { navController.navigate("management_detail/kelas") }) {
                Text("Kelola Kelas")
            }
            DeisaCard(onClick = { navController.navigate("management_detail/jurusan") }) {
                Text("Kelola Jurusan")
            }
            DeisaCard(onClick = { navController.navigate("management_detail/diagnosis") }) {
                Text("Kelola Diagnosis")
            }
        }
    }
}