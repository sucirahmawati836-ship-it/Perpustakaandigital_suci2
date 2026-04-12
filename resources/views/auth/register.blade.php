<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .theme-green {
            background-color: #2E7D32;
        }

        .theme-green:hover {
            background-color: #1B5E20;
        }

        .input-focus:focus {
            outline: none;
            border-color: #2E7D32;
            box-shadow: 0 0 0 2px rgba(46,125,50,0.2);
        }

        .link-green {
            color: #2E7D32;
        }
    </style>
</head>
<body class="bg-[#f1f8f4] flex items-center justify-center h-screen">

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

        <input type="text" name="name" placeholder="Nama"
            class="w-full mb-3 p-2 border rounded input-focus">

        <input type="email" name="email" placeholder="Email"
            class="w-full mb-3 p-2 border rounded input-focus">

        <input type="password" name="password" placeholder="Password"
            class="w-full mb-3 p-2 border rounded input-focus">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="w-full mb-3 p-2 border rounded input-focus">

        <input type="text" name="nis" placeholder="NIS"
            class="w-full mb-3 p-2 border rounded input-focus">

        <input type="text" name="kelas" placeholder="Kelas"
            class="w-full mb-4 p-2 border rounded input-focus">

        <button class="w-full theme-green text-white p-2 rounded">
            Register
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Sudah punya akun?
        <a href="/auth/login" class="link-green hover:underline">Login</a>
    </p>
</div>

</body>
</html>