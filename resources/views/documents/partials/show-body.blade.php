@php
    $documentListRoute = $documentListRoute ?? route('documents.index');
    $vatMultiplier = \App\Support\Vat::multiplierForCountry($document->company?->country);
    $statusStyles = [
        'paid' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300',
        'pending' => 'bg-amber-100 text-amber-900 dark:bg-amber-900/40 dark:text-amber-200',
        'draft' => 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200',
        'sent' => 'bg-sky-100 text-sky-900 dark:bg-sky-900/40 dark:text-sky-200',
    ];
    $statusClass = $statusStyles[$document->status] ?? 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200';
    $typeLabel = str_replace('_', ' ', $document->type);
    $isOverdue = $document->due_date && $document->due_date->isPast() && ($document->status ?? '') !== 'paid';
    $pricesIncludeVat = \Illuminate\Support\Facades\Schema::hasColumn('documents', 'apply_vat')
        && (bool) $document->apply_vat;
@endphp

@include('partials.catalog-ui-styles')

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow">{{ __('page.documents.badge') }}</span>
                        <span class="count-pill">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            #{{ $document->id }}
                        </span>
                    </div>
                    <h1 class="pg-title" style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);">{{ __('page.document_show.heading', ['id' => $document->id]) }}</h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 560px;">{{ __('page.document_show.subtitle', ['client' => $document->client?->name ?? $document->client_name_snapshot ?? '—']) }}</p>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;">
                    <a href="{{ $documentListRoute }}" class="btn-ghost">{{ __('page.document_show.cta_back') }}</a>
                    <a href="{{ route('documents.pdf', $document) }}" class="btn-ghost" target="_blank" rel="noopener noreferrer">{{ __('page.document_show.cta_pdf') }}</a>
                    <a href="{{ route('documents.edit', $document) }}" class="btn-primary">{{ __('page.document_show.cta_edit') }}</a>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success" role="status">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="main-card" style="padding: 24px;">
                <h2 class="pg-eyebrow" style="margin-bottom: 12px;">{{ __('page.document_show.card_client') }}</h2>
                <p class="tbl-name text-lg text-zinc-900 dark:text-zinc-100">{{ $document->client?->name ?? $document->client_name_snapshot ?? '—' }}</p>
            </div>
            <div class="main-card" style="padding: 24px;">
                <h2 class="pg-eyebrow" style="margin-bottom: 12px;">{{ __('page.document_show.card_amount') }}</h2>
                <p class="tbl-price text-3xl">€{{ number_format($document->total, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="main-card mt-1" style="padding: 24px;">
            <dl class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <dt class="pg-eyebrow" style="margin-bottom: 8px;">{{ __('page.document_show.label_type') }}</dt>
                    <dd class="m-0 font-medium text-zinc-900 dark:text-zinc-100">{{ ucfirst($typeLabel) }}</dd>
                </div>
                <div>
                    <dt class="pg-eyebrow" style="margin-bottom: 8px;">{{ __('page.document_show.label_delivery') }}</dt>
                    <dd class="m-0 font-medium text-zinc-900 dark:text-zinc-100">{{ $document->delivery_days }} {{ __('page.documents.days_suffix') }}</dd>
                </div>
                <div>
                    <dt class="pg-eyebrow" style="margin-bottom: 8px;">{{ __('page.document_show.label_status') }}</dt>
                    <dd class="m-0">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide {{ $statusClass }}">{{ $document->status }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="pg-eyebrow" style="margin-bottom: 8px;">{{ __('page.document_show.label_invoice_date') }}</dt>
                    <dd class="m-0 font-medium tabular-nums text-zinc-900 dark:text-zinc-100">{{ $document->invoice_date->format('Y-m-d') }}</dd>
                </div>
                <div class="sm:col-span-2 lg:col-span-2">
                    <dt class="pg-eyebrow" style="margin-bottom: 8px;">{{ __('page.document_show.label_due_date') }}</dt>
                    <dd class="m-0 font-medium tabular-nums {{ $isOverdue ? 'text-red-600 dark:text-red-400' : 'text-zinc-900 dark:text-zinc-100' }}">{{ $document->due_date->format('Y-m-d') }}</dd>
                </div>
            </dl>
        </div>

        @if ($document->lineItems->isNotEmpty())
            <div class="main-card" style="margin-top: 20px; padding: 24px;">
                <h2 class="pg-eyebrow" style="margin-bottom: 16px;">{{ __('page.document_show.line_items') }}</h2>
                <div class="data-table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('page.document_show.col_product') }}</th>
                                <th style="text-align: right;">{{ __('page.document_show.col_qty') }}</th>
                                <th style="text-align: right;">{{ __('page.document_show.col_price') }}</th>
                                <th style="text-align: right;">{{ __('page.document_show.col_cost_price') }}</th>
                                <th style="text-align: right;">{{ __('page.document_show.col_subtotal') }}</th>
                                <th style="text-align: right;">{{ __('page.document_show.col_profit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($document->lineItems as $line)
                                @php
                                    $unitCost = (float) ($line->product->cost_price ?? 0);
                                    $lineCost = (float) $line->quantity * $unitCost;
                                    $lineSubtotal = (float) ($line->subtotal ?? ($line->quantity * $line->price));
                                    $lineNetRevenue = $pricesIncludeVat ? ($lineSubtotal / $vatMultiplier) : $lineSubtotal;
                                    $lineProfit = $lineNetRevenue - $lineCost;
                                @endphp
                                <tr>
                                    <td>{{ $line->product?->name ?? '—' }}</td>
                                    <td style="text-align: right; font-variant-numeric: tabular-nums; color: #78716c;">{{ $line->quantity }}</td>
                                    <td style="text-align: right; font-variant-numeric: tabular-nums; color: #78716c;">€{{ number_format($line->price, 2) }}</td>
                                    <td style="text-align: right; font-variant-numeric: tabular-nums; color: #78716c;">€{{ number_format($unitCost, 2) }}</td>
                                    <td style="text-align: right; font-weight: 500;">€{{ number_format($lineSubtotal, 2) }}</td>
                                    <td style="text-align: right; font-variant-numeric: tabular-nums; color: {{ $lineProfit < 0 ? '#dc2626' : '#15803d' }};">€{{ number_format($lineProfit, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
