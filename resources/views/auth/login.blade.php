<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#eaf4f1] flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-[350px]">
        
        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-700">
            Login Perpustakaan
        </h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Login
            </button>

            <p class="text-center mt-4 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 font-medium">
                    Daftar
                </a>
            </p>
        </form>

    </div>

</body>
</html>