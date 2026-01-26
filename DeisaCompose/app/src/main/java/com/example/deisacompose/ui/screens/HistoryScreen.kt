package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.viewmodels.ActivityViewModel
import com.example.deisacompose.ui.theme.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HistoryScreen(
    navController: NavHostController,
    viewModel: ActivityViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    val logs by viewModel.logs.observeAsState(emptyList())
    val summary by viewModel.summary.observeAsState()
    val isLoading by viewModel.isLoading.observeAsState(false)
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    LaunchedEffect(Unit) {
        viewModel.fetchActivityLogs()
    }

    DeisaComposeTheme(primaryColor = primaryColor) {
        Scaffold(
            topBar = {
                CenterAlignedTopAppBar(
                    title = { Text("Activity Log", fontWeight = FontWeight.Black, fontSize = 16.sp, letterSpacing = 2.sp) },
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
            LazyColumn(
                modifier = Modifier.fillMaxSize().padding(padding),
                contentPadding = PaddingValues(24.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                item {
                    Text("Session Summary", fontWeight = FontWeight.Black, color = Slate950, style = MaterialTheme.typography.titleLarge)
                    Spacer(modifier = Modifier.height(16.dp))
                    SummaryGrid(summary, primaryColor)
                    Spacer(modifier = Modifier.height(32.dp))
                    Text("RECENT ACTIVITIES", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                    Spacer(modifier = Modifier.height(8.dp))
                }

                if (isLoading && logs.isEmpty()) {
                    item {
                        Box(Modifier.fillMaxWidth().height(200.dp), contentAlignment = Alignment.Center) {
                            CircularProgressIndicator(color = primaryColor)
                        }
                    }
                }

                items(logs) { log ->
                    LogCard(log, primaryColor)
                }

                if (logs.isEmpty() && !isLoading) {
                    item {
                        EmptyState()
                    }
                }
                
                item { Spacer(modifier = Modifier.height(40.dp)) }
            }
        }
    }
}

@Composable
fun SummaryGrid(summary: com.example.deisacompose.data.models.HistorySummary?, primaryColor: Color) {
    Column(verticalArrangement = Arrangement.spacedBy(12.dp)) {
        Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.spacedBy(12.dp)) {
            SummaryCard(
                modifier = Modifier.weight(1f),
                title = "TOTAL ACTIONS",
                value = summary?.total?.toString() ?: "0",
                color = Slate950,
                icon = Icons.Default.AllInclusive
            )
            SummaryCard(
                modifier = Modifier.weight(1f),
                title = "TODAY STATS",
                value = summary?.today?.toString() ?: "0",
                color = primaryColor,
                icon = Icons.Default.FlashOn
            )
        }
    }
}

@Composable
fun SummaryCard(
    modifier: Modifier = Modifier,
    title: String,
    value: String,
    color: Color,
    icon: ImageVector
) {
    ElevatedCard(
        modifier = modifier.height(110.dp),
        shape = RoundedCornerShape(28.dp),
        colors = CardDefaults.elevatedCardColors(containerColor = color)
    ) {
        Box(modifier = Modifier.fillMaxSize().padding(20.dp)) {
            Icon(
                icon, 
                null, 
                tint = Color.White.copy(alpha = 0.15f), 
                modifier = Modifier.size(56.dp).align(Alignment.BottomEnd).offset(x = 12.dp, y = 12.dp)
            )
            Column(verticalArrangement = Arrangement.spacedBy(4.dp)) {
                Text(title, color = Color.White.copy(alpha = 0.6f), fontSize = 9.sp, fontWeight = FontWeight.Black, letterSpacing = 1.sp)
                Text(value, color = Color.White, fontSize = 32.sp, fontWeight = FontWeight.Black, letterSpacing = (-1).sp)
            }
        }
    }
}

@Composable
fun LogCard(log: com.example.deisacompose.data.models.ActivityLog, primaryColor: Color) {
    ElevatedCard(
        shape = RoundedCornerShape(28.dp),
        colors = CardDefaults.elevatedCardColors(containerColor = Color.White),
        elevation = CardDefaults.elevatedCardElevation(defaultElevation = 2.dp)
    ) {
        Row(modifier = Modifier.padding(20.dp), verticalAlignment = Alignment.CenterVertically) {
            Surface(
                shape = RoundedCornerShape(12.dp),
                color = Slate50,
                modifier = Modifier.size(48.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(
                        imageVector = if (log.action?.contains("Santri") == true) Icons.Default.Person 
                                     else if (log.action?.contains("Obat") == true) Icons.Default.Medication 
                                     else Icons.Default.History,
                        contentDescription = null,
                        modifier = Modifier.size(24.dp),
                        tint = primaryColor
                    )
                }
            }
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(
                    text = log.action ?: "Unspecified Action", 
                    fontWeight = FontWeight.Black, 
                    fontSize = 14.sp, 
                    color = Slate950,
                    letterSpacing = (-0.5).sp
                )
                Text(
                    text = log.description ?: "No details provided.", 
                    fontSize = 11.sp, 
                    color = Slate500,
                    fontWeight = FontWeight.Bold
                )
            }
            Text(
                text = log.createdAt?.substringBefore("T") ?: "", 
                fontSize = 10.sp, 
                color = Slate400,
                fontWeight = FontWeight.Black,
                modifier = Modifier.align(Alignment.Top)
            )
        }
    }
}

@Composable
fun EmptyState() {
    Column(
        modifier = Modifier.fillMaxWidth().padding(vertical = 60.dp),
        horizontalAlignment = Alignment.CenterHorizontally,
        verticalArrangement = Arrangement.Center
    ) {
        Surface(color = Slate100, shape = CircleShape, modifier = Modifier.size(80.dp)) {
            Box(contentAlignment = Alignment.Center) {
                Icon(Icons.Default.History, null, tint = Slate400, modifier = Modifier.size(32.dp))
            }
        }
        Spacer(modifier = Modifier.height(24.dp))
        Text("Clean History", fontWeight = FontWeight.Black, color = Slate950, fontSize = 16.sp)
        Text("No activity records available for this period.", color = Slate400, fontSize = 12.sp, textAlign = TextAlign.Center)
    }
}
