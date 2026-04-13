<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPK App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --primary-hover: #3a56d4;
            --bg-body: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-body);
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 2rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 3rem 2.5rem;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
            background: var(--primary);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        p.welcome-text {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 0.75rem;
            padding: 0.8rem;
            font-weight: 500;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .alert {
            border-radius: 0.75rem;
            font-size: 0.9rem;
            border: none;
            background-color: #fef2f2;
            color: #b91c1c;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card">
            <h1>Selamat Datang</h1>
            <p class="welcome-text">Sistem Pendukung Keputusan</p>

            @if ($errors->any())
                <div class="alert text-start">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('validasi_menunggu'))
                <div class="alert alert-warning text-start" style="background: #fffbeb; color: #b45309;">
                    {{ session('validasi_menunggu') }}
                </div>
            @endif

            @if (session('validasi_ditolak'))
                <div class="alert text-start">
                    {{ session('validasi_ditolak') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com"
                        required value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="••••••••"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Login Sekarang
                </button>
            </form>

            <div class="footer-links">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Disini</a>
            </div>
        </div>
    </div>
</body>

</html>