@props([
    'title',
    'subtitle' => null,
    'badge' => null,
])
<section class="mb-8 border-b border-zinc-200/90 pb-8 dark:border-white/10 lg:mb-10 lg:pb-10" aria-labelledby="page-heading">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="min-w-0 max-w-3xl">
            @if ($badge)
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-800 dark:text-amber-300/90">{{ $badge }}</p>
            @endif
            <h1 id="page-heading" class="mt-1 font-display text-2xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $subtitle }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="flex shrink-0 flex-wrap items-center gap-2 sm:gap-3">{{ $actions }}</div>
        @endisset
    </div>
    @isset($below)
        <div class="mt-6 border-t border-zinc-100 pt-6 text-sm text-zinc-600 dark:border-white/5 dark:text-zinc-400">{{ $below }}</div>
    @endisset
</section>
