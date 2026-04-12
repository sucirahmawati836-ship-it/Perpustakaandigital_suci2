<!DOCTYPE html>
<html>
<head>
    <title>Login E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f1f8f4;
        }

        .card {
            border-radius: 15px;
        }

        .btn-custom {
            background-color: #2E7D32;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #1B5E20;
        }

        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46,125,50,0.25);
        }

        a {
            color: #2E7D32;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width:350px;">
        
        <h4 class="text-center mb-3">Login E-Perpus</h4>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">
                Login
            </button>
        </form>

        <p class="text-center mt-3">
            Belum punya akun?
            <a href="{{ route('auth.register') }}">Register</a>
        </p>

    </div>
</div>

</body>
</html>