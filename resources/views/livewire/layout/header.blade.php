<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<header class="bg-white border-b border-gray-100 flex items-center justify-between px-4 md:px-8 py-4 flex-shrink-0">
    <div class="flex items-center gap-3 md:gap-4 overflow-hidden">
        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-900 focus:outline-none flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        
        <img src="{{ asset('Logo_Himasi_Store.jpg') }}" alt="Logo Danus" class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover shadow-sm border border-gray-100 flex-shrink-0 lg:hidden">

        <h1 class="text-base md:text-lg font-bold text-gray-900 truncate">
            @php
                $routeName = request()->route()?->getName() ?? '';
                if (str_starts_with($routeName, 'members.')) {
                    echo 'Tim Divisi';
                } elseif (str_starts_with($routeName, 'bidang.')) {
                    echo 'Kelola Bidang';
                } elseif (str_starts_with($routeName, 'kas.')) {
                    echo 'Kas Divisi';
                } elseif (str_starts_with($routeName, 'system.')) {
                    echo 'Log Aktivitas Sistem';
                } elseif (str_starts_with($routeName, 'dokumen.')) {
                    echo 'Dokumen Divisi';
                } elseif ($routeName === 'dashboard') {
                    $role = auth()->user()->role;
                    if ($role === 'kadiv') {
                        echo 'Dashboard Kepala Divisi';
                    } elseif ($role === 'wakadiv') {
                        echo 'Dashboard Wakil Kadiv';
                    } elseif ($role === 'sekretaris') {
                        echo 'Dashboard Sekretaris';
                    } elseif ($role === 'bendahara') {
                        echo 'Dashboard Bendahara';
                    } else {
                        echo 'Dashboard';
                    }
                } elseif ($routeName === 'profile') {
                    echo 'Profil Saya';
                } elseif (str_starts_with($routeName, 'projects.')) {
                    echo 'Program Kerja';
                } elseif (str_starts_with($routeName, 'calendar.')) {
                    echo 'Kalender Divisi';
                } else {
                    echo 'Aplikasi Danus';
                }
            @endphp
        </h1>
    </div>

    <div class="flex items-center gap-6">
        <button class="text-gray-400 hover:text-gray-600 relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
        
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <!-- Trigger Button -->
            <button @click="open = !open" class="flex items-center gap-3 border-l border-gray-200 pl-6 focus:outline-none hover:opacity-80 transition-opacity">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-sm font-bold text-white flex-shrink-0 overflow-hidden">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name ?? '' }}</p>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ auth()->user()->nim ?? 'NIM' }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-cloak x-show="open" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                
                <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-blue-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>
                
                <hr class="border-gray-100 my-1">

                <button wire:click="logout" class="w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar Sistem
                </button>
            </div>
        </div>
    </div>
</header>