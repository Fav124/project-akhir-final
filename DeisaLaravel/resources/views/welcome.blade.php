<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEISA - Sistem Manajemen Kesehatan Santri</title>
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #065f46;
            --dark: #1f2937;
            --light: #f9fafb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        nav {
            background-color: var(--white);
            padding: 1.5rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 10%;
            background: linear-gradient(135deg, #10b981 0%, #065f46 100%);
            color: var(--white);
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            margin-top: 0;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-white {
            background-color: var(--white);
            color: var(--primary);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .features {
            padding: 5rem 10%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card h3 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 3rem 10%;
            text-align: center;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            nav { padding: 1rem 5%; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">DEISA</div>
        <div>
            <a href="/dashboard" style="text-decoration: none; color: var(--dark); font-weight: 600;">Dashboard API</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Manajemen Kesehatan Santri Jadi Lebih Mudah.</h1>
            <p>Sistem terintegrasi untuk pemantauan kesehatan, manajemen obat, dan pelaporan medis santri secara real-time.</p>
            <div style="display: flex; gap: 1rem;">
                <a href="/dashboard" class="btn btn-white">Akses Dashboard</a>
                <a href="#" class="btn" style="background: rgba(255,255,255,0.1); border: 1px solid white; color: white;">Unduh App Android</a>
            </div>
        </div>
    </header>

    <section class="features">
        <div class="feature-card">
            <h3>Monitoring Real-time</h3>
            <p>Pantau kondisi kesehatan santri yang sedang dirawat secara langsung dari perangkat Anda.</p>
        </div>
        <div class="feature-card">
            <h3>Manajemen Obat</h3>
            <p>Inventarisasi obat yang akurat dengan sistem peringatan stok rendah otomatis.</p>
        </div>
        <div class="feature-card">
            <h3>Laporan Cerdas</h3>
            <p>Dapatkan statistik penyakit dan tren kesehatan untuk kebijakan yang lebih baik.</p>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2026 DEISA System. Dibuat untuk mendukung kesehatan pesantren.</p>
    </footer>
</body>
</html>
