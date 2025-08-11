<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #E7FFFF, #C8F4F9);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            text-align: center;
            background: #ffffffd9;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            max-width: 500px;
            animation: fadeIn 0.6s ease-in-out;
        }
        .error-code {
            font-size: 150px;
            font-weight: 800;
            color: #00a37a;
            animation: float 3s ease-in-out infinite;
        }
        .error-message {
            font-size: 20px;
            font-weight: 500;
            color: #444;
            margin-bottom: 1.5rem;
        }
        .back-home {
            display: inline-block;
            background: #00a37a;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-home:hover {
            background: #008b62;
            transform: translateY(-3px);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
    <link rel="icon" href="{{ asset('public/asset/dist/img/logo-umkm.png') }}" type="image/png">
</head>
<body>
    <div class="error-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="#00a37a" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke-opacity=".2"/>
            <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div class="error-code">404</div>
        <div class="error-message">Oops! Halaman yang kamu cari tidak ditemukan</div>
        <a href="{{ url('/') }}" class="back-home">Kembali ke Home</a>
    </div>
</body>
</html>
