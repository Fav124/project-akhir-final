package com.example.deisacompose.ui.components

import androidx.compose.animation.*
import androidx.compose.animation.core.*
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.scale
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.graphicsLayer
import androidx.compose.ui.unit.dp
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.SuccessGreen

@Composable
fun PulsingLoader(
    modifier: Modifier = Modifier,
    color: Color = DeisaBlue
) {
    val infiniteTransition = rememberInfiniteTransition()
    val scale by infiniteTransition.animateFloat(
        initialValue = 0.5f,
        targetValue = 1.2f,
        animationSpec = infiniteRepeatable(
            animation = tween(1000, easing = FastOutSlowInEasing),
            repeatMode = RepeatMode.Reverse
        )
    )
    val alpha by infiniteTransition.animateFloat(
        initialValue = 0.8f,
        targetValue = 0.2f,
        animationSpec = infiniteRepeatable(
            animation = tween(1000, easing = FastOutSlowInEasing),
            repeatMode = RepeatMode.Reverse
        )
    )

    Box(
        modifier = modifier.fillMaxSize(),
        contentAlignment = Alignment.Center
    ) {
        Box(
            modifier = Modifier
                .size(60.dp)
                .scale(scale)
                .background(color.copy(alpha = alpha), CircleShape)
        )
        Box(
            modifier = Modifier
                .size(30.dp)
                .background(color, CircleShape)
        )
    }
}

@Composable
fun GradientCard(
    modifier: Modifier = Modifier,
    colors: List<Color>,
    onClick: () -> Unit = {},
    content: @Composable ColumnScope.() -> Unit
) {
    Card(
        onClick = onClick,
        modifier = modifier,
        shape = RoundedCornerShape(24.dp),
        elevation = CardDefaults.cardElevation(defaultElevation = 8.dp),
        colors = CardDefaults.cardColors(containerColor = Color.Transparent)
    ) {
        Box(
            modifier = Modifier
                .background(
                    brush = Brush.linearGradient(colors = colors)
                )
                .padding(16.dp)
        ) {
            Column {
                content()
            }
        }
    }
}

@Composable
fun AnimatedNumber(
    number: Int,
    modifier: Modifier = Modifier,
    style: androidx.compose.ui.text.TextStyle = MaterialTheme.typography.displayMedium,
    color: Color = Color.White
) {
    val animatedValue by animateIntAsState(
        targetValue = number,
        animationSpec = tween(durationMillis = 1500, easing = FastOutSlowInEasing)
    )
    Text(
        text = animatedValue.toString(),
        style = style,
        color = color,
        modifier = modifier
    )
}
