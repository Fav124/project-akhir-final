package com.example.deisacompose.ui.screens

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.material3.Text
import androidx.compose.runtime.*
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.theme.PrimaryGreen
import com.example.deisacompose.ui.theme.PrimaryDark
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.MainViewModel
import kotlinx.coroutines.delay

@Composable
fun SplashScreen(
    navController: NavController, 
    mainViewModel: MainViewModel = viewModel()
) {
    val user by mainViewModel.currentUser.observeAsState()
    var isChecking by remember { mutableStateOf(true) }
    
    LaunchedEffect(Unit) {
        // Minimum branding time
        val minDelay = kotlinx.coroutines.async { delay(2000) }
        
        // Check API
        // actually mainViewModel.fetchUser() implicitly checks token validity
        // If fetchUser fails (401), user stays null. If succeeds, user is set.
        mainViewModel.fetchUser() 
        
        minDelay.await()
        isChecking = false
    }
    
    LaunchedEffect(isChecking, user) {
        if (!isChecking) {
             val prefs = navController.context.getSharedPreferences("app_prefs", android.content.Context.MODE_PRIVATE)
             val token = prefs.getString("token", null)

            if (user != null) {
                navController.navigate("home") { popUpTo("splash") { inclusive = true } }
            } else if (!token.isNullOrEmpty() && user == null) {
                // Token exists but user fetch failed/is taking long -> likely expired or network error
                // For safety, let's try one more check or just go to login
                 navController.navigate("login") { popUpTo("splash") { inclusive = true } }
            } else {
                 navController.navigate("login") { popUpTo("splash") { inclusive = true } }
            }
        }
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(Color.White),
        contentAlignment = Alignment.Center
    ) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
             // Logo
            Box(
                modifier = Modifier
                    .size(100.dp)
                    .background(PrimaryGreen, shape = androidx.compose.foundation.shape.CircleShape),
                contentAlignment = Alignment.Center
            ) {
                Text("+", fontSize = 48.sp, color = Color.White, fontWeight = FontWeight.Bold)
            }
            
            Spacer(modifier = Modifier.height(16.dp))
            
            Text(
                text = "Santri Health",
                fontSize = 24.sp,
                fontWeight = FontWeight.Bold,
                color = PrimaryDark
            )
            
            Spacer(modifier = Modifier.height(32.dp))
            
            androidx.compose.material3.CircularProgressIndicator(color = PrimaryGreen)
        }
    }
}
