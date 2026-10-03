<div class="w-full">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Kelola Bidang</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Divisi Dana dan Usaha</p>
        </div>
        <div class="flex items-center justify-end gap-3 w-full sm:w-auto">
            <a href="{{ route('members.index') }}" wire:navigate class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <button wire:click="openAddForm" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Bidang
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl font-medium text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl font-medium text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div x-data="{ activeTab: {{ $bidangs->first()->id ?? 'null' }} }" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Left: Tab List --}}
        <div class="lg:col-span-1 space-y-3">
            @forelse($bidangs as $bidang)
            <div @click="activeTab = {{ $bidang->id }}" 
                 class="cursor-pointer p-4 rounded-xl border transition-all"
                 :class="activeTab === {{ $bidang->id }} ? 'bg-blue-600 border-blue-600 shadow-md text-white' : 'bg-white border-gray-200 hover:border-blue-300'">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold" :class="activeTab === {{ $bidang->id }} ? 'text-white' : 'text-gray-900'">{{ $bidang->name }}</h3>
                        <p class="text-xs mt-1" :class="activeTab === {{ $bidang->id }} ? 'text-blue-100' : 'text-gray-500 font-medium'">{{ $bidang->members->count() }} Anggota</p>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 ml-1" :class="activeTab === {{ $bidang->id }} ? 'text-blue-200' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-4 rounded-xl border border-dashed border-gray-200 text-center text-sm text-gray-400 font-medium">
                Belum ada bidang.
            </div>
            @endforelse
        </div>

        {{-- Right: Members Table --}}
        <div class="lg:col-span-3">
            @forelse($bidangs as $bidang)
            <div x-cloak x-show="activeTab === {{ $bidang->id }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="font-bold text-gray-900">Pengurus Bidang {{ $bidang->name }}</h2>
                    </div>
                    <div class="flex items-center gap-1">
                        <button wire:click="editBidang({{ $bidang->id }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Bidang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $bidang->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Bidang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-[10px] uppercase tracking-wider text-gray-400 font-bold">
                                <th class="px-6 py-4">Nama Pengurus</th>
                                <th class="px-6 py-4">NIM</th>
                                <th class="px-6 py-4">Angkatan</th>
                                <th class="px-6 py-4">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bidang->members as $member)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">{{ $member->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $member->nim }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium">{{ $member->angkatan }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md uppercase tracking-wider">{{ $member->jabatan }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400 font-medium">
                                    Belum ada anggota yang ditugaskan ke bidang ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
                <p>Belum ada data bidang dan pengurus.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if($confirmingDeletion)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cancelDelete"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex flex-col items-center">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="text-center w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                Hapus Bidang {{ $bidangToDeleteName }}?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus bidang ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                                @if($memberCountToDelete > 0)
                                <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-xl text-left">
                                    <p class="text-sm font-bold text-red-700 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Peringatan!
                                    </p>
                                    <p class="text-xs text-red-600 mt-1">
                                        Terdapat <strong>{{ $memberCountToDelete }} anggota</strong> di dalam bidang ini. Jika Anda menghapus bidang ini, seluruh data user/anggota yang bersangkutan <strong>juga akan terhapus secara permanen</strong> dari sistem!
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="button" wire:click="delete" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                        Ya, Hapus Sekarang
                    </button>
                    <button type="button" wire:click="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Add Bidang Modal --}}
    @if($showAddForm)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeAddForm"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form wire:submit="save">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <h3 class="text-xl leading-6 font-black text-gray-900" id="modal-title">Tambah Bidang Baru</h3>
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Bidang <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="name" id="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Bidang Internal">
                            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-2xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-colors">
                            Simpan Bidang
                        </button>
                        <button type="button" wire:click="closeAddForm" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:w-auto transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Edit Bidang Modal --}}
    @if($showEditForm)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeEditForm"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <form wire:submit="update">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <h3 class="text-xl leading-6 font-black text-gray-900" id="modal-title">Edit Nama Bidang</h3>
                        </div>
                        <div>
                            <label for="editName" class="block text-sm font-bold text-gray-700 mb-2">Nama Bidang Baru <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="editName" id="editName" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Bidang Internal">
                            @error('editName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-2xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-colors">
                            Simpan Perubahan
                        </button>
                        <button type="button" wire:click="closeEditForm" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:w-auto transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
