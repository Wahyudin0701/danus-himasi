<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- NIM / Username -->
        <div>
            <label for="nim" class="block text-sm font-bold text-gray-700 mb-2">NIM / Username</label>
            <input wire:model="form.nim" id="nim" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" type="text" name="nim" required autofocus autocomplete="username" placeholder="Masukkan NIM Anda" />
            <x-input-error :messages="$errors->get('form.nim')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
            <input wire:model="form.password" id="password" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4 cursor-pointer" name="remember">
                <span class="ms-2 text-sm font-bold text-gray-500 group-hover:text-gray-700 transition-colors">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center bg-blue-600 text-white text-sm font-bold rounded-xl px-8 py-3.5 hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</div>
