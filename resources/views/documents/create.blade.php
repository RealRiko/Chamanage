@extends('layouts.app')

@section('title', __('form.document.create_title') . ' — ' . config('app.name'))

@section('content')

@include('partials.catalog-ui-styles')

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow">{{ __('page.documents.badge') }}</span>
                    </div>
                    <h1 class="pg-title" style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);">{{ __('form.document.create_title') }}</h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 560px;">{{ __('form.document.create_sub') }}</p>
                </div>
                <a href="{{ route('documents.index') }}" class="btn-ghost">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7"/></svg>
                    {{ __('form.back') }}
                </a>
            </div>
        </header>

        <div class="main-card">
            <div style="padding: 28px 24px 32px;">
                @include('documents._document_form')
            </div>
        </div>
    </div>
</div>

@endsection
