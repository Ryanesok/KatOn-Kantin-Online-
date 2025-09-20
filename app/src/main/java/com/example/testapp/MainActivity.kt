package com.example.testapp

import android.os.Bundle
import android.widget.Button
import android.widget.TextView
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

class MainActivity : AppCompatActivity() {
    var angkaBulat: Int = 0

    fun hitung(){
        angkaBulat++
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        val textView: TextView = findViewById(R.id.text_view)
        val btnHitung: Button = findViewById(R.id.btn_hitung)

        btnHitung.setOnClickListener({
            hitung()
            textView.text = angkaBulat.toString()
        })
    }
}