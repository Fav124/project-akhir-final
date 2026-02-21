package com.example.deisacompose.ui.theme

import android.app.Activity
import android.os.Build
import androidx.compose.foundation.isSystemInDarkTheme
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.darkColorScheme
import androidx.compose.material3.dynamicDarkColorScheme
import androidx.compose.material3.dynamicLightColorScheme
import androidx.compose.material3.lightColorScheme
import androidx.compose.runtime.Composable
import androidx.compose.runtime.SideEffect
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.toArgb
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.LocalView
import androidx.core.view.WindowCompat

private val DarkColorScheme = darkColorScheme(
    primary = DeisaBlue,
    secondary = DeisaBlueLight,
    tertiary = SuccessGreen,
    background = DeisaNavy,
    surface = DeisaSoftNavy,
    onPrimary = Color.White,
    onSecondary = DeisaBlue,
    onTertiary = Color.White,
    onBackground = Color.White,
    onSurface = Color(0xFFCBD5E1), // Slate300 roughly
    error = DangerRed,
    errorContainer = DangerRed.copy(alpha = 0.1f),
    onErrorContainer = DangerRed
)

private val LightColorScheme = lightColorScheme(
    primary = DeisaBluePrimary,
    secondary = DeisaBlueLight,
    tertiary = SuccessGreen,
    background = Slate50,
    surface = Color.White,
    onPrimary = Color.White,
    onSecondary = DeisaBluePrimary,
    onTertiary = Color.White,
    onBackground = Slate900,
    onSurface = Slate700,
    outline = Slate300,
    error = DangerRed,
    errorContainer = DangerRed.copy(alpha = 0.1f),
    onErrorContainer = DangerRed
)

@Composable
fun DeisaComposeTheme(
    darkTheme: Boolean = false,
    primaryColor: Color = DeisaBlue,
    // Dynamic color is available on Android 12+
    dynamicColor: Boolean = false,
    content: @Composable () -> Unit
) {
    val colorScheme = when {
        dynamicColor && Build.VERSION.SDK_INT >= Build.VERSION_CODES.S -> {
            val context = LocalContext.current
            if (darkTheme) dynamicDarkColorScheme(context) else dynamicLightColorScheme(context)
        }

        darkTheme -> DarkColorScheme.copy(primary = primaryColor)
        else -> LightColorScheme.copy(primary = primaryColor)
    }
    val view = LocalView.current
    if (!view.isInEditMode) {
        SideEffect {
            val window = (view.context as Activity).window
            window.statusBarColor = colorScheme.primary.toArgb()
            WindowCompat.getInsetsController(window, view).isAppearanceLightStatusBars = !darkTheme
        }
    }

    MaterialTheme(
        colorScheme = colorScheme,
        typography = Typography,
        content = content
    )
}
