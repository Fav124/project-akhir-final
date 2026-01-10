package com.example.deisa

import android.app.AlertDialog
import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.example.deisa.models.RegisterRequest
import com.example.deisa.network.RetrofitClient
import com.example.deisa.services.FirebaseAuthService
import com.google.android.gms.common.SignInButton
import com.google.android.material.textfield.TextInputEditText
import kotlinx.coroutines.launch

class RegisterActivity : AppCompatActivity() {

    private lateinit var etName: TextInputEditText
    private lateinit var etEmail: TextInputEditText
    private lateinit var etPassword: TextInputEditText
    private lateinit var btnRegister: Button
    private lateinit var tvLogin: View
    private lateinit var signInButton: SignInButton
    private lateinit var firebaseAuthService: FirebaseAuthService

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_register)

        firebaseAuthService = FirebaseAuthService(this)

        etName = findViewById(R.id.etName)
        etEmail = findViewById(R.id.etEmail)
        etPassword = findViewById(R.id.etPassword)
        btnRegister = findViewById(R.id.btnRegister)
        tvLogin = findViewById(R.id.tvLogin)
        signInButton = findViewById(R.id.signInButton)

        btnRegister.setOnClickListener {
            handleManualRegister()
        }

        tvLogin.setOnClickListener {
            finish() // Go back to login
        }

        signInButton.setSize(SignInButton.SIZE_WIDE)
        signInButton.setOnClickListener {
            handleGoogleRegister()
        }
    }

    private fun handleManualRegister() {
        val name = etName.text.toString().trim()
        val email = etEmail.text.toString().trim()
        val password = etPassword.text.toString().trim()

        if (name.isEmpty() || email.isEmpty() || password.isEmpty()) {
            Toast.makeText(this, "Please fill all fields", Toast.LENGTH_SHORT).show()
            return
        }

        if (password.length < 6) {
            Toast.makeText(this, "Password must be at least 6 characters", Toast.LENGTH_SHORT).show()
            return
        }

        performRegister(RegisterRequest(name, email, password))
    }

    private fun handleGoogleRegister() {
        lifecycleScope.launch {
            try {
                val googleUser = firebaseAuthService.signInWithGoogle()
                if (googleUser != null) {
                    // Pre-fill fields or auto-register depending on requirement
                    // Here we auto-register using Google info
                    val request = RegisterRequest(
                        name = googleUser.displayName ?: "Unknown",
                        email = googleUser.email ?: "",
                        password = "", // No password for Google Auth
                        googleId = googleUser.uid, // Using Firebase UID or Google ID
                        avatar = googleUser.photoUrl?.toString()
                    )
                    performRegister(request)
                } else {
                    Toast.makeText(this@RegisterActivity, "Google Sign-In failed", Toast.LENGTH_SHORT).show()
                }
            } catch (e: Exception) {
                Toast.makeText(this@RegisterActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                e.printStackTrace()
            }
        }
    }

    private fun performRegister(request: RegisterRequest) {
        lifecycleScope.launch {
            try {
                // Disable button to prevent double click
                btnRegister.isEnabled = false
                
                val response = RetrofitClient.instance.register(request)
                
                if (response.isSuccessful && response.body()?.success == true) {
                    showSuccessDialog(response.body()?.message ?: "Registration successful")
                } else {
                    val errorBody = response.errorBody()?.string()
                    Toast.makeText(this@RegisterActivity, "Registration failed: $errorBody", Toast.LENGTH_LONG).show()
                }
            } catch (e: Exception) {
                Toast.makeText(this@RegisterActivity, "Network error: ${e.message}", Toast.LENGTH_SHORT).show()
                e.printStackTrace()
            } finally {
                btnRegister.isEnabled = true
            }
        }
    }

    private fun showSuccessDialog(message: String) {
        AlertDialog.Builder(this)
            .setTitle("Registration Sent")
            .setMessage(message)
            .setPositiveButton("OK") { _, _ ->
                finish() // Close activity and return to Login
            }
            .setCancelable(false)
            .show()
    }
}
