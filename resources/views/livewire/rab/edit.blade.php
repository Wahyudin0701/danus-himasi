<div class="w-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Edit RAB</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Rencana Anggaran Biaya untuk: <span class="font-bold text-gray-700">{{ $project->name }}</span></p>
        </div>
        <div class="flex items-center justify-end gap-3 w-full md:w-auto">
            <a href="{{ route('projects.show', $project->id) }}" wire:navigate
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Batal
            </a>
            <button wire:click="save"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>

    {{-- Form List Items --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-6 md:p-8">
        <div class="space-y-6">
            @foreach($items as $index => $item)
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-end border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Kebutuhan <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="items.{{ $index }}.description"
                           placeholder="Contoh: Cetak Banner 3x4m"
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 bg-white">
                    @error('items.'.$index.'.description') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="w-full md:w-24">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="items.{{ $index }}.quantity"
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 bg-white">
                    @error('items.'.$index.'.quantity') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="w-full md:w-32">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="items.{{ $index }}.unit"
                           placeholder="Pcs, Kotak..."
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 bg-white">
                    @error('items.'.$index.'.unit') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" wire:model="items.{{ $index }}.unit_price"
                           class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-2.5 bg-white">
                    @error('items.'.$index.'.unit_price') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="w-full md:w-auto">
                    @if(count($items) > 1)
                    <button wire:click="removeItem({{ $index }})"
                            class="w-full md:w-auto px-4 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors border border-red-100 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span class="md:hidden">Hapus</span>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach

            <div class="pt-4">
                <button wire:click="addItem"
                        class="px-5 py-2.5 bg-gray-50 text-gray-600 text-sm font-bold rounded-xl border border-gray-200 hover:bg-gray-100 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Baris Kebutuhan
                </button>
            </div>
        </div>
    </div>
</div>
