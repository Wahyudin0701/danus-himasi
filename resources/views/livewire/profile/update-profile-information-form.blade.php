<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public $photo; // For new uploaded photo
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
            'photo' => ['nullable', 'image', 'max:10240'], // 10MB Max
        ]);

        $user->fill($validated);

        if ($this->photo) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            // Store new photo
            $path = $this->photo->store('profile-photos', 'public');
            $user->photo = $path;
        }

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

    public function deleteProfilePhoto(): void
    {
        $user = Auth::user();
        if ($user->photo) {
            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = null;
            $user->save();
            
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'DELETE_PHOTO',
                'description' => $user->name . ' menghapus foto profilnya.',
                'ip_address' => request()->ip()
            ]);
        }
        
        $this->photo = null;
        $this->dispatch('profile-updated');
    }
}; ?>

<section x-data="{ showDeleteModal: false }">
    <header>
        <h2 class="text-lg font-black text-gray-900">Informasi Data Diri</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">
            Perbarui informasi profil dan data diri akun Anda.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-5">
        
        {{-- Profile Photo --}}
        <div class="flex items-center gap-6 mb-6">
            <div class="relative w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center border-4 border-white shadow-md overflow-hidden shrink-0">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                @elseif (auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-black text-gray-400">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                @endif
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-1">Foto Profil</label>
                <p class="text-xs text-gray-500 mb-3">Format JPG, PNG, atau GIF. Maksimal 10MB.</p>
                <div class="flex items-center gap-2">
                    <div class="relative overflow-hidden inline-block">
                        <input type="file" wire:model="photo" id="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <button type="button" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm focus:outline-none">
                            Pilih Foto Baru
                        </button>
                    </div>
                    @if(auth()->user()->photo)
                        <button type="button" @click="showDeleteModal = true" class="px-4 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-xl hover:bg-red-100 transition-colors focus:outline-none">
                            Hapus
                        </button>
                    @endif
                </div>
                <div wire:loading wire:target="photo" class="text-xs text-blue-600 font-bold mt-2">Mengunggah...</div>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>
        
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

        

        <div class="flex items-center justify-end gap-4 pt-4">
            <x-action-message class="me-3 text-sm font-bold text-green-600" on="profile-updated">
                Data berhasil disimpan!
            </x-action-message>

            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- Delete Modal --}}
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm transition-opacity"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="showDeleteModal = false" class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-sm overflow-hidden text-center p-8 relative transform transition-all"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-5">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Foto Profil?</h3>
            <p class="text-sm font-medium text-gray-500 leading-relaxed mb-8">
                Tindakan ini tidak dapat dibatalkan. Foto profil Anda akan dihapus secara permanen dari sistem.
            </p>

            <div class="flex items-center justify-center gap-3">
                <button @click="showDeleteModal = false" type="button" class="flex-1 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm font-bold rounded-2xl transition-colors">Batal</button>
                <button wire:click="deleteProfilePhoto" @click="showDeleteModal = false" type="button" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-2xl transition-colors shadow-sm shadow-red-200 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="deleteProfilePhoto">Ya, Hapus</span>
                    <span wire:loading wire:target="deleteProfilePhoto">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
</section>