<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-4xl mx-auto w-full">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl md:text-2xl font-black text-gray-900">Profil Saya</h1>
                <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="p-6 md:p-8 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="max-w-full">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-profile-information-form', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1318905631-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>

            
            <div class="p-6 md:p-8 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="max-w-full">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-password-form', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1318905631-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/profile.blade.php ENDPATH**/ ?>