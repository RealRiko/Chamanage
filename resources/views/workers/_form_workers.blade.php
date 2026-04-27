@php
    $isEdit = isset($worker);
@endphp

<form action="{{ $isEdit ? route('workers.update', $worker) : route('workers.store') }}" method="POST" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="form-label">{{ __('form.worker.label_name') }} <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                value="{{ old('name', $worker->name ?? '') }}"
                class="form-input @error('name') border-red-500 ring-1 ring-red-500/30 @enderror">
            @error('name')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="surname" class="form-label">{{ __('form.worker.label_surname') }} <span class="text-red-500">*</span></label>
            <input type="text" name="surname" id="surname" required
                value="{{ old('surname', $worker->surname ?? '') }}"
                class="form-input @error('surname') border-red-500 ring-1 ring-red-500/30 @enderror">
            @error('surname')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label for="email" class="form-label">{{ __('form.worker.label_email') }} <span class="text-red-500">*</span></label>
        <input type="email" name="email" id="email" required
            value="{{ old('email', $worker->email ?? '') }}"
            class="form-input @error('email') border-red-500 ring-1 ring-red-500/30 @enderror">
        @error('email')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="password" class="form-label">
                {{ $isEdit ? __('form.worker.label_password_new') : __('form.worker.label_password') }}
                @if (! $isEdit)<span class="text-red-500">*</span>@endif
            </label>
            <input type="password" name="password" id="password"
                placeholder="{{ $isEdit ? __('form.worker.placeholder_password_edit') : '' }}"
                class="form-input @error('password') border-red-500 ring-1 ring-red-500/30 @enderror"
                {{ $isEdit ? '' : 'required' }}>
            @error('password')<p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">{{ __('form.worker.label_password_confirm') }} @if (! $isEdit)<span class="text-red-500">*</span>@endif</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                placeholder="{{ $isEdit ? __('form.worker.placeholder_password_edit') : '' }}"
                class="form-input"
                {{ $isEdit ? '' : 'required' }}>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200/80 pt-8 sm:flex-row sm:items-center sm:justify-between dark:border-white/10">
        <a href="{{ route('workers.index') }}" class="btn-secondary justify-center sm:justify-start">
            ← {{ __('form.back') }}
        </a>
        <button type="submit" class="btn-primary px-8 py-3">
            {{ $isEdit ? __('form.worker.submit_update') : __('form.worker.submit_create') }}
        </button>
    </div>
</form>
