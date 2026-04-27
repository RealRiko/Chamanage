<section class="space-y-6" x-data="{ confirmingDelete: @js($errors->userDeletion->isNotEmpty()) }">
    <header>
        <h2 class="font-display text-xl font-bold text-zinc-900 dark:text-white">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button class="rounded-xl px-5 py-2.5 text-sm font-semibold normal-case tracking-normal"
        x-data=""
        x-on:click.prevent="confirmingDelete = true; $nextTick(() => $refs.deletePassword?.focus())"
    >{{ __('Delete Account') }}</x-danger-button>

    <div x-cloak x-show="confirmingDelete" x-transition
         class="rounded-2xl border border-red-200/80 bg-red-50/70 p-6 dark:border-red-500/30 dark:bg-red-950/30">
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <h2 class="font-display text-lg font-bold text-zinc-900 dark:text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <p class="mt-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label class="sr-only" for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    x-ref="deletePassword"
                    class="form-input max-w-md placeholder:text-zinc-400 dark:placeholder:text-zinc-500"
                    placeholder="{{ __('Password') }}"
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <button type="button" class="btn-secondary" x-on:click="confirmingDelete = false">
                    {{ __('Cancel') }}
                </button>
                <x-danger-button class="rounded-xl px-5 py-2.5 text-sm font-semibold normal-case tracking-normal">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</section>
