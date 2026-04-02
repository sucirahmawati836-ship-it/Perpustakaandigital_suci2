<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#eaf4f1] flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-[350px]">

        <h2 class="text-2xl font-semibold text-center mb-6 text-gray-700">
            Daftar Akun
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" placeholder="Nama"
                    class="w-full p-2 border rounded-lg"
                    value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-2 border rounded-lg"
                    value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <select name="role" class="w-full p-2 border rounded-lg">
                    <option value="">Pilih Role</option>
                    <option value="anggota">Anggota</option>
                    <option value="petugas">Petugas</option>
                    <option value="kepala">Kepala Perpus</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full p-2 border rounded-lg">
            </div>

            <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                Register
            </button>

            <p class="text-center mt-4 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 font-medium">
                    Login
                </a>
            </p>

        </form>

    </div>

</body>
</html>