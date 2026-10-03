<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $angkatan = '';
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->angkatan = $user->angkatan ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->fill($validated);
        $user->save();

        // Log the activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'UPDATE_PROFILE',
            'description' => $user->name . ' memperbarui data profilnya.',
            'ip_address' => request()->ip()
        ]);

        $this->dispatch('profile-updated', name: $user->name);
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-black text-gray-900">Informasi Data Diri</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">
            Perbarui informasi profil dan data diri akun Anda.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-5">
        
        {{-- NIM & Angkatan (Readonly) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Nomor Induk Mahasiswa (NIM)</label>
                <input type="text" value="{{ auth()->user()->nim }}" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl cursor-not-allowed">
                <p class="mt-1.5 text-xs text-gray-400 font-medium">NIM untuk login, tidak dapat diubah.</p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Tahun Angkatan</label>
                <input type="text" value="{{ auth()->user()->angkatan ?? '-' }}" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl cursor-not-allowed">
            </div>
        </div>

        {{-- Role & Bidang (Readonly) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Jabatan</label>
                <input type="text" value="{{ auth()->user()->jabatan ?? '-' }}" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 text-sm font-bold rounded-xl cursor-not-allowed">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Divisi / Bidang</label>
                <input type="text" value="{{ auth()->user()->bidang ? auth()->user()->bidang->name : 'DANA DAN USAHA' }}" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl cursor-not-allowed">
            </div>
        </div>

        {{-- Editable Fields --}}
        <div>
            <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
            <input wire:model="name" id="name" type="text" required class="w-full px-4 py-2.5 bg-white border border-gray-300 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" autofocus>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                Simpan Perubahan
            </button>

            <x-action-message class="me-3 text-sm font-bold text-green-600" on="profile-updated">
                Data berhasil disimpan!
            </x-action-message>
        </div>
    </form>
</section>