@extends('layouts.app')

@section('title', __('form.worker.create_title') . ' — ' . config('app.name'))

@section('content')
<div class="app-shell">
    <x-page-header :title="__('form.worker.create_title')" :subtitle="__('form.worker.create_sub')" :badge="__('page.workers.badge')">
        <x-slot name="actions">
            <a href="{{ route('workers.index') }}" class="btn-secondary">{{ __('form.back') }}</a>
        </x-slot>
    </x-page-header>

    <div class="app-panel mx-auto max-w-3xl">
        @include('workers._form_workers')
    </div>
</div>
@endsection
