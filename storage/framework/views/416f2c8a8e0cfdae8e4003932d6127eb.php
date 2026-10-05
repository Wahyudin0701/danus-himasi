<!DOCTYPE html>
<html lang="<?php echo e(str_replace(`_`, `-`, app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>Danus HIMASI</title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('Logo_Himasi_Store.png').'?v=2'); ?>">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased bg-[#f8f9fc] text-gray-800" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            
            
            <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.sidebar', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3393412040-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

            
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.header', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3393412040-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                
                <main class="flex-1 overflow-y-auto">
                    <div class="p-4 md:p-8 max-w-[1400px] mx-auto w-full"><?php echo e($slot); ?></div>
                </main>
            </div>
        </div>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>

<?php /**PATH C:\laragon\www\Danus-Himasi\resources\views/layouts/app.blade.php ENDPATH**/ ?>