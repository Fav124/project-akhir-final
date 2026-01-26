package com.example.deisacompose.ui.screens

import androidx.compose.foundation.*
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.data.models.Sakit
import com.example.deisacompose.data.models.SakitRequest
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.SakitViewModel
import com.example.deisacompose.viewmodels.SantriViewModel
import com.example.deisacompose.ui.components.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitScreen(
    navController: NavHostController,
    viewModel: SakitViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    var searchQuery by remember { mutableStateOf("") }
    val sakitList by viewModel.sakitList.observeAsState(emptyList())
    val isLoading by viewModel.isLoading.observeAsState(false)
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    LaunchedEffect(Unit) {
        viewModel.fetchSakit()
    }

    DeisaComposeTheme(primaryColor = primaryColor) {
        Scaffold(
            topBar = {
                CenterAlignedTopAppBar(
                    title = { Text("Health Monitoring", fontWeight = FontWeight.Black, fontSize = 16.sp, letterSpacing = 2.sp) },
                    navigationIcon = {
                        IconButton(onClick = { navController.navigateUp() }) {
                            Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                        }
                    },
                    colors = TopAppBarDefaults.centerAlignedTopAppBarColors(containerColor = Slate50)
                )
            },
            floatingActionButton = {
                FloatingActionButton(
                    onClick = { navController.navigate("sakit_form") },
                    containerColor = DangerRed,
                    contentColor = Color.White,
                    shape = RoundedCornerShape(20.dp),
                    elevation = FloatingActionButtonDefaults.elevation(defaultElevation = 10.dp)
                ) {
                    Icon(Icons.Default.Add, contentDescription = "Report")
                }
            },
            containerColor = Slate50
        ) { padding ->
            Column(
                modifier = Modifier
                    .padding(padding)
                    .fillMaxSize()
            ) {
                // High-End Search Bar
                Surface(
                    modifier = Modifier.fillMaxWidth().padding(horizontal = 20.dp, vertical = 10.dp),
                    shape = RoundedCornerShape(24.dp),
                    color = Color.White,
                    shadowElevation = 2.dp,
                    border = BorderStroke(1.dp, Slate100)
                ) {
                    Row(
                        modifier = Modifier.padding(horizontal = 20.dp, vertical = 4.dp),
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Icon(Icons.Default.Search, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp))
                        Spacer(modifier = Modifier.width(12.dp))
                        TextField(
                            value = searchQuery,
                            onValueChange = { 
                                searchQuery = it
                                viewModel.fetchSakit(it)
                            },
                            placeholder = { Text("Cari santri...", color = Slate400, fontWeight = FontWeight.Bold, fontSize = 14.sp) },
                            modifier = Modifier.fillMaxWidth(),
                            colors = TextFieldDefaults.textFieldColors(
                                containerColor = Color.Transparent,
                                focusedIndicatorColor = Color.Transparent,
                                unfocusedIndicatorColor = Color.Transparent
                            ),
                            singleLine = true
                        )
                    }
                }

                if (isLoading) {
                    Box(modifier = Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
                        CircularProgressIndicator(color = primaryColor)
                    }
                } else if (sakitList.isEmpty()) {
                    Column(
                        modifier = Modifier.fillMaxSize().padding(32.dp),
                        contentAlignment = Alignment.Center,
                        verticalArrangement = Arrangement.Center
                    ) {
                        Surface(color = Slate100, shape = CircleShape, modifier = Modifier.size(80.dp)) {
                            Box(contentAlignment = Alignment.Center) {
                                Icon(Icons.Default.Inbox, contentDescription = null, tint = Slate400, modifier = Modifier.size(32.dp))
                            }
                        }
                        Spacer(modifier = Modifier.height(24.dp))
                        Text("No active cases found", fontWeight = FontWeight.Black, color = Slate900, fontSize = 16.sp)
                        Text("All santri are currently healthy in the records.", color = Slate400, fontSize = 12.sp, textAlign = TextAlign.Center)
                    }
                } else {
                    LazyColumn(
                        modifier = Modifier.fillMaxSize(),
                        contentPadding = PaddingValues(20.dp),
                        verticalArrangement = Arrangement.spacedBy(16.dp)
                    ) {
                        items(sakitList) { sakit ->
                            SakitItem(sakit, viewModel, primaryColor) {
                                navController.navigate("sakit_form?id=${sakit.id}")
                            }
                        }
                    }
                }
            }
        }
    }
}

@Composable
fun SakitItem(
    sakit: Sakit, 
    viewModel: SakitViewModel,
    primaryColor: Color,
    onClick: () -> Unit
) {
    var showConfirmDialog by remember { mutableStateOf(false) }
    
    if (showConfirmDialog) {
        AlertDialog(
            onDismissRequest = { showConfirmDialog = false },
            title = { Text("Confirm Recovery", fontWeight = FontWeight.Black) },
            text = { Text("Tandai ${sakit.santri?.displayName() ?: "santri"} sebagai sembuh?", color = Slate500) },
            confirmButton = {
                Button(
                    onClick = {
                        viewModel.markAsSembuh(sakit.id, {}, {})
                        showConfirmDialog = false
                    },
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen),
                    shape = RoundedCornerShape(12.dp)
                ) {
                    Text("YES, RECOVERED")
                }
            },
            dismissButton = {
                TextButton(onClick = { showConfirmDialog = false }) {
                    Text("CANCEL", color = Slate400, fontWeight = FontWeight.Black)
                }
            },
            shape = RoundedCornerShape(24.dp),
            containerColor = Color.White
        )
    }
    
    ElevatedCard(
        modifier = Modifier.fillMaxWidth(),
        onClick = onClick,
        shape = RoundedCornerShape(28.dp),
        colors = CardDefaults.elevatedCardColors(containerColor = Color.White),
        elevation = CardDefaults.elevatedCardElevation(defaultElevation = 2.dp)
    ) {
        Column(modifier = Modifier.padding(20.dp)) {
            Row(verticalAlignment = Alignment.CenterVertically) {
                Surface(
                    color = DangerRed.copy(alpha = 0.1f),
                    shape = RoundedCornerShape(12.dp),
                    modifier = Modifier.size(48.dp)
                ) {
                    Box(contentAlignment = Alignment.Center) {
                        Icon(Icons.Default.Sick, contentDescription = null, tint = DangerRed, modifier = Modifier.size(24.dp))
                    }
                }
                Spacer(modifier = Modifier.width(16.dp))
                Column(modifier = Modifier.weight(1f)) {
                    Text(
                        text = sakit.santri?.displayName() ?: "Anonymous",
                        fontWeight = FontWeight.Black,
                        fontSize = 16.sp,
                        color = Slate950,
                        letterSpacing = (-0.5).sp
                    )
                    Text(
                        text = sakit.displayDate(),
                        fontSize = 11.sp,
                        fontWeight = FontWeight.Bold,
                        color = Slate400
                    )
                }
                StatusBadge(sakit.displayStatus())
            }
            
            Spacer(modifier = Modifier.height(20.dp))
            
            Surface(color = Slate50, shape = RoundedCornerShape(16.dp), modifier = Modifier.fillMaxWidth()) {
                Text(
                    text = sakit.keluhan ?: sakit.gejala ?: "No description provided.",
                    fontSize = 13.sp,
                    fontWeight = FontWeight.Medium,
                    color = Slate700,
                    modifier = Modifier.padding(16.dp)
                )
            }

            if (sakit.status != "Sembuh" && sakit.tingkatKondisi != "Sembuh") {
                Spacer(modifier = Modifier.height(16.dp))
                Button(
                    onClick = { showConfirmDialog = true },
                    modifier = Modifier.fillMaxWidth().height(48.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = SuccessGreen),
                    shape = RoundedCornerShape(16.dp)
                ) {
                    Icon(Icons.Default.CheckCircle, contentDescription = null, modifier = Modifier.size(16.dp))
                    Spacer(modifier = Modifier.width(8.dp))
                    Text("MARK AS RECOVERED", fontSize = 11.sp, fontWeight = FontWeight.Black, letterSpacing = 1.sp)
                }
            }
        }
    }
}

@Composable
fun StatusBadge(status: String) {
    val color = when (status.lowercase()) {
        "berat" -> DangerRed
        "sedang" -> WarningOrange
        "ringan" -> DeisaBlue
        "sembuh" -> SuccessGreen
        else -> Slate500
    }
    Surface(
        color = color.copy(alpha = 0.1f),
        shape = RoundedCornerShape(8.dp),
        border = BorderStroke(1.dp, color.copy(alpha = 0.1f))
    ) {
        Text(
            text = status.uppercase(),
            color = color,
            fontSize = 9.sp,
            fontWeight = FontWeight.Black,
            letterSpacing = 1.sp,
            modifier = Modifier.padding(horizontal = 10.dp, vertical = 4.dp)
        )
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SakitFormScreen(
    navController: NavHostController,
    sakitId: Int? = null,
    viewModel: SakitViewModel = viewModel(),
    santriViewModel: SantriViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    val sakitDetail by viewModel.sakitDetail.observeAsState()
    val santriList by santriViewModel.santriList.observeAsState(emptyList())
    val diagnosisList by viewModel.diagnosisList.observeAsState(emptyList())
    val obatList by viewModel.obatList.observeAsState(emptyList())
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")
    
    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    // Stepper
    var currentStep by remember { mutableIntStateOf(1) }

    // Form Data
    var selectedSantriId by remember { mutableStateOf<Int?>(null) }
    var searchQuery by remember { mutableStateOf("") }
    var gejala by remember { mutableStateOf("") }
    var tindakan by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("Ringan") }
    var selectedDiagnosisIds by remember { mutableStateOf(setOf<Int>()) }
    var selectedObatUsage by remember { mutableStateOf(mapOf<Int, Int>()) } 

    var expandedSantri by remember { mutableStateOf(false) }
    
    val filteredSantriList = remember(searchQuery, santriList) {
        if (searchQuery.isBlank()) santriList
        else santriList.filter { 
            it.displayName().contains(searchQuery, ignoreCase = true) || 
            (it.nis?.contains(searchQuery) == true)
        }
    }

    LaunchedEffect(Unit) {
        santriViewModel.fetchSantri()
        viewModel.fetchDiagnosis()
        viewModel.fetchObat()
        if (sakitId != null) viewModel.getSakitById(sakitId) else viewModel.clearDetail()
    }

    LaunchedEffect(sakitDetail) {
        sakitDetail?.let {
            selectedSantriId = it.santriId
            searchQuery = it.santri?.displayName() ?: ""
            gejala = it.gejala ?: ""
            tindakan = it.tindakan ?: ""
            status = it.tingkatKondisi ?: it.status ?: "Ringan"
        }
    }

    DeisaComposeTheme(primaryColor = primaryColor) {
        Scaffold(
            topBar = {
                CenterAlignedTopAppBar(
                    title = { Text(if (sakitId == null) "New Record" else "Edit Record", fontWeight = FontWeight.Black, fontSize = 16.sp, letterSpacing = 2.sp) },
                    navigationIcon = {
                        IconButton(onClick = { navController.navigateUp() }) {
                            Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                        }
                    },
                    colors = TopAppBarDefaults.centerAlignedTopAppBarColors(containerColor = Slate50)
                )
            },
            containerColor = Slate50
        ) { padding ->
            Column(modifier = Modifier.padding(padding).fillMaxSize()) {
                // High-End Progress Indicator
                Row(modifier = Modifier.fillMaxWidth().padding(24.dp), horizontalArrangement = Arrangement.spacedBy(12.dp)) {
                    Box(modifier = Modifier.weight(1f).height(4.dp).background(if (currentStep >= 1) primaryColor else Slate200, RoundedCornerShape(2.dp)))
                    Box(modifier = Modifier.weight(1f).height(4.dp).background(if (currentStep >= 2) primaryColor else Slate200, RoundedCornerShape(2.dp)))
                }

                Column(
                    modifier = Modifier.weight(1f).verticalScroll(rememberScrollState()).padding(horizontal = 24.dp),
                    verticalArrangement = Arrangement.spacedBy(24.dp)
                ) {
                    if (currentStep == 1) {
                        Text("Selection & Condition", fontWeight = FontWeight.Black, color = Slate950, style = MaterialTheme.typography.titleLarge)
                        
                        Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                             Text("PATIENT DETAILS", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                             
                             ExposedDropdownMenuBox(
                                expanded = expandedSantri,
                                onExpandedChange = { expandedSantri = !expandedSantri }
                            ) {
                                OutlinedTextField(
                                    value = searchQuery,
                                    onValueChange = { searchQuery = it; expandedSantri = true },
                                    placeholder = { Text("Search by Name or NIS", color = Slate400) },
                                    trailingIcon = { ExposedDropdownMenuDefaults.TrailingIcon(expanded = expandedSantri) },
                                    modifier = Modifier.menuAnchor().fillMaxWidth(),
                                    shape = RoundedCornerShape(24.dp),
                                    colors = TextFieldDefaults.outlinedTextFieldColors(
                                        containerColor = Color.White,
                                        unfocusedBorderColor = Slate100,
                                        focusedBorderColor = primaryColor
                                    ),
                                    singleLine = true
                                )
                                ExposedDropdownMenu(
                                    expanded = expandedSantri,
                                    onDismissRequest = { expandedSantri = false },
                                    modifier = Modifier.background(Color.White)
                                ) {
                                    filteredSantriList.take(6).forEach { santri ->
                                        DropdownMenuItem(
                                            text = { 
                                                Column {
                                                    Text(santri.displayName(), fontWeight = FontWeight.Bold, color = Slate900)
                                                    Text("NIS: ${santri.nis ?: "-"}", fontSize = 11.sp, color = Slate400)
                                                }
                                            },
                                            onClick = {
                                                selectedSantriId = santri.id
                                                searchQuery = santri.displayName()
                                                expandedSantri = false
                                            }
                                        )
                                    }
                                }
                            }
                        }

                        Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                             Text("SYMPTOMS DESCRIPTION", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                             OutlinedTextField(
                                value = gejala,
                                onValueChange = { gejala = it },
                                placeholder = { Text("Describe symptoms...", color = Slate400) },
                                modifier = Modifier.fillMaxWidth().height(120.dp),
                                shape = RoundedCornerShape(24.dp),
                                colors = TextFieldDefaults.outlinedTextFieldColors(
                                    containerColor = Color.White,
                                    unfocusedBorderColor = Slate100,
                                    focusedBorderColor = primaryColor
                                )
                            )
                        }

                        Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                            Text("SEVERITY LEVEL", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                            Row(horizontalArrangement = Arrangement.spacedBy(10.dp)) {
                                listOf("Ringan", "Sedang", "Berat").forEach { level ->
                                    val isSel = status == level
                                    Surface(
                                        onClick = { status = level },
                                        color = if (isSel) primaryColor else Color.White,
                                        shape = RoundedCornerShape(16.dp),
                                        border = if (isSel) null else BorderStroke(1.dp, Slate100),
                                        modifier = Modifier.height(44.dp).weight(1f)
                                    ) {
                                        Box(contentAlignment = Alignment.Center) {
                                            Text(level.uppercase(), color = if (isSel) Color.White else Slate900, fontWeight = FontWeight.Black, fontSize = 11.sp)
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        Text("Treatment & Prescription", fontWeight = FontWeight.Black, color = Slate950, style = MaterialTheme.typography.titleLarge)
                        
                        Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                            Text("MEDICAL ACTIONS", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                            OutlinedTextField(
                                value = tindakan,
                                onValueChange = { tindakan = it },
                                placeholder = { Text("Administered actions...", color = Slate400) },
                                modifier = Modifier.fillMaxWidth().height(120.dp),
                                shape = RoundedCornerShape(24.dp),
                                colors = TextFieldDefaults.outlinedTextFieldColors(
                                    containerColor = Color.White,
                                    unfocusedBorderColor = Slate100,
                                    focusedBorderColor = primaryColor
                                )
                            )
                        }

                        Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                            Text("DIAGNOSIS CHIPS", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                            @OptIn(ExperimentalLayoutApi::class)
                            FlowRow(horizontalArrangement = Arrangement.spacedBy(8.dp), verticalArrangement = Arrangement.spacedBy(8.dp)) {
                                diagnosisList.forEach { diag ->
                                    val isSel = selectedDiagnosisIds.contains(diag.id)
                                    Surface(
                                        onClick = { selectedDiagnosisIds = if (isSel) selectedDiagnosisIds - diag.id else selectedDiagnosisIds + diag.id },
                                        color = if (isSel) primaryColor.copy(alpha = 0.1f) else Color.White,
                                        shape = RoundedCornerShape(12.dp),
                                        border = BorderStroke(1.dp, if (isSel) primaryColor else Slate100)
                                    ) {
                                        Text(diag.namaPenyakit ?: "-", color = if (isSel) primaryColor else Slate900, fontWeight = FontWeight.Bold, fontSize = 12.sp, modifier = Modifier.padding(horizontal = 12.dp, vertical = 6.dp))
                                    }
                                }
                            }
                        }
                    }
                }

                // Footers
                Surface(color = Color.White, shadowElevation = 10.dp) {
                    Row(modifier = Modifier.padding(24.dp).fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                        if (currentStep > 1) {
                            OutlinedButton(onClick = { currentStep-- }, modifier = Modifier.weight(1f).height(64.dp), shape = RoundedCornerShape(20.dp), border = BorderStroke(1.dp, Slate100)) {
                                Text("PREVIOUS", color = Slate900, fontWeight = FontWeight.Black)
                            }
                        }
                        
                        Button(
                            onClick = {
                                if (currentStep < 2) {
                                    if (selectedSantriId != null) currentStep++
                                } else {
                                    val request = SakitRequest(
                                        santriId = selectedSantriId ?: 0,
                                        tglMasuk = java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(java.util.Date()),
                                        status = status,
                                        jenisPerawatan = "Rawat Inap",
                                        tujuanRujukan = null,
                                        gejala = gejala,
                                        tindakan = tindakan,
                                        catatan = "",
                                        diagnosisIds = selectedDiagnosisIds.toList(),
                                        obatUsage = selectedObatUsage.map { com.example.deisacompose.data.models.ObatUsageRequest(it.key, it.value) }
                                    )
                                    if (sakitId == null) viewModel.submitSakit(request, { navController.navigateUp() }, {})
                                    else viewModel.updateSakit(sakitId, request, { navController.navigateUp() }, {})
                                }
                            },
                            modifier = Modifier.weight(2f).height(64.dp),
                            shape = RoundedCornerShape(20.dp),
                            colors = ButtonDefaults.buttonColors(containerColor = Slate950)
                        ) {
                            Text(if (currentStep < 2) "NEXT STEP" else "FINALIZE RECORD", fontWeight = FontWeight.Black)
                        }
                    }
                }
            }
        }
    }
}
