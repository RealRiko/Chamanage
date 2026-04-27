@props([
    'title',
    'hint' => null,
])
<div class="rounded-2xl border border-dashed border-zinc-300/80 bg-white/60 p-10 text-center shadow-sm backdrop-blur-sm dark:border-white/12 dark:bg-zinc-950/40">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-100/90 text-zinc-400 shadow-inner dark:bg-white/[0.06] dark:text-zinc-500">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4M9 9h.01M15 9h.01M12 12h.01"/>
        </svg>
    </div>
    <p class="mt-5 font-display text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</p>
    @if ($hint)
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $hint }}</p>
    @endif
    @isset($action)
        <div class="mt-6 flex justify-center">{{ $action }}</div>
    @endisset
</div>
