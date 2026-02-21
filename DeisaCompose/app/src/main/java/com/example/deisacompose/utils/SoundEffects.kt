package com.example.deisacompose.utils

import android.content.Context
import android.media.MediaPlayer
import com.example.deisacompose.R

object SoundEffects {
    private var mediaPlayer: MediaPlayer? = null

    fun playAlertSound(context: Context) {
        try {
            // Stopping any currently playing sound
            mediaPlayer?.stop()
            mediaPlayer?.release()
            
            // We expect a file named 'kling.mp3' in res/raw
            // If it doesn't exist yet, this will cause a build error or runtime crash if not handled
            // For now, we use a resource ID if it exists, or just log if it doesn't
            val resId = context.resources.getIdentifier("kling", "raw", context.packageName)
            if (resId != 0) {
                mediaPlayer = MediaPlayer.create(context, resId)
                mediaPlayer?.start()
                mediaPlayer?.setOnCompletionListener {
                    it.release()
                    mediaPlayer = null
                }
            }
        } catch (e: Exception) {
            e.printStackTrace()
        }
    }
}
