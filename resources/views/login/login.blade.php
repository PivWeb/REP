<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - ERP PivWeb</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts e Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background-color: #ffffff;
        }

        .logo {
            width: 120px;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #0078D4;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #005fa3;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .text-link {
            font-size: 0.9rem;
            text-align: center;
            margin-top: 10px;
        }

        .text-link a {
            text-decoration: none;
            color: #0078D4;
        }

        .text-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card col-md-4">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h2 class="login-title">Bem-vindo ao ERP PivWeb</h2>
        </div>

        @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>

            <div class="text-link">
                <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
            </div>
        </form>
    </div>

</body>
</html>
