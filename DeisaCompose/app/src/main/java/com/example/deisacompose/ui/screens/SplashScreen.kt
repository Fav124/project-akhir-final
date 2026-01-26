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
    val scale = remember { Animatable(0.8f) }
    val alpha = remember { Animatable(0f) }

    LaunchedEffect(Unit) {
        launch {
            scale.animateTo(
                1f,
                animationSpec = tween(800, easing = FastOutSlowInEasing)
            )
        }
        launch {
            alpha.animateTo(1f, animationSpec = tween(800))
        }
        delay(2500)
        navController.navigate("login") {
            popUpTo("splash") { inclusive = true }
        }
    }

    Box(
        modifier = Modifier
            .fillMaxSize()
            .background(Slate950),
        contentAlignment = Alignment.Center
    ) {
        Column(
            horizontalAlignment = Alignment.CenterHorizontally,
            modifier = Modifier
                .scale(scale.value)
                .alpha(alpha.value)
        ) {
            // Icon Card
            Surface(
                modifier = Modifier
                    .size(100.dp)
                    .shadow(elevation = 40.dp, spotColor = DeisaBlue, shape = RoundedCornerShape(32.dp)),
                color = DeisaBlue,
                shape = RoundedCornerShape(32.dp)
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Icon(
                        imageVector = Icons.Default.MedicalServices,
                        contentDescription = "Logo",
                        tint = Color.White,
                        modifier = Modifier.size(48.dp)
                    )
                }
            }

            Spacer(modifier = Modifier.height(32.dp))

            Text(
                text = "DEISA",
                color = Color.White,
                fontSize = 48.sp,
                fontWeight = FontWeight.Black,
                letterSpacing = (-2).sp
            )
            Text(
                text = "MOBILE",
                color = DeisaBlue,
                fontSize = 14.sp,
                fontWeight = FontWeight.Black,
                letterSpacing = 8.sp,
                modifier = Modifier.offset(y = (-8).dp)
            )

            Spacer(modifier = Modifier.height(8.dp))

            Text(
                text = "DAR EL-ILMI HEALTH ECOSYSTEM",
                color = Slate500,
                fontSize = 11.sp,
                fontWeight = FontWeight.Bold,
                letterSpacing = 2.sp
            )
        }

        CircularProgressIndicator(
            modifier = Modifier
                .align(Alignment.BottomCenter)
                .padding(bottom = 64.dp)
                .size(24.dp),
            color = DeisaBlue.copy(alpha = 0.3f),
            strokeWidth = 3.dp
        )
    }
}
