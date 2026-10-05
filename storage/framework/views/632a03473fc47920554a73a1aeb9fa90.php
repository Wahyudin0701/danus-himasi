<div class="max-w-[1400px] mx-auto w-full">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl md:text-2xl font-black text-gray-900">Dokumen Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
            <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Kelola arsip dokumen dan tautan Google Drive divisi Anda.</p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->canEdit): ?>
        <div class="flex items-center gap-3 self-start sm:self-auto">
            <button wire:click="createItem('folder')" class="px-4 py-2 bg-white text-gray-700 font-bold text-sm rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                Buat Folder
            </button>
            <button wire:click="createItem('file')" class="px-4 py-2 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                Tambah Tautan File
            </button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="flex items-center gap-2 mb-6 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($parentId): ?>
        <button wire:click="goBack" class="p-1.5 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0" title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </button>
        <div class="w-px h-6 bg-gray-200 mx-1 flex-shrink-0"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <div class="flex items-center gap-2 text-sm font-bold whitespace-nowrap">
            <button wire:click="$set('parentId', null)" class="text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                Root
            </button>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <button wire:click="openFolder(<?php echo e($crumb->id); ?>)" class="text-gray-500 hover:text-blue-600 transition-colors">
                <?php echo e($crumb->name); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->type === 'folder'): ?>
                
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/></svg>
                        </div>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->canEdit): ?>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="editItem(<?php echo e($item->id); ?>)" class="p-1.5 text-gray-400 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button wire:click="confirmDelete(<?php echo e($item->id); ?>)" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <button wire:click="openFolder(<?php echo e($item->id); ?>)" class="text-left flex-1 outline-none">
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug"><?php echo e($item->name); ?></h3>
                    </button>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->link): ?>
                    <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tautan GDrive</span>
                        <a href="<?php echo e($item->link); ?>" target="_blank" class="p-1.5 bg-gray-50 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->canEdit): ?>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="editItem(<?php echo e($item->id); ?>)" class="p-1.5 text-gray-400 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button wire:click="confirmDelete(<?php echo e($item->id); ?>)" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->link): ?>
                    <a href="<?php echo e($item->link); ?>" target="_blank" class="flex-1 outline-none">
                        <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 leading-snug"><?php echo e($item->name); ?></h3>
                    </a>
                    <?php else: ?>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 line-clamp-2 leading-snug"><?php echo e($item->name); ?></h3>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tautan File</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->link): ?>
                        <a href="<?php echo e($item->link); ?>" target="_blank" class="p-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <?php else: ?>
                        <span class="text-xs font-medium text-gray-400">Tidak ada link</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-gray-50/50 rounded-3xl border border-gray-100 border-dashed">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Folder Kosong</h3>
                <p class="text-sm font-medium text-gray-500 max-w-md">Belum ada dokumen atau folder di sini. <?php echo e($this->canEdit ? 'Silakan tambahkan folder baru atau tautan file.' : ''); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div x-data="{ show: <?php if ((object) ('showModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'->value()); ?>')<?php echo e('showModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="show" x-transition.opacity class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" @click="show = false"></div>
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95" class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-lg font-black text-gray-900"><?php echo e($editId ? 'Edit' : 'Tambah'); ?> <?php echo e($type === 'folder' ? 'Folder' : 'Tautan File'); ?></h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6">
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama <?php echo e($type === 'folder' ? 'Folder' : 'File'); ?></label>
                        <input type="text" wire:model="name" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block px-4 py-3 font-medium transition-colors" placeholder="Masukkan nama..." required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 font-medium mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Link Google Drive <?php echo e($type === 'folder' ? '(Opsional)' : ''); ?></label>
                        <input type="url" wire:model="link" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block px-4 py-3 font-medium transition-colors" placeholder="https://drive.google.com/..." <?php echo e($type === 'file' ? 'required' : ''); ?>>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 font-medium mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                
                <div class="mt-8 flex gap-3">
                    <button type="button" @click="show = false" class="flex-1 bg-white border border-gray-200 text-gray-700 font-bold px-5 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold px-5 py-3 rounded-xl hover:bg-blue-700 shadow-md shadow-blue-200 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div x-data="{ show: <?php if ((object) ('showDeleteModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDeleteModal'->value()); ?>')<?php echo e('showDeleteModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showDeleteModal'); ?>')<?php endif; ?> }" x-show="show" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div x-show="show" x-transition.opacity class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" @click="show = false"></div>
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="bg-white rounded-3xl shadow-2xl w-full max-w-sm relative z-10 p-6 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Item?</h3>
            <p class="text-sm font-medium text-gray-500 mb-6">Tindakan ini tidak dapat dibatalkan. Menghapus folder juga akan menghapus semua isinya.</p>
            <div class="flex gap-3">
                <button @click="show = false" class="flex-1 bg-gray-100 text-gray-700 font-bold px-5 py-3 rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <button wire:click="deleteItem" class="flex-1 bg-red-600 text-white font-bold px-5 py-3 rounded-xl hover:bg-red-700 shadow-md shadow-red-200 transition-colors">Hapus</button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/livewire/dokumen/index.blade.php ENDPATH**/ ?>