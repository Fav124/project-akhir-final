package com.example.deisacompose.ui.screens

import androidx.compose.animation.*
import androidx.compose.animation.core.tween
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardActions
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.focus.FocusDirection
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.platform.LocalFocusManager
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.ImeAction
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.PremiumTextField
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.ui.theme.SuccessGreen
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@Composable
fun RegisterScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    val focusManager = LocalFocusManager.current
    val scope = rememberCoroutineScope()

    var name by remember { mutableStateOf("") }
    var email by remember { mutableStateOf("") }
    var password by remember { mutableStateOf("") }
    var passwordConfirmation by remember { mutableStateOf("") }
    var role by remember { mutableStateOf("petugas") }

    var passwordVisible by remember { mutableStateOf(false) }
    var confirmPasswordVisible by remember { mutableStateOf(false) }

    // Validation States
    var nameError by remember { mutableStateOf<String?>(null) }
    var emailError by remember { mutableStateOf<String?>(null) }
    var passwordError by remember { mutableStateOf<String?>(null) }
    var confirmError by remember { mutableStateOf<String?>(null) }

    var generalError by remember { mutableStateOf<String?>(null) }
    var generalSuccess by remember { mutableStateOf<String?>(null) }
    var isLoading by remember { mutableStateOf(false) }

    var visible by remember { mutableStateOf(false) }
    LaunchedEffect(Unit) {
        delay(100)
        visible = true
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(DeisaNavy)
    ) {
        // Decorative Background Elements
        AnimatedVisibility(
            visible = visible,
            enter = fadeIn(animationSpec = tween(1000, 500))
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
                .padding(horizontal = 32.dp)
                .verticalScroll(rememberScrollState()),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Spacer(modifier = Modifier.height(64.dp))

            // Logo & Header
            AnimatedVisibility(
                visible = visible,
                enter = fadeIn() + expandVertically()
            ) {
                Column(
                    horizontalAlignment = Alignment.CenterHorizontally,
                    modifier = Modifier.padding(bottom = 32.dp)
                ) {
                    DeisaLogo(size = LogoSize.MD)
                    Spacer(modifier = Modifier.height(16.dp))
                    Text(
                        text = "Buat Akses Baru",
                        style = MaterialTheme.typography.headlineSmall,
                        fontWeight = FontWeight.Bold,
                        color = Color.White
                    )
                    Text(
                        text = "Bergabung dengan ekosistem kesehatan pesantren",
                        style = MaterialTheme.typography.bodySmall,
                        color = Color.Gray
                    )
                }
            }

            // Registration Card
            AnimatedVisibility(
                visible = visible,
                enter = fadeIn(animationSpec = tween(600)) + slideInVertically(animationSpec = tween(600)) { it / 4 }
            ) {
                Column(
                    modifier = Modifier
                        .fillMaxWidth()
                        .clip(RoundedCornerShape(32.dp))
                        .background(DeisaSoftNavy.copy(alpha = 0.8f))
                        .border(1.dp, Color.White.copy(alpha = 0.05f), RoundedCornerShape(32.dp))
                        .padding(24.dp),
                    horizontalAlignment = Alignment.CenterHorizontally
                ) {
                    // Personal Section
                    Text(
                        "PROFIL PERSONAL",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.fillMaxWidth().padding(bottom = 16.dp)
                    )

                    PremiumTextField(
                        value = name,
                        onValueChange = {
                            name = it
                            nameError = if (it.isBlank()) "Nama lengkap wajib diisi" else null
                        },
                        label = "Nama Lengkap",
                        placeholder = "Masukkan nama lengkap",
                        leadingIcon = Icons.Default.Person,
                        error = nameError,
                        keyboardOptions = KeyboardOptions(imeAction = ImeAction.Next),
                        keyboardActions = KeyboardActions(onNext = { focusManager.moveFocus(FocusDirection.Down) })
                    )

                    Spacer(modifier = Modifier.height(16.dp))

                    PremiumTextField(
                        value = email,
                        onValueChange = {
                            email = it
                            emailError = if (it.isBlank()) "Email wajib diisi" else if (!android.util.Patterns.EMAIL_ADDRESS.matcher(it).matches()) "Format email tidak valid" else null
                        },
                        label = "Alamat Email",
                        placeholder = "nama@domain.com",
                        leadingIcon = Icons.Default.Email,
                        error = emailError,
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Email, imeAction = ImeAction.Next),
                        keyboardActions = KeyboardActions(onNext = { focusManager.moveFocus(FocusDirection.Down) })
                    )

                    Spacer(modifier = Modifier.height(24.dp))

                    // Authorization Section
                    Text(
                        "TINGKAT AKSES",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.fillMaxWidth().padding(bottom = 16.dp)
                    )

                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        listOf("petugas" to "Petugas", "admin" to "Admin").forEach { (id, label) ->
                            val isSelected = role == id
                            Box(
                                modifier = Modifier
                                    .weight(1f)
                                    .height(48.dp)
                                    .clip(RoundedCornerShape(12.dp))
                                    .background(if (isSelected) DeisaBlue else DeisaNavy)
                                    .border(1.dp, if (isSelected) DeisaBlue else Color.White.copy(alpha = 0.05f), RoundedCornerShape(12.dp))
                                    .clickable { role = id },
                                contentAlignment = Alignment.Center
                            ) {
                                Text(
                                    text = label,
                                    style = MaterialTheme.typography.bodyMedium,
                                    fontWeight = if (isSelected) FontWeight.Bold else FontWeight.Medium,
                                    color = if (isSelected) Color.White else Color.Gray
                                )
                            }
                        }
                    }

                    Spacer(modifier = Modifier.height(24.dp))

                    // Security Section
                    Text(
                        "KREDENSIAL KEAMANAN",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.fillMaxWidth().padding(bottom = 16.dp)
                    )

                    PremiumTextField(
                        value = password,
                        onValueChange = {
                            password = it
                            passwordError = if (it.length < 6) "Minimal 6 karakter" else null
                        },
                        label = "Kata Sandi",
                        placeholder = "••••••••",
                        leadingIcon = Icons.Default.Lock,
                        isPassword = true,
                        passwordVisible = passwordVisible,
                        onPasswordToggle = { passwordVisible = !passwordVisible },
                        error = passwordError,
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Password, imeAction = ImeAction.Next),
                        keyboardActions = KeyboardActions(onNext = { focusManager.moveFocus(FocusDirection.Down) })
                    )

                    Spacer(modifier = Modifier.height(16.dp))

                    PremiumTextField(
                        value = passwordConfirmation,
                        onValueChange = {
                            passwordConfirmation = it
                            confirmError = if (it != password) "Kata sandi tidak cocok" else null
                        },
                        label = "Konfirmasi Kata Sandi",
                        placeholder = "••••••••",
                        leadingIcon = Icons.Default.Lock,
                        isPassword = true,
                        passwordVisible = confirmPasswordVisible,
                        onPasswordToggle = { confirmPasswordVisible = !confirmPasswordVisible },
                        error = confirmError,
                        keyboardOptions = KeyboardOptions(keyboardType = KeyboardType.Password, imeAction = ImeAction.Done),
                        keyboardActions = KeyboardActions(onDone = {
                            focusManager.clearFocus()
                            if (name.isNotBlank() && email.isNotBlank() && password.isNotBlank() && passwordConfirmation == password) {
                                isLoading = true
                                generalError = null
                                authViewModel.register(name, email, password, passwordConfirmation, role) { result ->
                                    isLoading = false
                                    if (result.isSuccess) {
                                        generalSuccess = result.getOrNull() ?: "Registrasi berhasil"
                                        scope.launch {
                                            delay(2000)
                                            navController.navigate("login") {
                                                popUpTo("register") { inclusive = true }
                                            }
                                        }
                                    } else {
                                        generalError = result.exceptionOrNull()?.message ?: "Registrasi gagal"
                                    }
                                }
                            }
                        })
                    )

                    Spacer(modifier = Modifier.height(32.dp))

                    com.example.deisacompose.ui.components.PremiumGradientButton(
                        text = "Daftar Sekarang",
                        onClick = {
                            if (name.isNotBlank() && email.isNotBlank() && password.isNotBlank() && passwordConfirmation == password && nameError == null && emailError == null && passwordError == null && confirmError == null) {
                                isLoading = true
                                generalError = null
                                authViewModel.register(name, email, password, passwordConfirmation, role) { result ->
                                    isLoading = false
                                    if (result.isSuccess) {
                                        generalSuccess = result.getOrNull() ?: "Registrasi berhasil"
                                        scope.launch {
                                            delay(2000)
                                            navController.navigate("login") {
                                                popUpTo("register") { inclusive = true }
                                            }
                                        }
                                    } else {
                                        generalError = result.exceptionOrNull()?.message ?: "Registrasi gagal"
                                    }
                                }
                            } else {
                                if (name.isBlank()) nameError = "Nama wajib diisi"
                                if (email.isBlank()) emailError = "Email wajib diisi"
                                if (password.isBlank()) passwordError = "Kata sandi wajib diisi"
                                if (passwordConfirmation != password) confirmError = "Kata sandi tidak cocok"
                            }
                        },
                        isLoading = isLoading
                    )

                    Spacer(modifier = Modifier.height(24.dp))

                    Row(verticalAlignment = Alignment.CenterVertically) {
                        Text("Sudah punya akun?", style = MaterialTheme.typography.bodySmall, color = Color.Gray)
                        Spacer(modifier = Modifier.width(6.dp))
                        Text(
                            "Masuk Sekarang",
                            style = MaterialTheme.typography.bodySmall,
                            fontWeight = FontWeight.ExtraBold,
                            color = Color.White,
                            modifier = Modifier.clickable { navController.navigate("login") }
                        )
                    }
                }
            }
            Spacer(modifier = Modifier.height(48.dp))
        }

        // Integrated Feedback
        AnimatedVisibility(
            visible = generalError != null || generalSuccess != null,
            enter = slideInVertically { it } + fadeIn(),
            exit = slideOutVertically { it } + fadeOut(),
            modifier = Modifier.align(Alignment.BottomCenter).padding(24.dp)
        ) {
            val isSuccess = generalSuccess != null
            Box(
                modifier = Modifier
                    .fillMaxWidth()
                    .clip(RoundedCornerShape(16.dp))
                    .background(if (isSuccess) SuccessGreen.copy(alpha = 0.9f) else DangerRed.copy(alpha = 0.9f))
                    .padding(16.dp)
            ) {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Icon(if (isSuccess) Icons.Default.CheckCircle else Icons.Default.Warning, null, tint = Color.White)
                    Spacer(modifier = Modifier.width(12.dp))
                    Text(generalSuccess ?: generalError ?: "", color = Color.White, fontWeight = FontWeight.Bold)
                }
            }
        }
    }
}
