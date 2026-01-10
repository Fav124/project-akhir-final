package com.example.deisa

import android.content.Intent
import android.os.Bundle
import android.widget.LinearLayout
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        findViewById<LinearLayout>(R.id.btnSickRecords).setOnClickListener {
            startActivity(Intent(this, SakitListActivity::class.java))
        }

        findViewById<LinearLayout>(R.id.btnMedicine).setOnClickListener {
            startActivity(Intent(this, ObatListActivity::class.java))
        }

        findViewById<LinearLayout>(R.id.btnSantri).setOnClickListener {
            startActivity(Intent(this, SantriListActivity::class.java))
        }

        findViewById<LinearLayout>(R.id.btnReports).setOnClickListener {
            startActivity(Intent(this, LaporanActivity::class.java))
        }
    }
}