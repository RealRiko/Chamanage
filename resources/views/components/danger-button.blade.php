<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl border border-red-600 bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-red-500 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/60 focus:ring-offset-2 dark:border-red-500 dark:bg-red-600 dark:hover:bg-red-500']) }}>
    {{ $slot }}
</button>
