<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    <title>Loogbook UJA @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen flex flex-col md:flex-row">

    <!-- KIRI (hanya tampil di desktop) -->
    <div class="hidden md:flex w-1/2 bg-[#047857] items-center justify-center text-white">
        <h1 class="text-3xl font-bold text-[40px] leading-[55px] text-right px-[60px]">
            Selamat Datang <br />
            Di Logbook Peternakan <br />
            Bebek UJA
        </h1>
    </div>

    <!-- KANAN (mobile & desktop) -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-white py-10 md:py-0">
        <div class="w-full max-w-[484px] mx-auto px-6">
            <div class="flex flex-col items-center mb-6">
                <!-- Logo -->
                <img class="w-[120px] h-[90px] mb-1 object-contain" src="{{ asset('images/Logo.png') }}" alt="Logo UUDJA">
                <h2 class="text-[28px] md:text-[40px] font-bold text-[#0F172A] text-center">
                    Usaha Jeumala Amal
                </h2>
                <p class=" md:hidden text-center text-[16px] md:text-[18px] mt-1">
                    Selamat Datang Di Logbook Perternakan Bebek UUDJA
                </p>
            </div>

            <div class="bg-white p-6 md:p-10 rounded-xl shadow-2xl">
                <form action="/login" method="post" class="flex flex-col space-y-6">
                    @csrf

                    @error('auth')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <!-- USERNAME -->
                    <div>
                        <label class="text-[16px] md:text-[18px] font-semibold text-[#0F172A] mb-2 block">User Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('images/user.png') }}" class="w-[20px]" alt="User Icon">
                            </div>
                            <input type="text" name="username"
                                class="pl-10 pr-4 py-3 border-2 border-[#A3A1A1] rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-emerald-600"
                                required />
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="text-[16px] md:text-[18px] font-semibold text-[#0F172A] mb-2 block">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <img src="{{ asset('images/locked.png') }}" class="w-[20px]" alt="Password Icon">
                            </div>
                            <input type="password" name="password"
                                class="pl-10 pr-4 py-3 border-2 border-[#A3A1A1] rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-emerald-600"
                                required />
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="bg-[#047857] hover:bg-emerald-800 text-white font-semibold text-[18px] md:text-[20px] py-3 rounded-lg transition w-full">
                        LOGIN
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>


</html>



<!-- Form
<form action="/login" method="POST" class="space-y-4">
    <div class="space-y-[5px]">
        <label class="text-[18px] font-semibold text[#0F172A] mb-[5px]">User Name</label>
        <input type="text" name="username"
            class=" px-4 py-2 border-2 border-[#A3A1A1] rounded-lg w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600"
            required />
    </div>

    <div class="space-y-[5px]">
        <label class="text-[18px] font-semibold text-[#0F172A]">Password</label>
        <input type="text" name="password"
            class="px-4 py-2 border-2 border-[#A3A1A1] rounded-lg w-[378px] h-[62px] focus:outline-none focus:ring-2 focus:ring-emerald-600"
            required />
    </div>

    <a href="/">
        <div class="mt-[38px] flex items-center justify-center">
            <button type="submit"
                class="bg-[#047857] hover:bg-emerald-800 w-[161px] h-[62px] text-[20px] text-white font-semibold py-2 rounded-lg transition">
                LOGIN
            </button>
        </div>
    </a>
</form>-->
