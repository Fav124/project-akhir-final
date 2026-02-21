package com.example.deisacompose.ui.screens

import androidx.compose.animation.core.Animatable
import androidx.compose.animation.core.FastOutSlowInEasing
import androidx.compose.animation.core.Spring
import androidx.compose.animation.core.spring
import androidx.compose.animation.core.tween
import androidx.compose.animation.core.RepeatMode
import androidx.compose.animation.core.animateFloat
import androidx.compose.animation.core.infiniteRepeatable
import androidx.compose.animation.core.rememberInfiniteTransition
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.offset
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.MedicalServices
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Icon
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.alpha
import androidx.compose.ui.draw.scale
import androidx.compose.ui.draw.shadow
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.graphicsLayer
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.compose.ui.platform.LocalContext
import androidx.navigation.NavHostController
import com.example.deisacompose.data.network.ApiClient
import com.example.deisacompose.data.repository.AuthRepository
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaBluePrimary
import com.example.deisacompose.ui.theme.Slate50
import com.example.deisacompose.ui.theme.Slate400
import com.example.deisacompose.ui.theme.Slate500
import com.example.deisacompose.ui.theme.Slate900
import com.example.deisacompose.ui.theme.Slate950
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch
import com.example.deisacompose.ui.components.DeisaLogo
import com.example.deisacompose.ui.components.LogoShape
import com.example.deisacompose.ui.components.LogoSize
import com.example.deisacompose.ui.components.LogoVariant
import com.example.deisacompose.ui.theme.DeisaNavy

@Composable
fun SplashScreen(navController: NavHostController) {
    val logoScale = remember { Animatable(0f) }
    val logoAlpha = remember { Animatable(0f) }
    
    val titleAlpha = remember { Animatable(0f) }
    val titleOffsetY = remember { Animatable(20f) }
    
    val subtitleAlpha = remember { Animatable(0f) }
    val footerAlpha = remember { Animatable(0f) }
    
    val pulsingGlow = rememberInfiniteTransition(label = "glow")
    val glowRadius by pulsingGlow.animateFloat(
        initialValue = 400f,
        targetValue = 800f,
        animationSpec = infiniteRepeatable(
            animation = tween(3000, easing = FastOutSlowInEasing),
            repeatMode = RepeatMode.Reverse
        ),
        label = "glowRadius"
    )

    LaunchedEffect(Unit) {
        // Log-in/Session logic
        val token = ApiClient.getSessionManager().fetchAuthToken()
        val role = ApiClient.getSessionManager().fetchUserRole()
        
        // Staggered Animation Choreography
        launch {
            logoScale.animateTo(
                1f,
                animationSpec = spring(
                    dampingRatio = Spring.DampingRatioMediumBouncy,
                    stiffness = Spring.StiffnessLow
                )
            )
        }
        launch {
            logoAlpha.animateTo(1f, animationSpec = tween(1000))
        }
        
        launch {
            delay(400)
            titleAlpha.animateTo(1f, animationSpec = tween(800))
            titleOffsetY.animateTo(0f, animationSpec = spring(stiffness = Spring.StiffnessLow))
        }
        
        launch {
            delay(800)
            subtitleAlpha.animateTo(1f, animationSpec = tween(800))
        }
        
        launch {
            delay(1200)
            footerAlpha.animateTo(0.5f, animationSpec = tween(1000))
        }

        delay(3500) // Give user time to appreciate the "Wow"
        
        var destination = "login"
        
        if (!token.isNullOrEmpty()) {
            // Pre-flight check: Verify token with server
            val result = AuthRepository().getCurrentUser()
            if (result.isSuccess) {
                destination = when (role) {
                    "admin" -> "admin_dashboard"
                    "petugas" -> "staff_dashboard"
                    else -> "login"
                }
            } else {
                // Token invalid or expired
                ApiClient.getSessionManager().clearAuthToken()
            }
        }
        
        navController.navigate(destination) {
            popUpTo("splash") { inclusive = true }
        }
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(DeisaNavy),
        contentAlignment = Alignment.Center
    ) {
        // Background Ambient Glow
        Box(
            modifier = Modifier
                .fillMaxSize()
                .background(
                    Brush.radialGradient(
                        colors = listOf(DeisaBlue.copy(alpha = 0.15f), Color.Transparent),
                        radius = glowRadius
                    )
                )
        )

        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
        ) {
            // Animated Icon
            Box(
                modifier = Modifier
                    .scale(logoScale.value)
                    .alpha(logoAlpha.value),
                contentAlignment = Alignment.Center
            ) {
                 DeisaLogo(
                     size = LogoSize.XXL,
                     variant = LogoVariant.DEFAULT,
                     shape = LogoShape.CIRCLE
                 )
            }

            Spacer(modifier = Modifier.height(48.dp))

            // Animated Title Bundle
            Column(
                horizontalAlignment = Alignment.CenterHorizontally,
                modifier = Modifier
                    .offset(y = titleOffsetY.value.dp)
                    .alpha(titleAlpha.value)
            ) {
                Text(
                    text = "DEISA",
                    color = Color.White,
                    fontSize = 58.sp,
                    fontWeight = FontWeight.Black,
                    letterSpacing = (-2).sp,
                    style = MaterialTheme.typography.displayLarge
                )
                Text(
                    text = "MOBILE",
                    color = DeisaBlue,
                    fontSize = 18.sp,
                    fontWeight = FontWeight.Black,
                    letterSpacing = 10.sp,
                    modifier = Modifier.offset(y = (-12).dp)
                )
            }

            Spacer(modifier = Modifier.height(16.dp))

            Text(
                text = "DAR EL-ILMI HEALTH ECOSYSTEM",
                color = Color.White.copy(alpha = 0.4f),
                fontSize = 12.sp,
                fontWeight = FontWeight.Bold,
                letterSpacing = 3.sp,
                modifier = Modifier.alpha(subtitleAlpha.value)
            )
        }

        // Animated Footer
        Column(
            modifier = Modifier
                .align(Alignment.BottomCenter)
                .padding(bottom = 48.dp)
                .alpha(footerAlpha.value),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            CircularProgressIndicator(
                modifier = Modifier.size(24.dp),
                color = DeisaBlue,
                strokeWidth = 2.dp
            )
            Spacer(modifier = Modifier.height(16.dp))
            Text(
                "Versi 2.0.0-PRO",
                style = MaterialTheme.typography.labelSmall,
                color = Color.White,
                fontWeight = FontWeight.Light
            )
        }
    }
}
