package com.example.deisacompose.ui.components

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.deisacompose.ui.theme.DeisaBlue
import com.example.deisacompose.ui.theme.Slate100
import com.example.deisacompose.ui.theme.Slate500

@Composable
fun StepIndicator(step: Int, currentStep: Int, label: String) {
    Row(verticalAlignment = Alignment.CenterVertically, horizontalArrangement = Arrangement.spacedBy(8.dp)) {
        Surface(
            shape = CircleShape,
            color = if (step <= currentStep) DeisaBlue else Slate100,
            modifier = Modifier.size(24.dp)
        ) {
            Box(contentAlignment = Alignment.Center) {
                Text(step.toString(), color = Color.White, fontSize = 12.sp, fontWeight = FontWeight.Bold)
            }
        }
        Text(
            label,
            color = if (step <= currentStep) DeisaBlue else Slate500,
            fontWeight = if (step == currentStep) FontWeight.Bold else FontWeight.Normal,
            fontSize = 12.sp
        )
    }
}
