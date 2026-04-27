@extends('layouts.app')

@section('title', __('profile.page_title') . ' — ' . config('app.name'))

@section('content')
    <div class="app-shell">
        <x-page-header :title="__('profile.settings_heading')" :subtitle="__('profile.settings_sub')" :badge="__('profile.page_title')" />

        <div class="space-y-8">
            <div class="app-panel animate-slide-up">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="app-panel animate-slide-up delay-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="app-panel">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
