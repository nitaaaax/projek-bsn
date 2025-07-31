<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background: linear-gradient(135deg, #f6d365, #fda085, #f05454);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
        }

        .card-header {
            background: linear-gradient(to right, #ff4e50, #f00000);
        }

        .btn-primary {
            background-color: #ff4e50;
            border-color: #ff4e50;
        }

        .btn-primary:hover {
            background-color: #d90000;
            border-color: #d90000;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow rounded-4">
                <div class="card-header text-white text-center rounded-top-4">
                    <h4 class="my-2">Silakan Login</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100">Register</a>
                    </div>
                </div>

                <div class="card-footer text-muted text-center small">
                    &copy; {{ date('Y') }} Samudraz
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
