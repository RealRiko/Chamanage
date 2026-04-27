@extends('layouts.app')

@section('title', __('dashboard.page_title') . ' — ' . config('app.name'))

@section('content')
@php
    $userName = auth()->user()->name;
    $greetingFull = __('dashboard.greeting', ['name' => $userName]);
    $greetingLead = \Illuminate\Support\Str::beforeLast($greetingFull, $userName);
    $heroRevenueBars = array_values($revenues ?? []);
    if ($heroRevenueBars === []) {
        $heroRevenueBars = array_fill(0, 6, 0.0);
    }
    $heroMaxRev = max($heroRevenueBars) > 0 ? max($heroRevenueBars) : 1;
    $heroBarHeights = array_map(
        static fn ($v) => (int) max(14, min(100, (int) round(((float) $v / $heroMaxRev) * 100))),
        $heroRevenueBars
    );
@endphp

{{-- Dashboard: atsevišķs vertikālais ritms (ne app-shell — sarakstu lapām ciešāks apakšējais padding) --}}
<div class="relative z-10 mx-auto max-w-6xl px-4 pb-8 pt-6 sm:px-6 lg:px-8 lg:pb-12 lg:pt-8">
    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-900 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    {{-- Hero — tā pati struktūra kā welcome (2 kolonnas + preview rāmis) --}}
    <section class="lg:grid lg:grid-cols-2 lg:items-center lg:gap-16 xl:gap-20">
        <div>
            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-zinc-300/80 bg-white/70 px-4 py-1.5 font-display text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-800 shadow-sm dark:border-white/10 dark:bg-white/[0.06] dark:text-amber-200/95">
                {{ __('dashboard.badge_start') }}
            </p>
            <h1 class="font-display text-4xl font-extrabold leading-[1.08] tracking-tight text-zinc-900 dark:text-white sm:text-5xl xl:text-6xl">
                {{ $greetingLead }}<span class="bg-gradient-to-r from-amber-700 via-brand to-amber-500 bg-clip-text text-transparent dark:from-amber-100 dark:via-brand dark:to-amber-300">{{ $userName }}</span>
            </h1>
            <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:items-center">
                <a href="{{ route('documents.create') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-brand px-8 py-4 font-display text-[15px] font-bold text-white shadow-xl shadow-brand/35 transition hover:bg-brand-dark hover:shadow-brand/45">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('dashboard.quick_new_doc') }}
                </a>
                <a href="{{ route('reports.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-zinc-300/90 bg-white/80 px-6 py-4 font-medium text-zinc-800 shadow-sm transition hover:border-amber-400/50 hover:bg-amber-50/90 dark:border-white/15 dark:bg-white/[0.04] dark:text-white/90 dark:hover:border-white/25 dark:hover:bg-white/[0.08]">
                    {{ __('dashboard.quick_reports') }}
                </a>
                <a href="{{ route('invoices.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-zinc-300/90 bg-white/80 px-6 py-4 font-medium text-zinc-800 shadow-sm transition hover:border-amber-400/50 hover:bg-amber-50/90 dark:border-white/15 dark:bg-white/[0.04] dark:text-white/90 dark:hover:border-white/25 dark:hover:bg-white/[0.08]">
                    {{ __('dashboard.quick_invoices') }}
                </a>
            </div>
        </div>

        {{-- Preview rāmis — kā welcome «app frame» --}}
        <div class="relative mx-auto mt-14 w-full max-w-lg lg:mx-0 lg:mt-0">
            <div class="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-brand/50 via-amber-500/20 to-transparent opacity-70 blur-xl dark:opacity-60"></div>
            <div class="relative welcome-ring-glow rounded-3xl p-[1px]">
                <div class="overflow-hidden rounded-[22px] welcome-glass">
                    <div class="flex items-center gap-2 border-b border-zinc-200/60 px-4 py-3 dark:border-white/10">
                        <div class="flex gap-1.5">
                            <span class="h-3 w-3 rounded-full bg-red-400/90"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-400/90"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-400/90"></span>
                        </div>
                        <span class="ml-2 text-[11px] text-zinc-500 dark:text-white/35">{{ __('dashboard.hero_frame_label') }}</span>
                    </div>
                    <div class="p-5 sm:p-6">
                        <div>
                            <p class="text-xs text-zinc-500 dark:text-white/40">{{ __('dashboard.hero_income_title') }}</p>
                            <p class="font-display mt-1 text-3xl font-bold tabular-nums tracking-tight text-zinc-900 dark:text-white">
                                €{{ number_format($teamIncomeThisMonth ?? 0, 2, ',', '.') }}
                            </p>
                            <div class="mt-5 flex h-24 items-end justify-between gap-1.5 rounded-xl bg-zinc-100/80 px-3 pb-2 pt-4 dark:bg-white/[0.04]" role="img" aria-label="{{ __('dashboard.hero_chart_aria') }}">
                                @foreach ($heroBarHeights as $h)
                                    <div class="w-full rounded-sm bg-gradient-to-t from-brand/80 to-amber-400/50 dark:from-brand/90 dark:to-amber-400/40" style="height: {{ $h }}%"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (isset($overdueInvoices) && $overdueInvoices->isNotEmpty())
        <div class="mt-10 rounded-2xl border border-amber-300/60 bg-gradient-to-br from-amber-50 to-amber-100/40 p-5 shadow-sm dark:border-amber-700/50 dark:from-amber-950/50 dark:to-zinc-950/70 dark:shadow-none">
            <h2 class="mb-3 flex items-center gap-2 text-lg font-bold text-amber-950 dark:text-amber-100">
                <span class="inline-block h-2 w-2 animate-pulse rounded-full bg-amber-500"></span>
                {{ __('dashboard.overdue_heading') }}
            </h2>
            <ul class="space-y-2 text-sm text-amber-950 dark:text-amber-50/95">
                @foreach ($overdueInvoices as $doc)
                    <li class="flex flex-wrap justify-between gap-2 border-b border-amber-200/50 pb-2 last:border-0 dark:border-amber-800/40">
                        <a href="{{ route('documents.show', $doc->id) }}" class="font-medium underline decoration-amber-600/40 hover:text-brand">#{{ $doc->id }} — {{ $doc->client->name ?? __('dashboard.client_fallback') }}</a>
                        <span>{{ __('dashboard.due_label') }}: <strong>{{ $doc->due_date?->format('Y-m-d') }}</strong> · €{{ number_format($doc->total, 2, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-3 text-xs text-amber-900/80 dark:text-amber-200/70">{{ __('dashboard.overdue_hint') }}</p>
        </div>
    @endif

    @if ($company->low_stock_notify_enabled && isset($lowStockProducts) && $lowStockProducts->isNotEmpty())
        @push('head')
            <style>
                @keyframes low-stock-notify-in {
                    from { opacity: 0; transform: translateY(-14px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                @media (prefers-reduced-motion: reduce) {
                    .low-stock-notify { animation: none !important; }
                }
                .low-stock-notify {
                    animation: low-stock-notify-in 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
                }
                .low-stock-notify a:focus {
                    outline: none;
                }
                .low-stock-notify a:focus-visible {
                    outline: 2px solid rgba(202, 138, 4, 0.55);
                    outline-offset: 3px;
                    border-radius: 0.375rem;
                }
            </style>
        @endpush
        <div
            class="low-stock-notify relative z-[1] mt-10 overflow-hidden rounded-2xl border border-amber-300/60 border-l-[3px] border-l-brand bg-gradient-to-br from-amber-50 to-amber-100/40 p-5 shadow-lg shadow-amber-900/8 dark:border-white/[0.08] dark:border-l-brand dark:bg-zinc-950 dark:[background-image:none] dark:shadow-[0_16px_48px_-12px_rgba(0,0,0,0.55)]"
            role="status"
            aria-live="polite"
        >
            <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="flex flex-wrap items-center gap-2 text-lg font-bold text-amber-950 dark:text-white">
                    <span class="inline-flex h-2 w-2 shrink-0 animate-pulse rounded-full bg-brand shadow-[0_0_10px_rgba(202,138,4,0.65)] dark:shadow-[0_0_12px_rgba(202,138,4,0.45)]" aria-hidden="true"></span>
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-amber-300/50 bg-amber-500/20 text-amber-800 dark:border-white/[0.1] dark:bg-white/[0.06] dark:text-amber-400/90" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </span>
                    {{ __('dashboard.stock_title') }}
                </h2>
                <a href="{{ route('inventory.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-2xl border border-amber-400/70 bg-white/90 px-5 py-2.5 text-sm font-semibold text-amber-950 shadow-sm outline-none transition hover:border-brand hover:bg-amber-50/95 hover:text-brand focus-visible:ring-2 focus-visible:ring-brand/50 focus-visible:ring-offset-2 focus-visible:ring-offset-amber-50 dark:border-white/12 dark:bg-white/[0.06] dark:text-zinc-200 dark:shadow-none dark:focus-visible:ring-offset-zinc-950 dark:hover:border-amber-500/35 dark:hover:bg-white/[0.1] dark:hover:text-white">
                    {{ __('dashboard.stock_link') }}
                </a>
            </div>
            <ul class="space-y-2 text-sm text-amber-950 dark:text-zinc-300">
                @foreach ($lowStockProducts as $p)
                    @php $qty = (int) ($p->inventory->quantity ?? 0); @endphp
                    <li class="flex items-center justify-between gap-3 border-b border-amber-200/50 pb-2 last:border-0 dark:border-white/[0.06]">
                        <a href="{{ route('products.edit', $p) }}" class="min-w-0 truncate rounded-md font-medium underline decoration-amber-600/40 outline-none hover:text-brand focus-visible:ring-2 focus-visible:ring-brand/45 focus-visible:ring-offset-2 focus-visible:ring-offset-amber-50 dark:text-zinc-200 dark:decoration-white/20 dark:focus-visible:ring-offset-zinc-950 dark:hover:text-amber-400">{{ $p->name }}</a>
                        <span class="shrink-0 rounded-lg border border-amber-300/60 bg-white/80 px-2.5 py-1 text-xs font-bold tabular-nums text-amber-950 dark:border-white/[0.1] dark:bg-zinc-900 dark:text-zinc-200">{{ $qty }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-3 text-xs text-amber-900/80 dark:text-zinc-500">{{ __('dashboard.stock_hint') }}</p>
        </div>
    @endif
</div>

{{-- Bento — kā welcome #features: pilna platuma josla; x-data šeit, lai modālais un Labot poga būtu vienā Alpine komponentā --}}
<section
    class="relative z-10 mt-6 border-t border-amber-200/50 bg-amber-50/35 py-16 dark:border-white/[0.07] dark:bg-black/30"
    x-data="{ settingsOpen: {{ $errors->any() ? 'true' : 'false' }} }"
    @keydown.escape.window="settingsOpen = false"
>
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        @if (session('error'))
            <div class="mx-auto mt-6 max-w-2xl rounded-2xl border border-red-300/50 bg-red-50/90 px-4 py-3 text-sm font-medium text-red-900 dark:border-red-500/40 dark:bg-red-950/50 dark:text-red-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="mt-10 space-y-6">
            <div class="welcome-glass-card relative rounded-3xl p-6 sm:p-7">
                <div class="absolute right-4 top-4 z-[1] flex flex-row-reverse items-center gap-2 sm:gap-2.5">
                    <button type="button"
                            class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/90 text-zinc-500 shadow-sm transition hover:border-zinc-300 hover:bg-zinc-100 hover:text-zinc-800 dark:border-white/10 dark:bg-white/[0.04] dark:text-zinc-500 dark:hover:border-white/20 dark:hover:bg-white/[0.08] dark:hover:text-zinc-300"
                            title="{{ __('dashboard.refresh_data') }}"
                            aria-label="{{ __('dashboard.refresh_data') }}"
                            @click.prevent="window.location.reload()">
                        {{-- Atjaunot: tipiska apļveida bultiņu ikona (nav zīmuļa) --}}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <button type="button"
                            class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-amber-500/50 bg-amber-500/15 px-3 py-2 text-xs font-bold text-amber-900 shadow-sm transition hover:border-brand hover:bg-brand/15 hover:text-brand dark:border-amber-500/35 dark:bg-amber-500/10 dark:text-amber-100 dark:hover:border-amber-400/50 dark:hover:bg-amber-500/20 dark:hover:text-amber-50"
                            @click.prevent.stop="settingsOpen = true"
                            title="{{ __('dashboard.edit_my_goal') }}"
                            aria-label="{{ __('dashboard.edit_my_goal') }}">
                        <svg class="h-4 w-4 shrink-0 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                        </svg>
                        <span class="inline">{{ __('dashboard.edit') }}</span>
                    </button>
                </div>
                <div class="pr-28 sm:pr-48">
                    <h3 class="font-display text-lg font-bold text-zinc-900 dark:text-white">{{ __('dashboard.goals_panel_title') }}</h3>
                </div>
                <div class="mt-6 grid gap-5 lg:grid-cols-2">
                    <div class="rounded-2xl border border-zinc-200/70 bg-white/50 p-5 dark:border-white/10 dark:bg-white/[0.04]">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-zinc-500 dark:text-white/45">{{ __('dashboard.my_goal_section') }}</h4>
                        @if (!empty($hasPersonalDashboard) && $hasPersonalDashboard)
                            <dl class="mt-4 space-y-3 text-sm text-zinc-700 dark:text-zinc-200">
                                <div class="flex justify-between gap-4">
                                    <dt>{{ __('dashboard.col_goal_type') }}</dt>
                                    <dd class="font-medium text-right">{{ ($myGoalType ?? 'revenue') === 'net_profit' ? __('dashboard.goal_type_net') : __('dashboard.goal_type_revenue') }}</dd>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <dt>{{ __('dashboard.my_goal_this_month') }}</dt>
                                    <dd class="tabular-nums font-semibold text-right text-zinc-900 dark:text-white">€{{ number_format($myCurrent ?? 0, 2, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <dt>{{ __('dashboard.my_goal_target') }}</dt>
                                    <dd class="tabular-nums text-right">
                                        @if ($myGoalAmount !== null && (float) $myGoalAmount > 0)
                                            €{{ number_format((float) $myGoalAmount, 2, ',', '.') }}
                                        @else
                                            <span class="text-zinc-400 dark:text-white/35">—</span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex justify-between gap-4 border-t border-zinc-200/60 pt-3 dark:border-white/10">
                                    <dt class="font-semibold text-zinc-900 dark:text-white">{{ __('dashboard.my_goal_progress') }}</dt>
                                    <dd class="font-display text-2xl font-extrabold tabular-nums text-brand dark:text-amber-300">
                                        @if ($myProgressPct !== null)
                                            {{ number_format($myProgressPct, 1, ',', '.') }}%
                                        @else
                                            <span class="text-base font-normal text-zinc-400 dark:text-white/35">—</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                            @if ($myProgressPct !== null)
                                <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                                    <div class="h-2.5 rounded-full bg-gradient-to-r from-brand to-amber-400 transition-all" style="width: {{ min(100, (float) $myProgressPct) }}%"></div>
                                </div>
                            @endif
                        @else
                            <p class="mt-3 text-sm text-zinc-600 dark:text-white/50">{{ __('dashboard.settings_migrate_short') }}</p>
                        @endif
                    </div>
                    <div class="rounded-2xl border border-amber-200/60 bg-amber-50/40 p-5 dark:border-amber-500/25 dark:bg-amber-950/25">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-amber-900/90 dark:text-amber-200/90">{{ __('dashboard.company_goal_section') }}</h4>
                        @if ($goal > 0)
                            @php $coPct = min(100, (float) $goalProgress); @endphp
                            <dl class="mt-4 space-y-3 text-sm text-amber-950 dark:text-amber-50/95">
                                <div class="flex justify-between gap-4">
                                    <dt>{{ __('dashboard.company_goal_target_label') }}</dt>
                                    <dd class="tabular-nums font-semibold">€{{ number_format($goal, 2, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <dt>{{ __('dashboard.company_goal_current_label') }}</dt>
                                    <dd class="tabular-nums font-semibold">€{{ number_format($teamIncomeThisMonth, 2, ',', '.') }}</dd>
                                </div>
                                <div class="flex justify-between gap-4 border-t border-amber-300/50 pt-3 dark:border-amber-700/40">
                                    <dt class="font-bold">{{ __('dashboard.company_goal_progress_label') }}</dt>
                                    <dd class="font-display text-3xl font-extrabold tabular-nums text-brand dark:text-amber-300">{{ number_format($goalProgress, 1, ',', '.') }}%</dd>
                                </div>
                            </dl>
                            <div class="mt-4 h-3 overflow-hidden rounded-full bg-amber-200/80 dark:bg-amber-950/60">
                                <div class="h-3 rounded-full bg-gradient-to-r from-brand to-amber-400 shadow-sm" style="width: {{ $coPct }}%"></div>
                            </div>
                            <p class="mt-3 text-xs text-amber-900/75 dark:text-amber-200/70">{{ __('dashboard.company_goal_admin_hint') }}</p>
                        @else
                            <p class="mt-3 text-sm text-amber-950/85 dark:text-amber-100/80">{{ __('dashboard.company_goal_not_set') }}</p>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.companySettings') }}" class="mt-3 inline-flex text-sm font-semibold text-brand underline decoration-brand/40 hover:decoration-brand dark:text-amber-300">{{ __('dashboard.company_goal_open_admin') }}</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <div class="welcome-glass-card rounded-3xl p-7" x-data="{ netTab: 'week' }">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <h3 class="font-display text-lg font-bold text-zinc-900 dark:text-white">{{ __('dashboard.net_profit_company_title') }}</h3>
                        <div class="inline-flex shrink-0 rounded-xl border border-zinc-200/80 bg-zinc-100/80 p-0.5 dark:border-white/10 dark:bg-white/[0.06]" role="tablist" aria-label="{{ __('dashboard.net_profit_company_title') }}">
                            <button type="button" role="tab" :aria-selected="netTab === 'week'" @click="netTab = 'week'"
                                    :class="netTab === 'week' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white'"
                                    class="rounded-[10px] px-3 py-1.5 text-xs font-semibold transition">{{ __('dashboard.profit_period_week') }}</button>
                            <button type="button" role="tab" :aria-selected="netTab === 'month'" @click="netTab = 'month'"
                                    :class="netTab === 'month' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white'"
                                    class="rounded-[10px] px-3 py-1.5 text-xs font-semibold transition">{{ __('dashboard.profit_period_month') }}</button>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-white/50" x-show="netTab === 'week'">{{ __('dashboard.net_profit_range', ['from' => $weekStart->format('d.m.Y'), 'to' => $weekEnd->format('d.m.Y')]) }}</p>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-white/50" x-show="netTab === 'month'" x-cloak>{{ __('dashboard.net_profit_range', ['from' => $monthStart->format('d.m.Y'), 'to' => $monthEnd->format('d.m.Y')]) }}</p>
                    <p class="mt-6 font-display text-4xl font-extrabold tabular-nums text-zinc-900 dark:text-white" x-show="netTab === 'week'">€{{ number_format($weeklyNetProfitTotal, 2, ',', '.') }}</p>
                    <p class="mt-6 font-display text-4xl font-extrabold tabular-nums text-zinc-900 dark:text-white" x-show="netTab === 'month'" x-cloak>€{{ number_format($monthlyNetProfitTotal, 2, ',', '.') }}</p>
                    <p class="mt-2 text-xs leading-relaxed text-zinc-500 dark:text-white/40">{{ __('dashboard.net_profit_hint') }}</p>
                </div>

                <div class="welcome-glass-card min-h-[280px] rounded-3xl p-7">
                    <h3 class="font-display text-lg font-bold text-zinc-900 dark:text-white">{{ __('dashboard.chart_title') }}</h3>
                    <div class="mt-4 h-[min(300px,40vh)] min-h-[200px] rounded-2xl border border-zinc-200/60 bg-zinc-50/90 p-3 dark:border-white/5 dark:bg-black/40">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php $settingsUser = auth()->user(); @endphp
    <div x-show="settingsOpen" x-cloak x-transition.opacity class="fixed inset-0 z-[120] flex items-end justify-center bg-black/50 p-4 sm:items-center" role="dialog" aria-modal="true">
        <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl border border-zinc-200/80 bg-white p-6 shadow-2xl dark:border-white/10 dark:bg-zinc-900" @click.outside="settingsOpen = false">
            <div class="flex items-start justify-between gap-3">
                <h3 class="font-display text-lg font-bold text-zinc-900 dark:text-white">{{ __('dashboard.modal_title') }}</h3>
                <button type="button" class="rounded-lg p-1 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-800 dark:hover:bg-white/10 dark:hover:text-white" @click="settingsOpen = false" aria-label="{{ __('dashboard.modal_close') }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @if (!empty($hasPersonalDashboard) && $hasPersonalDashboard)
                <form method="post" action="{{ route('dashboard.personal-settings') }}" class="mt-6 space-y-5">
                    @csrf
                    @if ($errors->any())
                        <ul class="list-inside list-disc rounded-xl border border-red-300/60 bg-red-50/90 px-3 py-2 text-sm text-red-800 dark:border-red-500/40 dark:bg-red-950/40 dark:text-red-200">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300" for="personal_monthly_goal">{{ __('dashboard.field_goal_amount') }}</label>
                        <input id="personal_monthly_goal" name="personal_monthly_goal" type="number" step="0.01" min="0"
                               value="{{ old('personal_monthly_goal', $settingsUser->personal_monthly_goal) }}"
                               class="mt-1 w-full rounded-xl border border-zinc-300/90 bg-white px-3 py-2.5 text-zinc-900 dark:border-white/15 dark:bg-zinc-950 dark:text-white">
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('dashboard.field_goal_type') }}</span>
                        <div class="mt-2 flex flex-col gap-2">
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-zinc-200/80 px-3 py-2 dark:border-white/10">
                                <input type="radio" name="personal_goal_type" value="revenue" @checked(old('personal_goal_type', $settingsUser->personal_goal_type ?? 'revenue') === 'revenue')>
                                <span class="text-sm text-zinc-800 dark:text-zinc-200">{{ __('dashboard.goal_type_revenue') }}</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-zinc-200/80 px-3 py-2 dark:border-white/10">
                                <input type="radio" name="personal_goal_type" value="net_profit" @checked(old('personal_goal_type', $settingsUser->personal_goal_type ?? 'revenue') === 'net_profit')>
                                <span class="text-sm text-zinc-800 dark:text-zinc-200">{{ __('dashboard.goal_type_net') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-2xl bg-brand px-5 py-3 font-display text-sm font-bold text-white shadow-lg shadow-brand/30 hover:bg-brand-dark">{{ __('dashboard.save') }}</button>
                        <button type="button" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-zinc-300/90 px-5 py-3 text-sm font-semibold text-zinc-700 dark:border-white/15 dark:text-zinc-200" @click="settingsOpen = false">{{ __('dashboard.cancel') }}</button>
                    </div>
                </form>
            @else
                <div class="mt-6 space-y-4 rounded-2xl border border-amber-200/70 bg-amber-50/80 p-4 text-sm leading-relaxed text-amber-950 dark:border-amber-500/30 dark:bg-amber-950/30 dark:text-amber-50/95">
                    <p>{{ __('dashboard.settings_migrate_body') }}</p>
                    <code class="block rounded-lg bg-zinc-900/90 px-3 py-2 font-mono text-xs text-amber-100">php artisan migrate</code>
                </div>
                <button type="button" class="mt-6 w-full rounded-2xl border border-zinc-300/90 py-3 text-sm font-semibold text-zinc-700 dark:border-white/15 dark:text-zinc-200" @click="settingsOpen = false">{{ __('dashboard.cancel') }}</button>
            @endif
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    let chartInstance = null;

    function chartColors() {
        const isDark = document.documentElement.classList.contains('dark');
        return {
            primaryColor: '#EAB308',
            secondaryColor: isDark ? 'rgba(234, 179, 8, 0.14)' : 'rgba(202, 138, 4, 0.15)',
            gridColor: isDark ? 'rgba(255, 255, 255, 0.07)' : 'rgba(161, 161, 170, 0.35)',
            tickColor: isDark ? '#a1a1aa' : '#52525b',
            tooltipBg: isDark ? 'rgba(9, 9, 11, 0.94)' : 'rgba(255, 255, 255, 0.98)',
            tooltipTitle: isDark ? '#fafafa' : '#18181b',
        };
    }

    function buildChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;
        const c = chartColors();
        if (chartInstance) chartInstance.destroy();
        const dark = document.documentElement.classList.contains('dark');
        chartInstance = new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: @json(__('dashboard.chart_revenue_eur')),
                    data: @json($revenues),
                    fill: true,
                    borderColor: c.primaryColor,
                    backgroundColor: c.secondaryColor,
                    tension: 0.42,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#CA8A04',
                    pointBorderColor: dark ? '#09090b' : '#ffffff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: ctx => '€' + ctx.formattedValue },
                        backgroundColor: c.tooltipBg,
                        titleColor: c.tooltipTitle,
                        bodyColor: '#CA8A04',
                        borderColor: c.gridColor,
                        borderWidth: 1,
                        padding: 12,
                        bodyFont: { weight: '600', size: 13 },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: c.gridColor, drawBorder: false },
                        ticks: {
                            color: c.tickColor,
                            callback: function (value) { return '€' + value.toLocaleString(); }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: c.tickColor, maxRotation: 0 }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', buildChart);

    let prevDark = document.documentElement.classList.contains('dark');
    new MutationObserver(() => {
        const now = document.documentElement.classList.contains('dark');
        if (now !== prevDark && document.getElementById('revenueChart')) {
            prevDark = now;
            buildChart();
        }
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
})();
</script>
@endsection
