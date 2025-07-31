<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
        }

        .card-header {
            background: linear-gradient(to right, #56ab2f, #a8e063);
        }

        .btn-success {
            background-color: #56ab2f;
            border-color: #56ab2f;
        }

        .btn-success:hover {
            background-color: #3d8b1e;
            border-color: #3d8b1e;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow rounded-4">
            <div class="card-header text-white text-center rounded-top-4 bg-success">
                <h4 class="my-2">Buat Akun</h4>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Daftar Sebagai</label>
                        <select name="role_id" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </form>

                <div class="text-center">
                    <small>Udah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
                </div>
            </div>

            <div class="card-footer text-muted text-center small">
                &copy; {{ date('Y') }} Samudtronz
            </div>
        </div>
    </div>
</div>


</body>

</html>