package com.example.deisacompose

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.navigation.compose.rememberNavController
import androidx.compose.runtime.getValue
import androidx.compose.runtime.livedata.observeAsState
import androidx.lifecycle.viewmodel.compose.viewModel
import com.example.deisacompose.navigation.AppNavigation
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.MainViewModel

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            val mainViewModel: MainViewModel = viewModel()
            val themeChoice by mainViewModel.themeColor.observeAsState("blue")
            val primaryColor = when(themeChoice) {
                "indigo" -> ThemeIndigo
                "emerald" -> ThemeEmerald
                "rose" -> ThemeRose
                else -> DeisaBlue
            }
            DeisaComposeTheme(primaryColor = primaryColor) {
                AppNavigation(navController = rememberNavController())
            }
        }
    }
}