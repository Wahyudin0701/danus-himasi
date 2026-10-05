<div class="max-w-[1400px] mx-auto w-full">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl md:text-2xl font-black text-gray-900">Log Aktivitas Sistem</h1>
            <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Pantau seluruh aktivitas yang terjadi di dalam sistem oleh pengguna.</p>
        </div>

        <div class="w-full sm:w-72 relative">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari aktivitas atau nama..." class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
        </div>
    </div>

    
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative" wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-200">
        <div wire:loading.flex class="absolute inset-0 z-10 hidden items-center justify-center bg-white/50 backdrop-blur-sm">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Modul</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900"><?php echo e($log->created_at->format('d/m/Y')); ?></span>
                            <span class="text-xs font-medium text-gray-500 block"><?php echo e($log->created_at->format('H:i:s')); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->user): ?>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    <?php echo e(strtoupper(substr($log->user->name, 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900"><?php echo e($log->user->name); ?></p>
                                    <p class="text-xs font-medium text-gray-500"><?php echo e(strtoupper($log->user->role)); ?></p>
                                </div>
                            </div>
                            <?php else: ?>
                            <span class="text-sm font-medium text-gray-400">Sistem / Dihapus</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-700 leading-snug"><?php echo e($log->description); ?></p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $actionColor = match(true) {
                                    str_contains($log->action, 'CREATE') => 'bg-green-100 text-green-700',
                                    str_contains($log->action, 'UPDATE') => 'bg-blue-100 text-blue-700',
                                    str_contains($log->action, 'DELETE') => 'bg-red-100 text-red-700',
                                    str_contains($log->action, 'LOGIN') || str_contains($log->action, 'LOGOUT') => 'bg-purple-100 text-purple-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            ?>
                            <span class="px-3 py-1 rounded-lg text-xs font-bold <?php echo e($actionColor); ?>">
                                <?php echo e($log->action); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-900">Belum ada aktivitas</p>
                            <p class="text-xs font-medium text-gray-500 mt-1">Log aktivitas sistem akan muncul di sini.</p>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logs->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            <?php echo e($logs->links(data: ['scrollTo' => false])); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/system-log/index.blade.php ENDPATH**/ ?>