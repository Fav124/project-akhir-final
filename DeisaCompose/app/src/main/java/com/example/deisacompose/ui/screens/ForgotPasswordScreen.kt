package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.animation.core.tween
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.PremiumGradientButton
import com.example.deisacompose.ui.components.PremiumTextField
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ForgotPasswordScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    var email by remember { mutableStateOf("") }
    var showSuccess by remember { mutableStateOf(false) }
    var showError by remember { mutableStateOf(false) }
    var errorMessage by remember { mutableStateOf("") }
    var successMessage by remember { mutableStateOf("") }
    var isLoading by remember { mutableStateOf(false) }

    val focusManager = LocalFocusManager.current
    val scope = rememberCoroutineScope()

    var visible by remember { mutableStateOf(false) }
    LaunchedEffect(Unit) {
        delay(100)
        visible = true
    }

    Scaffold(
        containerColor = DeisaNavy
    ) { padding ->
        Box(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
        ) {
            // Background animations (matching LoginScreen)
            AnimatedVisibility(
                visible = visible,
                enter = fadeIn(animationSpec = tween(1000, 500)),
                exit = fadeOut(animationSpec = tween(500))
            ) {
                Box(
                    modifier = Modifier
                        .fillMaxSize()
                        .background(
                            Brush.radialGradient(
                                colors = listOf(DeisaBlue.copy(alpha = 0.1f), Color.Transparent),
                                radius = 800f
                            )
                        )
                )
            }

            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(32.dp),
                horizontalAlignment = Alignment.CenterHorizontally,
                verticalArrangement = Arrangement.Center
            ) {
                // Header
                AnimatedVisibility(
                    visible = visible,
                    enter = fadeIn(animationSpec = tween(1000, 500)) + scaleIn(initialScale = 0.8f)
                ) {
                    Column(
                        horizontalAlignment = Alignment.CenterHorizontally,
                        modifier = Modifier
                            .fillMaxWidth()
                            .clip(RoundedCornerShape(32.dp))
                            .background(DeisaSoftNavy.copy(alpha = 0.8f))
                            .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(32.dp))
                            .padding(32.dp)
                    ) {
                        DeisaLogo(size = LogoSize.SM)
                        Spacer(modifier = Modifier.height(16.dp))
                        Text(
                            "Lupa Kata Sandi",
                            style = MaterialTheme.typography.titleLarge,
                            fontWeight = FontWeight.Bold,
                            color = Color.White
                        )
                        Text(
                            "Kami akan mengirimkan tautan reset ke email Anda",
                            style = MaterialTheme.typography.bodySmall,
                            color = Color.Gray,
                            textAlign = TextAlign.Center
                        )

                        Spacer(modifier = Modifier.height(32.dp))

                        PremiumTextField(
                            value = email,
                            onValueChange = { email = it },
                            label = "Alamat Email",
                            placeholder = "Masukkan email terdaftar",
                            leadingIcon = Icons.Default.Email,
                            error = if (showError) errorMessage else null,
                            keyboardOptions = KeyboardOptions(
                                keyboardType = KeyboardType.Email,
                                imeAction = ImeAction.Done
                            ),
                            keyboardActions = KeyboardActions(
                                onDone = {
                                    focusManager.clearFocus()
                                    if (email.isNotBlank()) {
                                        isLoading = true
                                        showError = false
                                        showSuccess = false
                                        authViewModel.forgotPassword(email) { result ->
                                            isLoading = false
                                            if (result.isSuccess) {
                                                showSuccess = true
                                                successMessage = result.getOrNull() ?: "Link reset dikirim"
                                            } else {
                                                showError = true
                                                errorMessage = result.exceptionOrNull()?.message ?: "Gagal mengirim link"
                                            }
                                        }
                                    }
                                }
                            )
                        )

                        Spacer(modifier = Modifier.height(24.dp))

                        PremiumGradientButton(
                            text = "Kirim Instruksi",
                            onClick = {
                                if (email.isNotBlank()) {
                                    isLoading = true
                                    showError = false
                                    showSuccess = false
                                    authViewModel.forgotPassword(email) { result ->
                                        isLoading = false
                                        if (result.isSuccess) {
                                            showSuccess = true
                                            successMessage = result.getOrNull() ?: "Link reset dikirim"
                                        } else {
                                            showError = true
                                            errorMessage = result.exceptionOrNull()?.message ?: "Gagal mengirim link"
                                        }
                                    }
                                } else {
                                    errorMessage = "Email wajib diisi"
                                    showError = true
                                }
                            },
                            isLoading = isLoading
                        )

                        Spacer(modifier = Modifier.height(24.dp))

                        TextButton(
                            onClick = { navController.navigate("login") }
                        ) {
                            Icon(Icons.Default.ArrowBack, contentDescription = null, modifier = Modifier.size(16.dp), tint = DeisaBlue)
                            Spacer(modifier = Modifier.width(8.dp))
                            Text("Kembali ke Masuk", color = DeisaBlue, fontWeight = FontWeight.Bold)
                        }
                    }
                }
            }

            // Success Snackbar (Integrated style)
            AnimatedVisibility(
                visible = showSuccess,
                enter = slideInVertically { it } + fadeIn(),
                exit = slideOutVertically { it } + fadeOut(),
                modifier = Modifier
                    .align(Alignment.BottomCenter)
                    .padding(32.dp)
            ) {
                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(12.dp))
                        .background(SuccessGreen)
                        .padding(horizontal = 16.dp, vertical = 12.dp)
                ) {
                    Row(verticalAlignment = Alignment.CenterVertically) {
                        Icon(Icons.Default.CheckCircle, null, tint = Color.White)
                        Spacer(modifier = Modifier.width(12.dp))
                        Text(successMessage, color = Color.White, fontWeight = FontWeight.Bold)
                    }
                }
            }

            // Error message display
            AnimatedVisibility(
                visible = showError,
                enter = fadeIn(),
                exit = fadeOut(),
                modifier = Modifier
                    .align(Alignment.BottomCenter)
                    .padding(bottom = 32.dp)
            ) {
                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(12.dp))
                        .background(DangerRed)
                        .padding(horizontal = 16.dp, vertical = 12.dp)
                ) {
                    Text(errorMessage, color = Color.White, fontWeight = FontWeight.Bold)
                }
            }
        }
    }
}
