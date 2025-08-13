<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #E6F9FC, #B8F0F8);
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
            background: rgba(255, 255, 255, 0.9);
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
            color: #2EC6DF;
            margin: 0;
            line-height: 1;
            text-shadow: 5px 5px 0 rgba(46,198,223,0.1);
            position: relative;
            animation: float 3s ease-in-out infinite;
        }
        .error-code2 {
            font-size: 25px;
            font-weight: 800;
            color: #2EC6DF;
            margin: 0;
            line-height: 1;
            text-shadow: 5px 5px 0 rgba(46,198,223,0.1);
            position: relative;
            animation: float 3s ease-in-out infinite;
        }
        .error-message {
            font-size: 22px;
            font-weight: 500;
            color: #555;
            margin: 1.5rem 0;
            line-height: 1.4;
        }
        .back-home {
            display: inline-block;
            background: #2EC6DF;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(46,198,223,0.4);
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .back-home:hover {
            background: #25adc2;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46,198,223,0.5);
        }
        .back-home:active {
            transform: translateY(1px);
        }
        .back-home::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .back-home:hover::before {
            left: 100%;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .bubble {
            position: absolute;
            background: rgba(46,198,223,0.1);
            border-radius: 50%;
            animation: floatBubble 15s infinite linear;
            z-index: 1;
        }
        @keyframes floatBubble {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-5deg); }
            20%, 40%, 60%, 80% { transform: rotate(5deg); }
        }
        .search-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    <link rel="icon" href="{{ asset('public/asset/dist/img/logo-umkm.png') }}" type="image/png">
</head>
<body>
    <!-- Background bubbles -->
    <div class="bubble" style="width: 100px; height: 100px; left: 10%; top: 80%;"></div>
    <div class="bubble" style="width: 150px; height: 150px; left: 70%; top: 70%; animation-delay: -3s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; left: 30%; top: 90%; animation-delay: -5s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; left: 50%; top: 85%; animation-delay: -7s;"></div>
    <div class="bubble" style="width: 80px; height: 80px; left: 80%; top: 75%; animation-delay: -9s;"></div>
    
    <div class="error-container">
        <div class="error-code1">404</div>
        <div class="error-code2">NOT FOUND</div>
        <div class="error-message">Oops! Sepertinya kami tidak dapat menemukan halaman yang Anda cari</div>
        <a href="javascript:void(0)" onclick="goBack()" class="back-home">⬅ Kembali ke Halaman Sebelumnya</a>

        <script>
        function goBack() {
            const lastUrl = @json(session('last_non_error_url', url('/')));
            if (document.referrer && document.referrer !== window.location.href) {
                window.history.back();
            } else {
                window.location.href = lastUrl;
            }
        }
        
        // Create more bubbles dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.querySelector('body');
            for (let i = 0; i < 10; i++) {
                const bubble = document.createElement('div');
                bubble.className = 'bubble';
                const size = Math.random() * 100 + 50;
                const posX = Math.random() * 100;
                const delay = Math.random() * -15;
                const duration = Math.random() * 15 + 10;
                
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${posX}%`;
                bubble.style.top = `${Math.random() * 100 + 100}%`;
                bubble.style.animationDelay = `${delay}s`;
                bubble.style.animationDuration = `${duration}s`;
                
                body.appendChild(bubble);
            }
        });
        </script>
    </div>
</body>
</html>