<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('error.company_required.title')); ?> — <?php echo e(config('app.name')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-full bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
    <div class="flex min-h-full flex-col items-center justify-center px-4 py-12">
        <div class="w-full max-w-md rounded-2xl border border-zinc-200/80 bg-white/90 p-8 shadow-sm backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/60">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-800 dark:text-amber-300/90"><?php echo e(config('app.name')); ?></p>
            <h1 class="mt-2 font-display text-2xl font-bold tracking-tight"><?php echo e(__('error.company_required.title')); ?></h1>
            <p class="mt-3 text-sm font-medium text-zinc-700 dark:text-zinc-300"><?php echo e(__('error.company_required.lead')); ?></p>
            <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400"><?php echo e(__('error.company_required.body')); ?></p>

            <?php if(session('error')): ?>
                <p class="mt-4 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-200"><?php echo e(session('error')); ?></p>
            <?php endif; ?>

            <?php if(Route::has('logout')): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-8">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-primary w-full justify-center py-2.5 text-sm font-semibold"><?php echo e(__('error.company_required.logout')); ?></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/errors/company_required.blade.php ENDPATH**/ ?>