package com.example.deisacompose.ui.components

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.Dp
import androidx.compose.ui.unit.TextUnit
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp

import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.MedicalServices
import androidx.compose.material3.Icon

enum class LogoSize(val size: Dp, val iconSize: Dp, val cornerRadius: Dp) {
    XS(24.dp, 12.dp, 6.dp),
    SM(32.dp, 16.dp, 8.dp),
    MD(40.dp, 24.dp, 10.dp),
    LG(56.dp, 32.dp, 14.dp),
    XL(80.dp, 48.dp, 20.dp),
    XXL(100.dp, 48.dp, 32.dp)
}

enum class LogoVariant {
    DEFAULT,
    LIGHT,
    OUTLINE,
    DARK
}

@Composable
fun DeisaLogo(
    size: LogoSize = LogoSize.MD,
    variant: LogoVariant = LogoVariant.DEFAULT,
    modifier: Modifier = Modifier
) {
    val backgroundColor = when (variant) {
        LogoVariant.DEFAULT -> Color(0xFF0B63D6)
        LogoVariant.LIGHT -> MaterialTheme.colorScheme.surface
        LogoVariant.OUTLINE -> Color.Transparent
        LogoVariant.DARK -> MaterialTheme.colorScheme.surfaceVariant
    }

    val iconColor = when (variant) {
        LogoVariant.DEFAULT -> Color.White
        LogoVariant.LIGHT -> Color(0xFF0B63D6)
        LogoVariant.OUTLINE -> Color(0xFF0B63D6)
        LogoVariant.DARK -> MaterialTheme.colorScheme.onSurfaceVariant
    }

    Box(
        modifier = modifier
            .size(size.size)
            .background(
                color = backgroundColor,
                shape = RoundedCornerShape(size.cornerRadius)
            ),
        contentAlignment = Alignment.Center
    ) {
        Icon(
            imageVector = Icons.Default.MedicalServices,
            contentDescription = "Deisa Logo",
            tint = iconColor,
            modifier = Modifier.size(size.iconSize)
        )
    }
}
