<div class="w-full">
    
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900">Kelola Periode Kepengurusan Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
        <p class="text-sm text-gray-500 font-medium mt-1">Buat dan aktifkan periode kepengurusan HIMASI Divisi Dana dan Usaha.</p>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-bold">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePeriode): ?>
    <div class="mb-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Periode Aktif Saat Ini</p>
                <h2 class="text-3xl font-black"><?php echo e($activePeriode->name); ?></h2>
                <p class="text-blue-200 text-sm font-medium mt-1">Tahun <?php echo e($activePeriode->year_start); ?> – <?php echo e($activePeriode->year_end); ?></p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mb-6 flex justify-end">
        <button wire:click="openCreate"
                class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-200 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Periode Baru
        </button>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Semua Periode</h3>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">Periode</th>
                    <th class="px-6 py-3 text-left">Tahun</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-black text-gray-900"><?php echo e($periode->name); ?></td>
                    <td class="px-6 py-4 text-gray-600 font-medium"><?php echo e($periode->year_start); ?> – <?php echo e($periode->year_end); ?></td>
                    <td class="px-6 py-4 text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($periode->is_active): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Tidak Aktif
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$periode->is_active): ?>
                            <button wire:click="confirmActivate(<?php echo e($periode->id); ?>)"
                                    class="px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg hover:bg-blue-100 transition-colors border border-blue-100">
                                Aktifkan
                            </button>
                        <?php else: ?>
                            <span class="text-xs text-gray-400 font-medium italic">Periode ini aktif</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">Belum ada periode kepengurusan.</td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCreateModal): ?>
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         x-data x-on:keydown.escape.window="$wire.set('showCreateModal', false)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-black text-gray-900">Buat Periode Baru</h3>
                <button wire:click="$set('showCreateModal', false)" class="p-1 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3 text-left">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <span class="block text-sm font-bold text-amber-800 mb-1">Perhatian</span>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            Saat periode baru dibuat, pengurus dan admin <strong>tidak dapat mengakses data periode saat ini</strong>. Jika Anda perlu mengakses datanya kembali, Anda harus mengaktifkan periode tersebut dari tabel daftar periode.
                        </p>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-100 rounded-2xl px-4 py-4 text-center">
                    <span class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Periode yang akan dibuat</span>
                    <span class="text-2xl font-black text-blue-800"><?php echo e($nextPeriodeName); ?></span>
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button wire:click="$set('showCreateModal', false)"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button wire:click="createPeriode"
                        class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                    Buat Periode
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showActivateModal): ?>
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-data>
            <div class="p-6 text-center">
                <div class="mx-auto w-14 h-14 bg-yellow-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-1">Ganti Periode Aktif?</h3>
                <p class="text-sm text-gray-500 font-medium">
                    Sistem akan beralih ke periode <span class="font-bold text-blue-600"><?php echo e($confirmActivateName); ?></span>.
                    Pengguna periode sebelumnya tidak dapat login hingga periode mereka diaktifkan kembali.
                </p>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button wire:click="$set('showActivateModal', false)"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button wire:click="activatePeriode"
                        class="flex-1 px-4 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                    Ya, Aktifkan
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/periode/index.blade.php ENDPATH**/ ?>