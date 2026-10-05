<div class="w-full" x-data="{ showModal: false, showDeleteModal: false, deleteId: null }" @close-modal.window="showModal = false" @open-modal.window="showModal = true">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center text-[13px] text-gray-500 font-medium mb-2.5">
                <a href="<?php echo e(route('projects.show', $project->id)); ?>" wire:navigate class="hover:text-blue-600 transition-colors"><?php echo e($project->name); ?></a>
                <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 capitalize">Manajemen <?php echo e($type); ?></span>
            </nav>
            <h1 class="text-2xl font-black text-gray-900 capitalize">Pencatatan <?php echo e($type); ?></h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Kelola riwayat <?php echo e($type); ?> untuk program kerja ini.</p>
        </div>
        <div class="flex flex-row items-center gap-3 w-full md:w-auto mt-4 md:mt-0">
            <a href="<?php echo e(route('projects.show', $project->id)); ?>" wire:navigate class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
            <button wire:click="createRecord" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 <?php echo e($type == 'modal' ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' : 'bg-orange-600 hover:bg-orange-700 shadow-orange-200'); ?> text-white text-sm font-bold rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Entri
            </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Riwayat Pencatatan</h3>
            <div class="px-3 py-1 <?php echo e($type == 'modal' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-orange-50 text-orange-700 border-orange-100'); ?> text-xs font-bold rounded-lg border">
                Total: Rp <?php echo e(number_format($records->sum('amount'), 0, ',', '.')); ?>

            </div>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($records->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                        <th class="px-6 py-4 text-center">Aksi</th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo e(\Carbon\Carbon::parse($record->date)->format('d M Y')); ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?php echo e($record->description); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-900">Rp <?php echo e(number_format($record->amount, 0, ',', '.')); ?></td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button wire:click="editRecord(<?php echo e($record->id); ?>)" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-700 transition-colors mr-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button @click="deleteId = <?php echo e($record->id); ?>; showDeleteModal = true" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="p-10 flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada data <?php echo e($type); ?>.</p>
            <p class="text-xs text-gray-400 mt-1">Data yang ditambahkan akan muncul di sini.</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div x-cloak x-show="showModal">
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showModal = false"></div>
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-md relative z-10 overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900"><?php echo e($editId ? 'Edit Data' : 'Tambah Data'); ?> <?php echo e(ucfirst($type)); ?></h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="save">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                        <input type="date" wire:model="date" class="w-full rounded-xl border-gray-200 shadow-sm <?php echo e($type == 'modal' ? 'focus:border-blue-500 focus:ring-blue-200' : 'focus:border-orange-500 focus:ring-orange-200'); ?> focus:ring transition-colors py-2.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea wire:model="description" rows="2" placeholder="Contoh: <?php echo e($type == 'modal' ? 'Beli perlengkapan' : 'Penjualan hari ke-1'); ?>" class="w-full rounded-xl border-gray-200 shadow-sm <?php echo e($type == 'modal' ? 'focus:border-blue-500 focus:ring-blue-200' : 'focus:border-orange-500 focus:ring-orange-200'); ?> focus:ring transition-colors py-2.5"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nominal (Rp)</label>
                        <input type="number" wire:model="amount" min="1" class="w-full rounded-xl border-gray-200 shadow-sm <?php echo e($type == 'modal' ? 'focus:border-blue-500 focus:ring-blue-200' : 'focus:border-orange-500 focus:ring-orange-200'); ?> focus:ring transition-colors py-2.5" placeholder="0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs font-bold mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-100 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 <?php echo e($type == 'modal' ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-200' : 'bg-orange-600 hover:bg-orange-700 shadow-orange-200'); ?> text-white text-sm font-bold rounded-xl transition-colors shadow-sm"><?php echo e($editId ? 'Simpan Perubahan' : 'Simpan Data'); ?></button>
                </div>
            </form>
        </div>
    </div>
    </div>


    
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
</div><?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/project/finance.blade.php ENDPATH**/ ?>