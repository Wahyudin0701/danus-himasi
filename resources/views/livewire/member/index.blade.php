@php
    $pimpinans = $members->filter(fn($m) => in_array($m->role, ['kadiv', 'wakadiv']))->sortBy('role');
    $penguruses = $members->filter(fn($m) => !in_array($m->role, ['kadiv', 'wakadiv']));
@endphp
<div class="max-w-[1400px] mx-auto" x-data="{ showModal: false, m: null, showDeleteModal: false, deleteId: null }">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl md:text-2xl font-black text-gray-900">Dana dan Usaha</h1>
            <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Struktur kepengurusan dan anggota divisi.</p>
        </div>

        <div class="flex items-center self-start sm:self-auto">
            <span class="px-3 py-1.5 md:px-4 md:py-2 bg-gray-100/80 text-gray-600 font-bold text-xs rounded-xl flex items-center gap-2 border border-gray-200/60">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                {{ $members->count() }} Anggota Total
            </span>
        </div>
    </div>

    {{-- Cards Pimpinan --}}
    @if($pimpinans->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @foreach($pimpinans as $pimpinan)
        <div @click="m = JSON.parse($el.dataset.member); showModal = true" data-member="{{ json_encode($pimpinan) }}" class="cursor-pointer bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-start gap-4 relative hover:border-gray-200 transition-colors">
            <!-- Avatar -->
            <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold flex-shrink-0">
                {{ substr($pimpinan->name, 0, 1) }}
            </div>

            <div class="flex-1 pt-1">
                <h3 class="font-bold text-gray-900 text-[17px] leading-tight">{{ $pimpinan->name }}</h3>
                <p class="text-[12px] text-gray-500 mb-3 font-medium mt-1">NIM {{ $pimpinan->nim }} ({{ $pimpinan->angkatan }})</p>

                <div class="flex flex-wrap gap-2">
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-md text-indigo-700 bg-indigo-50 border border-indigo-100">
                        {{ $pimpinan->jabatan ?? ($pimpinan->role === 'kadiv' ? 'Ketua Divisi Dana Usaha' : 'Wakil Ketua Divisi Dana Usaha') }}
                    </span>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <div @click.stop class="absolute top-5 right-5">
                <a href="{{ route('members.edit', $pimpinan->id) }}" wire:navigate class="px-3 py-1.5 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg text-[11px] font-bold transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Actions for Table --}}
    @if(auth()->user()->role === 'admin')
    <div class="flex justify-end mb-6 gap-3">
        <a href="{{ route('bidang.index') }}" wire:navigate
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            Kelola Bidang
        </a>
        <a href="{{ route('members.create') }}" wire:navigate
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Anggota
        </a>
    </div>
    @endif

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-1/3">Nama Pengurus</th>
                        <th scope="col" class="px-6 py-4 text-center">NIM</th>
                        <th scope="col" class="px-6 py-4 text-center">Angkatan</th>
                        <th scope="col" class="px-6 py-4 text-center">Peran / Jabatan</th>
                        @if(auth()->user()->role === 'admin')
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($penguruses as $member)
                    <tr @click="m = JSON.parse($el.dataset.member); showModal = true" data-member="{{ json_encode($member) }}" class="hover:bg-gray-50/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-100 group-hover:scale-105 transition-transform">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $member->name }}</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $member->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-medium">{{ $member->nim ?? '-' }}</td>
                        <td class="px-6 py-5 text-center font-medium">{{ $member->angkatan ?? '-' }}</td>
                        <td class="px-6 py-5 text-center">
                            @if($member->jabatan)
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $member->jabatan }}
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider
                                    {{ $member->role === 'admin' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                                    {{ $member->role === 'kadiv' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}
                                    {{ $member->role === 'wakadiv' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : '' }}
                                    {{ $member->role === 'sekretaris' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                    {{ $member->role === 'bendahara' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                                    {{ $member->role === 'anggota' ? 'bg-gray-50 text-gray-700 border border-gray-200' : '' }}">
                                    {{ $member->role }}
                                </span>
                            @endif
                        </td>

                        @if(auth()->user()->role === 'admin')
                        <td @click.stop class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('members.edit', $member->id) }}" wire:navigate class="px-3 py-1.5 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-blue-600 rounded-lg text-[11px] font-bold transition-colors flex items-center gap-1 shadow-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit
                                </a>
                                @if($member->id !== auth()->id())
                                <button @click="deleteId = {{ $member->id }}; showDeleteModal = true" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-[11px] font-bold transition-colors flex items-center gap-1 shadow-sm border border-red-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">
                            Belum ada pengurus lain yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detail Anggota --}}
    <div x-cloak x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 backdrop-blur-sm p-4">
        <div @click.outside="showModal = false"
             class="bg-white rounded-3xl shadow-2xl w-full max-w-sm relative overflow-hidden transform transition-all"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <!-- Blue Banner -->
            <div class="h-28 bg-indigo-600 relative">
                <button @click="showModal = false" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/20 text-white hover:bg-white/30 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Avatar Overlapping -->
            <div class="flex justify-center -mt-14 relative z-10">
                <div class="w-28 h-28 rounded-full border-4 border-white bg-white text-indigo-600 flex items-center justify-center text-4xl font-bold shadow-sm">
                    <span x-text="m ? m.name.charAt(0) : ''"></span>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="text-center mt-3 mb-6 px-6">
                <h2 class="text-xl font-black text-gray-900" x-text="m ? m.name : ''"></h2>
                <p class="text-indigo-600 font-bold text-xs mt-1 uppercase tracking-wider" x-text="m ? (m.jabatan ? m.jabatan : m.role) : ''"></p>
            </div>

            <!-- Details Box -->
            <div class="px-6 pb-8">
                <div class="bg-gray-50/80 rounded-2xl p-4 space-y-4 border border-gray-100/50">
                    <!-- NIM -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm border border-gray-100">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">NIM</p>
                            <p class="font-bold text-gray-900 text-sm leading-none" x-text="m ? m.nim : ''"></p>
                        </div>
                    </div>
                    <!-- ANGKATAN -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm border border-gray-100">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Angkatan</p>
                            <p class="font-bold text-gray-900 text-sm leading-none" x-text="m ? (m.angkatan ? m.angkatan : '-') : ''"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Anggota?</h3>
            <p class="text-sm text-gray-500 font-medium mb-6">Data yang dihapus tidak dapat dikembalikan. Yakin ingin melanjutkan?</p>

            <div class="flex gap-3">
                <button @click="showDeleteModal = false" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition-colors">Batal</button>
                <button @click="$wire.delete(deleteId); showDeleteModal = false" class="flex-1 py-3 bg-red-600 text-white rounded-xl text-sm font-bold shadow-md shadow-red-200 hover:bg-red-700 transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>