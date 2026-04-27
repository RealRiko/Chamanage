<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth transition-colors duration-300">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Chamanage') }} — {{ __('welcome.title_suffix') }}</title>
    @include('partials.favicon')
    <script>
        (function () {
            try {
                var s = localStorage.getItem('theme');
                var dark = s === 'dark' || (s !== 'light' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#CA8A04', dark: '#A16207', glow: 'rgba(202,138,4,0.45)' },
                        sienna: { DEFAULT: '#CA8A04', dark: '#A16207', light: '#FDE68A' },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.7s ease-out forwards',
                        'pulse-slow': 'pulseSoft 4s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '0.4' },
                            '50%': { opacity: '0.75' },
                        },
                    },
                },
            },
        };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', system-ui, sans-serif; }

        .font-display { font-family: 'Plus Jakarta Sans', Inter, system-ui, sans-serif; }

        :root {
            --wm-mesh-bg: #f4f4f5;
            --wm-grid-a: rgba(15, 23, 42, 0.05);
            --wm-glow-top: rgba(202, 138, 4, 0.22);
            --wm-glow-tr: rgba(245, 158, 11, 0.1);
            --wm-glow-bl: rgba(202, 138, 4, 0.08);
            --wm-glass-bg: rgba(255, 255, 255, 0.82);
            --wm-glass-edge: rgba(15, 23, 42, 0.1);
            --wm-glass-card-a: rgba(255, 255, 255, 0.92);
            --wm-glass-card-b: rgba(241, 245, 249, 0.88);
            --wm-glass-card-border: rgba(15, 23, 42, 0.1);
            --wm-ring-a: rgba(202, 138, 4, 0.22);
            --wm-ring-b: rgba(15, 23, 42, 0.1);
            --wm-ring-c: rgba(202, 138, 4, 0.18);
            --wm-bento-hover-shadow: rgba(202, 138, 4, 0.14);
        }

        html.dark {
            --wm-mesh-bg: #050505;
            --wm-grid-a: rgba(255, 255, 255, 0.03);
            --wm-glow-top: rgba(202, 138, 4, 0.45);
            --wm-glow-tr: rgba(245, 158, 11, 0.12);
            --wm-glow-bl: rgba(202, 138, 4, 0.1);
            --wm-glass-bg: rgba(12, 12, 12, 0.72);
            --wm-glass-edge: rgba(255, 255, 255, 0.08);
            --wm-glass-card-a: rgba(255, 255, 255, 0.08);
            --wm-glass-card-b: rgba(255, 255, 255, 0.02);
            --wm-glass-card-border: rgba(255, 255, 255, 0.1);
            --wm-ring-a: rgba(202, 138, 4, 0.25);
            --wm-ring-b: rgba(0, 0, 0, 0.6);
            --wm-ring-c: rgba(202, 138, 4, 0.35);
            --wm-bento-hover-shadow: rgba(202, 138, 4, 0.2);
        }

        .mesh {
            background-color: var(--wm-mesh-bg);
            background-image:
                linear-gradient(var(--wm-grid-a) 1px, transparent 1px),
                linear-gradient(90deg, var(--wm-grid-a) 1px, transparent 1px);
            background-size: 64px 64px;
            background-position: center top;
        }

        .mesh::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 100% 60% at 50% -30%, var(--wm-glow-top), transparent 58%),
                radial-gradient(ellipse 70% 50% at 100% 40%, var(--wm-glow-tr), transparent 55%),
                radial-gradient(ellipse 60% 50% at 0% 70%, var(--wm-glow-bl), transparent 50%);
        }

        .glass {
            background: var(--wm-glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--wm-glass-edge);
        }

        .glass-card {
            background: linear-gradient(145deg, var(--wm-glass-card-a) 0%, var(--wm-glass-card-b) 100%);
            border: 1px solid var(--wm-glass-card-border);
            backdrop-filter: blur(12px);
        }

        .ring-glow {
            box-shadow:
                0 0 0 1px var(--wm-ring-a),
                0 24px 80px -12px var(--wm-ring-b),
                0 0 120px -40px var(--wm-ring-c);
        }

        .bento-hover {
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease;
        }
        .bento-hover:hover {
            transform: translateY(-4px);
            border-color: rgba(202, 138, 4, 0.35);
            box-shadow: 0 20px 50px -20px var(--wm-bento-hover-shadow);
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-fade-up { animation: none !important; opacity: 1 !important; transform: none !important; }
            .animate-pulse-slow { animation: none !important; }
        }
    </style>
</head>
<body class="mesh min-h-screen text-zinc-900 antialiased overflow-x-hidden dark:text-white">

    <header class="sticky top-0 z-50 border-b border-zinc-200/90 bg-white/85 backdrop-blur-xl dark:border-white/[0.08] dark:bg-zinc-950/80">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-brand to-amber-600 text-sm font-extrabold tracking-tight text-white shadow-lg shadow-brand/35 transition group-hover:scale-105">CM</span>
                <span class="font-display text-lg font-bold tracking-tight text-zinc-900 dark:text-white">{{ config('app.name', 'Chamanage') }}</span>
            </a>
            <div class="flex items-center justify-end gap-2 sm:gap-2.5">
                <div class="hidden shrink-0 rounded-lg border border-zinc-200/80 bg-zinc-50 p-0.5 sm:inline-flex dark:border-white/10 dark:bg-white/5">
                    <a href="{{ route('locale.switch', ['locale' => 'lv']) }}" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition {{ app()->isLocale('lv') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white' }}">{{ __('locale.lv') }}</a>
                    <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition {{ app()->isLocale('en') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white' }}">{{ __('locale.en') }}</a>
                </div>
                <button type="button" id="welcome-theme-toggle"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-zinc-200/90 bg-white text-amber-600 shadow-sm transition hover:border-amber-300 hover:bg-amber-50 dark:border-white/10 dark:bg-white/5 dark:text-amber-300 dark:hover:border-amber-500/40 dark:hover:bg-white/10"
                        title="{{ __('theme.light') }} / {{ __('theme.dark') }}">
                    <svg class="hidden h-5 w-5 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="h-5 w-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <a href="{{ route('login') }}" class="hidden rounded-xl px-3 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:text-white/85 dark:hover:bg-white/10 sm:inline-flex sm:px-4">
                    {{ __('welcome.nav_login') }}
                </a>
                <a href="{{ route('register') }}"
                   class="hidden rounded-xl bg-brand px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-brand/30 transition hover:bg-brand-dark hover:shadow-brand/40 sm:inline-flex sm:px-5 sm:py-2.5">
                    {{ __('welcome.nav_register') }}
                </a>
                <button type="button"
                        id="welcome-mobile-menu-toggle"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-700 shadow-sm transition hover:bg-zinc-50 sm:hidden dark:border-white/15 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-zinc-800"
                        aria-controls="welcome-mobile-menu"
                        aria-expanded="false"
                        aria-label="Toggle navigation menu">
                    <svg id="welcome-mobile-menu-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="welcome-mobile-menu-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="hidden h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="welcome-mobile-menu" class="hidden border-t border-zinc-200/90 bg-white/95 px-4 py-3 sm:hidden dark:border-white/10 dark:bg-zinc-950/95">
            <div class="mb-3 inline-flex rounded-lg border border-zinc-200/80 bg-zinc-50 p-0.5 dark:border-white/10 dark:bg-white/5">
                <a href="{{ route('locale.switch', ['locale' => 'lv']) }}" class="rounded-md px-3 py-1.5 text-xs font-semibold transition {{ app()->isLocale('lv') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white' }}">{{ __('locale.lv') }}</a>
                <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="rounded-md px-3 py-1.5 text-xs font-semibold transition {{ app()->isLocale('en') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white' }}">{{ __('locale.en') }}</a>
            </div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-white/15 dark:bg-white/[0.04] dark:text-white dark:hover:bg-white/10">
                    {{ __('welcome.nav_login') }}
                </a>
                <a href="{{ route('register') }}" class="inline-flex w-full items-center justify-center rounded-xl bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand/30 transition hover:bg-brand-dark hover:shadow-brand/40">
                    {{ __('welcome.nav_register') }}
                </a>
            </div>
        </div>
    </header>

    <main>
        {{-- Hero --}}
        <section class="relative mx-auto max-w-6xl px-4 pb-24 pt-14 sm:px-6 lg:px-8 lg:pb-32 lg:pt-20">
            <div class="lg:grid lg:grid-cols-2 lg:items-center lg:gap-16 xl:gap-20">
                <div class="animate-fade-up opacity-0 [animation-fill-mode:forwards]">
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white/90 px-4 py-1.5 font-display text-[11px] font-semibold uppercase tracking-[0.2em] text-amber-800 dark:border-white/10 dark:bg-white/[0.06] dark:text-amber-200/95">
                        {{ __('welcome.hero_kicker') }}
                    </p>
                    <h1 class="font-display text-4xl font-extrabold leading-[1.08] tracking-tight text-zinc-900 sm:text-5xl xl:text-6xl dark:text-white">
                        {{ __('welcome.hero_line1') }}
                        <span class="bg-gradient-to-r from-amber-700 via-brand to-amber-600 bg-clip-text text-transparent dark:from-amber-100 dark:via-brand dark:to-amber-300">{{ __('welcome.hero_gradient') }}</span>
                    </h1>
                    <p class="mt-6 max-w-lg text-base leading-relaxed text-zinc-600 sm:text-lg dark:text-white/60">
                        {{ __('welcome.hero_sub') }}
                    </p>
                    <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-brand px-8 py-4 font-display text-[15px] font-bold text-white shadow-xl shadow-brand/35 transition hover:bg-brand-dark hover:shadow-brand/45">
                            {{ __('welcome.cta_create') }}
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-zinc-200 bg-white px-8 py-4 font-medium text-zinc-800 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-white/15 dark:bg-white/[0.04] dark:text-white/90 dark:hover:border-white/25 dark:hover:bg-white/[0.08]">
                            {{ __('welcome.cta_have_account') }}
                        </a>
                    </div>
                    <dl class="mt-12 grid grid-cols-3 gap-4 border-t border-zinc-200 pt-10 dark:border-white/10 sm:max-w-md">
                        <div>
                            <dt class="text-[11px] font-medium uppercase tracking-wider text-zinc-500 dark:text-white/40">{{ __('welcome.stat_modules') }}</dt>
                            <dd class="font-display mt-1 text-2xl font-bold text-zinc-900 dark:text-white">6+</dd>
                        </div>
                        <div>
                            <dt class="text-[11px] font-medium uppercase tracking-wider text-zinc-500 dark:text-white/40">{{ __('welcome.stat_pdf') }}</dt>
                            <dd class="font-display mt-1 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('welcome.stat_yes') }}</dd>
                        </div>
                        <div>
                            <dt class="text-[11px] font-medium uppercase tracking-wider text-zinc-500 dark:text-white/40">{{ __('welcome.stat_roles') }}</dt>
                            <dd class="font-display mt-1 text-2xl font-bold text-zinc-900 dark:text-white">2</dd>
                        </div>
                    </dl>
                </div>

                {{-- Visual: app frame --}}
                <div class="relative mx-auto mt-16 w-full max-w-lg lg:mx-0 lg:mt-0">
                    <div class="absolute -inset-1 rounded-[28px] bg-gradient-to-br from-brand/50 via-amber-500/20 to-transparent opacity-60 blur-xl animate-pulse-slow"></div>
                    <div class="relative ring-glow rounded-3xl p-[1px]">
                        <div class="overflow-hidden rounded-[22px] glass">
                            <div class="flex items-center gap-2 border-b border-zinc-200 px-4 py-3 dark:border-white/10">
                                <div class="flex gap-1.5">
                                    <span class="h-3 w-3 rounded-full bg-red-400/90"></span>
                                    <span class="h-3 w-3 rounded-full bg-amber-400/90"></span>
                                    <span class="h-3 w-3 rounded-full bg-emerald-400/90"></span>
                                </div>
                                <span class="ml-2 text-[11px] text-zinc-400 dark:text-white/35">{{ __('welcome.preview_label') }}</span>
                            </div>
                            <div class="p-5 sm:p-6">
                                <div class="mb-6 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-xs text-zinc-500 dark:text-white/40">{{ __('welcome.preview_income') }}</p>
                                        <p class="font-display mt-1 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">€24 580</p>
                                    </div>
                                    <span class="rounded-lg border border-emerald-600/25 bg-emerald-500/10 px-2 py-1 text-xs font-semibold text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/15 dark:text-emerald-300">+12%</span>
                                </div>
                                <div class="mb-6 flex h-24 items-end justify-between gap-1.5 rounded-xl bg-zinc-100 px-3 pb-2 pt-4 dark:bg-white/[0.04]">
                                    @foreach ([40, 65, 45, 80, 55, 90, 70, 85, 60, 95, 75, 88] as $h)
                                        <div class="w-full rounded-sm bg-gradient-to-t from-brand/80 to-amber-400/50" style="height: {{ $h }}%"></div>
                                    @endforeach
                                </div>
                                <div class="space-y-2">
                                    @foreach ([__('welcome.demo_row1'), __('welcome.demo_row2'), __('welcome.demo_row3')] as $row)
                                        <div class="flex items-center justify-between rounded-xl border border-zinc-200/80 bg-white px-3 py-2.5 text-xs text-zinc-700 dark:border-white/[0.06] dark:bg-white/[0.04] dark:text-white/75">
                                            <span>{{ $row }}</span>
                                            <span class="text-zinc-400 dark:text-white/30">→</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Bento --}}
        <section id="features" class="border-t border-zinc-200 bg-zinc-100/90 py-20 dark:border-white/[0.07] dark:bg-black/30">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="font-display text-3xl font-extrabold tracking-tight text-zinc-900 sm:text-4xl dark:text-white">{{ __('welcome.bento_heading') }}</h2>
                    <p class="mt-3 text-zinc-600 dark:text-white/50">{{ __('welcome.bento_sub') }}</p>
                </div>

                <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 lg:gap-5">
                    <article class="bento-hover glass-card group relative overflow-hidden rounded-3xl p-7 sm:col-span-2 lg:row-span-1">
                        <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-brand/15 blur-3xl transition group-hover:bg-brand/25"></div>
                        <div class="relative">
                            <span class="inline-flex rounded-lg border border-zinc-200 bg-white/80 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-amber-800 dark:border-white/10 dark:bg-white/[0.06] dark:text-amber-200/90">{{ __('welcome.card_team_kicker') }}</span>
                            <h3 class="font-display mt-4 text-xl font-bold text-zinc-900 sm:text-2xl dark:text-white">{{ __('welcome.card_team_title') }}</h3>
                            <p class="mt-3 max-w-xl text-sm leading-relaxed text-zinc-600 dark:text-white/55">
                                {{ __('welcome.card_team_text') }}
                            </p>
                        </div>
                    </article>

                    <article class="bento-hover glass-card rounded-3xl p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand/20 text-brand">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="font-display mt-4 text-lg font-bold text-zinc-900 dark:text-white">{{ __('welcome.card_docs_title') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-white/50">{{ __('welcome.card_docs_text') }}</p>
                    </article>

                    <article class="bento-hover glass-card rounded-3xl p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand/20 text-brand">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-display mt-4 text-lg font-bold text-zinc-900 dark:text-white">{{ __('welcome.card_reports_title') }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-white/50">{{ __('welcome.card_reports_text') }}</p>
                    </article>

                    <article class="bento-hover glass-card rounded-3xl p-7 sm:col-span-2 lg:col-span-2">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="font-display text-lg font-bold text-zinc-900 dark:text-white">{{ __('welcome.card_stock_title') }}</h3>
                                <p class="mt-2 text-sm text-zinc-600 dark:text-white/50">{{ __('welcome.card_stock_text') }}</p>
                            </div>
                            <div class="group shrink-0 inline-flex max-w-[15rem] items-center gap-3 rounded-2xl border border-amber-400/35 bg-gradient-to-br from-amber-100/90 to-white px-4 py-3 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] ring-1 ring-zinc-200/80 transition hover:border-amber-500/50 sm:max-w-[17rem] dark:border-amber-400/20 dark:from-amber-500/[0.12] dark:to-white/[0.03] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.06)] dark:ring-white/5 dark:hover:border-amber-400/35 dark:hover:from-amber-500/[0.18]">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-800 shadow-sm ring-1 ring-amber-200/80 group-hover:bg-amber-50 dark:bg-white/10 dark:text-amber-200 dark:ring-white/10 dark:group-hover:bg-white/[0.14]" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m9 4.5h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9 9h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5"/></svg>
                                </span>
                                <p class="text-left text-[13px] font-semibold leading-snug text-zinc-800 sm:text-sm dark:text-white/90">{{ __('welcome.card_stock_callout') }}</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-[28px] border border-zinc-200 bg-gradient-to-br from-white via-zinc-50 to-zinc-100 px-8 py-14 shadow-2xl sm:px-12 dark:border-white/10 dark:from-zinc-900 dark:via-zinc-950 dark:to-black">
                    <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand/20 blur-3xl dark:bg-brand/25"></div>
                    <div class="pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-amber-400/15 blur-3xl dark:bg-amber-500/10"></div>
                    <div class="relative mx-auto max-w-2xl text-center">
                        <h2 class="font-display text-2xl font-extrabold text-zinc-900 sm:text-3xl dark:text-white">{{ __('welcome.cta2_title') }}</h2>
                        <p class="mt-3 text-sm text-zinc-600 sm:text-base dark:text-white/55">{{ __('welcome.cta2_sub') }}</p>
                        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                            <a href="{{ route('register') }}" class="inline-flex w-full justify-center rounded-2xl bg-brand px-8 py-3.5 font-display font-bold text-white shadow-lg shadow-brand/30 transition hover:bg-brand-dark sm:w-auto">
                                {{ __('welcome.cta2_register') }}
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex w-full justify-center rounded-2xl border border-zinc-200 bg-white px-8 py-3.5 font-semibold text-zinc-800 transition hover:bg-zinc-50 sm:w-auto dark:border-white/15 dark:bg-white/[0.05] dark:text-white dark:hover:bg-white/10">
                                {{ __('welcome.cta2_login') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 py-10 text-center text-xs text-zinc-500 dark:border-white/[0.08] dark:text-white/35">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Chamanage') }}</p>
    </footer>

    <script>
        document.getElementById('welcome-theme-toggle').addEventListener('click', function () {
            var root = document.documentElement;
            root.classList.toggle('dark');
            localStorage.setItem('theme', root.classList.contains('dark') ? 'dark' : 'light');
        });

        (function () {
            var toggle = document.getElementById('welcome-mobile-menu-toggle');
            var menu = document.getElementById('welcome-mobile-menu');
            var iconOpen = document.getElementById('welcome-mobile-menu-open');
            var iconClose = document.getElementById('welcome-mobile-menu-close');
            if (!toggle || !menu || !iconOpen || !iconClose) {
                return;
            }

            function setMenuState(open) {
                menu.classList.toggle('hidden', !open);
                iconOpen.classList.toggle('hidden', open);
                iconClose.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            toggle.addEventListener('click', function () {
                var isOpen = toggle.getAttribute('aria-expanded') === 'true';
                setMenuState(!isOpen);
            });

            menu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    setMenuState(false);
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setMenuState(false);
                }
            });
        })();
    </script>
</body>
</html>
