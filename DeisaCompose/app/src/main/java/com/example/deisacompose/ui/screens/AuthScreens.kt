package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.theme.PrimaryGreen
import com.example.deisacompose.ui.theme.PrimaryDark
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun LoginScreen(navController: NavController, viewModel: AuthViewModel = viewModel()) {
    var email by remember { mutableStateOf("") }
    var password by remember { mutableStateOf("") }
    
    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()
    
    val isLoading by viewModel.isLoading.observeAsState(false)
    val error by viewModel.error.observeAsState()
    val authSuccess by viewModel.authSuccess.observeAsState(false)

    LaunchedEffect(authSuccess) {
        if (authSuccess) {
            navController.navigate("home") {
                popUpTo("login") { inclusive = true }
            }
        }
    }
    
    LaunchedEffect(error) {
        error?.let {
            snackbarHostState.showSnackbar(it)
            viewModel.clearError()
        }
    }

    Scaffold(
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally,
            verticalArrangement = Arrangement.Center
        ) {
             Box(
                modifier = Modifier
                    .size(80.dp)
                    .background(PrimaryGreen, shape = androidx.compose.foundation.shape.CircleShape),
                contentAlignment = Alignment.Center
            ) {
                Text("+", fontSize = 48.sp, color = Color.White)
            }
            
            Spacer(modifier = Modifier.height(24.dp))
            
            Text("Selamat Datang", style = MaterialTheme.typography.titleLarge)
            Text("Masuk untuk melanjutkan", style = MaterialTheme.typography.bodyMedium, color = Color.Gray)
    
            Spacer(modifier = Modifier.height(32.dp))
    
            OutlinedTextField(
                value = email,
                onValueChange = { email = it },
                label = { Text("Surel (Email)") },
                modifier = Modifier.fillMaxWidth(),
                singleLine = true
            )
    
            Spacer(modifier = Modifier.height(16.dp))
    
            OutlinedTextField(
                value = password,
                onValueChange = { password = it },
                label = { Text("Kata Sandi") },
                 visualTransformation = PasswordVisualTransformation(),
                modifier = Modifier.fillMaxWidth(),
                singleLine = true
            )
    
            Spacer(modifier = Modifier.height(24.dp))
    
            Button(
                onClick = { 
                    if (email.isEmpty() || password.isEmpty()) {
                        scope.launch { snackbarHostState.showSnackbar("Surel dan kata sandi wajib diisi") }
                        return@Button
                    }
                    viewModel.login(email, password) 
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(50.dp),
                colors = ButtonDefaults.buttonColors(containerColor = PrimaryGreen)
            ) {
                 if (isLoading) {
                    CircularProgressIndicator(color = Color.White, modifier = Modifier.size(24.dp))
                } else {
                    Text("Masuk Sekarang", color = PrimaryDark)
                }
            }
    
            Spacer(modifier = Modifier.height(16.dp))
            
            TextButton(onClick = { navController.navigate("register") }) {
                Text("Belum punya akun? Ajukan Akses")
            }
        }
    }
}

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun RegisterScreen(navController: NavController, viewModel: AuthViewModel = viewModel()) {
    var name by remember { mutableStateOf("") }
    var email by remember { mutableStateOf("") }
    var password by remember { mutableStateOf("") }
    var confirmPassword by remember { mutableStateOf("") }
    
    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()
    
    val isLoading by viewModel.isLoading.observeAsState(false)
    val successMsg by viewModel.registrationSuccess.observeAsState()
    val error by viewModel.error.observeAsState()

     if (successMsg != null) {
        AlertDialog(
            onDismissRequest = { 
                viewModel.resetRegistrationSuccess()
                navController.popBackStack() 
            },
            title = { Text("Permintaan Terkirim") },
            text = { Text(successMsg!!) },
            confirmButton = {
                Button(onClick = {
                    viewModel.resetRegistrationSuccess()
                    navController.popBackStack()
                }) {
                    Text("Siap")
                }
            }
        )
    }
    
    LaunchedEffect(error) {
        error?.let {
            snackbarHostState.showSnackbar(it)
            viewModel.clearError()
        }
    }

    Scaffold(
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Text("Buat Akun Baru", style = MaterialTheme.typography.titleLarge)
            Spacer(modifier = Modifier.height(32.dp))
    
            OutlinedTextField(
                value = name,
                onValueChange = { name = it },
                label = { Text("Nama Lengkap") },
                modifier = Modifier.fillMaxWidth()
            )
            
            Spacer(modifier = Modifier.height(16.dp))
    
            OutlinedTextField(
                value = email,
                onValueChange = { email = it },
                label = { Text("Surel (Email)") },
                modifier = Modifier.fillMaxWidth()
            )
    
            Spacer(modifier = Modifier.height(16.dp))
    
            OutlinedTextField(
                value = password,
                onValueChange = { password = it },
                label = { Text("Kata Sandi") },
                 visualTransformation = PasswordVisualTransformation(),
                modifier = Modifier.fillMaxWidth()
            )
            
             Spacer(modifier = Modifier.height(16.dp))
    
            OutlinedTextField(
                value = confirmPassword,
                onValueChange = { confirmPassword = it },
                label = { Text("Konfirmasi Kata Sandi") },
                 visualTransformation = PasswordVisualTransformation(),
                modifier = Modifier.fillMaxWidth()
            )
    
            Spacer(modifier = Modifier.height(24.dp))
    
            Button(
                onClick = { 
                    if (name.isEmpty() || email.isEmpty() || password.isEmpty()) {
                        scope.launch { snackbarHostState.showSnackbar("Mohon lengkapi semua data") }
                        return@Button
                    }
                    if (password == confirmPassword) {
                        viewModel.register(name, email, password) 
                    } else {
                        scope.launch { snackbarHostState.showSnackbar("Konfirmasi kata sandi tidak cocok") }
                    }
                },
                modifier = Modifier
                    .fillMaxWidth()
                    .height(50.dp),
                colors = ButtonDefaults.buttonColors(containerColor = PrimaryGreen)
            ) {
                 if (isLoading) {
                    CircularProgressIndicator(color = Color.White, modifier = Modifier.size(24.dp))
                } else {
                    Text("Ajukan Pendaftaran", color = PrimaryDark)
                }
            }
            
             Spacer(modifier = Modifier.height(16.dp))
            
            TextButton(onClick = { navController.popBackStack() }) {
                Text("Sudah punya akun? Masuk")
            }
        }
    }
}
