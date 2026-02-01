package com.example.deisacompose.data.network

import android.content.Context
import android.content.SharedPreferences

class SessionManager(context: Context) {
    private val prefs: SharedPreferences = context.getSharedPreferences("deisa_prefs", Context.MODE_PRIVATE)

    companion object {
        const val USER_TOKEN = "user_token"
        const val REMEMBER_ME = "remember_me"
        
        // Static memory variable for non-persistent session
        // This will be cleared when the app process is killed
        private var memoryToken: String? = null
    }

    /**
     * Save auth token.
     * @param token The token string
     * @param rememberMe If true, save to SharedPreferences (persistent). If false, save to memory (volatile).
     */
    fun saveAuthToken(token: String, rememberMe: Boolean) {
        if (rememberMe) {
            val editor = prefs.edit()
            editor.putString(USER_TOKEN, token)
            // Ensure we update the remember status flag too
            editor.putBoolean(REMEMBER_ME, true)
            editor.apply()
            memoryToken = null // Clear memory token to avoid confusion/duplication, though having both is fine
        } else {
            memoryToken = token
            // Clear any existing persistent token to respect the "don't remember" choice
            val editor = prefs.edit()
            editor.remove(USER_TOKEN)
            editor.putBoolean(REMEMBER_ME, false)
            editor.apply()
        }
    }

    fun saveRememberStatus(remember: Boolean) {
        val editor = prefs.edit()
        editor.putBoolean(REMEMBER_ME, remember)
        editor.apply()
    }

    fun fetchRememberStatus(): Boolean {
        return prefs.getBoolean(REMEMBER_ME, false)
    }

    fun fetchAuthToken(): String? {
        // First check memory (for current session if not remembered)
        if (memoryToken != null) {
            return memoryToken
        }
        // Then check persistent storage
        return prefs.getString(USER_TOKEN, null)
    }

    fun clearAuthToken() {
        memoryToken = null
        val editor = prefs.edit()
        editor.remove(USER_TOKEN)
        // We might or might not want to clear REMEMBER_ME flag depending on UX,
        // but typically logout clears session data.
        // We usually keep the REMEMBER_ME preference for next login (to pre-check box) or clear it.
        // Requirement implies session clearing.
        editor.remove(REMEMBER_ME) 
        editor.apply()
    }
}
