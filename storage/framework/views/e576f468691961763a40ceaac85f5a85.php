<?php $__env->startSection('title', __('page.documents.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $docTotal = $documents->total();
    $hasRows = $documents->isNotEmpty();
    $filtersActive = filled(request('search'))
        || filled(request('date_from'))
        || filled(request('date_to'))
        || filled(request('client_id'))
        || filled(request('type'))
        || filled(request('status'));
?>

<?php echo $__env->make('partials.catalog-ui-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow"><?php echo e(__('page.documents.badge')); ?></span>
                        <?php if($docTotal > 0): ?>
                            <span class="count-pill">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <?php echo e($docTotal); ?> <?php echo e(__('page.documents.stat_shown')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="pg-title"><?php echo e(__('page.documents.title')); ?></h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 520px;"><?php echo e(__('page.documents.subtitle')); ?></p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <?php echo e(__('nav.home')); ?>

                    </a>
                    <a href="<?php echo e(route('documents.create')); ?>" class="btn-primary">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <?php echo e(__('page.documents.cta_new')); ?>

                    </a>
                </div>
            </div>
        </header>

        <?php if(session('success')): ?>
            <div class="alert alert-success" role="status">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="main-card">
            <div class="toolbar">
                <form method="get" action="<?php echo e(route('documents.index')); ?>" data-listing-live data-listing-root="documents-listing-live" style="width: 100%;">
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div class="search-wrap" style="max-width: 100%;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input
                                type="search"
                                name="search"
                                value="<?php echo e(request('search')); ?>"
                                autocomplete="off"
                                class="search-input"
                                placeholder="<?php echo e(__('page.documents.search_placeholder')); ?>"
                            >
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                            <div>
                                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;"><?php echo e(__('page.documents.label_from')); ?></label>
                                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="input-control" style="margin-top: 0; width: 100%;">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;"><?php echo e(__('page.documents.label_to')); ?></label>
                                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="input-control" style="margin-top: 0; width: 100%;">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;"><?php echo e(__('page.documents.label_client')); ?></label>
                                <select name="client_id" class="input-control" style="margin-top: 0; width: 100%;">
                                    <option value=""><?php echo e(__('reports.all')); ?></option>
                                    <?php $__currentLoopData = $clients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->id); ?>" <?php if((string) request('client_id') === (string) $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;"><?php echo e(__('page.documents.label_type')); ?></label>
                                <select name="type" class="input-control" style="margin-top: 0; width: 100%;">
                                    <option value=""><?php echo e(__('reports.all')); ?></option>
                                    <option value="estimate" <?php if(request('type') === 'estimate'): echo 'selected'; endif; ?>>estimate</option>
                                    <option value="sales_order" <?php if(request('type') === 'sales_order'): echo 'selected'; endif; ?>>sales_order</option>
                                    <option value="sales_invoice" <?php if(request('type') === 'sales_invoice'): echo 'selected'; endif; ?>>sales_invoice</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;"><?php echo e(__('page.documents.label_status')); ?></label>
                                <select name="status" class="input-control" style="margin-top: 0; width: 100%;">
                                    <option value=""><?php echo e(__('reports.all')); ?></option>
                                    <?php $__currentLoopData = ['draft','sent','confirmed','cancelled','waiting_payment','paid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($st); ?>" <?php if(request('status') === $st): echo 'selected'; endif; ?>><?php echo e($st); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                            <button type="submit" class="btn-search"><?php echo e(__('page.documents.filter_submit')); ?></button>
                            <?php if($filtersActive): ?>
                                <a href="<?php echo e(route('documents.index')); ?>" class="btn-clear"><?php echo e(__('page.documents.filter_clear')); ?></a>
                                <div class="match-badge">
                                    <strong><?php echo e($docTotal); ?></strong>
                                    <span style="font-weight: 400; opacity: .75;"><?php echo e(__('page.documents.stat_shown')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <div style="padding: 24px;">
                <div id="documents-listing-live">
                <?php if(! $hasRows): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="32" height="32" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="empty-title"><?php echo e(__('page.documents.empty_title')); ?></h3>
                        <p class="empty-hint"><?php echo e(__('page.documents.empty_hint')); ?></p>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                            <?php if($filtersActive): ?>
                                <a href="<?php echo e(route('documents.index')); ?>" class="btn-primary"><?php echo e(__('page.documents.filter_clear')); ?></a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('documents.create')); ?>" class="btn-primary">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <?php echo e(__('page.documents.cta_new')); ?>

                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('page.documents.col_type')); ?></th>
                                    <th><?php echo e(__('page.documents.col_client')); ?></th>
                                    <th class="hidden md:table-cell"><?php echo e(__('page.documents.col_delivery')); ?></th>
                                    <th style="text-align: right;"><?php echo e(__('page.documents.col_total')); ?></th>
                                    <th><?php echo e(__('page.documents.col_status')); ?></th>
                                    <th class="hidden lg:table-cell"><?php echo e(__('page.documents.col_created')); ?></th>
                                    <th><?php echo e(__('page.products.col_actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $statusColors = [
                                            'estimate' => [
                                                'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200',
                                                'sent'  => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200',
                                            ],
                                            'sales_order' => [
                                                'draft'     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200',
                                                'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200',
                                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200',
                                            ],
                                            'sales_invoice' => [
                                                'waiting_payment' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200',
                                                'paid'            => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200',
                                            ],
                                        ];
                                        $docType = $document->type;
                                        $docStatus = $document->status;
                                        $badgeClass = $statusColors[$docType][$docStatus] ?? 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-zinc-200';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="doc-type-cell">
                                                <span class="cat-tag"><?php echo e(__('pdf.document.types.' . $document->type)); ?></span>
                                                <span class="doc-type-cell__num">#<?php echo e($document->id); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tbl-name"><?php echo e($document->client?->name ?? $document->client_name_snapshot ?? 'N/A'); ?></div>
                                            <div class="tbl-id" style="margin-top: 4px;">
                                                <?php echo e(__('page.meta.created_by', ['name' => trim(($document->creator->name ?? '') . ' ' . ($document->creator->surname ?? '')) ?: '—'])); ?>

                                            </div>
                                        </td>
                                        <td class="hidden md:table-cell" style="color: #78716c;"><?php echo e($document->delivery_days); ?> <?php echo e(__('page.documents.days_suffix')); ?></td>
                                        <td style="text-align: right;"><span class="tbl-price">€<?php echo e(number_format($document->total, 2, ',', '.')); ?></span></td>
                                        <td>
                                            <span class="rounded-full px-3 py-1 text-xs font-bold <?php echo e($badgeClass); ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $docStatus))); ?>

                                            </span>
                                        </td>
                                        <td class="hidden lg:table-cell" style="color: #78716c;"><?php echo e($document->created_at->format('Y-m-d')); ?></td>
                                        <td>
                                            <div style="display: flex; justify-content: flex-end; gap: 4px; flex-wrap: wrap;">
                                                <a href="<?php echo e(route('documents.edit', $document)); ?>" class="icon-btn" title="<?php echo e(__('page.action_edit')); ?>">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <a href="<?php echo e(route('documents.pdf', $document)); ?>" class="icon-btn" title="PDF" target="_blank" rel="noopener noreferrer">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                </a>
                                                <button
                                                    type="button"
                                                    class="icon-btn danger document-delete-trigger"
                                                    title="<?php echo e(__('page.action_delete')); ?>"
                                                    data-doc-id="<?php echo e($document->id); ?>"
                                                    data-doc-label="<?php echo e(__('pdf.document.types.' . $document->type) . ' #' . $document->id); ?>"
                                                >
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 24px;">
                        <?php echo e($documents->links()); ?>

                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
    <div class="modal-box">
        <div class="modal-body">
            <div class="modal-danger-icon">
                <svg width="28" height="28" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="modal-title" id="delete-modal-title"><?php echo e(__('page.action_delete')); ?></h3>
            <p class="modal-desc"><?php echo e(__('page.documents.delete_confirm')); ?></p>
            <p class="modal-desc" style="margin-top: 10px;"><strong id="documentDeleteDisplay" class="modal-entity-name"></strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDocDeleteModal()" class="modal-cancel"><?php echo e(__('page.action_cancel')); ?></button>
            <form id="deleteForm" method="POST" style="flex: 1; display: flex;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="modal-delete" style="flex: 1;"><?php echo e(__('page.action_delete')); ?></button>
            </form>
        </div>
    </div>
</div>

<script>
function openDocDeleteModal(id, label) {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('open');
    document.getElementById('documentDeleteDisplay').textContent = label;
    document.getElementById('deleteForm').action = '/documents/' + encodeURIComponent(id);
    document.body.style.overflow = 'hidden';
}
function closeDocDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDocDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDocDeleteModal();
});
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.document-delete-trigger');
    if (!btn) return;
    e.preventDefault();
    openDocDeleteModal(btn.getAttribute('data-doc-id'), btn.getAttribute('data-doc-label'));
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/documents/index.blade.php ENDPATH**/ ?>