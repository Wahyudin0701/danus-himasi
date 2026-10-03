<div class="w-full">

    @if(auth()->user()->role === 'admin')
        {{-- ADMINISTRATOR DASHBOARD --}}
        <div class="mb-8">
            <p class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-2">SISTEM ADMINISTRATOR</p>
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
            <p class="text-xs font-bold text-green-500 uppercase tracking-widest mb-2">DANA DAN USAHA</p>
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Card 1 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-4xl font-black text-gray-900 mb-1 mt-2">{{ $totalAnggota }}</p>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Anggota</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-4xl font-black text-gray-900 mb-1 mt-2">{{ $totalProker }}</p>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Proker</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 3 (Total Anggaran) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-4xl font-black text-gray-900 mb-1 mt-2">Rp0</p>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Anggaran</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Grid: Program Kerja + Anggota --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- Program Kerja (3/5) --}}
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h2 class="font-bold text-gray-900">Program Kerja</h2>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Daftar proker divisi Anda</p>
                    </div>
                    <a href="{{ route('projects.index') }}" wire:navigate class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                    </a>
                </div>

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
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h2 class="font-bold text-gray-900">Anggota Divisi</h2>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Daftar anggota di DANUS</p>
                    </div>
                </div>

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
