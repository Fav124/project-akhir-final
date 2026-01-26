package com.example.deisacompose.data.network

import android.content.Context
import android.content.SharedPreferences

class SessionManager(context: Context) {
    private val prefs: SharedPreferences = context.getSharedPreferences("deisa_prefs", Context.MODE_PRIVATE)

    companion object {
        const val USER_TOKEN = "user_token"
        const val REMEMBER_ME = "remember_me"
    }

    fun saveAuthToken(token: String) {
        val editor = prefs.edit()
        editor.putString(USER_TOKEN, token)
        editor.apply()
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
        return prefs.getString(USER_TOKEN, null)
    }

    fun clearAuthToken() {
        val editor = prefs.edit()
        editor.remove(USER_TOKEN)
        if (!fetchRememberStatus()) {
            editor.remove(REMEMBER_ME)
        }
        editor.apply()
    }
}
