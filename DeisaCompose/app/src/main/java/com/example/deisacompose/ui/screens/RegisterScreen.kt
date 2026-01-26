package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
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
import com.example.deisacompose.ui.theme.Slate500

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun RegisterScreen(
    navController: NavHostController,
    authViewModel: AuthViewModel = viewModel(),
    mainViewModel: com.example.deisacompose.viewmodels.MainViewModel = viewModel()
) {
    var name by remember { mutableStateOf("") }
    var email by remember { mutableStateOf("") }
    var password by remember { mutableStateOf("") }
    var confirmPassword by remember { mutableStateOf("") }
    
    val isLoading by authViewModel.isLoading.observeAsState(false)
    val error by authViewModel.error.observeAsState()
    val registrationSuccess by authViewModel.registrationSuccess.observeAsState()
    val themeChoice by mainViewModel.themeColor.observeAsState("blue")

    val primaryColor = when(themeChoice) {
        "indigo" -> ThemeIndigo
        "emerald" -> ThemeEmerald
        "rose" -> ThemeRose
        else -> DeisaBlue
    }

    if (registrationSuccess != null) {
        AlertDialog(
            onDismissRequest = { authViewModel.resetRegistrationSuccess() },
            title = { Text("Registration Sent", fontWeight = FontWeight.Black) },
            text = { Text(registrationSuccess!!, color = Slate500) },
            confirmButton = {
                Button(
                    onClick = { 
                        authViewModel.resetRegistrationSuccess()
                        navController.navigate("login") {
                            popUpTo("register") { inclusive = true }
                        }
                    },
                    colors = ButtonDefaults.buttonColors(containerColor = primaryColor),
                    shape = RoundedCornerShape(12.dp)
                ) {
                    Text("DONE")
                }
            },
            shape = RoundedCornerShape(24.dp),
            containerColor = Color.White
        )
    }

    DeisaComposeTheme(primaryColor = primaryColor) {
        Scaffold(
            topBar = {
                CenterAlignedTopAppBar(
                    title = { Text("Create Account", fontWeight = FontWeight.Black, fontSize = 16.sp, letterSpacing = 2.sp) },
                    navigationIcon = {
                        IconButton(onClick = { navController.popBackStack() }) {
                            Icon(Icons.Default.ArrowBack, "Back")
                        }
                    },
                    colors = TopAppBarDefaults.centerAlignedTopAppBarColors(containerColor = Slate50)
                )
            },
            containerColor = Slate50
        ) { padding ->
            Column(
                modifier = Modifier
                    .padding(padding)
                    .fillMaxSize()
                    .verticalScroll(rememberScrollState())
                    .padding(32.dp),
                horizontalAlignment = Alignment.CenterHorizontally
            ) {
                // Intro
                Text(
                    "Join the Ecosystem",
                    style = MaterialTheme.typography.headlineSmall,
                    fontWeight = FontWeight.Black,
                    color = Slate950,
                    letterSpacing = (-0.5).sp
                )
                Text(
                    "Fill details to request access",
                    style = MaterialTheme.typography.bodyMedium,
                    color = Slate500,
                    fontWeight = FontWeight.Bold
                )

                Spacer(modifier = Modifier.height(48.dp))

                // Form
                Column(verticalArrangement = Arrangement.spacedBy(16.dp)) {
                    Text("PERSONAL INFORMATION", style = MaterialTheme.typography.labelLarge, color = Slate400, fontWeight = FontWeight.Black, letterSpacing = 2.sp)
                    
                    OutlinedTextField(
                        value = name,
                        onValueChange = { name = it; authViewModel.clearError() },
                        placeholder = { Text("Full Name", color = Slate400) },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(24.dp),
                        colors = TextFieldDefaults.outlinedTextFieldColors(
                            containerColor = Color.White,
                            unfocusedBorderColor = Slate100,
                            focusedBorderColor = primaryColor
                        ),
                        leadingIcon = { Icon(Icons.Default.Person, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp)) },
                        singleLine = true
                    )

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
                        placeholder = { Text("Create Password", color = Slate400) },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(24.dp),
                        colors = TextFieldDefaults.outlinedTextFieldColors(
                            containerColor = Color.White,
                            unfocusedBorderColor = Slate100,
                            focusedBorderColor = primaryColor
                        ),
                        leadingIcon = { Icon(Icons.Default.Lock, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp)) },
                        visualTransformation = PasswordVisualTransformation(),
                        singleLine = true
                    )

                    OutlinedTextField(
                        value = confirmPassword,
                        onValueChange = { confirmPassword = it; authViewModel.clearError() },
                        placeholder = { Text("Confirm Password", color = Slate400) },
                        modifier = Modifier.fillMaxWidth(),
                        shape = RoundedCornerShape(24.dp),
                        colors = TextFieldDefaults.outlinedTextFieldColors(
                            containerColor = Color.White,
                            unfocusedBorderColor = Slate100,
                            focusedBorderColor = primaryColor
                        ),
                        leadingIcon = { Icon(Icons.Default.Shield, contentDescription = null, tint = Slate400, modifier = Modifier.size(20.dp)) },
                        visualTransformation = PasswordVisualTransformation(),
                        singleLine = true
                    )

                    if (error != null) {
                        Text(error!!, color = DangerRed, fontSize = 12.sp, fontWeight = FontWeight.Bold, modifier = Modifier.padding(start = 12.dp))
                    }
                }

                Spacer(modifier = Modifier.height(48.dp))

                Button(
                    onClick = { 
                        if (password == confirmPassword) authViewModel.register(name, email, password)
                    },
                    modifier = Modifier.fillMaxWidth().height(64.dp),
                    shape = RoundedCornerShape(24.dp),
                    colors = ButtonDefaults.buttonColors(containerColor = Slate950),
                    enabled = !isLoading && name.isNotEmpty() && email.isNotEmpty() && password == confirmPassword && password.length >= 8
                ) {
                    if (isLoading) {
                        CircularProgressIndicator(modifier = Modifier.size(24.dp), color = Color.White, strokeWidth = 3.dp)
                    } else {
                        Text("REQUEST ACCESS", fontWeight = FontWeight.Black, letterSpacing = 1.sp)
                    }
                }

                Spacer(modifier = Modifier.height(24.dp))
                
                Text(
                    "Your account will be 'Pending' and requires manual Admin approval.",
                    textAlign = TextAlign.Center,
                    color = Slate500,
                    fontSize = 11.sp,
                    fontWeight = FontWeight.Bold,
                    lineHeight = 16.sp
                )
            }
        }
    }
}
