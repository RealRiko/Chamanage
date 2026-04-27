<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'hint' => null,
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
    'hint' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="rounded-2xl border border-dashed border-zinc-300/80 bg-white/60 p-10 text-center shadow-sm backdrop-blur-sm dark:border-white/12 dark:bg-zinc-950/40">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-100/90 text-zinc-400 shadow-inner dark:bg-white/[0.06] dark:text-zinc-500">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4M9 9h.01M15 9h.01M12 12h.01"/>
        </svg>
    </div>
    <p class="mt-5 font-display text-lg font-semibold text-zinc-800 dark:text-zinc-100"><?php echo e($title); ?></p>
    <?php if($hint): ?>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400"><?php echo e($hint); ?></p>
    <?php endif; ?>
    <?php if(isset($action)): ?>
        <div class="mt-6 flex justify-center"><?php echo e($action); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/components/listing-empty.blade.php ENDPATH**/ ?>