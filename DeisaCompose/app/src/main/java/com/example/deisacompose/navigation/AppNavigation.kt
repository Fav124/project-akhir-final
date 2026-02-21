package com.example.deisacompose.navigation

import androidx.compose.animation.*
import androidx.compose.animation.core.tween
import androidx.compose.foundation.layout.Box
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.navArgument
import com.example.deisacompose.ui.screens.*
import com.example.deisacompose.viewmodels.AdminViewModel
import com.example.deisacompose.viewmodels.AuthViewModel
import com.example.deisacompose.viewmodels.ResourceViewModel

@Composable
fun AppNavigation(
    navController: NavHostController,
    authViewModel: AuthViewModel = viewModel(),
    resourceViewModel: ResourceViewModel = viewModel(),
    adminViewModel: AdminViewModel = viewModel()
) {
    val currentUser by authViewModel.currentUser.collectAsState()
    
    // Resource Alerts
    val resAlertMessage by resourceViewModel.alertMessage.collectAsState()
    val resAlertType by resourceViewModel.alertType.collectAsState()
    
    // Admin Alerts
    val adminAlertMessage by adminViewModel.alertMessage.collectAsState()
    val adminAlertType by adminViewModel.alertType.collectAsState()

    // Auth Alerts
    val authAlertMessage by authViewModel.alertMessage.collectAsState()
    val authAlertType by authViewModel.alertType.collectAsState()

    Box {
        NavHost(
            navController = navController,
            startDestination = "splash",
            enterTransition = {
                slideInHorizontally(
                    initialOffsetX = { 300 },
                    animationSpec = tween(400)
                ) + fadeIn(animationSpec = tween(400))
            },
            exitTransition = {
                slideOutHorizontally(
                    targetOffsetX = { -300 },
                    animationSpec = tween(400)
                ) + fadeOut(animationSpec = tween(400))
            },
            popEnterTransition = {
                slideInHorizontally(
                    initialOffsetX = { -300 },
                    animationSpec = tween(400)
                ) + fadeIn(animationSpec = tween(400))
            },
            popExitTransition = {
                slideOutHorizontally(
                    targetOffsetX = { 300 },
                    animationSpec = tween(400)
                ) + fadeOut(animationSpec = tween(400))
            }
        ) {
            // Core Screens
            composable("splash") {
                SplashScreen(navController = navController)
            }

            composable("home") {
                HomeScreen(navController = navController)
            }

            composable("profile") {
                ProfileScreen(navController = navController)
            }

            composable("focus_mode") {
                FocusModeScreen()
            }

            composable("history") {
                HistoryScreen(navController = navController)
            }

            composable("laporan") {
                LaporanScreen(navController = navController)
            }

            composable("settings") {
                SettingsScreen(navController = navController)
            }

            // Auth Screens
            composable("login") {
                LoginScreen(navController = navController)
            }
            
            composable("register") {
                RegisterScreen(navController = navController)
            }
            
            composable("forgot_password") {
                ForgotPasswordScreen(navController = navController)
            }

            // Dashboards
            composable("admin_dashboard") {
                AdminDashboardScreen(navController = navController)
            }

            composable("staff_dashboard") {
                StaffDashboardScreen(navController = navController)
            }

            // Santri Screens
            composable("santri_list") {
                SantriListScreen(navController = navController)
            }
            
            composable(
                route = "santri_detail/{santriId}",
                arguments = listOf(navArgument("santriId") { type = NavType.IntType })
            ) { backStackEntry ->
                val santriId = backStackEntry.arguments?.getInt("santriId") ?: 0
                SantriDetailScreen(navController = navController, santriId = santriId)
            }
            
            composable("santri_add") {
                SantriAddScreen(navController = navController)
            }

            // Sakit Screens
            composable("sakit_list") {
                SakitListScreen(navController = navController)
            }
            
            composable(
                route = "sakit_detail/{sakitId}",
                arguments = listOf(navArgument("sakitId") { type = NavType.IntType })
            ) { backStackEntry ->
                val sakitId = backStackEntry.arguments?.getInt("sakitId") ?: 0
                SakitDetailScreen(navController = navController, sakitId = sakitId)
            }
            
            composable("sakit_add") {
                SakitAddScreen(navController = navController)
            }

            // Obat Screens
            composable("obat_list") {
                ObatListScreen(navController = navController)
            }
            
            composable(
                route = "obat_detail/{obatId}",
                arguments = listOf(navArgument("obatId") { type = NavType.IntType })
            ) { backStackEntry ->
                val obatId = backStackEntry.arguments?.getInt("obatId") ?: 0
                ObatDetailScreen(navController = navController, obatId = obatId)
            }
            
            composable("obat_add") {
                ObatAddScreen(navController = navController)
            }

            // Specialized Screens
            composable("kelas_list") {
                 KelasListScreen(navController = navController)
            }

            composable("jurusan_list") {
                 JurusanListScreen(navController = navController)
            }

            composable("user_management") {
                UserManagementScreen(navController = navController)
            }
            
            composable("activities") {
                 HistoryScreen(navController = navController)
            }
            
            composable("notifications") { // Mapping settings specifically to notification route if needed
                 SettingsScreen(navController = navController)
            }
        }

        // Global Alert Layer - Observing all potential sources
        com.example.deisacompose.ui.components.StitchAlert(
            message = resAlertMessage ?: adminAlertMessage ?: authAlertMessage,
            type = when {
                resAlertMessage != null -> resAlertType
                adminAlertMessage != null -> adminAlertType
                else -> authAlertType
            },
            onDismiss = { 
                resourceViewModel.clearAlert()
                adminViewModel.clearAlert()
                authViewModel.clearAlert()
            }
        )
    }
}