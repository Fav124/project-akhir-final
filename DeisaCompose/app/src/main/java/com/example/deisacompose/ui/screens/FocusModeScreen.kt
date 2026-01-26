package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun FocusModeScreen(navController: NavHostController) {
    Scaffold(
        topBar = {
            CenterAlignedTopAppBar(
                title = { 
                    Text("Focus Mode", fontWeight = FontWeight.Black, fontSize = 16.sp, letterSpacing = 2.sp)
                },
                navigationIcon = {
                    IconButton(onClick = { navController.popBackStack() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                },
                colors = TopAppBarDefaults.centerAlignedTopAppBarColors(
                    containerColor = Slate950,
                    titleContentColor = Color.White,
                    navigationIconContentColor = Color.White
                )
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .background(Slate950)
                .padding(padding)
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            // Header Info
            Surface(
                color = DeisaBlue.copy(alpha = 0.1f),
                shape = CircleShape,
                border = androidx.compose.foundation.BorderStroke(1.dp, DeisaBlue.copy(alpha = 0.2f))
            ) {
                Text(
                    "Patient 01/24", 
                    color = DeisaBlue, 
                    fontWeight = FontWeight.Black, 
                    fontSize = 10.sp,
                    modifier = Modifier.padding(horizontal = 16.dp, vertical = 6.dp)
                )
            }
            
            Spacer(modifier = Modifier.height(32.dp))

            // Patient Hero Card
            ElevatedCard(
                modifier = Modifier.fillMaxWidth().aspectRatio(0.8f),
                shape = RoundedCornerShape(48.dp),
                colors = CardDefaults.elevatedCardColors(containerColor = Slate900)
            ) {
                Column(
                    modifier = Modifier.padding(32.dp).fillMaxSize(),
                    verticalArrangement = Arrangement.SpaceBetween
                ) {
                    Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                         Surface(color = DeisaBlue, shape = RoundedCornerShape(20.dp), modifier = Modifier.size(64.dp)) {
                            Box(contentAlignment = Alignment.Center) {
                                Text("AR", color = Color.White, fontWeight = FontWeight.Black, fontSize = 24.sp)
                            }
                         }
                         
                         Column {
                             Text("Ahmad Rusydi", color = Color.White, style = MaterialTheme.typography.headlineLarge, fontWeight = FontWeight.Black)
                             Text("Grade 11 - Software Engineering", color = DeisaBlue, fontWeight = FontWeight.Bold, fontSize = 14.sp)
                         }
                         
                         Divider(color = Slate800, thickness = 1.dp)
                         
                         Text(
                             "Keluhan demam tinggi disertai batuk berdahak sejak pagi ini. Membutuhkan observasi ketat dan pemberian paracetamol berkala.",
                             color = Slate400,
                             style = MaterialTheme.typography.bodyMedium,
                             lineHeight = 22.sp
                         )
                    }

                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        Button(
                            onClick = { /* Action */ },
                            modifier = Modifier.weight(1f).height(64.dp),
                            shape = RoundedCornerShape(24.dp),
                            colors = ButtonDefaults.buttonColors(containerColor = ThemeEmerald)
                        ) {
                            Text("Sembuh", fontWeight = FontWeight.Black, fontSize = 14.sp)
                        }
                        
                         OutlinedButton(
                            onClick = { /* Action */ },
                            modifier = Modifier.weight(1f).height(64.dp),
                            shape = RoundedCornerShape(24.dp),
                            border = androidx.compose.foundation.BorderStroke(1.dp, Slate700)
                        ) {
                            Text("Next", color = Color.White, fontWeight = FontWeight.Black, fontSize = 14.sp)
                        }
                    }
                }
            }
            
            Spacer(modifier = Modifier.height(40.dp))
            
            Text(
                "Swipe left for next patient", 
                color = Slate500, 
                fontWeight = FontWeight.Bold, 
                fontSize = 12.sp,
                letterSpacing = 1.sp
            )
        }
    }
}
