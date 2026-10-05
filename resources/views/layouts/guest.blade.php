<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - Sistem Informasi Divisi Danus</title>
        <link rel="icon" type="image/png" href="{{ asset('Logo_Himasi_Store.png').'?v=2' }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ── Background blobs ── */
            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33%  { transform: translate(20px, -30px) scale(1.07); }
                66%  { transform: translate(-15px, 15px) scale(0.95); }
            }
            .blob { animation: blob 9s ease-in-out infinite; }
            .blob-d2 { animation-delay: 2.5s; }
            .blob-d4 { animation-delay: 5s; }

            /* ── Walk Left to Right ── */
            @keyframes walkLR {
                0%   { transform: translateX(-300px); opacity: 0; }
                5%   { opacity: 1; }
                95%  { opacity: 1; }
                100% { transform: translateX(110vw); opacity: 0; }
            }

            /* ── Walk Right to Left (mirrored) ── */
            @keyframes walkRL {
                0%   { transform: translateX(110vw) scaleX(-1); opacity: 0; }
                5%   { opacity: 1; }
                95%  { opacity: 1; }
                100% { transform: translateX(-300px) scaleX(-1); opacity: 0; }
            }

            /* ── Gentle bob while walking ── */
            @keyframes bob {
                0%, 100% { margin-bottom: 0; }
                50%       { margin-bottom: 12px; }
            }

            .walk-lr {
                position: fixed;
                bottom: -10px;
                left: 0;
                pointer-events: none;
                z-index: 1;
                animation: walkLR linear infinite;
            }
            .walk-rl {
                position: fixed;
                bottom: -10px;
                right: 0;
                pointer-events: none;
                z-index: 1;
                animation: walkRL linear infinite;
            }

            .char-img {
                animation: bob 0.5s ease-in-out infinite;
                display: block;
                filter: drop-shadow(0 12px 24px rgba(0,0,0,0.2));
            }

        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-x-hidden">

        {{-- ── Animated Background ── --}}
        <div class="fixed inset-0 -z-10 overflow-hidden bg-[#f0f5ff]">
            <div class="blob absolute -top-20 -left-20 w-[500px] h-[500px] rounded-full opacity-60"
                 style="background:#bfdbfe; filter:blur(80px);"></div>
            <div class="blob blob-d2 absolute top-1/3 -right-24 w-[500px] h-[500px] rounded-full opacity-45"
                 style="background:#a5f3fc; filter:blur(80px);"></div>
            <div class="blob blob-d4 absolute -bottom-24 left-1/3 w-[420px] h-[420px] rounded-full opacity-50"
                 style="background:#c7d2fe; filter:blur(70px);"></div>
        </div>

        {{-- ── Walking Characters (Left → Right) ── --}}
        @php
            $loginChars = \App\Models\CharacterSetting::forLogin();
            $directions = ['walk-lr', 'walk-rl'];
        @endphp
        @foreach($loginChars as $i => $char)
        @php
            // Randomize duration between 16s and 26s
            $walkDuration = rand(160, 260) / 10;
            // Randomize negative delay so they don't all start at once
            $walkDelay = -rand(20, 180) / 10;
            // Randomize bobbing speed between 0.4s and 0.55s
            $bobSpeed = rand(40, 55) / 100;
        @endphp
        <div class="{{ $directions[$i % 2] }}" style="animation-duration: {{ $walkDuration }}s; animation-delay: {{ $walkDelay }}s;">
            <img class="char-img w-40" src="{{ asset('Foto_Karikatur_Kepala_Besar/' . $char->filename) }}" alt="{{ $char->display_name }}" style="animation-duration: {{ $bobSpeed }}s;">
        </div>
        @endforeach

        {{-- ── Main Login Content ── --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-4 relative z-10">

            {{-- Logo Header --}}
            <div class="mb-8 flex flex-col items-center">
                <img src="{{ asset('Logo_Himasi_Store.png').'?v=2' }}" alt="Logo Himasi"
                     class="w-24 h-24 rounded-full object-cover shadow-lg mb-4 border-2 border-white">
                <div class="text-center">
                    <p class="font-black text-xl text-blue-900 tracking-tight">DANUS HIMASI</p>
                    <p class="text-xs font-bold text-orange-500 tracking-widest mt-1">UNIVERSITAS JAMBI</p>
                </div>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 sm:px-10 py-10 bg-white/60 backdrop-blur-xl shadow-xl shadow-blue-900/10 overflow-hidden rounded-[2rem] border border-white/60 mx-4 sm:mx-0">
                {{ $slot }}
            </div>

            <p class="mt-8 text-xs font-bold text-gray-400">Divisi Dana dan Usaha &copy; {{ date('Y') }}</p>
        </div>
    </body>
</html>
