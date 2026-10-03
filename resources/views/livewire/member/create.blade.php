<div class="w-full">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Tambah Pengurus</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Input data pengurus baru dan buatkan akun sistem secara otomatis.</p>
        </div>
        <a href="{{ route('members.index') }}" wire:navigate class="text-sm font-bold text-gray-500 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Row 1 --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" wire:model="name" id="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Budi Santoso">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Row 2 --}}
            <div>
                <label for="nim" class="block text-sm font-bold text-gray-700 mb-2">NIM <span class="text-red-500">*</span></label>
                <input type="text" wire:model="nim" id="nim" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: F1E121001">
                @error('nim') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="angkatan" class="block text-sm font-bold text-gray-700 mb-2">Tahun Angkatan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="angkatan" id="angkatan" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: 2021">
                @error('angkatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Row 3 --}}
            <div>
                <label for="divisi" class="block text-sm font-bold text-gray-700 mb-2">Divisi <span class="text-red-500">*</span></label>
                <select id="divisi" disabled class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3 bg-gray-50 text-gray-500">
                    <option>Dana dan Usaha</option>
                </select>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="jabatan" class="block text-sm font-bold text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                </div>
                <select wire:model="jabatan" id="jabatan" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3">
                    <option value="">-- Pilih Jabatan Utama --</option>
                    @foreach($this->jabatanOptions as $opt)
                        <option value="{{ $opt['value'] }}" {{ $opt['disabled'] ? 'disabled' : '' }}>
                            {{ $opt['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('jabatan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Divider --}}
            <div class="md:col-span-2 py-4"><hr class="border-gray-100"></div>

            {{-- Account --}}
            
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Sementara <span class="text-red-500">*</span></label>
                <input type="text" wire:model="password" id="password" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Masukkan password awal">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3">
            <a href="{{ route('members.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Simpan Pengurus
            </button>
        </div>
    </form>
</div>
