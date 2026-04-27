@extends('layouts.app')

@section('title', __('page.workers.title') . ' — ' . config('app.name'))

@section('content')
<div class="app-shell">
    <x-page-header :title="__('page.workers.title')" :subtitle="__('page.workers.subtitle')" :badge="__('page.workers.badge')">
        <x-slot name="actions">
            @if (auth()->user()->isAdmin())
                <a href="{{ route('workers.create') }}" class="btn-primary inline-flex items-center gap-2 shadow-lg">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('page.workers.cta_new') }}
                </a>
            @endif
        </x-slot>
    </x-page-header>

    @if ($workers->isNotEmpty())
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('page.workers.stat_members') }}</p>
                <p class="font-display mt-2 text-3xl font-bold tabular-nums text-zinc-900 dark:text-white">{{ $workers->count() }}</p>
            </div>
        </div>
    @endif

    <div class="app-panel">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200/80 bg-green-50/90 p-4 text-green-800 dark:border-green-800/50 dark:bg-green-950/30 dark:text-green-200">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200/80 bg-red-50/90 p-4 text-red-800 dark:border-red-800/50 dark:bg-red-950/30 dark:text-red-200">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if ($workers->isEmpty())
            <x-listing-empty :title="__('page.workers.empty_title')" :hint="__('page.workers.empty_hint')">
                @if (auth()->user()->isAdmin())
                    <x-slot name="action">
                        <a href="{{ route('workers.create') }}" class="btn-primary">{{ __('page.workers.cta_new') }}</a>
                    </x-slot>
                @endif
            </x-listing-empty>
        @else
            <div class="table-wrap overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="table-head-row sm:text-sm">
                            <th class="rounded-tl-xl px-6 py-3 text-left">{{ __('page.workers.col_name') }}</th>
                            <th class="px-6 py-3 text-left">{{ __('page.workers.col_email') }}</th>
                            @if (auth()->user()->isAdmin())
                                <th class="rounded-tr-xl px-6 py-3 text-center">{{ __('page.products.col_actions') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach ($workers as $worker)
                            <tr class="table-row text-zinc-900 dark:text-zinc-200">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">{{ $worker->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">{{ $worker->email }}</td>
                                @if (auth()->user()->isAdmin())
                                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                        <a href="{{ route('workers.edit', $worker->id) }}" class="font-semibold text-sienna dark:text-amber-400">{{ __('page.action_edit') }}</a>
                                        @if (auth()->id() !== $worker->id)
                                            <span class="text-zinc-300 dark:text-zinc-600"> | </span>
                                            <button type="button" onclick="openDeleteModal({{ $worker->id }}, '{{ addslashes($worker->name) }}')" class="cursor-pointer font-semibold text-red-600 dark:text-red-400" style="background:none;border:none;padding:0;">
                                                {{ __('page.action_delete') }}
                                            </button>
                                        @else
                                            <span class="text-zinc-300 dark:text-zinc-600"> | </span>
                                            <span class="cursor-not-allowed font-semibold text-zinc-400" title="{{ __('page.workers.delete_disabled') }}">{{ __('page.action_delete') }}</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-zinc-950/60 p-4 backdrop-blur-sm flex">
    <div class="modal-surface transform transition-all">
        <div class="p-6">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="mb-2 text-center text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('page.action_delete') }}</h3>
            <p class="mb-6 text-center text-zinc-600 dark:text-zinc-400">{{ __('page.workers.delete_confirm') }}</p>
            <p class="mb-6 text-center font-semibold text-zinc-900 dark:text-zinc-100"><span id="workerName"></span></p>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-xl border border-zinc-200 bg-zinc-100 px-4 py-2.5 font-semibold text-zinc-800 transition hover:bg-zinc-200 dark:border-white/10 dark:bg-white/10 dark:text-zinc-200 dark:hover:bg-white/15">
                    {{ __('Cancel') }}
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-2.5 font-semibold text-white transition hover:bg-red-700">
                        {{ __('page.action_delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(workerId, workerName) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('workerName').textContent = workerName;
    document.getElementById('deleteForm').action = `/workers/${workerId}`;
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
@endsection
