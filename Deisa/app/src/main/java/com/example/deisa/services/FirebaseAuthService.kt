package com.example.deisa.services

import android.content.Context
import android.util.Log
import androidx.credentials.CredentialManager
import androidx.credentials.CustomCredential
import androidx.credentials.GetCredentialRequest
import androidx.credentials.GetCredentialResponse
import androidx.credentials.exceptions.GetCredentialException
import com.google.android.libraries.identity.googleid.GetGoogleIdOption
import com.google.android.libraries.identity.googleid.GoogleIdTokenCredential
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.auth.FirebaseUser
import com.google.firebase.auth.GoogleAuthProvider
import kotlinx.coroutines.tasks.await

class FirebaseAuthService(private val context: Context) {

    private val auth: FirebaseAuth = FirebaseAuth.getInstance()
    private val credentialManager: CredentialManager = CredentialManager.create(context)

    // TODO: Replace with your actual Web Client ID from Google Cloud Console
    // Usually located in google-services.json or Firebase Console -> Authentication -> Sign-in method -> Google
    private val WEB_CLIENT_ID = "502457282438-ghr07o7ho4ktc4nesj152t95hs8hsfcl.apps.googleusercontent.com"

    suspend fun signInWithGoogle(): FirebaseUser? {
        try {
            val googleIdOption = GetGoogleIdOption.Builder()
                .setFilterByAuthorizedAccounts(false)
                .setServerClientId(WEB_CLIENT_ID) 
                .setAutoSelectEnabled(true)
                .build()

            val request = GetCredentialRequest.Builder()
                .addCredentialOption(googleIdOption)
                .build()

            val result = credentialManager.getCredential(request = request, context = context)
            return handleSignIn(result)
        } catch (e: GetCredentialException) {
            Log.e("FirebaseAuthService", "GetCredentialException", e)
            return null
        } catch (e: Exception) {
            Log.e("FirebaseAuthService", "Exception", e)
            return null
        }
    }

    private suspend fun handleSignIn(result: GetCredentialResponse): FirebaseUser? {
        val credential = result.credential
        if (credential is CustomCredential && credential.type == GoogleIdTokenCredential.TYPE_GOOGLE_ID_TOKEN_CREDENTIAL) {
            try {
                val googleIdTokenCredential = GoogleIdTokenCredential.createFrom(credential.data)
                val idToken = googleIdTokenCredential.idToken
                
                Log.d("FirebaseAuthService", "Google ID Token: $idToken")

                val firebaseCredential = GoogleAuthProvider.getCredential(idToken, null)
                val authResult = auth.signInWithCredential(firebaseCredential).await()
                return authResult.user
            } catch (e: Exception) {
                Log.e("FirebaseAuthService", "Firebase Auth Failed", e)
                return null
            }
        } else {
            Log.e("FirebaseAuthService", "Unexpected credential type")
            return null
        }
    }

    fun getCurrentUser(): FirebaseUser? {
        return auth.currentUser
    }

    fun logout() {
        auth.signOut()
    }
}
