<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<style>
    /* Šrifti kā layouts.app / sākumlapa: Inter + Plus Jakarta Sans */
    .products-page {
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* Fons kā app sākumlapai: globālais body (režģis + dzintara spīdumi app.css) */
    .pg-shell {
        position: relative;
        z-index: 10;
        min-height: 0;
        background: transparent;
    }

    /* ── Typography ─────────────────────────────────────────────────── */
    .pg-eyebrow {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #92400e;
    }
    .dark .pg-eyebrow { color: #fbbf24; }

    .pg-title {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-size: clamp(2rem, 4vw, 3.25rem);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -.02em;
        color: #1c1917;
        margin: 0;
    }
    .dark .pg-title { color: #fafaf9; }

    .pg-subtitle {
        font-size: 15px;
        color: #78716c;
        line-height: 1.6;
        margin: 0;
    }
    .dark .pg-subtitle { color: #a8a29e; }

    /* ── Header count pill ───────────────────────────────────────────── */
    .count-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 999px;
        padding: 3px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #92400e;
    }
    .dark .count-pill {
        background: rgba(120,53,15,.25);
        border-color: rgba(180,83,9,.4);
        color: #fbbf24;
    }

    /* ── Buttons ────────────────────────────────────────────────────── */
    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #44403c;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: background .15s, border-color .15s, box-shadow .15s;
        cursor: pointer;
    }
    .btn-ghost:hover { background: #f5f5f4; border-color: #d6d3d1; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .dark .btn-ghost { background: #1c1917; border-color: #3f3f46; color: #e7e5e4; }
    .dark .btn-ghost:hover { background: #292524; }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(180,83,9,.35), 0 1px 3px rgba(0,0,0,.1);
        transition: transform .15s, box-shadow .15s, filter .15s;
        cursor: pointer;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(180,83,9,.4), 0 2px 6px rgba(0,0,0,.12); }
    .btn-primary:active { transform: translateY(0); }

    /* ── Alert strips ───────────────────────────────────────────────── */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid;
    }
    .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    .alert-error   { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    .dark .alert-success { background: rgba(5,46,22,.4); border-color: rgba(21,128,61,.4); color: #86efac; }
    .dark .alert-error   { background: rgba(69,10,10,.4); border-color: rgba(153,27,27,.4); color: #fca5a5; }
    .alert-icon {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }
    .alert-success .alert-icon { background: #22c55e; color: #fff; }
    .alert-error   .alert-icon { background: #ef4444; color: #fff; }

    /* ── Main card ───────────────────────────────────────────────────── */
    .main-card {
        background: #fff;
        border: 1px solid rgba(0,0,0,.07);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 8px 32px rgba(0,0,0,.04);
    }
    .dark .main-card { background: #171614; border-color: rgba(255,255,255,.08); }

    /* ── Toolbar ────────────────────────────────────────────────────── */
    .toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid #f5f5f4;
        background: #fafaf9;
    }
    .dark .toolbar { background: #1c1917; border-color: rgba(255,255,255,.06); }

    .search-wrap {
        position: relative;
        flex: 1;
    }
    .search-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a8a29e;
        pointer-events: none;
    }
    .search-input {
        width: 100%;
        height: 42px;
        padding: 0 16px 0 42px;
        border-radius: 12px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #1c1917;
        font-size: 14px;
        font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
        outline: none;
        box-sizing: border-box;
    }
    .search-input::placeholder { color: #a8a29e; }
    .search-input:focus { border-color: #d97706; box-shadow: 0 0 0 3px rgba(217,119,6,.12); }
    .dark .search-input { background: #1c1917; border-color: #44403c; color: #fafaf9; }
    .dark .search-input:focus { border-color: #d97706; }

    .btn-search {
        height: 42px;
        padding: 0 20px;
        border-radius: 12px;
        border: none;
        background: #b45309;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
        flex-shrink: 0;
    }
    .btn-search:hover { background: #92400e; }

    .btn-clear {
        height: 42px;
        padding: 0 16px;
        border-radius: 12px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #44403c;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background .15s;
        flex-shrink: 0;
    }
    .btn-clear:hover { background: #f5f5f4; }
    .dark .btn-clear { background: #1c1917; border-color: #44403c; color: #d6d3d1; }

    .match-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 42px;
        padding: 0 16px;
        border-radius: 12px;
        background: #fef3c7;
        font-size: 13px;
        font-weight: 600;
        color: #92400e;
    }
    .dark .match-badge { background: rgba(120,53,15,.3); color: #fbbf24; }

    /* ── View toggle ────────────────────────────────────────────────── */
    .view-toggle {
        display: inline-flex;
        background: #f5f5f4;
        border-radius: 10px;
        padding: 3px;
        gap: 2px;
    }
    .dark .view-toggle { background: #292524; }

    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #78716c;
        font-size: 12px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s, color .15s, box-shadow .15s;
    }
    .view-btn.active {
        background: #fff;
        color: #b45309;
        box-shadow: 0 1px 4px rgba(0,0,0,.08);
    }
    .dark .view-btn.active { background: #3f3f46; color: #fbbf24; }
    .dark .view-btn { color: #a8a29e; }

    /* ── Product grid cards ─────────────────────────────────────────── */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #f5f5f4;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .product-card:hover {
        border-color: #fde68a;
        box-shadow: 0 8px 28px rgba(180,83,9,.1);
        transform: translateY(-2px);
    }
    .dark .product-card { background: #1c1917; border-color: rgba(255,255,255,.07); }
    .dark .product-card:hover { border-color: rgba(217,119,6,.4); box-shadow: 0 8px 28px rgba(180,83,9,.12); }

    .card-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #fbbf24, #b45309);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        box-shadow: 0 2px 8px rgba(180,83,9,.3);
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 18px 18px 12px;
    }
    .card-name {
        font-size: 15px;
        font-weight: 600;
        color: #1c1917;
        margin: 0 0 2px;
        line-height: 1.3;
    }
    .dark .card-name { color: #fafaf9; }

    .card-id {
        font-size: 11px;
        color: #a8a29e;
        font-variant-numeric: tabular-nums;
    }
    .card-price {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-size: 22px;
        color: #b45309;
        white-space: nowrap;
        line-height: 1;
        margin-top: 2px;
    }
    .dark .card-price { color: #fbbf24; }

    .card-body { flex: 1; padding: 0 18px 14px; }
    .cat-tag {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        background: #fef3c7;
        font-size: 11px;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 10px;
        letter-spacing: .02em;
    }
    .dark .cat-tag { background: rgba(120,53,15,.3); color: #fcd34d; }
    .card-desc {
        font-size: 13px;
        color: #78716c;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark .card-desc { color: #a8a29e; }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        padding: 10px 14px;
        border-top: 1px solid #f5f5f4;
    }
    .dark .card-footer { border-top-color: rgba(255,255,255,.06); }

    .icon-btn {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        color: #a8a29e;
        transition: background .15s, color .15s;
    }
    .icon-btn:hover { background: #fef3c7; color: #b45309; }
    .icon-btn.danger:hover { background: #fef2f2; color: #dc2626; }
    .dark .icon-btn:hover { background: rgba(217,119,6,.15); color: #fbbf24; }
    .dark .icon-btn.danger:hover { background: rgba(220,38,38,.15); color: #f87171; }

    /* ── Table ─────────────────────────────────────────────────────── */
    .data-table-wrap {
        border-radius: 14px;
        border: 1px solid #f5f5f4;
        overflow: hidden;
    }
    .dark .data-table-wrap { border-color: rgba(255,255,255,.07); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #a8a29e;
        background: #fafaf9;
        border-bottom: 1px solid #f5f5f4;
    }
    .dark .data-table thead th { background: #1c1917; border-bottom-color: rgba(255,255,255,.06); }
    .data-table thead th:last-child { text-align: right; }
    .storage-table .data-table thead th:nth-child(4),
    .storage-table .data-table thead th:nth-child(5) { text-align: center !important; }
    .storage-table .data-table tbody td:nth-child(4),
    .storage-table .data-table tbody td:nth-child(5) { text-align: center !important; }
    /* Klienti — tālrunis centrā */
    .client-table .data-table thead th:nth-child(3),
    .client-table .data-table tbody td:nth-child(3) { text-align: center !important; }
    .data-table tbody tr { transition: background .12s; }
    .data-table tbody tr:hover { background: #fffbeb; }
    .dark .data-table tbody tr:hover { background: rgba(217,119,6,.06); }
    .data-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: #1c1917;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
    }
    .dark .data-table tbody td { color: #e7e5e4; border-bottom-color: rgba(255,255,255,.05); }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .tbl-avatar {
        width: 36px; height: 36px;
        border-radius: 9px;
        background: linear-gradient(135deg, #fbbf24, #b45309);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; color: #fff;
        flex-shrink: 0;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
    }
    .tbl-name { font-weight: 500; font-size: 14px; }
    .tbl-id { font-size: 11px; color: #a8a29e; }

    /* Dokumentu tabula — tips + Nr. vienā rindā */
    .doc-type-cell {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        max-width: 100%;
    }
    .doc-type-cell .cat-tag { margin-bottom: 0; }
    .doc-type-cell__num {
        font-size: 11px;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.02em;
        color: #57534e;
        padding: 3px 9px;
        border-radius: 8px;
        background: #f5f5f4;
        border: 1px solid #e7e5e4;
        line-height: 1.2;
        white-space: nowrap;
    }
    .dark .doc-type-cell__num {
        color: #d6d3d1;
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.1);
    }
    .tbl-price { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif; font-size: 17px; color: #b45309; font-weight: 600; }
    .dark .tbl-price { color: #fbbf24; }

    /* ── Empty state ─────────────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
    }
    .empty-icon {
        width: 72px; height: 72px;
        border-radius: 20px;
        background: #fef3c7;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .dark .empty-icon { background: rgba(120,53,15,.25); }
    .empty-title {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-size: 22px;
        color: #1c1917;
        margin: 0 0 8px;
    }
    .dark .empty-title { color: #fafaf9; }
    .empty-hint {
        font-size: 14px;
        color: #78716c;
        margin: 0 0 28px;
    }
    .dark .empty-hint { color: #a8a29e; }

    /* ── Delete modal ───────────────────────────────────────────────── */
    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 50;
        background: rgba(15,15,14,.75);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(0,0,0,.2);
        animation: modalIn .2s ease;
    }
    .dark .modal-box { background: #1c1917; }
    @keyframes modalIn {
        from { opacity: 0; transform: scale(.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-body {
        padding: 32px 28px 24px;
        text-align: center;
    }
    .modal-danger-icon {
        width: 60px; height: 60px;
        border-radius: 50%;
        background: #fef2f2;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px;
    }
    .dark .modal-danger-icon { background: rgba(127,29,29,.3); }
    .modal-title {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-size: 20px;
        color: #1c1917;
        margin: 0 0 8px;
    }
    .dark .modal-title { color: #fafaf9; }
    .modal-desc {
        font-size: 14px;
        color: #78716c;
        margin: 0;
        line-height: 1.6;
    }
    .dark .modal-desc { color: #a8a29e; }
    .modal-entity-name { color: #1c1917; font-weight: 600; }
    .dark .modal-entity-name { color: #fafaf9; }
    .modal-footer {
        display: flex;
        gap: 10px;
        padding: 16px 20px 20px;
    }
    .modal-cancel {
        flex: 1;
        height: 44px;
        border-radius: 12px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #44403c;
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s;
    }
    .modal-cancel:hover { background: #f5f5f4; }
    .dark .modal-cancel { background: #292524; border-color: #44403c; color: #d6d3d1; }
    .dark .modal-cancel:hover { background: #3f3f46; }
    .modal-delete {
        flex: 1;
        height: 44px;
        border-radius: 12px;
        border: none;
        background: #dc2626;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .15s, box-shadow .15s;
        box-shadow: 0 2px 8px rgba(220,38,38,.3);
    }
    .modal-delete:hover { background: #b91c1c; }

    /* Noliktava — viena forma, viens saglabāt */
    .inv-bulk-form {
        margin: 0;
    }
    .inv-qty-cell {
        text-align: center;
        vertical-align: middle;
    }
    .inv-bulk-save-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e7e5e4;
    }
    .dark .inv-bulk-save-bar {
        border-top-color: #44403c;
    }
    .inv-qty-field {
        width: 5.5rem;
        height: 38px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #1c1917;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        font-family: inherit;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .inv-qty-field:focus {
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(217,119,6,.12);
    }
    .dark .inv-qty-field {
        background: #1c1917;
        border-color: #44403c;
        color: #fafaf9;
    }
    .btn-search.btn-compact {
        height: 38px;
        padding: 0 14px;
        font-size: 12px;
    }
</style>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/partials/catalog-ui-styles.blade.php ENDPATH**/ ?>