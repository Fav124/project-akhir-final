package com.example.deisacompose.ui.screens

import androidx.compose.animation.core.Animatable
import androidx.compose.animation.core.FastOutSlowInEasing
import androidx.compose.animation.core.Spring
import androidx.compose.animation.core.spring
import androidx.compose.animation.core.tween
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.MedicalServices
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Icon
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.alpha
import androidx.compose.ui.draw.scale
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.graphicsLayer
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import androidx.navigation.NavHostController
import com.example.deisacompose.ui.theme.DeisaBlue
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@Composable
fun SplashScreen(navController: NavHostController) {
    // Logo scale animation
    val logoScale = remember { Animatable(0f) }
    val logoAlpha = remember { Animatable(0f) }

    // Title animations
    val titleAlpha = remember { Animatable(0f) }
    val titleOffset = remember { Animatable(50f) }

    // Subtitle animation
    val subtitleAlpha = remember { Animatable(0f) }

    // Pulsing circle animation
    val pulseScale = remember { Animatable(1f) }
    val pulseAlpha = remember { Animatable(0.3f) }

    LaunchedEffect(key1 = true) {
        // Start logo animation
        launch {
            logoAlpha.animateTo(
                targetValue = 1f,
                animationSpec = tween(800, easing = FastOutSlowInEasing)
            )
            logoScale.animateTo(
                targetValue = 1f,
                animationSpec = spring(
                    dampingRatio = Spring.DampingRatioMediumBouncy,
                    stiffness = Spring.StiffnessLow
                )
            )
        }

        delay(300)

        // Start title animation
        launch {
            titleAlpha.animateTo(1f, animationSpec = tween(600))
            titleOffset.animateTo(0f, animationSpec = spring(
                dampingRatio = Spring.DampingRatioMediumBouncy
            ))
        }

        delay(400)

        // Start subtitle animation
        launch {
            subtitleAlpha.animateTo(1f, animationSpec = tween(600))
        }

        // Continuous pulse animation
        launch {
            while (true) {
                pulseScale.animateTo(
                    1.3f,
                    animationSpec = tween(1000, easing = FastOutSlowInEasing)
                )
                pulseAlpha.animateTo(0f, animationSpec = tween(1000))
                pulseScale.animateTo(
                    1f,
                    animationSpec = tween(1000, easing = FastOutSlowInEasing)
                )
                pulseAlpha.animateTo(0.3f, animationSpec = tween(1000))
            }
        }

        delay(2500L)
        navController.navigate("login") {
            popUpTo("splash") { inclusive = true }
        }
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(
                brush = androidx.compose.ui.graphics.Brush.verticalGradient(
                    colors = listOf(
                        DeisaBlue,
                        DeisaBlue.copy(alpha = 0.8f)
                    )
                )
            ),
        contentAlignment = Alignment.Center
    ) {
        // Animated background circles
        Box(
            modifier = Modifier
                .size(200.dp * pulseScale.value)
                .graphicsLayer { alpha = pulseAlpha.value }
                .background(Color.White.copy(alpha = 0.1f), CircleShape),
            contentAlignment = Alignment.Center
        ) {}

        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
            modifier = Modifier.alpha(logoAlpha.value)
        ) {
            // Logo with medical icon
            Box(
                modifier = Modifier
                    .size(120.dp)
                    .scale(logoScale.value)
                    .background(
                        Color.White,
                        RoundedCornerShape(28.dp)
                    )
                    .graphicsLayer {
                        rotationY = logoScale.value * 180f
                    },
                contentAlignment = Alignment.Center
            ) {
                Icon(
                    imageVector = Icons.Default.MedicalServices,
                    contentDescription = "DEISA Logo",
                    tint = DeisaBlue,
                    modifier = Modifier.size(64.dp)
                )
            }

            Spacer(modifier = Modifier.height(32.dp))

            // App Name with animation
            Text(
                text = "DEISA",
                color = Color.White,
                fontSize = 42.sp,
                fontWeight = FontWeight.ExtraBold,
                modifier = Modifier
                    .alpha(titleAlpha.value)
                    .graphicsLayer { translationY = titleOffset.value },
                letterSpacing = 4.sp
            )

            Text(
                text = "Dar El-Ilmi Kesehatan",
                color = Color.White.copy(alpha = 0.9f),
                fontSize = 16.sp,
                fontWeight = FontWeight.Medium,
                modifier = Modifier
                    .alpha(subtitleAlpha.value)
                    .graphicsLayer { translationY = titleOffset.value },
                letterSpacing = 1.sp
            )

            Spacer(modifier = Modifier.height(8.dp))

            Text(
                text = "Sistem Manajemen Kesehatan Santri",
                color = Color.White.copy(alpha = 0.7f),
                fontSize = 12.sp,
                textAlign = TextAlign.Center,
                modifier = Modifier.alpha(subtitleAlpha.value)
            )
        }

        // Loading indicator at bottom
        CircularProgressIndicator(
            modifier = Modifier
                .align(Alignment.BottomCenter)
                .padding(bottom = 80.dp)
                .alpha(subtitleAlpha.value),
            color = Color.White,
            strokeWidth = 3.dp
        )
    }
}
