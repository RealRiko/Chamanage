<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    'badge' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'subtitle' => null,
    'badge' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="mb-8 border-b border-zinc-200/90 pb-8 dark:border-white/10 lg:mb-10 lg:pb-10" aria-labelledby="page-heading">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="min-w-0 max-w-3xl">
            <?php if($badge): ?>
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-800 dark:text-amber-300/90"><?php echo e($badge); ?></p>
            <?php endif; ?>
            <h1 id="page-heading" class="mt-1 font-display text-2xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-3xl"><?php echo e($title); ?></h1>
            <?php if($subtitle): ?>
                <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>
        <?php if(isset($actions)): ?>
            <div class="flex shrink-0 flex-wrap items-center gap-2 sm:gap-3"><?php echo e($actions); ?></div>
        <?php endif; ?>
    </div>
    <?php if(isset($below)): ?>
        <div class="mt-6 border-t border-zinc-100 pt-6 text-sm text-zinc-600 dark:border-white/5 dark:text-zinc-400"><?php echo e($below); ?></div>
    <?php endif; ?>
</section>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/components/page-header.blade.php ENDPATH**/ ?>