@extends('layouts.app')

@section('title', __('page.invoices.title') . ' — ' . config('app.name'))

@section('content')
<div class="app-shell">
    <x-page-header :title="__('page.invoices.title')" :subtitle="__('page.invoices.subtitle')" :badge="__('page.invoices.badge')">
        <x-slot name="actions">
            <a href="{{ route('reports.index', ['type' => 'sales_invoice', 'date_from' => now()->startOfMonth()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]) }}"
               class="inline-flex items-center rounded-2xl border border-zinc-300/90 bg-white/80 px-5 py-3 text-sm font-semibold text-zinc-800 shadow-sm transition hover:border-amber-400/50 hover:bg-amber-50/90 dark:border-white/15 dark:bg-white/[0.04] dark:text-white/90 dark:hover:border-white/25 dark:hover:bg-white/[0.08]">
                {{ __('page.invoices.link_reports') }}
            </a>
        </x-slot>
    </x-page-header>

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="stat-card border-emerald-200/60 dark:border-emerald-900/40">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-800 dark:text-emerald-300">{{ __('page.invoices.paid_sum') }}</p>
            <p class="font-display mt-2 text-2xl font-bold tabular-nums text-emerald-700 dark:text-emerald-400">€{{ number_format($paidSum ?? 0, 2, ',', '.') }}</p>
        </div>
        <div class="stat-card border-amber-200/60 dark:border-amber-900/40">
            <p class="text-xs font-semibold uppercase tracking-wide text-amber-900 dark:text-amber-300">{{ __('page.invoices.waiting_sum') }}</p>
            <p class="font-display mt-2 text-2xl font-bold tabular-nums text-sienna">€{{ number_format($waitingSum ?? 0, 2, ',', '.') }}</p>
        </div>
        <div class="stat-card sm:col-span-2 lg:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('page.invoices.stat_shown') }}</p>
            <p class="font-display mt-2 text-3xl font-bold tabular-nums text-zinc-900 dark:text-white">{{ $invoices->total() }}</p>
        </div>
    </div>

    <div class="app-panel">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200/80 bg-green-50/90 p-4 text-green-800 dark:border-green-800/50 dark:bg-green-950/30 dark:text-green-200">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="listing-filter-shell mb-8">
            <form method="get" action="{{ route('invoices.index') }}" data-listing-live data-listing-root="invoices-table-live" class="space-y-4">
                <div class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2 xl:grid-cols-6 xl:items-end">
                    <div class="flex min-h-[3.25rem] flex-col justify-end sm:col-span-2 xl:col-span-2">
                        <label for="invoices-filter-search" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('page.invoices.search_label') }}</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute left-3 top-1/2 z-[1] -translate-y-1/2 text-zinc-400" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input id="invoices-filter-search" type="text" name="search" placeholder="{{ __('page.invoices.search_placeholder') }}" value="{{ request('search') }}"
                                class="input-control relative z-0 w-full pl-10">
                        </div>
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-from" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('page.documents.label_from') }}</label>
                        <input id="invoices-filter-from" type="date" name="date_from" value="{{ request('date_from') }}" class="input-control w-full">
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-to" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('page.documents.label_to') }}</label>
                        <input id="invoices-filter-to" type="date" name="date_to" value="{{ request('date_to') }}" class="input-control w-full">
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-client" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('page.documents.label_client') }}</label>
                        <select id="invoices-filter-client" name="client_id" class="input-control w-full">
                            <option value="">{{ __('reports.all') }}</option>
                            @foreach ($clients ?? [] as $c)
                                <option value="{{ $c->id }}" @selected((string) request('client_id') === (string) $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-status" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('page.documents.label_status') }}</label>
                        <select id="invoices-filter-status" name="status" class="input-control w-full">
                            <option value="">{{ __('reports.all') }}</option>
                            <option value="waiting_payment" @selected(request('status') === 'waiting_payment')>waiting_payment</option>
                            <option value="paid" @selected(request('status') === 'paid')>paid</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary py-2.5 text-sm">{{ __('page.documents.filter_submit') }}</button>
                    <a href="{{ route('invoices.index') }}" class="btn-secondary py-2.5 text-sm">{{ __('page.documents.filter_clear') }}</a>
                </div>
            </form>
        </div>

        <div id="invoices-table-live">
        @if ($invoices->isEmpty())
            <x-listing-empty :title="__('page.invoices.empty_title')" :hint="__('page.invoices.empty_hint')"/>
        @else
            <div class="table-wrap overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="table-head-row sm:text-sm">
                            <th class="rounded-tl-xl px-6 py-3 text-left">{{ __('page.invoices.col_id') }}</th>
                            <th class="px-6 py-3 text-left">{{ __('page.documents.col_client') }}</th>
                            <th class="px-6 py-3 text-left">{{ __('page.invoices.col_date') }}</th>
                            <th class="px-6 py-3 text-center">{{ __('page.documents.col_status') }}</th>
                            <th class="px-6 py-3 text-center">{{ __('page.documents.col_total') }}</th>
                            <th class="rounded-tr-xl px-6 py-3 text-center">{{ __('page.products.col_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach ($invoices as $invoice)
                            <tr class="table-row text-zinc-900 dark:text-zinc-200">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">#{{ $invoice->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    @if ($invoice->client_id && $invoice->client)
                                        <a href="{{ route('clients.edit', $invoice->client_id) }}" class="font-semibold text-sienna hover:underline dark:text-amber-400">
                                            {{ $invoice->client->name }}
                                        </a>
                                    @else
                                        <span class="text-zinc-500 dark:text-zinc-400">{{ $invoice->client_name_snapshot ?? 'N/A' }}</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
                                        {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-200' : 'bg-amber-100 text-amber-900 dark:bg-amber-950/50 dark:text-amber-200' }}">
                                        {{ str_replace('_', ' ', $invoice->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-emerald-600 dark:text-emerald-400">€{{ number_format($invoice->total, 2, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="rounded-lg px-2 py-1 font-semibold text-sienna transition hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-white/10">{{ __('page.invoices.view') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($invoices->hasPages())
                <div class="mt-8">
                    {{ $invoices->links() }}
                </div>
            @endif
        @endif
        </div>
    </div>
</div>
@endsection
