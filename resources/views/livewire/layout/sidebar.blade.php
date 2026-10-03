<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-[280px] bg-white border-r border-gray-100 flex flex-col flex-shrink-0 absolute inset-y-0 left-0 z-50 h-full overflow-y-auto transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">

    {{-- Logo --}}
    <div class="px-6 py-6 border-b border-gray-100 flex items-center gap-3">
        <img src="{{ asset('Logo_Himasi_Store.jpg') }}" alt="Logo Himasi" class="w-11 h-11 rounded-full object-cover flex-shrink-0 shadow-md border border-gray-100">
        <div class="leading-tight">
            <p class="font-black text-sm text-blue-900">DANUS HIMASI</p>
            <p class="text-[10px] font-bold text-orange-500 tracking-wider">UNJA</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-4 py-6 space-y-1">
        
        @if(auth()->user()->role === 'admin')
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-3">MENU ADMINISTRATOR</p>

            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                Dashboard
            </a>

                        <a href="{{ route('projects.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('projects.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Program Kerja
            </a>


            <a href="{{ route('kas.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('kas.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Kas Divisi
            </a>

            <a href="{{ route('dokumen.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('dokumen.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Dokumen Divisi
            </a>

            <a href="{{ route('members.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('members.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tim Divisi
            </a>
            <a href="{{ route('calendar.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('calendar.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kalender Divisi
            </a>

            <a href="{{ route('system.logs') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('system.logs') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Log Aktivitas Sistem
            </a>
        @else
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-3">MENU DIVISI DANA DAN USAHA</p>

            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                Dashboard
            </a>

                        <a href="{{ route('projects.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('projects.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Program Kerja
            </a>


                        <a href="{{ route('kas.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('kas.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Kas Divisi
            </a>

            <a href="{{ route('dokumen.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('dokumen.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Dokumen Divisi
            </a>

            
            <a href="{{ route('members.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('members.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tim Divisi
            </a>
            <a href="{{ route('calendar.index') }}" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all mt-1 {{ request()->routeIs('calendar.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kalender Divisi
            </a>
            
        @endif

        <div class="pt-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-3">PENGATURAN</p>
            
            <a href="/profile" wire:navigate class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-gray-500 hover:bg-gray-50 hover:text-blue-600">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
            </a>
        </div>
    </nav>

    {{-- Logout Footer --}}
    <div class="px-6 py-5 border-t border-gray-100">
        <button wire:click="logout" class="flex items-center justify-between w-full text-left group">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white shadow-md">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ auth()->user()->nim ?? 'Logout' }}</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </button>
    </div>
</aside>
