package com.example.deisacompose.ui.screens

import androidx.compose.animation.AnimatedVisibility
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.text.KeyboardOptions
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.KeyboardType
import androidx.compose.ui.unit.dp
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavController
import com.example.deisacompose.ui.components.StitchTopBar
import com.example.deisacompose.ui.theme.DangerRed
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.DeisaNavy
import com.example.deisacompose.ui.theme.DeisaSoftNavy
import com.example.deisacompose.viewmodels.ResourceUiState
import com.example.deisacompose.viewmodels.ResourceViewModel
import kotlinx.coroutines.delay

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SantriAddScreen(
    navController: NavController,
    resourceViewModel: ResourceViewModel = viewModel(),
    authViewModel: com.example.deisacompose.viewmodels.AuthViewModel = viewModel()
) {
    val uiState by resourceViewModel.uiState.collectAsState()
    val kelasList by resourceViewModel.kelasList.collectAsState()
    val jurusanList by resourceViewModel.jurusanList.collectAsState()

    var namaLengkap by remember { mutableStateOf("") }
    var nis by remember { mutableStateOf("") }
    var jenisKelamin by remember { mutableStateOf("L") }
    var tempatLahir by remember { mutableStateOf("") }
    var tanggalLahir by remember { mutableStateOf("") }
    var alamat by remember { mutableStateOf("") }
    var noHpWali by remember { mutableStateOf("") }
    var namaWali by remember { mutableStateOf("") }
    var golonganDarah by remember { mutableStateOf("") }
    var riwayatAlergi by remember { mutableStateOf("") }
    var catatanMedis by remember { mutableStateOf("") }
    var selectedKelasId by remember { mutableStateOf<Int?>(null) }
    var selectedJurusanId by remember { mutableStateOf<Int?>(null) }
    var tahunMasuk by remember { mutableStateOf("") }

    var expandedKelas by remember { mutableStateOf(false) }
    var expandedJurusan by remember { mutableStateOf(false) }

    // Validation States
    var nameError by remember { mutableStateOf<String?>(null) }
    var nisError by remember { mutableStateOf<String?>(null) }
    var globalError by remember { mutableStateOf<String?>(null) }

    LaunchedEffect(Unit) {
        resourceViewModel.loadKelas()
        resourceViewModel.loadJurusan()
        resourceViewModel.resetState()
    }

    LaunchedEffect(uiState) {
        when (val state = uiState) {
            is ResourceUiState.Success -> {
                delay(1000)
                navController.navigateUp()
                resourceViewModel.resetState()
            }
            is ResourceUiState.Error -> {
                if (state.message == "SESI_HABIS") {
                    authViewModel.logout()
                    navController.navigate("login") {
                        popUpTo(0) { inclusive = true }
                    }
                } else {
                    globalError = state.message
                    delay(3000)
                    globalError = null
                }
                resourceViewModel.resetState()
            }
            else -> {}
        }
    }

    fun validate(): Boolean {
        var isValid = true
        if (namaLengkap.isBlank()) {
            nameError = "Nama lengkap wajib diisi"
            isValid = false
        } else if (namaLengkap.length < 3) {
            nameError = "Nama terlalu pendek"
            isValid = false
        } else {
            nameError = null
        }

        if (nis.isBlank()) {
            nisError = "NIS wajib diisi"
            isValid = false
        } else if (nis.length < 5) {
            nisError = "NIS minimal 5 digit"
            isValid = false
        } else {
            nisError = null
        }

        if (selectedKelasId == null || selectedJurusanId == null) {
            globalError = "Mohon pilih Kelas dan Jurusan"
            isValid = false
        }
        
        return isValid
    }

    Scaffold(
        containerColor = DeisaNavy,
        topBar = {
            StitchTopBar(
                title = "Tambah Santri Baru",
                onMenuClick = { navController.navigateUp() },
                showMenu = true,
                navigationIcon = Icons.Default.ArrowBack
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(24.dp),
            verticalArrangement = Arrangement.spacedBy(24.dp)
        ) {
            // Header Info
            Column {
                Text(
                    "Informasi Santri",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold,
                    color = Color.White
                )
                Text(
                    "Isi detail di bawah untuk mendaftarkan santri baru",
                    style = MaterialTheme.typography.labelSmall,
                    color = Color.Gray
                )
            }

            // Form Fields
            com.example.deisacompose.ui.components.PremiumTextField(
                value = namaLengkap,
                onValueChange = { 
                    namaLengkap = it
                    if (nameError != null) nameError = null
                },
                label = "Nama Lengkap",
                placeholder = "Masukkan nama lengkap",
                leadingIcon = Icons.Default.Person,
                error = nameError
            )

            com.example.deisacompose.ui.components.PremiumTextField(
                value = nis,
                onValueChange = { 
                    nis = it
                    if (nisError != null) nisError = null
                },
                label = "NIS (Nomor Induk Santri)",
                placeholder = "Masukkan NIS",
                leadingIcon = Icons.Default.Badge,
                error = nisError,
            )

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                Box(modifier = Modifier.weight(1f)) {
                    com.example.deisacompose.ui.components.PremiumTextField(
                        value = tempatLahir,
                        onValueChange = { tempatLahir = it },
                        label = "Tempat Lahir",
                        placeholder = "Contoh: Jakarta",
                        leadingIcon = Icons.Default.Place
                    )
                }
                Box(modifier = Modifier.weight(1f)) {
                    com.example.deisacompose.ui.components.PremiumTextField(
                        value = tanggalLahir,
                        onValueChange = { tanggalLahir = it },
                        label = "Tanggal Lahir",
                        placeholder = "YYYY-MM-DD",
                        leadingIcon = Icons.Default.CalendarMonth
                    )
                }
            }

            // Gender Selection (Styled for Stitch)
            Column {
                Text(
                    "JENIS KELAMIN",
                    style = MaterialTheme.typography.labelSmall,
                    fontWeight = FontWeight.Bold,
                    color = Color.Gray,
                    modifier = Modifier.padding(start = 4.dp, bottom = 8.dp)
                )
                Row(
                    modifier = Modifier.fillMaxWidth(),
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    listOf("L" to "Laki-laki", "P" to "Perempuan").forEach { (code, label) ->
                        Box(
                            modifier = Modifier
                                .weight(1f)
                                .height(56.dp)
                                .clip(RoundedCornerShape(16.dp))
                                .background(if (jenisKelamin == code) DeisaBlue.copy(alpha = 0.1f) else DeisaSoftNavy)
                                .border(
                                    1.dp, 
                                    if (jenisKelamin == code) DeisaBlue else Color.White.copy(alpha = 0.05f),
                                    RoundedCornerShape(16.dp)
                                )
                                .clickable { jenisKelamin = code },
                            contentAlignment = Alignment.Center
                        ) {
                            Text(
                                label,
                                color = if (jenisKelamin == code) DeisaBlue else Color.White,
                                fontWeight = FontWeight.Bold
                            )
                        }
                    }
                }
            }

            // Class & Major Dropdowns
            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                Box(modifier = Modifier.weight(1f)) {
                    ExposedDropdownMenuBox(
                        expanded = expandedKelas,
                        onExpandedChange = { expandedKelas = !expandedKelas }
                    ) {
                        com.example.deisacompose.ui.components.PremiumTextField(
                            value = kelasList.find { it.id == selectedKelasId }?.nama_kelas ?: "",
                            onValueChange = {},
                            label = "Kelas",
                            placeholder = "Pilih kelas",
                            leadingIcon = Icons.Default.School,
                            modifier = Modifier.menuAnchor(),
                            error = null // Handled globally or can be added per field
                        )
                        ExposedDropdownMenu(
                            expanded = expandedKelas,
                            onDismissRequest = { expandedKelas = false },
                            modifier = Modifier.background(DeisaSoftNavy)
                        ) {
                            kelasList.forEach { kelas ->
                                DropdownMenuItem(
                                    text = { Text(kelas.nama_kelas, color = Color.White) },
                                    onClick = {
                                        selectedKelasId = kelas.id
                                        expandedKelas = false
                                    }
                                )
                            }
                        }
                    }
                }
                Box(modifier = Modifier.weight(1f)) {
                    ExposedDropdownMenuBox(
                        expanded = expandedJurusan,
                        onExpandedChange = { expandedJurusan = !expandedJurusan }
                    ) {
                        com.example.deisacompose.ui.components.PremiumTextField(
                            value = jurusanList.find { it.id == selectedJurusanId }?.nama_jurusan ?: "",
                            onValueChange = {},
                            label = "Jurusan",
                            placeholder = "Pilih jurusan",
                            leadingIcon = Icons.Default.Category,
                            modifier = Modifier.menuAnchor()
                        )
                        ExposedDropdownMenu(
                            expanded = expandedJurusan,
                            onDismissRequest = { expandedJurusan = false },
                            modifier = Modifier.background(DeisaSoftNavy)
                        ) {
                            jurusanList.forEach { jurusan ->
                                DropdownMenuItem(
                                    text = { Text(jurusan.nama_jurusan, color = Color.White) },
                                    onClick = {
                                        selectedJurusanId = jurusan.id
                                        expandedJurusan = false
                                    }
                                )
                            }
                        }
                    }
                }
            }

            com.example.deisacompose.ui.components.PremiumTextField(
                value = tahunMasuk,
                onValueChange = { tahunMasuk = it },
                label = "Tahun Masuk / Ajaran",
                placeholder = "Contoh: 2024",
                leadingIcon = Icons.Default.DateRange
            )

            com.example.deisacompose.ui.components.PremiumTextField(
                value = alamat,
                onValueChange = { alamat = it },
                label = "Alamat Lengkap",
                placeholder = "Masukkan alamat domisili",
                leadingIcon = Icons.Default.Home
            )

            com.example.deisacompose.ui.components.PremiumTextField(
                value = noHpWali,
                onValueChange = { noHpWali = it },
                label = "Nomor HP Wali",
                placeholder = "Contoh: 08123456789",
                leadingIcon = Icons.Default.Phone,
            )

            com.example.deisacompose.ui.components.PremiumTextField(
                value = namaWali,
                onValueChange = { namaWali = it },
                label = "Nama Wali / Orang Tua",
                placeholder = "Masukkan nama wali",
                leadingIcon = Icons.Default.SupervisorAccount,
            )

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                Box(modifier = Modifier.weight(1f)) {
                    com.example.deisacompose.ui.components.PremiumTextField(
                        value = golonganDarah,
                        onValueChange = { golonganDarah = it },
                        label = "Gol. Darah",
                        placeholder = "A, B, AB, O",
                        leadingIcon = Icons.Default.Bloodtype
                    )
                }
                Box(modifier = Modifier.weight(1f)) {
                    com.example.deisacompose.ui.components.PremiumTextField(
                        value = riwayatAlergi,
                        onValueChange = { riwayatAlergi = it },
                        label = "Riwayat Alergi",
                        placeholder = "Tidak ada",
                        leadingIcon = Icons.Default.ReportProblem
                    )
                }
            }

            com.example.deisacompose.ui.components.PremiumTextField(
                value = catatanMedis,
                onValueChange = { catatanMedis = it },
                label = "Catatan Medis Tambahan",
                placeholder = "Contoh: Memiliki asma",
                leadingIcon = Icons.Default.Description
            )

            AnimatedVisibility(visible = globalError != null) {
                Text(
                    globalError ?: "",
                    color = DangerRed,
                    style = MaterialTheme.typography.labelSmall,
                    modifier = Modifier.padding(start = 4.dp)
                )
            }

            Spacer(modifier = Modifier.height(8.dp))

            com.example.deisacompose.ui.components.PremiumGradientButton(
                text = "Daftarkan Santri",
                onClick = {
                    if (validate()) {
                        val santriData: Map<String, Any> = mapOf(
                            "nama_lengkap" to namaLengkap,
                            "nis" to nis,
                            "jenis_kelamin" to jenisKelamin,
                            "tempat_lahir" to tempatLahir,
                            "tanggal_lahir" to (if (tanggalLahir.isEmpty()) "2000-01-01" else tanggalLahir),
                            "alamat" to alamat,
                            "nama_wali" to (if (namaWali.isEmpty()) "Wali $namaLengkap" else namaWali),
                            "no_hp_wali" to noHpWali,
                            "kelas_id" to selectedKelasId!!,
                            "jurusan_id" to selectedJurusanId!!,
                            "tahun_masuk" to ((if (tahunMasuk.isEmpty()) "2024" else tahunMasuk).toIntOrNull() ?: 2024),
                            "golongan_darah" to golonganDarah,
                            "riwayat_alergi" to riwayatAlergi,
                            "catatan_medis" to catatanMedis,
                            "status" to "Aktif"
                        )
                        resourceViewModel.createSantri(santriData)
                    }
                },
                isLoading = uiState is ResourceUiState.Loading
            )
            
            Spacer(modifier = Modifier.height(32.dp))
        }
    }
}
