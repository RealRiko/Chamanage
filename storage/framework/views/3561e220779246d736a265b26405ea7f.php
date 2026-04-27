<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
      class="transition-colors duration-300"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark'
              || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          mobileMenu: false
      }"
      x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        $watch('darkMode', (value) => {
            if (value) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
      ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', config('app.name', 'Chamanage')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .text-amber-sienna { color: #CA8A04; }
        .border-amber-sienna { border-color: #CA8A04; }
        .bg-amber-sienna { background-color: #CA8A04; }
        .hover\:bg-amber-sienna:hover { background-color: #A16207; }
    </style>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="min-h-screen overflow-x-hidden">

<nav class="sticky top-0 z-50 border-b border-zinc-200/80 bg-white/90 backdrop-blur-xl dark:border-white/[0.08] dark:bg-zinc-950/80 dark:backdrop-blur-xl">
    <div class="mx-auto flex min-h-14 max-w-7xl items-center justify-between gap-3 px-4 py-2.5 sm:px-6 lg:gap-5 lg:px-8">
        
        <div class="flex min-w-0 shrink-0 items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="group flex items-center gap-2.5 sm:gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sienna to-amber-600 text-xs font-extrabold tracking-tight text-white shadow-md shadow-sienna/25 transition group-hover:scale-[1.02] sm:h-10 sm:w-10 sm:text-sm">CM</span>
                <span class="font-display truncate text-base font-bold tracking-tight text-zinc-900 dark:text-white sm:text-lg"><?php echo e(config('app.name')); ?></span>
            </a>
        </div>

        <?php if(auth()->guard()->check()): ?>
            
            <div class="hidden min-w-0 flex-1 items-center lg:flex">
                <div class="scrollbar-hide -mx-1 flex max-w-full flex-nowrap items-center gap-1 overflow-x-auto px-1 sm:gap-1.5">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('dashboard') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.home')); ?></a>
                    <a href="<?php echo e(route('products.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('products.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.products')); ?></a>
                    <a href="<?php echo e(route('inventory.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('inventory.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.storage')); ?></a>
                    <a href="<?php echo e(route('clients.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('clients.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.clients')); ?></a>
                    <a href="<?php echo e(route('documents.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('documents.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.documents')); ?></a>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('invoices.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.invoices')); ?></a>
                    <a href="<?php echo e(route('reports.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('reports.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.reports')); ?></a>
                    <a href="<?php echo e(route('workers.index')); ?>" class="nav-link-app shrink-0 <?php echo e(request()->routeIs('workers.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.workers')); ?></a>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex shrink-0 items-center gap-2 sm:gap-2.5">
            <div class="inline-flex rounded-lg border border-zinc-200/80 bg-zinc-50 p-0.5 dark:border-white/10 dark:bg-white/5">
                <a href="<?php echo e(route('locale.switch', ['locale' => 'lv'])); ?>" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition <?php echo e(app()->isLocale('lv') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white'); ?>"><?php echo e(__('locale.lv')); ?></a>
                <a href="<?php echo e(route('locale.switch', ['locale' => 'en'])); ?>" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition <?php echo e(app()->isLocale('en') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white'); ?>"><?php echo e(__('locale.en')); ?></a>
            </div>

            <button type="button" x-on:click="darkMode = !darkMode"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-zinc-200/90 bg-white text-amber-600 shadow-sm transition hover:border-amber-300 hover:bg-amber-50 dark:border-white/10 dark:bg-white/5 dark:text-amber-300 dark:hover:border-amber-500/40 dark:hover:bg-white/10 sm:h-10 sm:w-10"
                    :title="darkMode ? <?php echo \Illuminate\Support\Js::from(__('theme.light'))->toHtml() ?> : <?php echo \Illuminate\Support\Js::from(__('theme.dark'))->toHtml() ?>">
                <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg x-show="darkMode" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>

            <?php if(auth()->guard()->check()): ?>
                <div class="relative hidden sm:block">
                    <button type="button" x-on:click="$refs.dropdown.classList.toggle('hidden')"
                            class="inline-flex max-w-[14rem] items-center gap-2 rounded-lg border border-zinc-200/80 bg-zinc-50/90 px-3 py-1.5 text-left transition hover:bg-zinc-100 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10">
                        <span class="truncate text-sm font-medium text-zinc-800 dark:text-zinc-100"><?php echo e(Auth::user()->name); ?></span>
                        <svg class="h-4 w-4 shrink-0 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-ref="dropdown"
                         class="absolute right-0 z-30 mt-2 hidden w-52 rounded-xl border border-zinc-200 bg-white py-1 shadow-xl dark:border-white/10 dark:bg-zinc-950/95 dark:backdrop-blur-xl">
                        <a href="<?php echo e(route('profile.edit')); ?>"
                           class="block px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50 dark:text-zinc-200 dark:hover:bg-white/10"><?php echo e(__('nav.profile')); ?></a>
                        <?php if(method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.companySettings')); ?>"
                               class="block px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50 dark:text-zinc-200 dark:hover:bg-white/10 <?php echo e(request()->routeIs('admin.*') ? 'bg-zinc-50 font-semibold text-sienna dark:bg-white/10 dark:text-amber-400' : ''); ?>"><?php echo e(__('nav.admin')); ?></a>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="block w-full px-4 py-2.5 text-left text-sm text-zinc-700 hover:bg-zinc-50 dark:text-zinc-200 dark:hover:bg-white/10">
                                <?php echo e(__('nav.logout')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="hidden rounded-xl px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-white/10 sm:inline"><?php echo e(__('nav.login')); ?></a>
                <a href="<?php echo e(route('register')); ?>" class="hidden rounded-xl bg-sienna px-3 py-2 text-sm font-semibold text-white shadow-md shadow-sienna/25 hover:bg-sienna-dark sm:inline"><?php echo e(__('nav.register')); ?></a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <button type="button" @click="mobileMenu = !mobileMenu" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-700 shadow-sm hover:bg-zinc-50 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200 dark:hover:bg-white/10 lg:hidden" aria-expanded="false" :aria-expanded="mobileMenu">
                    <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenu" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex rounded-xl bg-sienna px-3 py-2 text-sm font-semibold text-white shadow-md sm:hidden"><?php echo e(__('nav.login')); ?></a>
            <?php endif; ?>
        </div>
    </div>

    
    <div x-show="mobileMenu" x-cloak x-transition
         class="border-t border-zinc-200 bg-white/95 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-950/98 lg:hidden">
        <div class="mx-auto max-w-7xl space-y-4 px-4 py-4 sm:px-6">
            <?php if(auth()->guard()->check()): ?>
                <nav class="flex flex-col gap-0.5" aria-label="<?php echo e(__('nav.menu')); ?>">
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('dashboard') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.home')); ?></a>
                    <a href="<?php echo e(route('products.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('products.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.products')); ?></a>
                    <a href="<?php echo e(route('inventory.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('inventory.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.storage')); ?></a>
                    <a href="<?php echo e(route('clients.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('clients.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.clients')); ?></a>
                    <a href="<?php echo e(route('documents.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('documents.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.documents')); ?></a>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('invoices.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.invoices')); ?></a>
                    <a href="<?php echo e(route('reports.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('reports.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.reports')); ?></a>
                    <a href="<?php echo e(route('workers.index')); ?>" class="nav-link-app block w-full <?php echo e(request()->routeIs('workers.*') ? 'nav-link-app-active' : ''); ?>"><?php echo e(__('nav.workers')); ?></a>
                </nav>
                <div class="border-t border-zinc-200 pt-3 dark:border-white/10 sm:hidden">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-white/10"><?php echo e(__('nav.profile')); ?></a>
                    <?php if(method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.companySettings')); ?>" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-white/10 <?php echo e(request()->routeIs('admin.*') ? 'font-semibold text-sienna dark:text-amber-400' : ''); ?>"><?php echo e(__('nav.admin')); ?></a>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="mt-1 w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-white/10"><?php echo e(__('nav.logout')); ?></button>
                    </form>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-200"><?php echo e(__('nav.login')); ?></a>
                <a href="<?php echo e(route('register')); ?>" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-sienna hover:bg-amber-50 dark:text-amber-400"><?php echo e(__('nav.register')); ?></a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="relative z-10 min-h-[calc(100vh-4rem)]">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<style>[x-cloak]{display:none!important}</style>
<?php echo $__env->make('partials.live-search-forms-script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/layouts/app.blade.php ENDPATH**/ ?>