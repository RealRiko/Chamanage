@extends('layouts.app')

@section('title', __('reports.title') . ' — ' . config('app.name'))

@section('content')
    <div class="app-shell">
        <x-page-header :title="__('reports.title')" :subtitle="__('reports.tagline')" :badge="__('reports.page_badge')">
            <x-slot name="actions">
                <a href="{{ route('reports.export', request()->query()) }}"
                   class="btn-primary inline-flex whitespace-nowrap py-2.5 px-5 text-sm shadow-lg">
                    {{ __('reports.export_pdf') }}
                </a>
            </x-slot>
        </x-page-header>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200/80 bg-red-50/90 p-4 text-sm text-red-800 dark:border-red-800/50 dark:bg-red-950/30 dark:text-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="get" action="{{ route('reports.index') }}" class="listing-filter-shell mb-8 grid grid-cols-1 gap-x-4 gap-y-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 xl:items-end">
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-date-from" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('reports.date_from') }}</label>
                <input id="reports-date-from" type="date" name="date_from" value="{{ $filters['date_from']->format('Y-m-d') }}"
                       class="input-control w-full">
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-date-to" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('reports.date_to') }}</label>
                <input id="reports-date-to" type="date" name="date_to" value="{{ $filters['date_to']->format('Y-m-d') }}"
                       class="input-control w-full">
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-client" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('reports.client') }}</label>
                <select id="reports-client" name="client_id" class="input-control w-full">
                    <option value="">{{ __('reports.all') }}</option>
                    @foreach ($clients as $c)
                        <option value="{{ $c->id }}" @selected((string) ($filters['client_id'] ?? '') === (string) $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-type" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('reports.doc_type') }}</label>
                <select id="reports-type" name="type" class="input-control w-full">
                    <option value="">{{ __('reports.all') }}</option>
                    <option value="estimate" @selected($filters['type'] === 'estimate')>estimate</option>
                    <option value="sales_order" @selected($filters['type'] === 'sales_order')>sales_order</option>
                    <option value="sales_invoice" @selected($filters['type'] === 'sales_invoice')>sales_invoice</option>
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-status" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300">{{ __('reports.status') }}</label>
                <select id="reports-status" name="status" class="input-control w-full">
                    <option value="">{{ __('reports.all') }}</option>
                    @foreach (['draft','sent','confirmed','cancelled','waiting_payment','paid'] as $st)
                        <option value="{{ $st }}" @selected($filters['status'] === $st)>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <div class="mb-1.5 h-4 shrink-0" aria-hidden="true"></div>
                <button type="submit" class="btn-primary w-full py-2.5 text-sm shadow">
                    {{ __('reports.filter') }}
                </button>
            </div>
        </form>

        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('reports.paid_revenue') }}</p>
                <p class="mt-1 text-3xl font-bold text-sienna tabular-nums">€{{ number_format($paidRevenue, 2, ',', '.') }}</p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('reports.paid_hint') }}</p>
            </div>
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('reports.outstanding') }}</p>
                <p class="mt-1 text-3xl font-bold text-zinc-900 tabular-nums dark:text-white">€{{ number_format($outstanding, 2, ',', '.') }}</p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ __('reports.out_hint') }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/50 dark:shadow-glass-dark">
            <div class="border-b border-zinc-200 px-6 py-4 font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                {{ __('reports.documents_heading', ['count' => $documents->total()]) }}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-zinc-100/90 text-left text-xs uppercase text-zinc-600 dark:bg-zinc-950 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3">{{ __('reports.th_id') }}</th>
                            <th class="px-4 py-3">{{ __('reports.th_type') }}</th>
                            <th class="px-4 py-3">{{ __('reports.th_client') }}</th>
                            <th class="px-4 py-3">{{ __('reports.th_invoice_date') }}</th>
                            <th class="px-4 py-3">{{ __('reports.th_status') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('reports.th_amount') }}</th>
                            <th class="px-4 py-3 text-center">{{ __('reports.th_pdf') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($documents as $doc)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 font-mono">#{{ $doc->id }}</td>
                                <td class="px-4 py-3">{{ $doc->type }}</td>
                                <td class="px-4 py-3">{{ $doc->client->name ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $doc->invoice_date?->format('Y-m-d') }}</td>
                                <td class="px-4 py-3">{{ $doc->status }}</td>
                                <td class="px-4 py-3 text-right font-semibold">€{{ number_format($doc->total, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('documents.pdf', $doc) }}" class="font-medium text-sienna hover:underline dark:text-amber-400">PDF</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-zinc-500 dark:text-zinc-400">{{ __('reports.empty') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($documents->hasPages())
                <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-800">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
