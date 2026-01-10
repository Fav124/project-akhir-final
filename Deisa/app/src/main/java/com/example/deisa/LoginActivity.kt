package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.ProgressBar
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import com.example.deisa.models.LoginRequest
import com.example.deisa.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class LoginActivity : AppCompatActivity() {

    private lateinit var etEmail: EditText
    private lateinit var etPassword: EditText
    private lateinit var btnLogin: Button
    private lateinit var btnGoogleLogin: Button
    private lateinit var progressBar: ProgressBar
    
    // Services
    private lateinit var firebaseAuthService: com.example.deisa.services.FirebaseAuthService

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)
        
        firebaseAuthService = com.example.deisa.services.FirebaseAuthService(this)

        // Check if already logged in (Firebase or specific Token)
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        val currentUser = firebaseAuthService.getCurrentUser()
        
        if (currentUser != null || prefs.getString("token", "")?.isNotEmpty() == true) {
            startActivity(Intent(this, MainActivity::class.java))
            finish()
            return
        }

        etEmail = findViewById(R.id.etEmail)
        etPassword = findViewById(R.id.etPassword)
        btnLogin = findViewById(R.id.btnLogin)
        btnGoogleLogin = findViewById(R.id.btnGoogleLogin)
        progressBar = findViewById(R.id.progressBar)
        
        val tvRegister: android.widget.TextView = findViewById(R.id.tvRegister)
        tvRegister.setOnClickListener {
            startActivity(Intent(this, RegisterActivity::class.java))
        }

        btnLogin.setOnClickListener {
            val email = etEmail.text.toString()
            val password = etPassword.text.toString()

            if (email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Please enter email and password", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            login(email, password)
        }

        btnGoogleLogin.setOnClickListener {
            performGoogleLogin()
        }
    }

    private fun performGoogleLogin() {
        progressBar.isVisible = true
        btnLogin.isEnabled = false
        btnGoogleLogin.isEnabled = false

        CoroutineScope(Dispatchers.Main).launch {
            val user = firebaseAuthService.signInWithGoogle()
            if (user != null) {
                // Successfully signed in with Firebase
                // TODO: Sync with Backend or just use Firebase User
                
                // For now, save basic info to prefs to compatible with existing logic
                val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
                prefs.edit()
                    .putString("token", "firebase-token-${user.uid}") // Placeholder
                    .putString("user_id", user.uid)
                    .putString("user_name", user.displayName ?: "User")
                    .putString("user_email", user.email ?: "")
                    .apply()

                Toast.makeText(this@LoginActivity, "Welcome ${user.displayName}", Toast.LENGTH_SHORT).show()
                startActivity(Intent(this@LoginActivity, MainActivity::class.java))
                finish()
            } else {
                Toast.makeText(this@LoginActivity, "Google Sign-In Failed", Toast.LENGTH_SHORT).show()
                progressBar.isVisible = false
                btnLogin.isEnabled = true
                btnGoogleLogin.isEnabled = true
            }
        }
    }

    private fun login(email: String, password: String) {
        progressBar.isVisible = true
        btnLogin.isEnabled = false
        btnGoogleLogin.isEnabled = false

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.login(LoginRequest(email, password))
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnLogin.isEnabled = true
                    btnGoogleLogin.isEnabled = true

                    if (response.isSuccessful && response.body() != null) {
                        val loginData = response.body()!!.data
                        val token = loginData.token
                        val user = loginData.user
                        
                        // Save token and user info
                        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
                        prefs.edit()
                            .putString("token", token)
                            .putInt("user_id", user.id)
                            .putString("user_name", user.name)
                            .putString("user_email", user.email)
                            .putString("user_role", user.role ?: "user")
                            .putBoolean("is_admin", user.isAdmin)
                            .apply()

                        startActivity(Intent(this@LoginActivity, MainActivity::class.java))
                        finish()
                    } else {
                        Toast.makeText(this@LoginActivity, "Login failed: ${response.message()}", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnLogin.isEnabled = true
                    btnGoogleLogin.isEnabled = true
                    Toast.makeText(this@LoginActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
