package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import com.example.deisa.services.FirebaseAuthService

class ProfileActivity : AppCompatActivity() {

    private lateinit var tvName: TextView
    private lateinit var tvEmail: TextView
    private lateinit var tvRole: TextView
    private lateinit var tvUserId: TextView
    private lateinit var btnLogout: Button
    
    private lateinit var firebaseAuthService: FirebaseAuthService

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_profile)
        
        firebaseAuthService = FirebaseAuthService(this)

        setSupportActionBar(findViewById(R.id.toolbar))
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        tvName = findViewById(R.id.tvName)
        tvEmail = findViewById(R.id.tvEmail)
        tvRole = findViewById(R.id.tvRole)
        tvUserId = findViewById(R.id.tvUserId)
        btnLogout = findViewById(R.id.btnLogout)

        loadUserData()

        btnLogout.setOnClickListener {
            performLogout()
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    private fun loadUserData() {
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        tvName.text = prefs.getString("user_name", "User")
        tvEmail.text = prefs.getString("user_email", "")
        tvRole.text = prefs.getString("user_role", "User")?.capitalize()
        tvUserId.text = prefs.getString("user_id", "") ?: prefs.getInt("user_id", 0).toString()
    }

    private fun performLogout() {
        // Clear Firebase Auth
        firebaseAuthService.logout()
        
        // Clear Local Prefs
        val prefs = getSharedPreferences("app_prefs", MODE_PRIVATE)
        prefs.edit().clear().apply()

        // Navigate to Login
        val intent = Intent(this, LoginActivity::class.java)
        intent.flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK
        startActivity(intent)
        finish()
    }
}
