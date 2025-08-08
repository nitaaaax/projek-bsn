<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SI-UMKM RIAU</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('public/asset/dist/img/logo-umkm.png') }}" type="image/png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background-color: #f0fafe;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            border: none;
            box-shadow: 0 0 20px rgba(46, 198, 223, 0.3);
        }

        .brand-logo-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-logo-box img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            border-radius: 12px;
            background-color: #e3faff;
            padding: 6px;
        }

        .brand-logo-box span {
            font-size: 1.5rem;
        }

        .form-control:focus {
            border-color: #2EC6DF;
            box-shadow: 0 0 0 0.2rem rgba(46, 198, 223, 0.25);
        }

        .btn-cyan {
            background-color: #2EC6DF;
            color: white;
        }

        .btn-cyan:hover {
            background-color: #28b3c9;
        }

        .text-highlight {
            color: #B9375D;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card card-login p-4">
            <div class="brand-logo-box text-center">
                <img src="{{ asset('asset/dist/img/logo-umkm.png') }}" alt="Logo SI-UMKM">
                <span class="brand-text fw-bold text-dark">
                    SI-UMKM <span style="color:#15AABF">RIAU</span>
                </span>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label text-highlight">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-highlight">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-cyan">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery & Toastr -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Config + Flash Message -->
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "timeOut": "3000", // 3 detik
            "extendedTimeOut": "1000"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>
</html>
