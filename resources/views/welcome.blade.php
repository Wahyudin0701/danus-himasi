<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal - Danus HIMASI</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Background blobs */
        @keyframes blob {
            0%, 100% { transform: translate(0,0) scale(1); }
            33%  { transform: translate(25px,-35px) scale(1.08); }
            66%  { transform: translate(-15px,20px) scale(0.95); }
        }
        .blob { animation: blob 9s ease-in-out infinite; }
        .blob-d2 { animation-delay: 2.5s; }
        .blob-d4 { animation-delay: 5s; }

        /* Fade up */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fu    { opacity: 0; animation: fadeUp 0.65s ease forwards; }
        .fu-d1 { animation-delay: 0.08s; }
        .fu-d2 { animation-delay: 0.2s; }
        .fu-d3 { animation-delay: 0.35s; }
        .fu-d4 { animation-delay: 0.5s; }
        .fu-d5 { animation-delay: 0.65s; }
        .fu-d6 { animation-delay: 0.8s; }

        /* Logo ring pulse */
        @keyframes ring {
            0%   { transform: scale(1);    opacity: 0.5; }
            100% { transform: scale(1.65); opacity: 0; }
        }
        .logo-ring { animation: ring 2.4s ease-out infinite; }

        /* Status dot */
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.45;} }
        .dot-pulse { animation: pulse 2s ease-in-out infinite; }

        /* Orange shimmer */
        @keyframes shimmer {
            0%,100% { background-position: 0% 50%; }
            50%      { background-position: 100% 50%; }
        }
        .text-shimmer {
            background: linear-gradient(90deg, #f97316, #fb923c, #ea580c, #f97316);
            background-size: 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3.5s ease infinite;
        }

        /* Nav shadow on scroll */
        .nav-shadow { box-shadow: 0 4px 24px rgba(0,0,0,0.07); }

        /* Stat card subtle hover */
        .stat-card { transition: transform .25s ease, box-shadow .25s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(30,58,138,.1); }
    </style>
</head>
<body class="font-sans antialiased selection:bg-orange-400 selection:text-white flex flex-col min-h-screen overflow-x-hidden bg-slate-50">

    {{-- ── Animated background ── --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="blob  blob-d0 absolute -top-16 -left-24 w-[480px] h-[480px] rounded-full opacity-60"
             style="background:#bfdbfe; filter:blur(72px);"></div>
        <div class="blob  blob-d2 absolute top-1/3 -right-28 w-[520px] h-[520px] rounded-full opacity-45"
             style="background:#a5f3fc; filter:blur(80px);"></div>
        <div class="blob  blob-d4 absolute -bottom-28 left-1/3 w-[400px] h-[400px] rounded-full opacity-50"
             style="background:#c7d2fe; filter:blur(65px);"></div>
        <div class="absolute inset-0"
             style="background:rgba(248,250,252,.75);"></div>
    </div>

    {{-- ── Navbar ── --}}
    <header id="navbar" class="sticky top-0 z-50 bg-white/70 backdrop-blur-lg border-b border-white/80 transition-shadow duration-300 w-full">
        <div class="w-full px-5 sm:px-10 h-16 flex items-center justify-between">

            {{-- Brand --}}
            <div class="flex items-center gap-3 fu fu-d1">
                <img src="{{ asset('Logo_Himasi_Store.png').'?v=2' }}" alt="Logo"
                     class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-100 shadow-sm">
                <div class="leading-none">
                    <p class="font-black text-sm text-blue-900 tracking-tight">DANUS HIMASI</p>
                    <p class="text-[9px] font-bold text-orange-500 tracking-widest uppercase">Universitas Jambi</p>
                </div>
            </div>

            {{-- Nav action --}}
            @if(Route::has('login'))
            <div class="fu fu-d1">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center px-6 py-2 rounded-xl text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 shadow transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-6 py-2 rounded-xl text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 shadow transition-all">
                        Login
                    </a>
                @endauth
            </div>
            @endif
        </div>
    </header>

    {{-- ── Hero ── --}}
    <main class="flex-grow flex flex-col items-center justify-center px-5 pt-14 pb-4">

        {{-- Logo --}}
        <div class="relative mb-7 fu fu-d2">
            <div class="logo-ring absolute inset-0 m-1 rounded-full border-[3px] border-blue-300"></div>
            <img src="{{ asset('Logo_Himasi_Store.png').'?v=2' }}" alt="Logo HIMASI"
                 class="relative w-24 h-24 rounded-full object-cover shadow-xl ring-4 ring-white z-10">
        </div>

        {{-- Headline --}}
        <h1 class="text-3xl sm:text-5xl font-black text-blue-900 tracking-tight text-center leading-tight mb-3 fu fu-d3">
            Sistem Informasi<br>
            <span class="text-shimmer">Divisi Danus</span>
        </h1>

        <p class="text-sm sm:text-base text-gray-500 max-w-lg text-center font-medium leading-relaxed mb-7 fu fu-d4">
            Platform digital untuk pengelolaan administrasi, keuangan, dan program kerja
            Divisi Dana dan Usaha <strong class="text-blue-800 font-black">HIMASI</strong> Universitas Jambi.
        </p>

        {{-- Active Period Badge --}}
        @php $activePeriode = \App\Models\Periode::active(); @endphp
        <div class="mb-8 fu fu-d4">
            @if($activePeriode)
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 border border-green-200 shadow-sm text-sm">
                    <span class="dot-pulse w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                    <span class="text-gray-600 font-semibold">Kepengurusan Aktif:</span>
                    <span class="font-black text-green-700">{{ $activePeriode->name }}</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 border border-orange-200 shadow-sm text-sm">
                    <span class="w-2 h-2 rounded-full bg-orange-400 shrink-0"></span>
                    <span class="text-gray-500 font-semibold">Belum ada periode aktif</span>
                </div>
            @endif
        </div>

        {{-- CTA Button --}}
        <div class="fu fu-d5 mb-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="group inline-flex items-center gap-3 px-9 py-3.5 rounded-2xl text-white font-black text-sm shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 hover:shadow-blue-900/35 transition-all duration-300"
                   style="background:linear-gradient(135deg,#1e3a8a,#2563eb);">
                    Buka Dashboard
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="group inline-flex items-center gap-3 px-9 py-3.5 rounded-2xl text-white font-black text-sm shadow-lg shadow-blue-900/20 hover:-translate-y-0.5 hover:shadow-blue-900/35 transition-all duration-300"
                   style="background:linear-gradient(135deg,#1e3a8a,#2563eb);">
                    Masuk ke Sistem
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            @endauth
        </div>



    </main>

    {{-- ── Characters Section ── --}}
    @php $homeChars = \App\Models\CharacterSetting::forHome(); @endphp
    @if($homeChars->isNotEmpty())
    <section class="w-full overflow-hidden">
        <div class="flex items-end justify-center">
            @foreach($homeChars as $char)
            <img class="flex-shrink-0 drop-shadow-xl" 
                 style="width: {{ max(8, round(90 / $homeChars->count(), 1)) }}%;"
                 src="{{ asset('Foto_Karikatur_Kepala_Besar/' . $char->filename) }}" 
                 alt="{{ $char->display_name }}">
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── Footer ── --}}
    <footer class="py-6 text-center text-[11px] font-semibold text-gray-400">
        Divisi Dana &amp; Usaha HIMASI &copy; {{ date('Y') }} &mdash; Universitas Jambi
    </footer>

    <script>
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('nav-shadow', window.scrollY > 8);
        });
    </script>
</body>
</html>
