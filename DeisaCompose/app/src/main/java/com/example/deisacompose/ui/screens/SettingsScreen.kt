package com.example.deisacompose.ui.screens

import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.Spacer
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ArrowBack
import androidx.compose.material.icons.filled.ChevronRight
import androidx.compose.material.icons.filled.DarkMode
import androidx.compose.material.icons.filled.Info
import androidx.compose.material.icons.filled.Notifications
import androidx.compose.material.icons.filled.Security
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.DrawerValue
import androidx.compose.material3.ExperimentalMaterial3Api
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.ModalDrawerSheet
import androidx.compose.material3.ModalNavigationDrawer
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Surface
import androidx.compose.material3.Switch
import androidx.compose.material3.SwitchDefaults
import androidx.compose.material3.Text
import androidx.compose.material3.TopAppBar
import androidx.compose.material3.rememberDrawerState
import androidx.compose.runtime.Composable
import androidx.compose.runtime.collectAsState
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import androidx.navigation.compose.currentBackStackEntryAsState
import com.example.deisacompose.ui.components.StitchDrawerContent
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.*
import com.example.deisacompose.viewmodels.AuthViewModel
import kotlinx.coroutines.launch

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SettingsScreen(
    navController: NavController,
    authViewModel: AuthViewModel = viewModel()
) {
    val drawerState = rememberDrawerState(initialValue = DrawerValue.Closed)
    val scope = rememberCoroutineScope()
    val currentUser by authViewModel.currentUser.collectAsState()
    val navBackStackEntry by navController.currentBackStackEntryAsState()
    val currentRoute = navBackStackEntry?.destination?.route ?: ""

    ModalNavigationDrawer(
        drawerState = drawerState,
        drawerContent = {
            ModalDrawerSheet(
                drawerContainerColor = DeisaSoftNavy,
                drawerContentColor = Color.White
            ) {
                StitchDrawerContent(
                    userName = currentUser?.name ?: "User",
                    onLogout = {
                        authViewModel.logout()
                        navController.navigate("login") {
                            popUpTo(0) { inclusive = true }
                        }
                    },
                    navController = navController,
                    currentRoute = currentRoute
                )
            }
        }
    ) {
        Scaffold(
            containerColor = DeisaNavy,
            topBar = {
                StitchTopBar(
                    title = "Pengaturan",
                    onMenuClick = {
                        scope.launch { drawerState.open() }
                    },
                    showMenu = true
                )
            }
        ) { padding ->
            LazyColumn(
                modifier = Modifier
                    .fillMaxSize()
                    .padding(padding),
                contentPadding = PaddingValues(24.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                item {
                    Text(
                        "PENGATURAN AKUN",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.padding(bottom = 8.dp, start = 4.dp)
                    )
                }

                item {
                    var notificationsEnabled by remember { mutableStateOf(true) }
                    SettingsItem(
                        icon = Icons.Default.Notifications,
                        title = "Notifikasi",
                        subtitle = "Terima pemberitahuan kesehatan santri",
                        color = DeisaBlue,
                        hasSwitch = true,
                        switchChecked = notificationsEnabled,
                        onSwitchChange = { notificationsEnabled = it }
                    )
                }

                item {
                    var isDarkMode by remember { mutableStateOf(true) }
                    SettingsItem(
                        icon = Icons.Default.DarkMode,
                        title = "Tema Antarmuka",
                        subtitle = "Aktifkan tampilan gelap premium",
                        color = DeisaPurple,
                        hasSwitch = true,
                        switchChecked = isDarkMode,
                        onSwitchChange = { isDarkMode = it }
                    )
                }

                item {
                    SettingsItem(
                        icon = Icons.Default.Security,
                        title = "Keamanan & Sandi",
                        subtitle = "Ubah kata sandi dan keamanan",
                        color = DangerRed,
                        onClick = { navController.navigate("forgot_password") }
                    )
                }

                item {
                    Spacer(modifier = Modifier.height(16.dp))
                    Text(
                        "SISTEM & INFORMASI",
                        style = MaterialTheme.typography.labelSmall,
                        fontWeight = FontWeight.Black,
                        color = DeisaBlue,
                        modifier = Modifier.padding(bottom = 8.dp, start = 4.dp)
                    )
                }

                item {
                    SettingsItem(
                        icon = Icons.Default.Info,
                        title = "Tentang Aplikasi",
                        subtitle = "Deisa Health v2.4.0 High-End Build",
                        color = SuccessGreen,
                        onClick = { /* Show dialog */ }
                    )
                }

                item {
                    Spacer(modifier = Modifier.height(32.dp))
                    com.example.deisacompose.ui.components.PremiumGradientButton(
                        text = "Sinkronisasi Data",
                        onClick = { /* Handle sync */ },
                        modifier = Modifier.height(50.dp)
                    )
                }
            }
        }
    }
}

@Composable
fun SettingsItem(
    icon: androidx.compose.ui.graphics.vector.ImageVector,
    title: String,
    subtitle: String,
    color: Color,
    onClick: (() -> Unit)? = null,
    hasSwitch: Boolean = false,
    switchChecked: Boolean = false,
    onSwitchChange: ((Boolean) -> Unit)? = null
) {
    com.example.deisacompose.ui.components.PremiumCard(
        modifier = Modifier.fillMaxWidth().then(
            if (onClick != null) Modifier.clickable { onClick() } else Modifier
        ),
        accentColor = color,
        backgroundColor = DeisaSoftNavy
    ) {
        Row(
            verticalAlignment = Alignment.CenterVertically
        ) {
            Box(
                modifier = Modifier
                    .size(44.dp)
                    .clip(RoundedCornerShape(12.dp))
                    .background(color.copy(alpha = 0.1f)),
                contentAlignment = Alignment.Center
            ) {
                Icon(icon, null, tint = color, modifier = Modifier.size(24.dp))
            }
            Spacer(modifier = Modifier.width(16.dp))
            Column(modifier = Modifier.weight(1f)) {
                Text(title, fontWeight = FontWeight.Bold, style = MaterialTheme.typography.bodyLarge, color = Color.White)
                Text(subtitle, style = MaterialTheme.typography.labelSmall, color = Color.Gray)
            }
            
            if (hasSwitch) {
                Switch(
                    checked = switchChecked,
                    onCheckedChange = onSwitchChange,
                    colors = SwitchDefaults.colors(
                        checkedThumbColor = DeisaBlue,
                        checkedTrackColor = DeisaBlue.copy(alpha = 0.5f),
                        uncheckedThumbColor = Color.Gray,
                        uncheckedTrackColor = Color.Gray.copy(alpha = 0.2f)
                    )
                )
            } else {
                Icon(Icons.Default.ChevronRight, null, tint = Color.White.copy(alpha = 0.1f))
            }
        }
    }
}
