<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    .edit-page {
        font-family: 'Inter', system-ui, sans-serif;
        position: relative;
        z-index: 10;
        background: transparent;
    }

    .ep-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #92400e;
    }
    .dark .ep-eyebrow { color: #fbbf24; }

    .ep-title {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -.02em;
        color: #1c1917;
        margin: 0;
    }
    .dark .ep-title { color: #fafaf9; }

    .ep-subtitle {
        font-size: 14px;
        color: #78716c;
        margin: 0;
    }
    .dark .ep-subtitle { color: #a8a29e; }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #a8a29e;
        margin-bottom: 20px;
    }
    .breadcrumb a {
        color: #78716c;
        text-decoration: none;
        transition: color .15s;
    }
    .breadcrumb a:hover { color: #b45309; }
    .dark .breadcrumb a { color: #a8a29e; }
    .dark .breadcrumb a:hover { color: #fbbf24; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        border-radius: 11px;
        border: 1px solid #e7e5e4;
        background: #fff;
        color: #44403c;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        text-decoration: none;
        transition: background .15s, border-color .15s;
        cursor: pointer;
        white-space: nowrap;
    }
    .btn-back:hover { background: #f5f5f4; border-color: #d6d3d1; }
    .dark .btn-back { background: #1c1917; border-color: #44403c; color: #d6d3d1; }
    .dark .btn-back:hover { background: #292524; }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(180,83,9,.35), 0 1px 3px rgba(0,0,0,.1);
        transition: transform .15s, box-shadow .15s;
        white-space: nowrap;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(180,83,9,.4); }
    .btn-save:active { transform: translateY(0); }

    .form-panel {
        background: #fff;
        border: 1px solid rgba(0,0,0,.07);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 8px 32px rgba(0,0,0,.04);
    }
    .dark .form-panel { background: #171614; border-color: rgba(255,255,255,.08); }

    .form-panel-accent {
        height: 4px;
        background: linear-gradient(90deg, #b45309, #fbbf24, #b45309);
        background-size: 200% 100%;
        animation: shimmer 3s linear infinite;
    }
    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .form-body { padding: 32px; }
    @media (max-width: 560px) { .form-body { padding: 20px; } }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 32px;
        border-top: 1px solid #f5f5f4;
        background: #fafaf9;
        flex-wrap: wrap;
    }
    .dark .form-footer { border-top-color: rgba(255,255,255,.07); background: #1c1917; }
    @media (max-width: 560px) { .form-footer { padding: 16px 20px; } }

    .id-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        background: #f5f5f4;
        font-size: 11px;
        font-weight: 600;
        color: #78716c;
        letter-spacing: .04em;
    }
    .dark .id-chip { background: #292524; color: #a8a29e; }

    .error-banner {
        margin: 24px 32px 0;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #fecaca;
        background: #fef2f2;
        font-size: 13px;
        color: #991b1b;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .dark .error-banner { background: rgba(69,10,10,.4); border-color: rgba(153,27,27,.4); color: #fca5a5; }
    @media (max-width: 560px) { .error-banner { margin: 16px 20px 0; } }

    .form-errors-slot { padding: 24px 32px 0; }
    @media (max-width: 560px) { .form-errors-slot { padding: 16px 20px 0; } }
    .form-errors-slot .error-banner {
        margin: 0;
    }
    .error-banner + .form-body { padding-top: 20px; }

    .success-banner {
        margin: 0 0 20px;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        font-size: 13px;
        color: #166534;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .dark .success-banner { background: rgba(5,46,22,.4); border-color: rgba(21,128,61,.4); color: #86efac; }
</style>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/partials/edit-form-page-styles.blade.php ENDPATH**/ ?>