<!DOCTYPE html>
<html lang="{{ str_replace(`_`, `-`, app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Danus HIMASI</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8f9fc] text-gray-800" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            
            {{-- Mobile Overlay --}}
            <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            {{-- SIDEBAR --}}
            <livewire:layout.sidebar />

            {{-- MAIN WRAPPER --}}
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                {{-- TOPBAR --}}
                <livewire:layout.header />

                {{-- PAGE CONTENT --}}
                <main class="flex-1 overflow-y-auto">
                    <div class="p-4 md:p-8 max-w-[1400px] mx-auto w-full">{{ $slot }}</div>
                </main>
            </div>
        </div>
    </body>
</html>

