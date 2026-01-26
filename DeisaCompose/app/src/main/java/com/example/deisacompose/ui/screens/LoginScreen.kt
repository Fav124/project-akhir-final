package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
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
import androidx.compose.ui.text.input.*
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.ui.theme.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun LoginScreen(
    navController: NavHostController,
    authViewModel: AuthViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    var email by remember { mutableStateOf("") }
    var password by remember { mutableStateOf("") }
    var passwordVisible by remember { mutableStateOf(false) }

    val isLoading by authViewModel.isLoading.observeAsState(false)
    val error by authViewModel.error.observeAsState()
    val authSuccess by authViewModel.authSuccess.observeAsState(false)
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    LaunchedEffect(authSuccess) {
        if (authSuccess) {
            navController.navigate("home") {
                popUpTo("login") { inclusive = true }
            }
        }
    }

    DeisaComposeTheme(primaryColor = primaryColor) {
        Box(
            modifier = Modifier
                .fillMaxSize()
                .background(Slate50)
        ) {
            // Background branding circle
            Box(modifier = Modifier.align(Alignment.TopEnd).offset(x = 100.dp, y = (-100).dp).size(300.dp).background(primaryColor.copy(alpha = 0.05f), CircleShape))
            
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(32.dp)
                    .verticalScroll(rememberScrollState()),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                Spacer(modifier = Modifier.height(48.dp))

                // Branding
                Surface(
                    modifier = Modifier.size(64.dp),
                    shape = RoundedCornerShape(20.dp),
                    color = primaryColor,
                    shadowElevation = 10.dp
                ) {
                    Box(contentAlignment = Alignment.Center) {
                        Text("D", color = Color.White, fontWeight = FontWeight.Black, fontSize = 32.sp)
                    }
                }
                
                Spacer(modifier = Modifier.height(24.dp))
                
                Text(
                    "Welcome Back",
                    style = MaterialTheme.typography.headlineMedium,
                    fontWeight = FontWeight.Black,
                    color = Slate950,
                    letterSpacing = (-1).sp
                )
                Text(
                    "Sign in to access medical dashboard",
                    style = MaterialTheme.typography.bodyMedium,
                    color = Slate500,
                    fontWeight = FontWeight.Bold
                )

                Spacer(modifier = Modifier.height(48.dp))

                // Form
                Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                    Text("ACCOUNT DETAILS", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                    
                    OutlinedTextField(
                        value = email,
                        onValueChange = { email = it; authViewModel.clearError() },
                        placeholder = { Text("Email Address", color = Slate400) },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(24.dp),
                        colors = TextFieldDefaults.outlinedTextFieldColors(
                            containerColor = Color.White,
                            unfocusedBorderColor = Slate100,
                            focusedBorderColor = primaryColor
                        ),
                        leadingIcon = { Icon(Icons.Default.Email, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp)) },
                        singleLine = true
                    )

                    OutlinedTextField(
                        value = password,
                        onValueChange = { password = it; authViewModel.clearError() },
                        placeholder = { Text("Password", color = Slate400) },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(24.dp),
                        colors = TextFieldDefaults.outlinedTextFieldColors(
                            containerColor = Color.White,
                            unfocusedBorderColor = Slate100,
                            focusedBorderColor = primaryColor
                        ),
                        leadingIcon = { Icon(Icons.Default.Lock, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp)) },
                        visualTransformation = if (passwordVisible) VisualTransformation.None else PasswordVisualTransformation(),
                        trailingIcon = {
                            IconButton(onClick = { passwordVisible = !passwordVisible }) {
                                Icon(if (passwordVisible) Icons.Default.VisibilityOff else Icons.Default.Visibility, null, tint = Slate400, modifier = Modifier.size(20.dp))
                            }
                        },
                        singleLine = true
                    )

                    if (error != null) {
                        Text(error!!, color = DangerRed, fontSize = 12.sp, fontWeight = FontWeight.Bold, modifier = Modifier.padding(start = 12.dp))
                    }
                }

                Spacer(modifier = Modifier.height(12.dp))

                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.End
                ) {
                    TextButton(onClick = { navController.navigate("forgot_password") }) {
                        Text("FORGOT PASSWORD?", color = Slate400, fontWeight = FontWeight.Black, fontSize = 10.sp, letterSpacing = 1.sp)
                    }
                }

                Spacer(modifier = Modifier.height(32.dp))

                Button(
                    onClick = { authViewModel.login(email, password, true) },
                    modifier = Modifier.fillMaxWidth().height(64.dp),
                    shape = RoundedCornerShape(24.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = Slate950),
                    enabled = !isLoading
                ) {
                    if (isLoading) {
                        CircularProgressIndicator(modifier = Modifier.size(24.dp), color = Color.White, strokeWidth = 3.dp)
                    } else {
                        Text("LOGIN TO ECOSYSTEM", fontWeight = FontWeight.Black, letterSpacing = 1.sp)
                    }
                }

                Spacer(modifier = Modifier.height(48.dp))

                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text("Don't have an account? ", color = Slate500, fontWeight = FontWeight.Bold, fontSize = 14.sp)
                    TextButton(onClick = { navController.navigate("register") }) {
                        Text("SIGN UP", fontWeight = FontWeight.Black, color = primaryColor, fontSize = 14.sp)
                    }
                }
            }
        }
    }
}
