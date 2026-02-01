package com.example.deisacompose.navigation

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
import com.example.deisacompose.viewmodels.AuthViewModel

@Composable
fun AppNavigation(
    navController: NavHostController,
    authViewModel: AuthViewModel = viewModel()
) {
    val currentUser by authViewModel.currentUser.collectAsState()

    // Determine start destination based on auth state
    // We can use a simple logic: if loading, maybe show splash (or blank), else routing
    // For now, let's assume if user is null we go to login, else dashboard
    // But we need to handle the initial check (e.g. valid token validation)
    
    // We'll define the graph. The start destination is dynamically handled or we default to 'login' 
    // and rely on AuthViewModel to navigate if already logged in?
    // Actually, in the previous plan, we checked currentUser. 
    // Let's rely on the fact that AuthViewModel checks 'getCurrentUser' on init.
    // If we want a true splash, we could add it back. 
    // For this implementation, let's keep it simple: Login is start. 
    // Inside Login, if user is already authenticated (checked via ViewModel), it auto-navigates.
    
    NavHost(
        navController = navController,
        startDestination = "login"
    ) {
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

        // Admin Dashboard
        composable("admin_dashboard") {
            AdminDashboardScreen(navController = navController)
        }

        // Staff Dashboard
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

        // Kelas Screens (Read-only for staff)
        composable("kelas_list") {
            // Fallback to santri list or placeholder
             SantriListScreen(navController = navController)
        }

        // Jurusan Screens (Read-only for staff)
        composable("jurusan_list") {
             SantriListScreen(navController = navController)
        }

        // Admin-only Screens
        composable("user_management") {
            UserManagementScreen(navController = navController)
        }
        
        composable("activities") {
             AdminDashboardScreen(navController = navController)
        }
        
        composable("notifications") {
             AdminDashboardScreen(navController = navController)
        }
    }
}