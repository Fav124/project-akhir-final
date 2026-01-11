<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DEISA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #10b981; --bg: #f3f4f6; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 2.5rem; border-radius: 1rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .logo { font-size: 2rem; font-weight: 800; color: var(--primary); text-align: center; margin-bottom: 2rem; letter-spacing: -1px; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; }
        .form-input { width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #d1d5db; outline: none; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 0.75rem; background: var(--primary); color: white; border: none; border-radius: 0.5rem; font-weight: 700; cursor: pointer; font-size: 1rem; }
        .error { color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">DEISA</div>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" required autofocus>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; color: #6b7280; font-size: 0.875rem;">
            Belum punya akun? <br> Daftar melalui Aplikasi Mobile
        </p>
    </div>
</body>
</html>
