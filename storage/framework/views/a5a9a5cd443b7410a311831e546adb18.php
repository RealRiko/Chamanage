<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('auth.login_title')); ?> — <?php echo e(config('app.name', 'Chamanage')); ?></title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { brand: { DEFAULT: '#CA8A04', dark: '#A16207' } },
                },
            },
        };
    </script>
    <script>
        (() => {
            const storedTheme = localStorage.getItem('theme');
            const preferDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const useDark = storedTheme ? storedTheme === 'dark' : preferDark;

            if (useDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', system-ui, sans-serif; }
        body.auth-page {
            background-color: #f5f2ec;
            background-image:
                linear-gradient(rgba(202, 138, 4, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(202, 138, 4, 0.06) 1px, transparent 1px);
            background-size: 64px 64px;
            background-position: center top;
        }
        body.auth-page::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(ellipse 100% 55% at 50% -25%, rgba(202, 138, 4, 0.16), transparent 55%),
                radial-gradient(ellipse 70% 45% at 100% 35%, rgba(245, 158, 11, 0.1), transparent 52%),
                radial-gradient(ellipse 55% 45% at 0% 75%, rgba(202, 138, 4, 0.06), transparent 50%);
        }
        .dark body.auth-page {
            background-color: #050505;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 64px 64px;
            background-position: center top;
        }
        .dark body.auth-page::before {
            background:
                radial-gradient(ellipse 100% 60% at 50% -30%, rgba(202, 138, 4, 0.45), transparent 58%),
                radial-gradient(ellipse 70% 50% at 100% 40%, rgba(245, 158, 11, 0.12), transparent 55%),
                radial-gradient(ellipse 60% 50% at 0% 70%, rgba(202, 138, 4, 0.1), transparent 50%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 25px 60px -30px rgba(24, 24, 27, 0.35);
        }
        .dark .glass {
            background: rgba(9, 9, 11, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="auth-page min-h-screen text-zinc-900 antialiased transition-colors dark:text-white">

    <header class="relative z-20 border-b border-zinc-200/80 dark:border-white/10">
        <div class="mx-auto flex max-w-lg items-center justify-between gap-4 px-4 py-5 sm:px-6">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-base font-bold tracking-tight">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand to-amber-600 text-xs font-extrabold shadow-lg shadow-brand/30">CM</span>
                <span><?php echo e(config('app.name', 'Chamanage')); ?></span>
            </a>
            <div class="flex items-center gap-3">
                <div class="inline-flex rounded-lg border border-zinc-200/80 bg-zinc-50 p-0.5 dark:border-white/10 dark:bg-white/5">
                    <a href="<?php echo e(route('locale.switch', ['locale' => 'lv'])); ?>" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition <?php echo e(app()->isLocale('lv') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white'); ?>"><?php echo e(__('locale.lv')); ?></a>
                    <a href="<?php echo e(route('locale.switch', ['locale' => 'en'])); ?>" class="rounded-md px-2.5 py-1.5 text-xs font-semibold transition <?php echo e(app()->isLocale('en') ? 'bg-white text-sienna shadow-sm dark:bg-white/20 dark:text-amber-300' : 'text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white'); ?>"><?php echo e(__('locale.en')); ?></a>
                </div>
                <button type="button" id="theme-toggle"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200/90 bg-white text-amber-600 shadow-sm transition hover:border-amber-300 hover:bg-amber-50 dark:border-white/10 dark:bg-white/5 dark:text-amber-300 dark:hover:border-amber-500/40 dark:hover:bg-white/10"
                    title="<?php echo e(__('theme.dark')); ?>">
                    <svg id="theme-icon-sun" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg id="theme-icon-moon" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <a href="<?php echo e(route('register')); ?>" class="text-sm font-medium text-zinc-700 transition hover:text-zinc-900 dark:text-white/80 dark:hover:text-white"><?php echo e(__('auth.sign_up_link')); ?></a>
            </div>
        </div>
    </header>

    <main class="relative z-10 flex min-h-[calc(100vh-5rem)] items-center justify-center px-4 py-10 sm:px-6">
        <div class="w-full max-w-md">
            <div class="glass rounded-3xl p-8 shadow-2xl sm:p-10">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                        <span class="bg-gradient-to-r from-amber-200 via-brand to-amber-300 bg-clip-text text-transparent"><?php echo e(__('auth.welcome_back')); ?></span>
                    </h1>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-white/55"><?php echo e(__('auth.subtitle')); ?></p>
                </div>

                <?php if(session('status')): ?>
                    <div class="mb-6 rounded-xl border border-amber-300/70 bg-amber-50/90 px-4 py-3 text-sm text-amber-900 dark:border-amber-400/30 dark:bg-amber-500/15 dark:text-amber-100" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-white/70"><?php echo e(__('auth.email')); ?></label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username"
                            class="w-full rounded-xl border border-zinc-300/80 bg-white/85 px-4 py-3.5 text-zinc-900 shadow-inner placeholder:text-zinc-400 transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/40 dark:border-white/20 dark:bg-white/10 dark:text-white dark:placeholder:text-white/35 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400/70 ring-2 ring-red-500/40 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="you@company.com" />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-white/70"><?php echo e(__('auth.password')); ?></label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-xl border border-zinc-300/80 bg-white/85 px-4 py-3.5 text-zinc-900 shadow-inner placeholder:text-zinc-400 transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/40 dark:border-white/20 dark:bg-white/10 dark:text-white dark:placeholder:text-white/35 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400/70 ring-2 ring-red-500/40 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••" />
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 dark:text-red-300"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <label class="inline-flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/30 bg-white/10 text-brand focus:ring-brand focus:ring-offset-0 focus:ring-offset-transparent">
                            <span class="text-sm text-zinc-600 dark:text-white/65"><?php echo e(__('auth.remember')); ?></span>
                        </label>
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-medium text-amber-300/90 transition hover:text-amber-200"><?php echo e(__('auth.forgot')); ?></a>
                        <?php endif; ?>
                    </div>

                    <button type="submit"
                        class="mt-2 flex w-full items-center justify-center rounded-xl bg-brand py-3.5 text-base font-bold text-white shadow-lg shadow-brand/30 transition hover:bg-brand-dark focus:outline-none focus:ring-4 focus:ring-brand/40">
                        <?php echo e(__('auth.sign_in')); ?>

                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-zinc-600 dark:text-white/50">
                    <?php echo e(__('auth.new_here')); ?>

                    <a href="<?php echo e(route('register')); ?>" class="font-semibold text-amber-300 transition hover:text-amber-200"><?php echo e(__('auth.create_account')); ?></a>
                </p>
            </div>

            <p class="mt-8 text-center text-xs text-zinc-500 dark:text-white/35">
                <a href="<?php echo e(route('home')); ?>" class="transition hover:text-zinc-700 dark:hover:text-white/55"><?php echo e(__('auth.back_home')); ?></a>
            </p>
        </div>
    </main>
    <script>
        (() => {
            const root = document.documentElement;
            const toggle = document.getElementById('theme-toggle');
            const sun = document.getElementById('theme-icon-sun');
            const moon = document.getElementById('theme-icon-moon');
            const darkTitle = <?php echo \Illuminate\Support\Js::from(__('theme.dark'))->toHtml() ?>;
            const lightTitle = <?php echo \Illuminate\Support\Js::from(__('theme.light'))->toHtml() ?>;

            const syncIcons = () => {
                const isDark = root.classList.contains('dark');
                sun.classList.toggle('hidden', isDark);
                moon.classList.toggle('hidden', !isDark);
                toggle.title = isDark ? lightTitle : darkTitle;
            };

            toggle.addEventListener('click', () => {
                const isDark = root.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                syncIcons();
            });

            syncIcons();
        })();
    </script>
</body>
</html>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/auth/login.blade.php ENDPATH**/ ?>