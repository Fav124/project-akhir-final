package com.example.deisacompose.data.models

data class User(
    val id: Int,
    val name: String,
    val email: String,
    val role: String, // "admin" or "petugas"
    val status: String // "active" or "pending"
)

data class LoginRequest(
    val email: String,
    val password: String,
    val remember: Boolean = false
)

data class RegisterRequest(
    val name: String,
    val email: String,
    val password: String,
    val password_confirmation: String,
    val role: String
)

data class LoginResponse(
    val success: Boolean,
    val message: String?,
    val data: LoginData?
)

data class LoginData(
    val user: User,
    val token: String
)

data class ApiResponse<T>(
    val success: Boolean,
    val message: String? = null,
    val data: T? = null,
    val meta: PaginationMeta? = null
)

data class PaginationMeta(
    val current_page: Int,
    val last_page: Int,
    val per_page: Int,
    val total: Int
)
