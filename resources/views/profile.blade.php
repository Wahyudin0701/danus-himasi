<x-app-layout>
    <div class="max-w-4xl mx-auto w-full">
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-gray-900">Profil Saya</h1>
                <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Update Profile Info Form --}}
            <div class="p-6 md:p-8 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="max-w-full">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Update Password Form --}}
            <div class="p-6 md:p-8 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="max-w-full">
                    <livewire:profile.update-password-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>