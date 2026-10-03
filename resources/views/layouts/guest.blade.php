<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Sistem Informasi Divisi Danus</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#f8f9fc]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Logo Header --}}
            <div class="mb-8 flex flex-col items-center">
                <img src="{{ asset('Logo_Himasi_Store.jpg') }}" alt="Logo Himasi" class="w-24 h-24 rounded-full object-cover shadow-lg mb-4 border-2 border-white">
                <div class="text-center">
                    <p class="font-black text-xl text-blue-900 tracking-tight">SISTEM INFORMASI</p>
                    <p class="text-xs font-bold text-orange-500 tracking-widest mt-1">UNIVERSITAS JAMBI</p>
                </div>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-10 py-10 bg-white shadow-xl shadow-gray-100/50 overflow-hidden sm:rounded-3xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-xs font-bold text-gray-400">Divisi Dana dan Usaha &copy; {{ date('Y') }}</p>
        </div>
    </body>
</html>
