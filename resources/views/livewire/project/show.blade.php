<div class="w-full">
    @php
        $start = $project->start_date ? \Carbon\Carbon::parse($project->start_date)->startOfDay() : null;
        $end = $project->end_date ? \Carbon\Carbon::parse($project->end_date)->endOfDay() : null;
        $now = now();
        $progress = 0;
        $statusText = 'Belum Dimulai';
        $statusColor = 'text-gray-500';

        if ($start && $end) {
            if ($now->lt($start)) {
                $statusText = 'Belum Dimulai ( ' . (int)$now->diffInDays($start) . ' hari lagi )';
                $statusColor = 'text-blue-500';
            } elseif ($now->between($start, $end)) {
                $total = $start->diffInDays($end) ?: 1;
                $passed = $start->diffInDays($now);
                $progress = min(100, round(($passed / $total) * 100));
                $statusText = 'Sedang Berjalan ( Sisa ' . (int)$now->diffInDays($end) . ' hari )';
                $statusColor = 'text-green-500';
            } else {
                $progress = 100;
                $statusText = 'Selesai';
                $statusColor = 'text-indigo-500';
            }
        }
        
        $isPj = $project->members->where('user_id', auth()->id())->where('is_pic', true)->isNotEmpty();
        
        // Setup Header Colors
        $barColor = 'bg-gray-400';
        $badgeClass = 'bg-gray-100 text-gray-600';
        $statusLabel = 'DRAFT';
        
        if ($project->status === 'draft') {
            $barColor = 'bg-blue-500';
            $badgeClass = 'bg-blue-50 text-blue-700 border-blue-100';
            $statusLabel = 'PLANNING';
        } elseif ($project->status === 'active') {
            $barColor = 'bg-green-500';
            $badgeClass = 'bg-green-50 text-green-700 border-green-100';
            $statusLabel = 'AKTIF';
        } elseif ($project->status === 'completed') {
            $barColor = 'bg-indigo-500';
            $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-100';
            $statusLabel = 'SELESAI';
        }
    @endphp

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center text-[13px] text-gray-500 font-medium mb-2.5">
                <a href="{{ route('projects.index') }}" wire:navigate class="hover:text-blue-600 transition-colors">Program Kerja</a>
                <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900">{{ $project->name }}</span>
            </nav>
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Detail Program Kerja</h1>
        </div>
        <div class="flex items-center justify-end gap-3 w-full md:w-auto">
            <a href="{{ route('projects.index') }}" wire:navigate class="md:flex-none justify-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            @if(in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv']))
            <a href="{{ route('projects.edit', $project->id) }}" wire:navigate class="flex-1 md:flex-none justify-center px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Proker
            </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Main Info & RAB --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Hero Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <!-- Color Accent Top Bar -->
                <div class="h-2 w-full {{ $barColor }}"></div>
                
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">{{ $project->name }}</h2>
                            <span class="inline-block mt-3 text-[11px] font-bold px-3 py-1 bg-gray-100 text-gray-600 rounded-lg uppercase tracking-wider">
                                {{ str_replace('_', ' ', ucwords($project->category, '_')) }}
                            </span>
                        </div>
                        <span class="inline-flex items-center justify-center text-[11px] font-bold px-3 py-1.5 rounded-lg border uppercase tracking-wider {{ $badgeClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="prose max-w-none">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tujuan Program Kerja</h3>
                            <p class="text-sm leading-relaxed text-gray-700 bg-gray-50/50 p-4 rounded-2xl border border-gray-50 h-full">
                                {{ $project->tujuan ?: '-' }}
                            </p>
                        </div>
                        <div class="prose max-w-none">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Sasaran Program Kerja</h3>
                            <p class="text-sm leading-relaxed text-gray-700 bg-gray-50/50 p-4 rounded-2xl border border-gray-50 h-full">
                                {{ $project->sasaran ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Proker</h3>
                        <p class="text-sm leading-relaxed text-gray-700 bg-gray-50/50 p-4 rounded-2xl border border-gray-50">
                            {{ $project->description ?: 'Belum ada deskripsi yang ditambahkan untuk program kerja ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            @php
    $canEditProject = $isPj || in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv']);
@endphp
              {{-- Keuangan Proker --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-green-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                <div class="flex items-center justify-between mb-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center transform rotate-3 shadow-sm border border-green-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">Keuangan Proker</h3>
                            <p class="text-xs font-medium text-gray-500 mt-1">Rekapitulasi modal, pendapatan, dan keuntungan</p>
                        </div>
                    </div>

                </div>
                @php
                    $modal      = $project->modal ?? 0;
                    $pendapatan = $project->pendapatan ?? 0;
                    $keuntungan = $pendapatan - $modal;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 relative z-10">
                    <div class="bg-blue-50/60 rounded-2xl p-5 border border-blue-100/60 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Modal</p>
                                @if($canEditProject)
                                <a href="{{ route('projects.finance', ['project' => $project->id, 'type' => 'modal']) }}" wire:navigate class="text-[10px] font-bold text-blue-600 bg-white px-2 py-1 rounded-lg border border-blue-100 hover:bg-blue-50 transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Update
                                </a>
                                @else
                                <a href="{{ route('projects.finance', ['project' => $project->id, 'type' => 'modal']) }}" wire:navigate class="text-[10px] font-bold text-gray-500 bg-white px-2 py-1 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                                @endif
                            </div>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($modal, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Dana yang dikeluarkan</p>
                        </div>
                    </div>
                    <div class="bg-orange-50/60 rounded-2xl p-5 border border-orange-100/60 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-[11px] font-bold text-orange-600 uppercase tracking-wider">Pendapatan</p>
                                @if($canEditProject)
                                <a href="{{ route('projects.finance', ['project' => $project->id, 'type' => 'pendapatan']) }}" wire:navigate class="text-[10px] font-bold text-orange-600 bg-white px-2 py-1 rounded-lg border border-orange-100 hover:bg-orange-50 transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Update
                                </a>
                                @else
                                <a href="{{ route('projects.finance', ['project' => $project->id, 'type' => 'pendapatan']) }}" wire:navigate class="text-[10px] font-bold text-gray-500 bg-white px-2 py-1 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                                @endif
                            </div>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Total pemasukan</p>
                        </div>
                    </div>
                    <div class="{{ $keuntungan >= 0 ? 'bg-green-50/60 border-green-100/60' : 'bg-red-50/60 border-red-100/60' }} rounded-2xl p-5 border">
                        <p class="text-[11px] font-bold {{ $keuntungan >= 0 ? 'text-green-600' : 'text-red-600' }} uppercase tracking-wider mb-2">Keuntungan</p>
                        <p class="text-2xl font-black {{ $keuntungan >= 0 ? 'text-green-700' : 'text-red-600' }}">
                            {{ $keuntungan >= 0 ? '' : '-' }}Rp {{ number_format(abs($keuntungan), 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $keuntungan >= 0 ? 'Pendapatan - Modal' : 'Merugi' }}</p>
                    </div>
                </div>
            </div>

            {{-- Catatan Evaluasi --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8" x-data="{ saved: false }" @evaluasi-saved.window="saved = true; setTimeout(() => saved = false, 2500)">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center transform rotate-3 shadow-sm border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900">Catatan Evaluasi</h3>
                        <p class="text-xs font-medium text-gray-500 mt-1">Refleksi dan evaluasi pelaksanaan program kerja</p>
                    </div>
                </div>

                @if($canEditProject)
                <form wire:submit="saveEvaluasi">
                    <textarea wire:model="catatan_evaluasi" rows="5" placeholder="Tuliskan evaluasi pelaksanaan proker di sini: apa yang berjalan dengan baik, kendala yang dihadapi, saran untuk ke depannya..." class="w-full rounded-2xl border-gray-200 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 transition-colors text-sm text-gray-700 resize-none"></textarea>
                    <div class="flex items-center justify-between mt-4">
                        <span x-show="saved" x-transition class="text-xs font-bold text-green-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Catatan berhasil disimpan!
                        </span>
                        <span x-show="!saved"></span>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 text-white text-sm font-bold rounded-xl hover:bg-purple-700 transition-colors shadow-sm shadow-purple-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Simpan Catatan
                        </button>
                    </div>
                </form>
                @else
                <div class="w-full rounded-2xl bg-gray-50 border border-gray-100 p-4 min-h-[100px] text-sm text-gray-700">
                    @if($project->catatan_evaluasi)
                        <p class="whitespace-pre-line leading-relaxed">{{ $project->catatan_evaluasi }}</p>
                    @else
                        <p class="text-gray-400 italic">Belum ada catatan evaluasi yang ditambahkan.</p>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Integrated Info --}}

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Pelaksanaan</h3>
                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Mulai</p>
                            <p class="text-sm font-bold text-gray-900">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Selesai</p>
                            <p class="text-sm font-bold text-gray-900">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 mb-6">

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Tim Internal</h3>
                @php
                    $pj = $project->members->where('is_pic', true)->first();
                @endphp
                @if($pj)
                <div class="flex items-center gap-4 p-3 bg-blue-50/50 rounded-2xl border border-blue-50/80">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shadow-sm">
                        {{ substr($pj->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $pj->user->name }}</p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mt-0.5">Penanggung Jawab (PJ)</p>
                    </div>
                </div>
                @else
                <div class="text-center py-4 bg-gray-50 rounded-2xl border border-gray-100 text-sm text-gray-500 font-medium">
                    Belum ada PJ yang ditunjuk.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>