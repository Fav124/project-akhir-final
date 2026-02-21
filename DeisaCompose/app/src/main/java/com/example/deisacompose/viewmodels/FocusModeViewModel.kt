package com.example.deisacompose.viewmodels

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import kotlinx.coroutines.Job
import kotlinx.coroutines.delay
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.launch

class FocusModeViewModel : ViewModel() {

    private val _timeRemaining = MutableStateFlow("25:00")
    val timeRemaining: StateFlow<String> = _timeRemaining

    private val _progress = MutableStateFlow(1f)
    val progress: StateFlow<Float> = _progress

    private val _isRunning = MutableStateFlow(false)
    val isRunning: StateFlow<Boolean> = _isRunning

    private val _isFinished = MutableStateFlow(false)
    val isFinished: StateFlow<Boolean> = _isFinished

    private var timerJob: Job? = null
    private var totalTime: Long = 25 * 60 * 1000
    private var timeLeft: Long = totalTime

    fun startTimer(durationMinutes: Int = 25) {
        if (timerJob?.isActive == true) return

        totalTime = durationMinutes * 60 * 1000L
        if (timeLeft == 0L || timeLeft > totalTime) {
            timeLeft = totalTime
        }
        
        _isFinished.value = false
        _isRunning.value = true

        timerJob = viewModelScope.launch {
            while (timeLeft > 0) {
                delay(1000)
                timeLeft -= 1000
                _timeRemaining.value = formatTime(timeLeft)
                _progress.value = timeLeft.toFloat() / totalTime
            }
            _isRunning.value = false
            _isFinished.value = true
        }
    }

    fun pauseTimer() {
        timerJob?.cancel()
        _isRunning.value = false
    }

    fun stopTimer() {
        timerJob?.cancel()
        timeLeft = totalTime
        _timeRemaining.value = formatTime(totalTime)
        _progress.value = 1f
        _isRunning.value = false
        _isFinished.value = false
    }

    private fun formatTime(millis: Long): String {
        val minutes = (millis / 1000) / 60
        val seconds = (millis / 1000) % 60
        return String.format("%02d:%02d", minutes, seconds)
    }
}