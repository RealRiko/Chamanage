@extends('layouts.app')

@section('title', __('page.clients.title') . ' — ' . config('app.name'))

@section('content')
@php
    $hasClients = $clients->isNotEmpty();
@endphp

@include('partials.catalog-ui-styles')

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow">{{ __('page.clients.badge') }}</span>
                        @if ($hasClients)
                            <span class="count-pill">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                {{ $clients->count() }} {{ __('page.clients.stat_total') }}
                            </span>
                        @endif
                    </div>
                    <h1 class="pg-title">{{ __('page.clients.title') }}</h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 520px;">{{ __('page.clients.subtitle') }}</p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('dashboard') }}" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        {{ __('nav.home') }}
                    </a>
                    <a href="{{ route('clients.create') }}" class="btn-primary">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        {{ __('form.client.create_title') }}
                    </a>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success" role="status">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                {{ session('error') }}
            </div>
        @endif

        <div class="main-card">
            @if ($clients->isEmpty())
                <div style="padding: 24px;">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="32" height="32" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="empty-title">{{ __('page.clients.empty_title') }}</h3>
                        <p class="empty-hint">{{ __('page.clients.empty_hint') }}</p>
                        <div style="display: flex; justify-content: center;">
                            <a href="{{ route('clients.create') }}" class="btn-primary">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                {{ __('form.client.create_title') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="toolbar">
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center; width: 100%;">
                        <div class="search-wrap" style="max-width: 420px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input
                                id="live-search-input"
                                type="search"
                                autocomplete="off"
                                class="search-input"
                                placeholder="{{ __('page.clients.search_placeholder') }}"
                            >
                        </div>
                    </div>
                </div>

                <div style="padding: 24px; position: relative;">
                    <div id="loading-overlay" class="absolute inset-0 z-10 hidden items-center justify-center rounded-xl bg-white/80 backdrop-blur-sm dark:bg-zinc-900/80">
                        <div class="h-8 w-8 animate-spin rounded-full border-2 border-zinc-200 border-t-amber-600 dark:border-zinc-700 dark:border-t-amber-500"></div>
                    </div>

                    <div class="client-table">
                        <div class="data-table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('page.clients.col_name') }}</th>
                                        <th>{{ __('page.clients.col_email') }}</th>
                                        <th>{{ __('page.clients.col_phone') }}</th>
                                        <th style="text-align: right;">{{ __('page.products.col_actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="client-list-body">
                                    @foreach ($clients as $client)
                                        @php
                                            $initial = $client->name ? mb_strtoupper(mb_substr($client->name, 0, 1, 'UTF-8')) : '?';
                                        @endphp
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <div class="tbl-avatar">{{ $initial }}</div>
                                                    <div>
                                                        <div class="tbl-name">{{ $client->name }}</div>
                                                        <div class="tbl-id">#{{ $client->id }}</div>
                                                        <div class="tbl-id" style="opacity: .8;">
                                                            {{ __('page.meta.created_by', ['name' => trim(($client->creator->name ?? '') . ' ' . ($client->creator->surname ?? '')) ?: '—']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="color: #78716c;">{{ $client->email }}</td>
                                            <td><span style="color: #78716c;">{{ $client->phone ?? '—' }}</span></td>
                                            <td>
                                                <div style="display: flex; justify-content: flex-end; gap: 4px;">
                                                    <a href="{{ route('clients.edit', $client) }}" class="icon-btn" title="{{ __('page.action_edit') }}">
                                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="icon-btn danger client-delete-trigger"
                                                        title="{{ __('page.action_delete') }}"
                                                        data-client-id="{{ $client->id }}"
                                                        data-client-name="{{ e($client->name) }}"
                                                    >
                                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="deleteModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
    <div class="modal-box">
        <div class="modal-body">
            <div class="modal-danger-icon">
                <svg width="28" height="28" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="modal-title" id="delete-modal-title">{{ __('page.action_delete') }}</h3>
            <p class="modal-desc">{{ __('page.clients.delete_confirm') }}</p>
            <p class="modal-desc" style="margin-top: 10px;"><strong id="clientDeleteDisplay" class="modal-entity-name"></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDeleteModal()" class="modal-cancel">{{ __('page.action_cancel') }}</button>
            <form id="deleteForm" method="POST" style="flex: 1; display: flex;">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-delete" style="flex: 1;">{{ __('page.action_delete') }}</button>
            </form>
        </div>
    </div>
</div>

<script>
const clientSearchNone = @json(__('page.clients.search_none'));
const editLabel = @json(__('page.action_edit'));
const deleteLabel = @json(__('page.action_delete'));
const createdByPrefix = @json(__('page.meta.created_by_prefix'));
const clientModel = @json(\App\Models\Client::class);

function openDeleteModal(clientId, clientName) {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('open');
    document.getElementById('clientDeleteDisplay').textContent = clientName;
    document.getElementById('deleteForm').action = '/clients/' + encodeURIComponent(clientId);
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});

function escHtml(str) {
    const d = document.createElement('div');
    d.textContent = str == null ? '' : String(str);
    return d.innerHTML;
}
function escAttr(str) {
    return String(str == null ? '' : str)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('client-list-body');
    if (tbody) {
        tbody.addEventListener('click', function(e) {
            const btn = e.target.closest('.client-delete-trigger');
            if (!btn) return;
            openDeleteModal(btn.getAttribute('data-client-id'), btn.getAttribute('data-client-name'));
        });
    }

    const input = document.getElementById('live-search-input');
    if (!input) return;
    const loader = document.getElementById('loading-overlay');
    if (!tbody || !loader) return;
    const originalHTML = tbody.innerHTML;
    let timer;
    input.addEventListener('keydown', function(e) { if (e.key === 'Enter') e.preventDefault(); });
    input.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(async function() {
            const query = input.value.trim();
            if (!query) {
                loader.classList.add('hidden');
                tbody.innerHTML = originalHTML;
                return;
            }
            loader.classList.remove('hidden');
            try {
                const response = await fetch('/live-search?query=' + encodeURIComponent(query) + '&model=' + encodeURIComponent(clientModel));
                const data = await response.json();
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="padding: 24px; text-align: center; color: #78716c;">' + escHtml(clientSearchNone) + '</td></tr>';
                } else {
                    data.forEach(function(client) {
                        const rawName = client.name || '?';
                        const initial = rawName.length ? rawName.charAt(0).toUpperCase() : '?';
                        const id = client.id;
                        const name = client.name || '';
                        const creatorName = client.creator
                            ? [client.creator.name || '', client.creator.surname || ''].join(' ').trim()
                            : '';
                        const createdByText = (createdByPrefix || 'Created by') + ': ' + (creatorName || '—');
                        const email = client.email || '—';
                        const phone = client.phone || '—';
                        const row = document.createElement('tr');
                        row.innerHTML =
                            '<td><div style="display:flex;align-items:center;gap:12px;">' +
                            '<div class="tbl-avatar">' + escHtml(initial) + '</div>' +
                            '<div><div class="tbl-name">' + escHtml(name) + '</div><div class="tbl-id">#' + escHtml(String(id)) + '</div><div class="tbl-id" style="opacity:.8;">' + escHtml(createdByText) + '</div></div></div></td>' +
                            '<td style="color:#78716c;">' + escHtml(email) + '</td>' +
                            '<td><span style="color:#78716c;">' + escHtml(phone) + '</span></td>' +
                            '<td><div style="display:flex;justify-content:flex-end;gap:4px;">' +
                            '<a href="/clients/' + id + '/edit" class="icon-btn" title="' + escAttr(editLabel) + '">' +
                            '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>' +
                            '<button type="button" class="icon-btn danger client-delete-trigger" title="' + escAttr(deleteLabel) + '" data-client-id="' + id + '" data-client-name="' + escAttr(name) + '">' +
                            '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
                            '</div></td>';
                        tbody.appendChild(row);
                    });
                }
            } catch (err) {
                console.error('Search error:', err);
            } finally {
                loader.classList.add('hidden');
            }
        }, 300);
    });
});
</script>
@endsection
