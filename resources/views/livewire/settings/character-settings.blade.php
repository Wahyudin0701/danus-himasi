<div class="w-full" x-data="{ deletingId: null }">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Karakter Tampilan Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Ubah foto karakter yang akan ditampilkan di Halaman Utama dan Halaman Login.</p>
        </div>
        <button wire:click="triggerAdd" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200 w-full md:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Karakter
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-bold text-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif

    @if($isAdding)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 w-full max-w-lg overflow-hidden relative">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-900">Tambah Karakter Baru</h3>
                    <button wire:click="cancelAdd" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama Karakter</label>
                        <input type="text" wire:model="addName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: Jaket Biru (Cowok)">
                        @error('addName') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Foto Karakter (PNG/JPG)</label>
                        <input type="file" wire:model="addPhoto" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors border border-gray-200 rounded-xl p-1.5 bg-gray-50 cursor-pointer">
                        @error('addPhoto') <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 flex items-center justify-end gap-3 bg-gray-50/50">
                    <button wire:click="cancelAdd" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-bold rounded-xl transition-colors shadow-sm">Batal</button>
                    <button wire:click="saveNewCharacter" wire:loading.attr="disabled" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm shadow-blue-200 disabled:opacity-50 flex items-center justify-center gap-2 min-w-[140px]">
                        <span wire:loading.remove wire:target="saveNewCharacter, addPhoto">Simpan Karakter</span>
                        <span wire:loading wire:target="saveNewCharacter">Menyimpan...</span>
                        <span wire:loading wire:target="addPhoto">Mengunggah...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($characters as $char)
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 flex flex-col items-center text-center relative overflow-hidden group">
                
                {{-- Delete Button --}}
                <button @click="deletingId = {{ $char['id'] }}" class="absolute top-2 right-2 p-1.5 bg-white/80 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-lg transition-colors z-10 backdrop-blur-sm shadow-sm border border-gray-100 opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>

                <div class="w-full flex justify-center mb-4 min-h-[120px] items-end">
                    <img src="{{ asset('Foto_Karikatur_Kepala_Besar/' . $char['filename']) }}"
                         alt="{{ $char['display_name'] }}"
                         class="h-28 object-contain drop-shadow-xl group-hover:scale-105 transition-transform duration-300">
                </div>
                
                <h3 class="text-sm font-black text-gray-900">{{ $char['display_name'] }}</h3>
                
                <div class="mt-4 w-full">
                    @if($editingId === $char['id'])
                        <div class="w-full text-left space-y-3">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Karakter</label>
                                <input type="text" wire:model="editName" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-xs font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('editName') <span class="text-[10px] text-red-500 font-bold block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Ganti Foto (Opsional)</label>
                                <input type="file" wire:model="newPhoto" accept="image/*" class="block w-full text-xs text-slate-500
                                    file:mr-3 file:py-1.5 file:px-3
                                    file:rounded-full file:border-0
                                    file:text-[10px] file:font-bold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 transition-colors
                                ">
                                @error('newPhoto') <span class="text-[10px] text-red-500 font-bold block mt-0.5">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex items-center gap-2 pt-1">
                                <button wire:click="updateCharacter" wire:loading.attr="disabled" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm shadow-blue-200 flex justify-center items-center gap-1 disabled:opacity-50">
                                    <span wire:loading.remove wire:target="updateCharacter, newPhoto">Simpan</span>
                                    <span wire:loading wire:target="updateCharacter">Menyimpan...</span>
                                    <span wire:loading wire:target="newPhoto">Mengunggah...</span>
                                </button>
                                <button wire:click="cancelEdit" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors">
                                    Batal
                                </button>
                            </div>
                        </div>
                    @else
                        <button wire:click="triggerEdit({{ $char['id'] }})" class="w-full py-2 bg-gray-50 hover:bg-blue-50 text-gray-600 hover:text-blue-600 border border-gray-200 hover:border-blue-200 text-xs font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Edit Karakter
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="deletingId !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm transition-opacity"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div @click.away="deletingId = null" class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-sm overflow-hidden text-center p-8 relative transform transition-all"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-5">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Data?</h3>
            <p class="text-sm font-medium text-gray-500 leading-relaxed mb-8">
                Data yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?
            </p>

            <div class="flex items-center justify-center gap-3">
                <button @click="deletingId = null" class="flex-1 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm font-bold rounded-2xl transition-colors">Batal</button>
                <button @click="$wire.deleteCharacter(deletingId).then(() => { deletingId = null })" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-2xl transition-colors shadow-sm shadow-red-200 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="deleteCharacter">Ya, Hapus</span>
                    <span wire:loading wire:target="deleteCharacter">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
</div>
