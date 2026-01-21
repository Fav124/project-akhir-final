# DEISA - Dar El-Ilmi Kesehatan System

Welcome to **DEISA**, a comprehensive Health Management System designed for Pesantren Dar El-Ilmi using strict MVC, SOLID, and Agile principles. The project consists of a robust Laravel Backend and a modern Android Jetpack Compose Application.

## 🌟 Project Overview
DEISA streamlines the health monitoring process for Santri (students). It allows health officers to record medical history, manage medicine inventory, and track sickness reports in real-time.

### Components
1.  **DeisaLaravel**: The backend API and Administrative Website.
2.  **DeisaCompose**: The mobile application for health officers and staff.

## 🚀 Tech Stack
### Backend & Web
-   **Framework**: Laravel 12.x
-   **Database**: MySQL
-   **Frontend**: Blade Views + Tailwind CSS 4.0 + Alpine.js
-   **API**: RESTful API with Sanctum Authentication

### Mobile App (Android)
-   **Language**: Kotlin
-   **UI Toolkit**: Jetpack Compose (Material 3)
-   **Architecture**: MVVM (Model-View-ViewModel)
-   **Networking**: Retrofit + OkHttp
-   **Async**: Coroutines

## 🛠️ Installation & Setup

### 1. Backend (Laravel)
Ensure you have PHP 8.2+, Composer, and MySQL installed.

```bash
cd DeisaLaravel
composer install
npm install
cp .env.example .env
# Configure your .env with your database credentials
php artisan key:generate
php artisan migrate --seed
npm run build
```

## 🚀 Running the Project

### Option 1: The "Realtime" Experience (Recommended)
To get the best experience with **Vite Hot Module Replacement (HMR)** and automatic background queues, run this single command:

```bash
cd DeisaLaravel
composer run dev
```

This command automatically starts:
-   Laravel Development Server (`php artisan serve`)
-   Vite Asset Server (`npm run dev`)
-   Queue Listener (`php artisan queue:listen`)
-   Tail Logging (`php artisan pail`)

> **Note**: This requires `concurrently` (installed automatically via `npm install`).

### Option 2: Classic Manual Method
If you prefer running services separately:

1.  **Terminal 1 (Laravel Server)**:
    ```bash
    cd DeisaLaravel
    php artisan serve
    ```

2.  **Terminal 2 (Vite Assets)**:
    ```bash
    cd DeisaLaravel
    npm run dev
    ```

### 2. Android App (Compose)
Open the `DeisaCompose` folder in Android Studio.

**Important**: For physical device testing, you must update the API Base URL.
1.  Open `DeisaCompose/app/src/main/java/com/example/deisacompose/data/network/ApiClient.kt`
2.  Update `BASE_URL`:
    ```kotlin
    // Change 10.0.2.2 (Emulator) to your PC's IP address
    private const val BASE_URL = "http://192.168.1.X:8000/api/" 
    ```
3.  Sync Gradle and Run.

## 📱 Features
See [FEATURES.md](FEATURES.md) for a detailed breakdown of all capabilities.

## 🤝 Project Structure
-   `DeisaLaravel/app/Models`: Eloquent Models.
-   `DeisaLaravel/app/Http/Controllers`: Logic Layer.
-   `DeisaCompose/app/src/main/java/ui/screens`: Compose Screens.
-   `DeisaCompose/app/src/main/java/viewmodels`: State Management.

---
**Ready for Launch** 🚀
