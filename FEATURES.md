# ✨ DEISA Features Showcase

This document outlines the key features of the DEISA ecosystem, ready for presentation.

## 🌐 Web Platform (Admin & Dashboard)

### 1. Dashboard Eksekutif
-   **Real-time Statistics**: View total students, sick reports today, and low stock warnings.
-   **Graphical Analytics**: Chart.js integration showing health trends over months.

### 2. Manajemen Santri
-   **CRUD Santri**: Add, Edit, Delete Santri data.
-   **Detail View**: View medical history (riwayat alergi, golongan darah).
-   **Wali Management**: Integrated parent/guardian contact info.

### 3. Electronic Health Records (Pencatatan Sakit)
-   **Diagnosis System**: Record symptoms, diagnosis, and actions taken.
-   **Status Tracking**: Track if a student is "Sakit", "Dirawat", or "Sembuh".
-   **PDF Export**: Export monthly health reports for administration.

### 4. Inventory Obat (Medicine)
-   **Stock Tracking**: Real-time deduction of stock when medicine is prescribed.
-   **Restock Logs**: Track when and how much medicine was added.
-   **Low Stock Alerts**: Visual indicators when stock is critical.

### 5. Role-Based Access
-   **Admin**: Full access to all settings and master data.
-   **Petugas**: Focused reporting and daily operations.

---

## 📱 Android Application (Mobile)

### 1. Modern User Interface
-   **Material You**: Responsive Design using Jetpack Compose.
-   **Dark Mode Support**: Adapts to system theme.

### 2. Mobile Workflow
-   **Quick Report**: Report a sick student immediately from the field.
-   **Offline First UI**: Skeleton loading states for smooth UX.

### 3. Integrated Search
-   **Smart Search**: Instantly find students by Name or NIS.
-   **Real-time Filters**: Filter data without reloading.

### 4. Secure Authentication
-   **JWT-based Login**: Secure sessions with auto-logout capabilities.
-   **Profile Management**: Update officer details on the go.

---

## 🔒 Security & Architecture
-   **MVC Pattern**: Backend follows strict Model-View-Controller separation.
-   **MVVM Pattern**: Android app uses ViewModel for clean state management.
-   **Input Validation**: Strong validation on both server and client side.
