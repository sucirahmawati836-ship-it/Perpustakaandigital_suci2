<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Register Anggota</h2>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/auth/register">
        @csrf

        {{-- NAMA --}}
        <input type="text" name="name" placeholder="Nama"
            class="w-full mb-3 p-2 border rounded">

        {{-- EMAIL --}}
        <input type="email" name="email" placeholder="Email"
            class="w-full mb-3 p-2 border rounded">

        {{-- PASSWORD --}}
        <input type="password" name="password" placeholder="Password"
            class="w-full mb-3 p-2 border rounded">

        {{-- KONFIRMASI PASSWORD --}}
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="w-full mb-3 p-2 border rounded">

        {{-- NIS --}}
        <input type="text" name="nis" placeholder="NIS"
            class="w-full mb-3 p-2 border rounded">

        {{-- KELAS --}}
        <input type="text" name="kelas" placeholder="Kelas"
            class="w-full mb-4 p-2 border rounded">

        <button class="w-full bg-green-500 hover:bg-green-600 text-white p-2 rounded">
            Register
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Sudah punya akun?
        <a href="/auth/login" class="text-blue-500 hover:underline">Login</a>
    </p>
</div>

</body>
</html>