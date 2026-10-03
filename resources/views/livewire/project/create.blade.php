<div class="w-full">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Tambah Program Kerja</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Buat program kerja atau agenda baru untuk divisi Anda.</p>
        </div>
        <a href="{{ route('projects.index') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Nama Program Kerja --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program Kerja <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5" placeholder="Contoh: Pembuatan Baju Prodi Himasi">
                    @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis/Kategori --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jenis / Kategori <span class="text-red-500">*</span></label>
                    <select wire:model="category" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="pembuatan_atribut">Pembuatan Atribut</option>
                        <option value="penjualan_event">Penjualan di Event</option>
                        <option value="event_danus">Event Danus Khusus</option>
                        <option value="konsumsi_kegiatan">Konsumsi Kegiatan</option>
                        <option value="penyewaan">Penyewaan</option>
                        <option value="usaha_tetap">Usaha Tetap/Kantin</option>
                    </select>
                    @error('category') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Penanggung Jawab Utama --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Penanggung Jawab Utama (Dari Divisi Internal) <span class="text-red-500">*</span></label>
                    <select wire:model="pic_id" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 bg-white">
                        <option value="">-- Pilih Penanggung Jawab --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->jabatan ?? ucwords($u->role) }})</option>
                        @endforeach
                    </select>
                    @error('pic_id') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="start_date" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 text-gray-600">
                    @error('start_date') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="end_date" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 text-gray-600">
                    @error('end_date') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                                {{-- Tujuan & Sasaran --}}
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tujuan Program Kerja <span class="text-red-500">*</span></label>
                        <textarea wire:model="tujuan" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Meningkatkan kualitas akademik mahasiswa..."></textarea>
                        @error('tujuan') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Sasaran Program Kerja <span class="text-red-500">*</span></label>
                        <textarea wire:model="sasaran" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Seluruh Mahasiswa Sistem Informasi..."></textarea>
                        @error('sasaran') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Modal & Pendapatan --}}
                <div class="md:col-span-2">
                    
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea wire:model="description" rows="4" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Jelaskan secara singkat mengenai program kerja ini (opsional)..."></textarea>
                    @error('description') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end mt-10 gap-4 border-t border-gray-100 pt-6">
                <a href="{{ route('projects.index') }}" wire:navigate class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors px-4 py-2">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center bg-blue-600 text-white text-sm font-bold rounded-xl px-8 py-3 hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                    Simpan Program Kerja
                </button>
            </div>
        </form>
    </div>
</div>
