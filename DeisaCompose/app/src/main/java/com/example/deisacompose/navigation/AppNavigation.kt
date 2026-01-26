package com.example.deisacompose.navigation

import androidx.compose.runtime.Composable
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.navArgument
import com.example.deisacompose.ui.screens.*

@Composable
fun AppNavigation(navController: NavHostController) {
    NavHost(navController = navController, startDestination = "splash") {
        composable("splash") { SplashScreen(navController) }
        composable("login") { LoginScreen(navController) }
        composable("register") { RegisterScreen(navController) }
        composable("forgot_password") { ForgotPasswordScreen(navController) }
        composable("history") { HistoryScreen(navController) }
        composable("home") { HomeScreen(navController) }
        
        // Features
        composable("santri") { SantriScreen(navController) }
        composable(
            "santri_form?id={id}",
            arguments = listOf(navArgument("id") { type = NavType.IntType; defaultValue = -1 })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getInt("id")
            SantriFormScreen(navController, santriId = if (id == -1) null else id)
        }

        composable("sakit") { SakitScreen(navController) }
        composable(
            "sakit_form?id={id}",
            arguments = listOf(navArgument("id") { type = NavType.IntType; defaultValue = -1 })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getInt("id")
            SakitFormScreen(navController, sakitId = if (id == -1) null else id)
        }

        composable("obat") { ObatScreen(navController) }
        composable(
            "obat_form?id={id}",
            arguments = listOf(navArgument("id") { type = NavType.IntType; defaultValue = -1 })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getInt("id")
            ObatFormScreen(navController, obatId = if (id == -1) null else id)
        }

        composable("laporan") { LaporanScreen(navController) }
        composable("focus_mode") { FocusModeScreen(navController) }
        
        // Admin Management
        composable("management_list") { ManagementListScreen(navController) }
        composable(
            "management_detail/{type}",
            arguments = listOf(navArgument("type") { type = NavType.StringType })
        ) { backStackEntry ->
            val type = backStackEntry.arguments?.getString("type") ?: ""
            ManagementScreen(navController, type = type)
        }
        
        // Secondary
        composable("profile") { ProfileScreen(navController) }
        composable("about") { AboutScreen(navController) }
        composable("settings") { SettingsScreen(navController) }
        
        // Admin
        composable("admin_registrations") { AdminRegistrationsScreen(navController) }
        composable("admin_users") { AdminUsersScreen(navController) }
    }
}