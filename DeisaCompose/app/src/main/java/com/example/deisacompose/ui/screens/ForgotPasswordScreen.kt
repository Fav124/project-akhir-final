package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.filled.Email
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.ui.theme.*

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ForgotPasswordScreen(
    navController: NavHostController,
    viewModel: AuthViewModel = viewModel()
) {
    var email by remember { mutableStateOf("") }
    val isLoading by viewModel.isLoading.observeAsState(false)
    val successMessage by viewModel.registrationSuccess.observeAsState()
    val error by viewModel.error.observeAsState()

    DisposableEffect(Unit) {
        onDispose {
            viewModel.resetRegistrationSuccess()
            viewModel.clearError()
        }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Lupa Password", fontWeight = FontWeight.Bold) },
                navigationIcon = {
                    IconButton(onClick = { navController.navigateUp() }) {
                        Icon(Icons.Default.ArrowBack, contentDescription = "Back")
                    }
                },
                colors = TopAppBarDefaults.topAppBarColors(
                    containerColor = Color.White,
                    titleContentColor = Slate900
                )
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Text(
                text = "Masukkan email terdaftar Anda. Kami akan mencatat permintaan reset password Anda.",
                style = MaterialTheme.typography.bodyMedium,
                color = Slate500,
                textAlign = TextAlign.Center
            )

            Spacer(modifier = Modifier.height(32.dp))

            if (successMessage != null) {
                Surface(
                    color = SuccessGreen.copy(alpha = 0.1f),
                    shape = RoundedCornerShape(12.dp),
                    modifier = Modifier.fillMaxWidth()
                ) {
                    Text(
                        text = successMessage!!,
                        color = SuccessGreen,
                        modifier = Modifier.padding(16.dp),
                        textAlign = TextAlign.Center,
                        fontSize = 14.sp,
                        fontWeight = FontWeight.Medium
                    )
                }
                
                Spacer(modifier = Modifier.height(24.dp))
                
                Button(
                    onClick = { navController.navigateUp() },
                    modifier = Modifier.fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp)
                ) {
                    Text("KEMBALI KE LOGIN")
                }
            } else {
                OutlinedTextField(
                    value = email,
                    onValueChange = { email = it; viewModel.clearError() },
                    label = { Text("Email Address") },
                    modifier = Modifier.fillMaxWidth(),
                    shape = RoundedCornerShape(12.dp),
                    leadingIcon = { Icon(Icons.Default.Email, contentDescription = null) },
                    keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Email, imeAction = ImeAction.Done),
                    singleLine = true
                )

                if (error != null) {
                    Text(
                        text = error!!,
                        color = MaterialTheme.colorScheme.error,
                        fontSize = 12.sp,
                        modifier = Modifier.padding(top = 8.dp, start = 4.dp).fillMaxWidth()
                    )
                }

                Spacer(modifier = Modifier.height(32.dp))

                Button(
                    onClick = { viewModel.forgotPassword(email) },
                    modifier = Modifier.fillMaxWidth().height(56.dp),
                    shape = RoundedCornerShape(12.dp),
                    enabled = !isLoading && email.isNotBlank()
                ) {
                    if (isLoading) {
                        CircularProgressIndicator(color = Color.White, modifier = Modifier.size(24.dp))
                    } else {
                        Text("KIRIM PERMINTAAN", fontWeight = FontWeight.Bold)
                    }
                }
            }
        }
    }
}
