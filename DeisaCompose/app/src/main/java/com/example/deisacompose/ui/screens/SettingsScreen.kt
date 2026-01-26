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
    viewModel: HomeViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")
    var threshold by remember { mutableStateOf(viewModel.sickThreshold.toFloat()) }

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { 
                    Text("System Settings", fontWeight = FontWeight.Black, color = Slate950) 
                },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back", tint = Slate950)
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(containerColor = Slate50)
            )
        },
        containerColor = Slate50
    ) { padding ->
        Column(
            modifier = Modifier
                .padding(padding)
                .padding(24.dp)
                .fillMaxSize(),
            verticalArrangement = Arrangement.spacedBy(32.dp)
        ) {
            // Appearance Theme Section
            Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                Text(
                    "Global Appearance",
                    style = MaterialTheme.typography.labelLarge,
                    fontWeight = FontWeight.Black,
                    color = Slate400,
                    letterSpacing = 2.sp
                )

                ElevatedCard(
                    modifier = Modifier.fillMaxWidth(),
                    shape = RoundedCornerShape(32.dp),
                    colors = CardDefaults.elevatedCardColors(containerColor = Color.White)
                ) {
                    Column(modifier = Modifier.padding(24.dp), verticalArrangement = Arrangement.spacedBy(20.dp)) {
                        Text("Active Theme", fontWeight = FontWeight.ExtraBold, color = Slate900, fontSize = 18.sp)
                        
                        Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.SpaceBetween) {
                            ThemeBubble("blue", DeisaBlue, themeChoice == "blue") { mainViewModel.setTheme("blue") }
                            ThemeBubble("indigo", ThemeIndigo, themeChoice == "indigo") { mainViewModel.setTheme("indigo") }
                            ThemeBubble("emerald", ThemeEmerald, themeChoice == "emerald") { mainViewModel.setTheme("emerald") }
                            ThemeBubble("rose", ThemeRose, themeChoice == "rose") { mainViewModel.setTheme("rose") }
                        }
                    }
                }
            }

            // Threshold Section
            Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                Text(
                    "Notification Logic",
                    style = MaterialTheme.typography.labelLarge,
                    fontWeight = FontWeight.Black,
                    color = Slate400,
                    letterSpacing = 2.sp
                )

                ElevatedCard(
                    modifier = Modifier.fillMaxWidth(),
                    shape = RoundedCornerShape(32.dp),
                    colors = CardDefaults.elevatedCardColors(containerColor = Color.White)
                ) {
                    Column(modifier = Modifier.padding(24.dp)) {
                        Text("Outbreak Threshold", fontWeight = FontWeight.ExtraBold, color = Slate900, fontSize = 18.sp)
                        Text("Trigger alerts when sick count matches this value.", color = Slate500, fontSize = 11.sp, fontWeight = FontWeight.Bold)
                        
                        Spacer(modifier = Modifier.height(32.dp))
                        
                        Row(verticalAlignment = Alignment.CenterVertically) {
                            Slider(
                                value = threshold,
                                onValueChange = { threshold = it },
                                valueRange = 1f..15f,
                                steps = 13,
                                modifier = Modifier.weight(1f),
                                colors = SliderDefaults.colors(
                                    thumbColor = primaryColor,
                                    activeTrackColor = primaryColor,
                                    inactiveTrackColor = primaryColor.copy(alpha = 0.1f)
                                )
                            )
                            Spacer(modifier = Modifier.width(16.dp))
                            Text(
                                text = threshold.toInt().toString(),
                                fontWeight = FontWeight.Black,
                                fontSize = 24.sp,
                                color = primaryColor
                            )
                        }
                    }
                }
            }

            Spacer(modifier = Modifier.weight(1f))

            Button(
                onClick = {
                    viewModel.setSickThreshold(threshold.toInt())
                    navController.navigateUp()
                },
                modifier = Modifier.fillMaxWidth().height(72.dp),
                shape = RoundedCornerShape(24.dp),
                colors = ButtonDefaults.buttonColors(containerColor = Slate950)
            ) {
                Text("SAVE ALL CHANGES", fontWeight = FontWeight.Black, letterSpacing = 1.sp)
            }
        }
    }
}

@Composable
fun ThemeBubble(name: String, color: Color, isSelected: Boolean, onClick: () -> Unit) {
    Column(horizontalAlignment = Alignment.CenterHorizontally, verticalArrangement = Arrangement.spacedBy(8.dp)) {
        Surface(
            onClick = onClick,
            modifier = Modifier.size(56.dp),
            shape = CircleShape,
            color = color,
            border = if (isSelected) androidx.compose.foundation.BorderStroke(4.dp, Slate100) else null,
            shadowElevation = if (isSelected) 8.dp else 2.dp
        ) {
            if (isSelected) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(Icons.Default.Check, contentDescription = null, tint = Color.White, modifier = Modifier.size(24.dp))
                }
            }
        }
        Text(name.uppercase(), fontSize = 8.sp, fontWeight = FontWeight.Black, color = if (isSelected) color else Slate400, letterSpacing = 1.sp)
    }
}
