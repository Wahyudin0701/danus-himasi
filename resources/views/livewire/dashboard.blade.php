<div class="w-full">

    @if(auth()->user()->role === 'admin')
        {{-- ADMINISTRATOR DASHBOARD --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <p class="text-xs font-bold text-blue-500 uppercase tracking-widest">SISTEM ADMINISTRATOR</p>
                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">PERIODE {{ \App\Models\Periode::active()?->name ?? '-' }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-[28px] font-black text-gray-900 leading-tight">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Berikut ringkasan operasional sistem secara keseluruhan.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center text-gray-500 h-64 flex flex-col items-center justify-center">
            <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="font-bold">Log Aktivitas Sistem</p>
            <p class="text-sm mt-1">Sistem pencatatan log aktivitas belum diimplementasikan.</p>
        </div>

    @else
        {{-- KADIV, WAKADIV & ANGGOTA DASHBOARD --}}
        {{-- Greeting Banner --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <p class="text-xs font-bold text-green-500 uppercase tracking-widest">DANA DAN USAHA</p>
                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">PERIODE {{ \App\Models\Periode::active()?->name ?? '-' }}</p>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-[28px] font-black text-gray-900 leading-tight">
                        Selamat datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Berikut ringkasan divisi dan program kerja Anda.</p>
                </div>
                
            </div>
        </div>

        {{-- Stats Cards --}}
        <div x-data="{ showFinanceModal: false }" class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card Anggota --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2">{{ $totalAnggota }}</p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Anggota</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Card Proker --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2">{{ $totalProker }}</p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Proker</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Card Keuntungan (Clickable) --}}
                <div @click="showFinanceModal = true" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md hover:border-emerald-200 transition-all duration-200 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-2xl font-black {{ $totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600' }} mb-1 mt-2">
                                {{ $totalKeuntungan < 0 ? '-' : '' }}Rp{{ number_format(abs($totalKeuntungan), 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Keuntungan</p>
                            <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Klik untuk rincian
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl {{ $totalKeuntungan >= 0 ? 'bg-emerald-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0">
                            @if($totalKeuntungan >= 0)
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
                            @else
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" /></svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Finance Detail Floating Modal --}}
            <div x-cloak x-show="showFinanceModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-show="showFinanceModal" x-transition.opacity @click="showFinanceModal = false"></div>
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm relative z-10 overflow-hidden"
                     x-show="showFinanceModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                    {{-- Header --}}
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 pb-8">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest">Rincian Keuangan Divisi</p>
                            <button @click="showFinanceModal = false" class="w-7 h-7 rounded-full bg-white/20 text-white hover:bg-white/30 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p class="text-4xl font-black text-white">{{ $totalKeuntungan < 0 ? '-' : '' }}Rp{{ number_format(abs($totalKeuntungan), 0, ',', '.') }}</p>
                        <p class="text-sm font-bold text-emerald-100 mt-1">Total Keuntungan Divisi</p>
                    </div>
                    {{-- Breakdown --}}
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-2xl border border-orange-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Modal</p>
                                    <p class="text-sm font-black text-gray-900">Rp{{ number_format($totalModal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-orange-600 bg-orange-100 px-2.5 py-1 rounded-lg">Keluar</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-2xl border border-green-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                                    <p class="text-sm font-black text-gray-900">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-lg">Masuk</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <p class="text-sm font-bold text-gray-600">Keuntungan Bersih</p>
                            <p class="text-lg font-black {{ $totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $totalKeuntungan < 0 ? '-' : '+' }}Rp{{ number_format(abs($totalKeuntungan), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid: Program Kerja + Anggota --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- Program Kerja (3/5) --}}
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <a href="{{ route('projects.index') }}" wire:navigate class="block px-6 py-5 border-b border-gray-100 hover:bg-gray-50 transition-colors rounded-t-2xl group cursor-pointer">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Program Kerja</h2>
                            <p class="text-[11px] font-medium text-gray-400 mt-0.5">Daftar proker divisi Anda</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @forelse($recentProjects as $project)
                        <div class="flex items-start gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors border border-transparent hover:border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $project->name }}</p>
                                <p class="text-xs font-medium text-gray-400 truncate mt-1">{{ $project->description ?? str_replace('_', ' ', ucwords($project->category, '_')) }}</p>
                            </div>
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full flex-shrink-0 uppercase tracking-wider bg-gray-100 text-gray-600">
                                {{ $project->status === 'draft' ? 'PLANNING' : $project->status }}
                            </span>
                        </div>
                        @empty
                        <div class="py-8 text-center text-gray-400 text-sm font-medium">
                            Belum ada proker yang ditambahkan.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Anggota Divisi (2/5) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 h-fit">
                <a href="{{ route('members.index') }}" wire:navigate class="block px-6 py-5 border-b border-gray-100 hover:bg-gray-50 transition-colors rounded-t-2xl group cursor-pointer">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Tim Divisi</h2>
                            <p class="text-[11px] font-medium text-gray-400 mt-0.5">Daftar anggota di DANUS</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <div class="px-6 py-4">
                    <div class="space-y-2">
                        @foreach($anggota as $member)
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-sm font-bold text-blue-700 flex-shrink-0">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $member->name }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5">{{ $member->jabatan ?? $member->role }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>