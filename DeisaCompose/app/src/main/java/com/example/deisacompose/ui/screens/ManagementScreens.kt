package com.example.deisacompose.ui.screens

import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
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
    
    // Dialog States
    var showDialog by remember { mutableStateOf(false) }
    var editId by remember { mutableStateOf<Int?>(null) } // Generic ID handling logic is complex here, let's keep it simple: Add only for now or simple prompt
    
    // Inputs
    var inputName by remember { mutableStateOf("") }
    var inputDesc by remember { mutableStateOf("") }

    LaunchedEffect(type) {
        when(type) {
            "users" -> viewModel.fetchUsers() // Usually strictly managed, but listing is fine
            "kelas" -> viewModel.fetchKelas()
            "jurusan" -> viewModel.fetchJurusan()
            "diagnosis" -> viewModel.fetchDiagnosis()
            "history" -> viewModel.fetchHistory()
        }
    }

    Scaffold(
        topBar = { DeisaTopBar("Manage $title") },
        floatingActionButton = {
            if (type != "history" && type != "users") { // Users managed via Registration
                DeisaFab(onClick = { 
                    inputName = ""
                    inputDesc = ""
                    showDialog = true 
                })
            }
        }
    ) { padding ->
         Box(modifier = Modifier.padding(padding)) {
             LazyColumn(modifier = Modifier.padding(16.dp)) {
                 when(type) {
                     "users" -> items(users) { user ->
                         DeisaCard { 
                             Row(horizontalArrangement = Arrangement.SpaceBetween, modifier = Modifier.fillMaxWidth()) {
                                 Column {
                                     Text(user.name, style = MaterialTheme.typography.titleMedium)
                                     Text(user.email, style = MaterialTheme.typography.bodySmall)
                                 }
                                 IconButton(onClick = { viewModel.deleteUser(user.id) }) {
                                     Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
                                 }
                             }
                         }
                     }
                     "kelas" -> items(kelas) { k ->
                         DeisaCard {
                             Row(horizontalArrangement = Arrangement.SpaceBetween, modifier = Modifier.fillMaxWidth()) {
                                 Text(k.namaKelas ?: "-")
                                 IconButton(onClick = { viewModel.deleteKelas(k.id) }) {
                                     Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
                                 }
                             }
                         }
                     }
                     "jurusan" -> items(jurusan) { j ->
                         DeisaCard {
                             Row(horizontalArrangement = Arrangement.SpaceBetween, modifier = Modifier.fillMaxWidth()) {
                                 Text(j.namaJurusan ?: "-")
                                  IconButton(onClick = { viewModel.deleteJurusan(j.id) }) {
                                     Icon(Icons.Default.Delete, contentDescription = "Delete", tint = Color.Red)
                                 }
                             }
                         }
                     }
                     "diagnosis" -> items(diagnosis) { d ->
                         DeisaCard {
                             Row(horizontalArrangement = Arrangement.SpaceBetween, modifier = Modifier.fillMaxWidth()) {
                                 Column {
                                    Text(d.namaPenyakit ?: "-")
                                    if (!d.deskripsi.isNullOrEmpty()) Text(d.deskripsi, style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                                 }
                                  // Assuming diagnosis delete API exists, otherwise hide
                             }
                         }
                     }
                     "history" -> items(history) { h ->
                         DeisaCard {
                             Text(h.action ?: "-", style = MaterialTheme.typography.titleSmall)
                             Text(h.description ?: "", style = MaterialTheme.typography.bodyMedium)
                             Text(h.createdAt ?: "", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                         }
                     }
                 }
             }
         }
         
         if (showDialog) {
             DeisaDialog(
                 title = "Add $title",
                 onDismiss = { showDialog = false }
             ) {
                 DeisaTextField(value = inputName, onValueChange = { inputName = it }, label = "Name")
                 if (type == "diagnosis") {
                     Spacer(modifier = Modifier.height(8.dp))
                     DeisaTextField(value = inputDesc, onValueChange = { inputDesc = it }, label = "Description")
                 }
                 Spacer(modifier = Modifier.height(16.dp))
                 DeisaButton(
                     text = "Save", 
                     onClick = {
                         when(type) {
                             "kelas" -> viewModel.addKelas(inputName)
                             "jurusan" -> viewModel.addJurusan(inputName)
                             "diagnosis" -> viewModel.addDiagnosis(inputName, inputDesc)
                         }
                         showDialog = false
                     },
                     modifier = Modifier.fillMaxWidth()
                 )
             }
         }
    }
}
