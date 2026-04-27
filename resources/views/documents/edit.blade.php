@extends('layouts.app')

@section('title', __('form.document.edit_title') . ' — ' . config('app.name'))

@section('content')

@include('partials.catalog-ui-styles')

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow">{{ __('page.documents.badge') }}</span>
                        <span class="count-pill">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            ID {{ $document->id }}
                        </span>
                    </div>
                    <h1 class="pg-title" style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);">{{ __('form.document.edit_title') }}</h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 560px;">{{ __('form.document.edit_sub') }}</p>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;">
                    <a href="{{ route('documents.copy', $document) }}" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2h-8a2 2 0 01-2-2V7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 17V5a2 2 0 012-2h8"/></svg>
                        {{ __('form.document.copy_as_new') }}
                    </a>
                    <a href="{{ route('documents.index') }}" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7"/></svg>
                        {{ __('form.back') }}
                    </a>
                </div>
            </div>
        </header>

        <div class="main-card">
            <div style="padding: 28px 24px 32px;">
                @include('documents._document_form', ['document' => $document])
            </div>
        </div>
    </div>
</div>

@endsection
