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
    private lateinit var progressBar: ProgressBar

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)

        // Check if already logged in
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        if (prefs.getString("token", "")?.isNotEmpty() == true) {
            startActivity(Intent(this, MainActivity::class.java))
            finish()
            return
        }

        etEmail = findViewById(R.id.etEmail)
        etPassword = findViewById(R.id.etPassword)
        btnLogin = findViewById(R.id.btnLogin)
        progressBar = findViewById(R.id.progressBar)

        btnLogin.setOnClickListener {
            val email = etEmail.text.toString()
            val password = etPassword.text.toString()

            if (email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Please enter email and password", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            login(email, password)
        }
    }

    private fun login(email: String, password: String) {
        progressBar.isVisible = true
        btnLogin.isEnabled = false

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.instance.login(LoginRequest(email, password))
                withContext(Dispatchers.Main) {
                    progressBar.isVisible = false
                    btnLogin.isEnabled = true

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
                    Toast.makeText(this@LoginActivity, "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
