<div class="w-full">
    
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Program Kerja Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
            <p class="text-sm font-medium text-gray-500 mt-1"><?php echo e(in_array(auth()->user()->role, ['kadiv', 'wakadiv']) ? 'Kelola seluruh program kerja divisi Anda pada periode ini.' : 'Daftar program kerja divisi Anda pada periode ini.'); ?></p>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])): ?>
        <a href="<?php echo e(route('projects.create')); ?>" wire:navigate
           class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200 w-full md:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Proker
        </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role !== 'admin'): ?>
    
    <div class="flex items-center gap-2 mb-5">
        <button wire:click="$set('filter', 'all')" wire:loading.attr="disabled" wire:target="filter"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-colors <?php echo e($filter === 'all' ? 'bg-blue-600 text-white shadow-sm shadow-blue-200' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'); ?>">
            Semua Proker
        </button>
        <button wire:click="$set('filter', 'mine')" wire:loading.attr="disabled" wire:target="filter"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-colors <?php echo e($filter === 'mine' ? 'bg-blue-600 text-white shadow-sm shadow-blue-200' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'); ?>">
            Proker Saya
        </button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative" wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-200">
        <div wire:loading.flex class="absolute inset-0 z-10 flex items-center justify-center bg-white/50 backdrop-blur-sm">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-1/3">Nama Program Kerja</th>
                        <th scope="col" class="px-6 py-4 text-center">Tanggal Pelaksanaan</th>
                        <th scope="col" class="px-6 py-4 text-center">Jenis Program</th>
                        <th scope="col" class="px-6 py-4 text-center">PJ</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Keuntungan</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        
                        <td class="px-6 py-5 font-bold text-gray-900 whitespace-normal">
                            <?php echo e($project->name); ?>

                        </td>
                        
                        
                        <td class="px-6 py-5 text-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->start_date): ?>
                                <?php echo e(\Carbon\Carbon::parse($project->start_date)->format('d/m/Y')); ?> 
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($project->end_date): ?>
                                    - <?php echo e(\Carbon\Carbon::parse($project->end_date)->format('d/m/Y')); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <span class="text-gray-300">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        
                        
                        <td class="px-6 py-5 text-center font-medium">
                            <?php echo e(str_replace('_', ' ', ucwords($project->category, '_'))); ?>

                        </td>
                        
                        
                        <td class="px-6 py-5 text-center">
                            <?php
                                $pj = $project->members->where('is_pic', true)->first();
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pj): ?>
                                <?php echo e($pj->user->name); ?>

                            <?php else: ?>
                                <span class="text-gray-300">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        
                        
                        <td class="px-6 py-5 text-center">
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider
                                <?php echo e($project->status === 'active' ? 'bg-green-100 text-green-700' : ''); ?>

                                <?php echo e($project->status === 'planning' ? 'bg-blue-50 text-blue-600' : ''); ?>

                                <?php echo e($project->status === 'completed' ? 'bg-indigo-100 text-indigo-700' : ''); ?>

                                <?php echo e($project->status === 'archived' ? 'bg-gray-100 text-gray-600' : ''); ?>">
                                <?php echo e($project->status === 'planning' ? 'PLANNING' : $project->status); ?>

                            </span>
                        </td>
                        
                        
                        <td class="px-6 py-5 text-center">
                            <?php
                                $modal = $project->modal ?? 0;
                                $pendapatan = $project->pendapatan ?? 0;
                                $keuntungan = $pendapatan - $modal;
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($keuntungan > 0): ?>
                                <span class="text-green-600 font-bold">+Rp <?php echo e(number_format($keuntungan, 0, ',', '.')); ?></span>
                            <?php elseif($keuntungan < 0): ?>
                                <span class="text-red-600 font-bold">-Rp <?php echo e(number_format(abs($keuntungan), 0, ',', '.')); ?></span>
                            <?php else: ?>
                                <span class="text-gray-400 font-bold">Rp 0</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        
                        
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?php echo e(route('projects.show', $project->id)); ?>" wire:navigate class="px-3 py-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg text-xs font-bold transition-colors">Detail</a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array(auth()->user()->role, ['admin', 'kadiv', 'wakadiv'])): ?>
                                <a href="<?php echo e(route('projects.edit', $project->id)); ?>" wire:navigate class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-bold transition-colors">Edit</a>
                                <button wire:click="confirmDelete(<?php echo e($project->id); ?>)" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition-colors">Batalkan</button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                            Belum ada program kerja yang ditambahkan.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
                <tfoot class="bg-gray-50/80 border-t border-gray-100 font-black text-gray-900">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-right text-xs uppercase tracking-wider text-gray-500">Total Keuntungan Keseluruhan</td>
                        <td class="px-6 py-4 text-center text-base">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalKeuntungan > 0): ?>
                                <span class="text-green-600">+Rp <?php echo e(number_format($totalKeuntungan, 0, ',', '.')); ?></span>
                            <?php elseif($totalKeuntungan < 0): ?>
                                <span class="text-red-600">-Rp <?php echo e(number_format(abs($totalKeuntungan), 0, ',', '.')); ?></span>
                            <?php else: ?>
                                <span class="text-gray-400">Rp 0</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showDeleteModal): ?>
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data x-on:keydown.escape.window="$wire.cancelDelete()">
        <div class="bg-white rounded-[24px] shadow-2xl w-full max-w-sm overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="p-6 text-center mt-2">
                <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Batalkan Proker?</h3>
                <p class="text-sm text-gray-500 font-medium leading-relaxed">
                    Anda akan membatalkan dan menghapus permanen proker <span class="font-bold text-gray-900"><?php echo e($projectToDeleteName); ?></span> beserta seluruh data RAB dan catatan keuangannya. Yakin ingin melanjutkan?
                </p>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button wire:click="cancelDelete"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button wire:click="deleteProject"
                        class="flex-1 px-4 py-3 bg-red-600 text-white text-sm font-bold rounded-2xl hover:bg-red-700 transition-colors shadow-md shadow-red-200">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/project/index.blade.php ENDPATH**/ ?>