<!DOCTYPE html>
<html>
<head>
    <title>Login E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9;">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width:350px; border-radius:15px;">
        
        <h4 class="text-center mb-3">Login E-Perpus</h4>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
        </form>

    </div>
</div>

</body>
</html>