<div class="w-full">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role === 'admin'): ?>
        
        <div class="mb-8 flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-2">SISTEM ADMINISTRATOR</p>
                <h1 class="text-[28px] font-black text-gray-900 leading-tight">
                    Selamat datang, <?php echo e(auth()->user()->name); ?>

                </h1>
                <p class="text-sm font-medium text-gray-500 mt-1">Berikut ringkasan operasional sistem secara keseluruhan.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm flex-shrink-0">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Periode Kepengurusan</p>
                    <p class="text-sm font-black text-gray-900 leading-none mt-1"><?php echo e(\App\Models\Periode::active()?->name ?? 'Belum Ada'); ?></p>
                </div>
            </div>
        </div>

        
        <div x-data="{ showFinanceModal: false }" class="mb-8">
            
            <div class="flex md:hidden items-start justify-between gap-3 mt-4 mb-2">
                
                <div class="flex flex-col items-center gap-2 flex-1">
                    <div class="w-full max-w-[76px] h-[76px] rounded-[1.25rem] bg-blue-50 text-blue-600 border border-blue-100 flex flex-col items-center justify-center shadow-sm">
                        <span class="text-3xl font-black"><?php echo e($totalAnggota); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight">Total<br>Anggota</p>
                </div>

                
                <div class="flex flex-col items-center gap-2 flex-1">
                    <div class="w-full max-w-[76px] h-[76px] rounded-[1.25rem] bg-purple-50 text-purple-600 border border-purple-100 flex flex-col items-center justify-center shadow-sm">
                        <span class="text-3xl font-black"><?php echo e($totalProker); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight">Total<br>Proker</p>
                </div>

                
                <div @click="showFinanceModal = true" class="flex flex-col items-center gap-2 flex-[1.8] cursor-pointer active:scale-95 transition-transform">
                    <div class="w-full max-w-[140px] h-[76px] rounded-[1.25rem] <?php echo e($totalKeuntungan >= 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100'); ?> flex items-center justify-center shadow-sm px-2 text-center gap-0.5">
                        <span class="text-[10px] font-bold opacity-80 mt-[3px]"><?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp</span>
                        <span class="text-[15px] sm:text-base font-black truncate"><?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight flex items-center justify-center gap-0.5">
                        Keuntungan
                        <svg class="w-2.5 h-2.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </p>
                </div>
            </div>

            
            <div class="hidden md:grid grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2"><?php echo e($totalAnggota); ?></p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Anggota</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2"><?php echo e($totalProker); ?></p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Proker</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                        </div>
                    </div>
                </div>

                
                <div @click="showFinanceModal = true" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md hover:border-emerald-200 transition-all duration-200 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-2xl font-black <?php echo e($totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600'); ?> mb-1 mt-2">
                                <?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?>

                            </p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Keuntungan</p>
                            <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Klik untuk rincian
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl <?php echo e($totalKeuntungan >= 0 ? 'bg-emerald-50' : 'bg-red-50'); ?> flex items-center justify-center flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalKeuntungan >= 0): ?>
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" /></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
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
                    
                    <div class="bg-blue-700 p-6 pb-8">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-bold text-blue-100 uppercase tracking-widest">Rincian Keuangan Divisi</p>
                            <button @click="showFinanceModal = false" class="w-7 h-7 rounded-full bg-white/20 text-white hover:bg-white/30 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p class="text-4xl font-black text-white"><?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?></p>
                        <p class="text-sm font-bold text-blue-100 mt-1">Total Keuntungan Divisi</p>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-2xl border border-orange-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Modal</p>
                                    <p class="text-sm font-black text-gray-900">Rp<?php echo e(number_format($totalModal, 0, ',', '.')); ?></p>
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
                                    <p class="text-sm font-black text-gray-900">Rp<?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-lg">Masuk</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <p class="text-sm font-bold text-gray-600">Keuntungan Bersih</p>
                            <p class="text-lg font-black <?php echo e($totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600'); ?>">
                                <?php echo e($totalKeuntungan < 0 ? '-' : '+'); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900">10 Log Aktivitas Terbaru</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $activityLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 hover:bg-gray-50 transition-colors flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold text-xs">
                            <?php echo e(strtoupper(substr($log->user->name ?? '?', 0, 1))); ?>

                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900"><?php echo e($log->description); ?></p>
                            <p class="text-xs text-gray-400 mt-1"><?php echo e($log->created_at->diffForHumans()); ?> &bull; <?php echo e($log->ip_address); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-gray-400 text-sm font-medium">Belum ada log aktivitas.</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-900">Manajemen Periode</h2>
                    <a href="<?php echo e(route('periode.index')); ?>" wire:navigate class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $semuaPeriode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-5 flex items-center justify-between <?php echo e($periode->is_active ? 'bg-blue-50/30' : 'hover:bg-gray-50'); ?> transition-colors">
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-gray-900"><?php echo e($periode->name); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($periode->is_active): ?>
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Aktif</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="flex items-center gap-4 mt-2">
                                <p class="text-xs font-medium text-gray-500"><span class="font-bold text-gray-700"><?php echo e($periode->users_count); ?></span> Anggota</p>
                                <p class="text-xs font-medium text-gray-500"><span class="font-bold text-gray-700"><?php echo e($periode->projects_count); ?></span> Proker</p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('periode.index')); ?>" wire:navigate class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center text-gray-400 text-sm font-medium">Belum ada periode.</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

    <?php else: ?>
        
        
        <div class="mb-8 flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-green-500 uppercase tracking-widest mb-2">DANA DAN USAHA</p>
                <h1 class="text-[28px] font-black text-gray-900 leading-tight">
                    Selamat datang, <?php echo e(auth()->user()->name); ?>

                </h1>
                <p class="text-sm font-medium text-gray-500 mt-1">Berikut ringkasan divisi dan program kerja Anda.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm flex-shrink-0">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Periode Kepengurusan</p>
                    <p class="text-sm font-black text-gray-900 leading-none mt-1"><?php echo e(\App\Models\Periode::active()?->name ?? 'Belum Ada'); ?></p>
                </div>
            </div>
        </div>

        
        <div x-data="{ showFinanceModal: false }" class="mb-8">
            
            <div class="flex md:hidden items-start justify-between gap-3 mt-4 mb-2">
                
                <div class="flex flex-col items-center gap-2 flex-1">
                    <div class="w-full max-w-[76px] h-[76px] rounded-[1.25rem] bg-blue-50 text-blue-600 border border-blue-100 flex flex-col items-center justify-center shadow-sm">
                        <span class="text-3xl font-black"><?php echo e($totalAnggota); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight">Total<br>Anggota</p>
                </div>

                
                <div class="flex flex-col items-center gap-2 flex-1">
                    <div class="w-full max-w-[76px] h-[76px] rounded-[1.25rem] bg-purple-50 text-purple-600 border border-purple-100 flex flex-col items-center justify-center shadow-sm">
                        <span class="text-3xl font-black"><?php echo e($totalProker); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight">Total<br>Proker</p>
                </div>

                
                <div @click="showFinanceModal = true" class="flex flex-col items-center gap-2 flex-[1.8] cursor-pointer active:scale-95 transition-transform">
                    <div class="w-full max-w-[140px] h-[76px] rounded-[1.25rem] <?php echo e($totalKeuntungan >= 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100'); ?> flex items-center justify-center shadow-sm px-2 text-center gap-0.5">
                        <span class="text-[10px] font-bold opacity-80 mt-[3px]"><?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp</span>
                        <span class="text-[15px] sm:text-base font-black truncate"><?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?></span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-700 text-center leading-tight flex items-center justify-center gap-0.5">
                        Keuntungan
                        <svg class="w-2.5 h-2.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </p>
                </div>
            </div>

            
            <div class="hidden md:grid grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2"><?php echo e($totalAnggota); ?></p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Anggota</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4xl font-black text-gray-900 mb-1 mt-2"><?php echo e($totalProker); ?></p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Proker</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                        </div>
                    </div>
                </div>

                
                <div @click="showFinanceModal = true" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 cursor-pointer hover:shadow-md hover:border-emerald-200 transition-all duration-200 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-2xl font-black <?php echo e($totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600'); ?> mb-1 mt-2">
                                <?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?>

                            </p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Keuntungan</p>
                            <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Klik untuk rincian
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl <?php echo e($totalKeuntungan >= 0 ? 'bg-emerald-50' : 'bg-red-50'); ?> flex items-center justify-center flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalKeuntungan >= 0): ?>
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" /></svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" /></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
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
                    
                    <div class="bg-blue-700 p-6 pb-8">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-xs font-bold text-blue-100 uppercase tracking-widest">Rincian Keuangan Divisi</p>
                            <button @click="showFinanceModal = false" class="w-7 h-7 rounded-full bg-white/20 text-white hover:bg-white/30 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p class="text-4xl font-black text-white"><?php echo e($totalKeuntungan < 0 ? '-' : ''); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?></p>
                        <p class="text-sm font-bold text-blue-100 mt-1">Total Keuntungan Divisi</p>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-2xl border border-orange-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Modal</p>
                                    <p class="text-sm font-black text-gray-900">Rp<?php echo e(number_format($totalModal, 0, ',', '.')); ?></p>
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
                                    <p class="text-sm font-black text-gray-900">Rp<?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-lg">Masuk</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <p class="text-sm font-bold text-gray-600">Keuntungan Bersih</p>
                            <p class="text-lg font-black <?php echo e($totalKeuntungan >= 0 ? 'text-emerald-600' : 'text-red-600'); ?>">
                                <?php echo e($totalKeuntungan < 0 ? '-' : '+'); ?>Rp<?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <a href="<?php echo e(route('projects.index')); ?>" wire:navigate class="block px-6 py-5 border-b border-gray-100 hover:bg-gray-50 transition-colors rounded-t-2xl group cursor-pointer">
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-start gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors border border-transparent hover:border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate"><?php echo e($project->name); ?></p>
                                <p class="text-xs font-medium text-gray-400 truncate mt-1"><?php echo e($project->description ?? str_replace('_', ' ', ucwords($project->category, '_'))); ?></p>
                            </div>
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full flex-shrink-0 uppercase tracking-wider bg-gray-100 text-gray-600">
                                <?php echo e($project->status === 'draft' ? 'PLANNING' : $project->status); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="py-8 text-center text-gray-400 text-sm font-medium">
                            Belum ada proker yang ditambahkan.
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 h-fit">
                <a href="<?php echo e(route('members.index')); ?>" wire:navigate class="block px-6 py-5 border-b border-gray-100 hover:bg-gray-50 transition-colors rounded-t-2xl group cursor-pointer">
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-sm font-bold text-blue-700 flex-shrink-0">
                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate"><?php echo e($member->name); ?></p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-0.5"><?php echo e($member->jabatan ?? $member->role); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>