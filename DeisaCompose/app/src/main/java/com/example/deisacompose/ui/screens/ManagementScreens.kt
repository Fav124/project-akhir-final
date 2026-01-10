package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.*
import com.example.deisacompose.viewmodels.ManagementViewModel

// Generic Management List Screen
@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ManagementScreen(
    navController: NavController,
    type: String, // "users", "kelas", "jurusan", "diagnosis", "history"
    viewModel: ManagementViewModel = viewModel()
) {
    val title = type.replaceFirstChar { it.uppercase() }
    
    // States observing
    val users by viewModel.userList.observeAsState(emptyList())
    val kelas by viewModel.kelasList.observeAsState(emptyList())
    val jurusan by viewModel.jurusanList.observeAsState(emptyList())
    val diagnosis by viewModel.diagnosisList.observeAsState(emptyList())
    val history by viewModel.historyList.observeAsState(emptyList())

    LaunchedEffect(type) {
        when(type) {
            "users" -> viewModel.fetchUsers()
            "kelas" -> viewModel.fetchKelas()
            "jurusan" -> viewModel.fetchJurusan()
            "diagnosis" -> viewModel.fetchDiagnosis()
            "history" -> viewModel.fetchHistory()
        }
    }

    Scaffold(
        topBar = { DeisaTopBar("Manage $title") },
        floatingActionButton = {
            if (type != "history") {
                DeisaFab(onClick = { /* Add Dialog */ })
            }
        }
    ) { padding ->
         Box(modifier = Modifier.padding(padding)) {
             LazyColumn(modifier = Modifier.padding(16.dp)) {
                 when(type) {
                     "users" -> items(users) { user ->
                         DeisaCard { 
                             Text(user.name, style = MaterialTheme.typography.titleMedium)
                             Text(user.email, style = MaterialTheme.typography.bodySmall)
                             Text("Role: ${if(user.isAdmin) "Admin" else "User"}", color = Color.Gray)
                         }
                     }
                     "kelas" -> items(kelas) { k ->
                         DeisaCard { Text(k.namaKelas ?: "-") }
                     }
                     "jurusan" -> items(jurusan) { j ->
                         DeisaCard { Text(j.namaJurusan ?: "-") }
                     }
                     "diagnosis" -> items(diagnosis) { d ->
                         DeisaCard { Text(d.namaPenyakit ?: "-") }
                     }
                     "history" -> items(history) { h ->
                         DeisaCard {
                             Text(h.action ?: "-", style = MaterialTheme.typography.titleSmall)
                             Text(h.description ?: "", style = MaterialTheme.typography.bodyMedium)
                             Text(h.createdAt ?: "", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                             Text("By: ${h.user?.name ?: "System"}", style = MaterialTheme.typography.bodySmall, color = Color.Blue)
                         }
                     }
                 }
             }
         }
    }
}
