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

            {{-- EMAIL --}}
            <div class="mb-3">
                <label>Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control"
                    value="{{ old('email') }}" 
                    required
                >
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label>Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    required
                >
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>

        {{-- LINK REGISTER --}}
        <p class="text-center mt-3">
            Belum punya akun?
            <a href="{{ route('auth.register') }}">Daftar</a>
        </p>

    </div>
</div>

</body>
</html>