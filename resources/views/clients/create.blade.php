@extends('layouts.app')

@section('title', __('form.client.create_title') . ' — ' . config('app.name'))

@section('content')

@include('partials.edit-form-page-styles')

<div class="edit-page">
    <div style="max-width: 740px; margin: 0 auto; padding: 40px 24px 64px;">

        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('clients.index') }}">{{ __('page.clients.badge') }}</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span>{{ __('form.client.create_title') }}</span>
        </nav>

        <header style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:28px; flex-wrap:wrap;">
            <div>
                <span class="ep-eyebrow">{{ __('page.clients.badge') }}</span>
                <h1 class="ep-title" style="margin-top:8px;">{{ __('form.client.create_title') }}</h1>
                <p class="ep-subtitle" style="margin-top:6px;">{{ __('form.client.create_sub') }}</p>
            </div>
            <a href="{{ route('clients.index') }}" class="btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('form.back') }}
            </a>
        </header>

        <div class="form-panel">
            <div class="form-panel-accent"></div>

            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="error-banner" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <strong style="display:block; margin-bottom:4px;">{{ __('form.errors_found') }}</strong>
                            <ul style="margin:0; padding-left:16px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="form-body">
                    @if (session('success'))
                        <div class="success-banner" role="status">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @include('clients._client_fields')
                </div>

                <div class="form-footer">
                    <p style="font-size:12px; color:#a8a29e; margin:0;">
                        <span style="display:inline-block; width:5px; height:5px; border-radius:50%; background:#b45309; vertical-align:middle; margin-right:5px; margin-bottom:1px;"></span>
                        {{ __('form.required_fields') }}
                    </p>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <a href="{{ route('clients.index') }}" class="btn-back">{{ __('form.back') }}</a>
                        <button type="submit" class="btn-save">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            {{ __('form.client.submit_create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
