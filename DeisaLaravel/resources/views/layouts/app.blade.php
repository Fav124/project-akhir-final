<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEISA - @yield('title', 'Sistem Manajemen Kesehatan')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #10b981;
            --primary-hover: #059669;
            --bg: #f9fafb;
            --sidebar: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --white: #ffffff;
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }

        .sidebar-header {
            padding: 2rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
        }

        .nav-links {
            flex: 1;
            padding: 0 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--text-muted);
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #f0fdf4;
            color: var(--primary);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card {
            background: var(--white);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }

        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-muted); }
        .form-input { 
            width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--border); outline: none; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); }

        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; border-bottom: 1px solid var(--border); color: var(--text-muted); font-size: 0.875rem; }
        td { padding: 1rem; border-bottom: 1px solid var(--border); }

        .badge {
            padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-error { background: #fee2e2; color: #991b1b; }

        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar-header, .sidebar-link span { display: none; }
            .main-content { margin-left: 80px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">DEISA</div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('santri.index') }}" class="nav-link {{ request()->routeIs('santri.*') ? 'active' : '' }}">Data Santri</a>
            <a href="{{ route('obat.index') }}" class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}">Inventaris Obat</a>
            <a href="{{ route('sakit.index') }}" class="nav-link {{ request()->routeIs('sakit.*') ? 'active' : '' }}">Catatan Sakit</a>
            
            @if(Auth::user()->role === 'admin')
            <div style="padding: 1rem 1rem 0.5rem; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Admin Only</div>
            <a href="{{ route('admin.registrations') }}" class="nav-link {{ request()->routeIs('admin.registrations') ? 'active' : '' }}">Registrasi Baru</a>
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">Manajemen User</a>
            @endif
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="color: var(--error); padding: 0.5rem 0; width: 100%; justify-content: flex-start;">Logout</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="card" style="background: #ecfdf5; border: 1px solid #10b981; color: #065f46; padding: 1rem;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="card" style="background: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem;">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
