package com.example.deisacompose

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import com.example.deisacompose.navigation.AppNavigation
import com.example.deisacompose.ui.theme.DeisaComposeTheme

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            DeisaComposeTheme {
                AppNavigation()
            }
        }
    }
}