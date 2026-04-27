<?php $__env->startSection('title', __('page.storage.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $search = trim((string) request('search', ''));
    $totalUnits = $products->sum(fn ($p) => (int) ($p->inventory->quantity ?? 0));
    $showToolbar = $products->isNotEmpty() || $search !== '';
?>

<?php echo $__env->make('partials.catalog-ui-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow"><?php echo e(__('page.storage.badge')); ?></span>
                        <?php if($products->isNotEmpty()): ?>
                            <span class="count-pill">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <?php echo e($products->count()); ?> <?php echo e(__('page.storage.stat_skus')); ?>

                            </span>
                            <span class="count-pill">
                                <?php echo e(number_format($totalUnits, 0, ',', ' ')); ?> <?php echo e(__('page.storage.stat_units')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="pg-title"><?php echo e(__('page.storage.title')); ?></h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 520px;"><?php echo e(__('page.storage.subtitle')); ?></p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <?php echo e(__('nav.products')); ?>

                    </a>
                    <a href="<?php echo e(route('products.create')); ?>" class="btn-primary">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <?php echo e(__('page.storage.link_products')); ?>

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

        <?php if(session('error')): ?>
            <div class="alert alert-error" role="alert">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-error" role="alert">
                <div class="alert-icon">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="main-card">
            <?php if($showToolbar): ?>
                <div class="toolbar">
                    <form method="get" action="<?php echo e(route('inventory.index')); ?>" data-listing-live data-listing-root="inventory-listing-live" style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        <div class="search-wrap">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input
                                id="inv-search"
                                type="search"
                                name="search"
                                value="<?php echo e($search); ?>"
                                autocomplete="off"
                                class="search-input"
                                placeholder="<?php echo e(__('page.storage.search_placeholder')); ?>"
                            >
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button type="submit" class="btn-search"><?php echo e(__('page.products.filter_submit')); ?></button>
                            <?php if($search !== ''): ?>
                                <a href="<?php echo e(route('inventory.index')); ?>" class="btn-clear"><?php echo e(__('page.products.filter_clear')); ?></a>
                                <div class="match-badge">
                                    <strong><?php echo e($products->count()); ?></strong>
                                    <span style="font-weight: 400; opacity: .75;"><?php echo e(__('page.products.stat_matches')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div style="padding: 24px;">
                <div id="inventory-listing-live">
                <?php if($products->isEmpty()): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="32" height="32" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <?php if($search !== ''): ?>
                            <h3 class="empty-title"><?php echo e(__('page.products.empty_search_title')); ?></h3>
                            <p class="empty-hint"><?php echo e(__('page.products.empty_search_hint')); ?></p>
                            <div style="display: flex; justify-content: center;">
                                <a href="<?php echo e(route('inventory.index')); ?>" class="btn-primary"><?php echo e(__('page.products.filter_clear')); ?></a>
                            </div>
                        <?php else: ?>
                            <h3 class="empty-title"><?php echo e(__('page.storage.empty_title')); ?></h3>
                            <p class="empty-hint"><?php echo e(__('page.storage.empty_hint')); ?></p>
                            <div style="display: flex; justify-content: center;">
                                <a href="<?php echo e(route('products.create')); ?>" class="btn-primary">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    <?php echo e(__('page.storage.link_products')); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <form method="post" action="<?php echo e(route('inventory.bulkUpdate')); ?>" class="inv-bulk-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="search" value="<?php echo e($search); ?>">
                        <div class="storage-table">
                            <div class="data-table-wrap">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('page.products.col_name')); ?></th>
                                            <th class="hidden sm:table-cell"><?php echo e(__('page.products.col_category')); ?></th>
                                            <th style="text-align: right;"><?php echo e(__('page.products.col_price')); ?></th>
                                            <th style="text-align: right;"><?php echo e(__('page.storage.col_cost_price')); ?></th>
                                            <th><?php echo e(__('page.storage.col_current')); ?></th>
                                            <th><?php echo e(__('page.storage.col_new_qty')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $initial = mb_strtoupper(mb_substr($product->name ?: '?', 0, 1, 'UTF-8'));
                                                $quantity = (int) ($product->inventory->quantity ?? 0);
                                                $colorClass = $quantity < 0
                                                    ? 'bg-red-100 text-red-800 ring-red-500 dark:bg-red-950/50 dark:text-red-300'
                                                    : ($quantity < 10
                                                        ? 'bg-amber-100 text-amber-900 ring-amber-500 dark:bg-amber-950/50 dark:text-amber-200'
                                                        : 'bg-emerald-100 text-emerald-900 ring-emerald-500 dark:bg-emerald-950/50 dark:text-emerald-200');
                                            ?>
                                            <tr>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 12px;">
                                                        <div class="tbl-avatar"><?php echo e($initial); ?></div>
                                                        <div>
                                                            <div class="tbl-name"><?php echo e($product->name); ?></div>
                                                            <div class="tbl-id">#<?php echo e($product->id); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="hidden sm:table-cell">
                                                    <?php if($product->category): ?>
                                                        <span class="cat-tag"><?php echo e($product->category); ?></span>
                                                    <?php else: ?>
                                                        <span style="color: #d6d3d1;">—</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="text-align: right;"><span class="tbl-price">€<?php echo e(number_format($product->price, 2, ',', '.')); ?></span></td>
                                                <td style="text-align: right;">
                                                    <span class="tbl-price">
                                                        <?php if(is_numeric($product->cost_price ?? null)): ?>
                                                            €<?php echo e(number_format((float) $product->cost_price, 2, ',', '.')); ?>

                                                        <?php else: ?>
                                                            —
                                                        <?php endif; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="inline-flex items-center justify-center rounded-full px-3 py-1.5 text-sm font-bold ring-1 ring-inset <?php echo e($colorClass); ?>">
                                                        <?php echo e($quantity); ?>

                                                    </span>
                                                </td>
                                                <td class="inv-qty-cell">
                                                    <input
                                                        type="number"
                                                        name="quantities[<?php echo e($product->id); ?>]"
                                                        min="0"
                                                        value="<?php echo e(old('quantities.' . $product->id, $quantity)); ?>"
                                                        class="inv-qty-field"
                                                        aria-label="<?php echo e(__('page.storage.col_new_qty')); ?> — <?php echo e($product->name); ?>"
                                                    >
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="inv-bulk-save-bar">
                            <button type="submit" class="btn-primary"><?php echo e(__('page.storage.save_all')); ?></button>
                        </div>
                    </form>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/inventory/index.blade.php ENDPATH**/ ?>