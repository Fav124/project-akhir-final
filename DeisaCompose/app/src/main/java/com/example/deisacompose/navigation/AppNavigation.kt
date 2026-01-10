package com.example.deisacompose.navigation

import androidx.compose.runtime.Composable
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import com.example.deisacompose.ui.screens.*

@Composable
fun AppNavigation() {
    val navController = rememberNavController()

    NavHost(navController = navController, startDestination = "splash") {
        composable("splash") {
            SplashScreen(navController)
        }
        composable("login") {
            LoginScreen(navController)
        }
        composable("register") {
            RegisterScreen(navController)
        }
        composable("home") {
            HomeScreen(navController)
        }
        composable("santri_list") {
            SantriScreen(navController)
        }
        composable("sakit_list") {
            SakitScreen(navController)
        }
        composable("obat_list") {
            ObatScreen(navController)
        }
        composable("laporan") {
            LaporanScreen(navController)
        }
        composable("manage/{type}") { backStackEntry ->
            val type = backStackEntry.arguments?.getString("type") ?: "kelas"
            ManagementScreen(navController, type)
        }
    }
}
