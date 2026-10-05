<div class="w-full">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Edit Pengurus</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Ubah data pengurus dan kredensial sistemnya.</p>
        </div>
        <a href="<?php echo e(route('members.index')); ?>" wire:navigate class="text-sm font-bold text-gray-500 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" wire:model="name" id="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: Budi Santoso">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div>
                <label for="nim" class="block text-sm font-bold text-gray-700 mb-2">NIM <span class="text-red-500">*</span></label>
                <input type="text" wire:model="nim" id="nim" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: F1E121001">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div>
                <label for="angkatan" class="block text-sm font-bold text-gray-700 mb-2">Tahun Angkatan <span class="text-red-500">*</span></label>
                <input type="text" wire:model="angkatan" id="angkatan" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Contoh: 2021">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['angkatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div>
                <label for="divisi" class="block text-sm font-bold text-gray-700 mb-2">Divisi <span class="text-red-500">*</span></label>
                <select id="divisi" disabled class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3 bg-gray-50 text-gray-500">
                    <option>Dana dan Usaha</option>
                </select>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="jabatan" class="block text-sm font-bold text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                </div>
                <select wire:model="jabatan" id="jabatan" <?php echo e(in_array($member->role, ['kadiv', 'wakadiv']) ? 'disabled' : ''); ?> class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3 <?php echo e(in_array($member->role, ['kadiv', 'wakadiv']) ? 'bg-gray-50 text-gray-500' : ''); ?>">
                    <option value="">-- Pilih Jabatan Utama --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->jabatanOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($opt['value']); ?>" <?php echo e($opt['disabled'] ? 'disabled' : ''); ?>>
                            <?php echo e($opt['label']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="md:col-span-2 py-4"><hr class="border-gray-100"></div>

            
            
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password (Opsional)</label>
                <input type="text" wire:model="password" id="password" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors py-3" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3">
            <a href="<?php echo e(route('members.index')); ?>" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Simpan Pengurus
            </button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/member/edit.blade.php ENDPATH**/ ?>