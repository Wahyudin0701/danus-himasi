<div x-data="{ showDeleteModal: false, deleteId: null }" class="w-full">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Kas <span class="text-blue-600">DANUS</span></h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Kelola arus kas (pemasukan & pengeluaran) divisi Anda.</p>
        </div>
        @if($canEdit)
        <button wire:click="createRecord" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Transaksi
        </button>
        @endif
    </div>

    {{-- Cards Dashboard --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Pemasukan --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full blur-2xl opacity-60"></div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center border border-green-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pemasukan</p>
                    <p class="text-2xl font-black text-gray-900 mt-0.5">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 rounded-full blur-2xl opacity-60"></div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center border border-red-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengeluaran</p>
                    <p class="text-2xl font-black text-gray-900 mt-0.5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Saldo --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full blur-2xl opacity-60"></div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center border border-green-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Kas Saat Ini</p>
                    <p class="text-3xl font-black text-gray-900 mt-0.5">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Tanggal</th>
                        <th scope="col" class="px-6 py-4">Keterangan</th>
                        <th scope="col" class="px-6 py-4 text-center">Jenis</th>
                        <th scope="col" class="px-6 py-4 text-right">Nominal</th>
                        <th scope="col" class="px-6 py-4 text-center">Ditambahkan Oleh</th>
                        @if($canEdit)
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($records as $record)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 font-medium">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900 whitespace-normal">{{ $record->description }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($record->type === 'pemasukan')
                                <span class="text-[10px] font-bold px-3 py-1 rounded-lg bg-green-50 text-green-600 uppercase tracking-wider">Pemasukan</span>
                            @else
                                <span class="text-[10px] font-bold px-3 py-1 rounded-lg bg-red-50 text-red-600 uppercase tracking-wider">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-black {{ $record->type === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $record->type === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($record->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center text-xs font-medium text-gray-500">{{ $record->creator->name ?? '-' }}</td>
                        @if($canEdit)
                        <td class="px-6 py-4 text-center">
                            <button wire:click="editRecord({{ $record->id }})" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-700 transition-colors mr-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="deleteId = {{ $record->id }}; showDeleteModal = true" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $canEdit ? 6 : 5 }}" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-gray-500 font-medium text-sm">Belum ada riwayat transaksi kas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $records->links() }}
        </div>
        @endif
    </div>

    {{-- Modal Tambah --}}
    @if($showModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
        <div class="bg-white rounded-3xl w-full max-w-md relative z-10 shadow-2xl overflow-hidden"
             x-data
             x-init="gsap.from($el, {y: 50, opacity: 0, duration: 0.3, ease: 'back.out(1.5)'})">
             
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900">{{ $editId ? 'Edit Transaksi' : 'Catat Transaksi' }}</h3>
                <button wire:click="$set('showModal', false)" class="w-8 h-8 flex items-center justify-center rounded-xl bg-gray-50 text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form wire:submit="saveRecord" class="p-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal</label>
                    <input type="date" wire:model="date" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 text-sm font-medium">
                    @error('date') <span class="text-xs text-red-500 font-medium mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative">
                            <input type="radio" wire:model="type" value="pemasukan" class="peer sr-only">
                            <div class="p-3 text-center rounded-xl border border-gray-200 cursor-pointer transition-all peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 text-gray-500 hover:bg-gray-50">
                                <span class="text-sm font-bold block">Pemasukan</span>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" wire:model="type" value="pengeluaran" class="peer sr-only">
                            <div class="p-3 text-center rounded-xl border border-gray-200 cursor-pointer transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 text-gray-500 hover:bg-gray-50">
                                <span class="text-sm font-bold block">Pengeluaran</span>
                            </div>
                        </label>
                    </div>
                    @error('type') <span class="text-xs text-red-500 font-medium mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nominal (Rp)</label>
                    <input type="number" wire:model="amount" placeholder="Contoh: 500000" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 text-sm font-bold">
                    @error('amount') <span class="text-xs text-red-500 font-medium mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Keterangan</label>
                    <textarea wire:model="description" rows="3" placeholder="Contoh: Uang kas bulan November" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 text-sm resize-none"></textarea>
                    @error('description') <span class="text-xs text-red-500 font-medium mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-200 hover:bg-blue-700 transition-colors">
                        {{ $editId ? 'Simpan Perubahan' : 'Simpan Transaksi' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Modal Konfirmasi Hapus --}}
    <div x-cloak x-show="showDeleteModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" x-show="showDeleteModal" x-transition.opacity @click="showDeleteModal = false"></div>
        <div class="bg-white rounded-3xl w-full max-w-sm relative z-10 shadow-2xl overflow-hidden p-6 text-center"
             x-show="showDeleteModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-90">
             
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Data?</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Data yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?</p>
            
            <div class="flex gap-3">
                <button @click="showDeleteModal = false" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button @click="$wire.deleteRecord(deleteId); showDeleteModal = false" class="flex-1 py-3 bg-red-600 text-white rounded-xl text-sm font-bold shadow-md shadow-red-200 hover:bg-red-700 transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>