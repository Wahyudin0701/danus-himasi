<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        // Log the activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'UPDATE_PASSWORD',
            'description' => $user->name . ' mengubah kata sandi akunnya.',
            'ip_address' => request()->ip()
        ]);

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-black text-gray-900">Perbarui Kata Sandi</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-5">
        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi Saat Ini</label>
            <input wire:model="current_password" id="update_password_current_password" type="password" required class="w-full px-4 py-2.5 bg-white border border-gray-300 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" autocomplete="current-password">
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
            <input wire:model="password" id="update_password_password" type="password" required class="w-full px-4 py-2.5 bg-white border border-gray-300 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" type="password" required class="w-full px-4 py-2.5 bg-white border border-gray-300 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
            <x-action-message class="me-3 text-sm font-bold text-green-600" on="password-updated">
                Kata sandi berhasil diganti!
            </x-action-message>

            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                Ganti Kata Sandi
            </button>
        </div>
    </form>
</section>