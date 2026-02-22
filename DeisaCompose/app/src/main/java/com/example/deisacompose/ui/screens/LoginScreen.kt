package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.animation.core.tween
import androidx.compose.animation.fadeIn
import androidx.compose.animation.fadeOut
import androidx.compose.animation.scaleIn
import androidx.compose.animation.slideInVertically
import androidx.compose.animation.slideOutVertically
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Email
import androidx.compose.material.icons.filled.Lock
import androidx.compose.material.icons.filled.Visibility
import androidx.compose.material.icons.filled.VisibilityOff
import androidx.compose.material3.ButtonDefaults
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Divider
import androidx.compose.material3.ExperimentalMaterial3Api
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Scaffold
import androidx.compose.material3.SnackbarHost
import androidx.compose.material3.SnackbarHostState
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.focus.FocusDirection
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.SolidColor
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.text.input.VisualTransformation
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.PremiumGradientButton
import com.example.deisacompose.ui.components.PremiumTextField
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun LoginScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    val currentUser by authViewModel.currentUser.collectAsState()
    val focusManager = LocalFocusManager.current
    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()

    var email by remember { mutableStateOf("") } // Clear default email
    var password by remember { mutableStateOf("") } // Clear default password
    var passwordVisible by remember { mutableStateOf(false) }
    var rememberMe by remember { mutableStateOf(false) } // Add state for Remember Me
    var showError by remember { mutableStateOf(false) }
    var errorMessage by remember { mutableStateOf("") }
    var isLoading by remember { mutableStateOf(false) }

    var visible by remember { mutableStateOf(false) }

    LaunchedEffect(Unit) {
        authViewModel.getCurrentUser() // Check if user is already logged in
        delay(100)
        visible = true
    }

    LaunchedEffect(currentUser) {
        if (currentUser != null) {
            navController.navigate(if (currentUser!!.role == "admin") "admin_dashboard" else "staff_dashboard") {
                popUpTo("login") { inclusive = true }
            }
        }
    }

    Scaffold(
        containerColor = DeisaNavy,
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) {
        Box(
            modifier = Modifier
                .fillMaxSize()
                .padding(it)
        ) {
            // Background animations
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
            AnimatedVisibility(
                visible = visible,
                enter = fadeIn(animationSpec = tween(1000, 1000)),
                exit = fadeOut(animationSpec = tween(500))
            ) {
                Box(
                    modifier = Modifier
                        .align(Alignment.BottomEnd)
                        .fillMaxSize()
                        .background(
                            Brush.radialGradient(
                                colors = listOf(DeisaBlue.copy(alpha = 0.1f), Color.Transparent),
                                radius = 800f
                            )
                        )
                )
            }

            // Main Content
            Column(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(32.dp),
                horizontalAlignment = Alignment.CenterHorizontally,
                verticalArrangement = Arrangement.Center
            ) {
                AnimatedVisibility(
                    visible = visible,
                    enter = fadeIn(animationSpec = tween(1000, 500)) + scaleIn(initialScale = 0.8f, animationSpec = tween(1000))
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
                        // Logo and Title
                        DeisaLogo(size = LogoSize.SM)
                        Spacer(modifier = Modifier.height(16.dp))
                        Text(
                            "DEISA",
                            style = MaterialTheme.typography.titleLarge,
                            fontWeight = FontWeight.Bold,
                            color = Color.White
                        )
                        Text(
                            "Dar El-Ilmi Kesehatan",
                            style = MaterialTheme.typography.bodySmall,
                            color = Color.Gray,
                            textAlign = TextAlign.Center
                        )

                        Spacer(modifier = Modifier.height(32.dp))

                        // Input Fields
                        PremiumTextField(
                            value = email,
                            onValueChange = { email = it },
                            label = "Alamat Email",
                            placeholder = "Masukkan email Anda",
                            leadingIcon = Icons.Default.Email,
                            error = if (showError) errorMessage else null,
                            keyboardOptions = KeyboardOptions(
                                keyboardType = KeyboardType.Email,
                                imeAction = ImeAction.Next
                            ),
                            keyboardActions = KeyboardActions(
                                onNext = { focusManager.moveFocus(FocusDirection.Down) }
                            )
                        )

                        Spacer(modifier = Modifier.height(16.dp))

                        PremiumTextField(
                            value = password,
                            onValueChange = { password = it },
                            label = "Kata Sandi",
                            placeholder = "Masukkan kata sandi",
                            leadingIcon = Icons.Default.Lock,
                            error = if (showError) errorMessage else null,

                            isPassword = true,
                            passwordVisible = passwordVisible,
                            onPasswordToggle = { passwordVisible = !passwordVisible },

                            keyboardOptions = KeyboardOptions(
                                keyboardType = KeyboardType.Password,
                                imeAction = ImeAction.Done
                            ),
                            keyboardActions = KeyboardActions(
                                onDone = {
                                    focusManager.clearFocus()
                                    if (email.isNotBlank() && password.isNotBlank()) {
                                        isLoading = true
                                        showError = false
                                        authViewModel.login(email, password) { result ->
                                            isLoading = false
                                            if (result.isFailure) {
                                                showError = true
                                                errorMessage = result.exceptionOrNull()?.message ?: "Login gagal"
                                            }
                                        }
                                    }
                                }
                            )
                        )

                        Spacer(modifier = Modifier.height(16.dp))

                        // Remember Me and Forgot Password
                        Row(
                            modifier = Modifier.fillMaxWidth(),
                            horizontalArrangement = Arrangement.SpaceBetween,
                            verticalAlignment = Alignment.CenterVertically
                        ) {
                            Row(verticalAlignment = Alignment.CenterVertically) {
                                androidx.compose.material3.Checkbox(
                                    checked = rememberMe,
                                    onCheckedChange = { rememberMe = it },
                                    colors = androidx.compose.material3.CheckboxDefaults.colors(
                                        checkedColor = DeisaBlue,
                                        uncheckedColor = Color.Gray,
                                        checkmarkColor = Color.White
                                    )
                                )
                                Text("Ingat Saya", color = Color.Gray, fontSize = 14.sp)
                            }
                            TextButton(onClick = { navController.navigate("forgot_password") }) {
                                Text("Lupa Sandi?", color = DeisaBlue, fontWeight = FontWeight.Bold)
                            }
                        }

                        Spacer(modifier = Modifier.height(24.dp))

                        // Login Button
                        PremiumGradientButton(
                            text = "Masuk",
                            onClick = {
                                if (email.isBlank() || password.isBlank()) {
                                    showError = true
                                    errorMessage = "Email dan password wajib diisi"
                                    return@PremiumGradientButton
                                }
                                
                                isLoading = true
                                showError = false
                                authViewModel.login(email, password) { result ->
                                    isLoading = false
                                    if (result.isFailure) {
                                        showError = true
                                        errorMessage = result.exceptionOrNull()?.message ?: "Login gagal"
                                    }
                                }
                            },
                            isLoading = isLoading
                        )

                        Spacer(modifier = Modifier.height(24.dp))

                        // Divider and Social Login
                        Row(verticalAlignment = Alignment.CenterVertically) {
                            Divider(modifier = Modifier.weight(1f), color = Color.White.copy(alpha = 0.1f))
                            Text("ATAU", modifier = Modifier.padding(horizontal = 16.dp), color = Color.Gray, fontSize = 12.sp)
                            Divider(modifier = Modifier.weight(1f), color = Color.White.copy(alpha = 0.1f))
                        }

                        Spacer(modifier = Modifier.height(24.dp))

                        // Social Login Buttons
                        OutlinedButton(
                            onClick = { /* TODO: Implement Google Sign-In */ },
                            modifier = Modifier.fillMaxWidth(),
                            shape = RoundedCornerShape(16.dp),
                            border = ButtonDefaults.outlinedButtonBorder.copy(brush = SolidColor(DeisaBlue))
                        ) {
                            Text("G", color = DeisaBlue, fontWeight = FontWeight.ExtraBold, fontSize = 18.sp, modifier = Modifier.padding(end = 8.dp))
                            Spacer(modifier = Modifier.width(8.dp))
                            Text("Masuk dengan Google", color = Color.White)
                        }
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
