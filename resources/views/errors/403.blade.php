<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #FCE6E6, #F8B8B8);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .error-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem 3rem;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 500px;
            animation: fadeIn 0.8s ease-out;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .error-code1 {
            font-size: 150px;
            font-weight: 800;
            color: #DF2E2E;
            margin: 0;
            line-height: 1;
            text-shadow: 5px 5px 0 rgba(223,46,46,0.1);
            position: relative;
            animation: shake 0.5s ease-in-out infinite alternate;
        }
        .error-code2 {
            font-size: 25px;
            font-weight: 800;
            color: #DF2E2E;
            margin: 0;
            line-height: 1;
            text-shadow: 5px 5px 0 rgba(223,46,46,0.1);
            position: relative;
            animation: shake 0.5s ease-in-out infinite alternate;
        }
        .error-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.75rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-back {
            background: #6c757d;
            color: white;
        }
        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(108,117,125,0.3);
        }
        .btn-home:hover {
            background: #c22525;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(223,46,46,0.3);
        }
        .btn i {
            margin-right: 8px;
            font-size: 1.1em;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes shake {
            0% { transform: translateX(-3px); }
            100% { transform: translateX(3px); }
        }
        .lock-icon {
            font-size: 80px;
            color: #DF2E2E;
            margin-bottom: 10px;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
        .warning-triangle {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 60px;
            color: #DF2E2E;
            opacity: 0.2;
            z-index: -1;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('public/asset/dist/img/logo-umkm.png') }}" type="image/png">
</head>
<body>
    <div class="error-container">
        <div class="lock-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="error-code1">403</div>
        <h2 class="error-code2">Akses Ditolak!</h2>
        <p class="error-message">Anda tidak memiliki izin untuk mengakses halaman ini.<br>Silakan hubungi administrator jika ini sebuah kesalahan.</p>
        
        <div class="btn-group">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" 
       class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

    </div>
</body>
</html>