<?php $__env->startSection('title', __('page.products.title') . ' — ' . config('app.name', 'Chamanage')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $hasCatalog = $catalogTotal > 0;
    $showToolbar = $hasCatalog || $search !== '';
?>


<?php echo $__env->make('partials.catalog-ui-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        
        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow"><?php echo e(__('page.products.badge')); ?></span>
                        <?php if($hasCatalog): ?>
                            <span class="count-pill">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <?php echo e($catalogTotal); ?> <?php echo e(__('page.products.stat_items')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="pg-title"><?php echo e(__('page.products.title')); ?></h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 480px;"><?php echo e(__('page.products.subtitle')); ?></p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="<?php echo e(route('inventory.index')); ?>" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <?php echo e(__('page.products.link_storage')); ?>

                    </a>
                    <a href="<?php echo e(route('products.create')); ?>" class="btn-primary">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <?php echo e(__('page.products.cta_new')); ?>

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
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <div class="main-card">

            
            <?php if($showToolbar): ?>
                <div class="toolbar">
                    <form method="GET" action="<?php echo e(route('products.index')); ?>" style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        <div class="search-wrap">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input
                                id="product-search"
                                type="search"
                                name="search"
                                value="<?php echo e($search); ?>"
                                autocomplete="off"
                                class="search-input"
                                placeholder="<?php echo e(__('page.products.search_placeholder')); ?>"
                            >
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button type="submit" class="btn-search"><?php echo e(__('page.products.filter_submit')); ?></button>
                            <?php if($search !== ''): ?>
                                <a href="<?php echo e(route('products.index')); ?>" class="btn-clear"><?php echo e(__('page.products.filter_clear')); ?></a>
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
                <?php if($products->isEmpty()): ?>
                    
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="32" height="32" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <?php if($search !== ''): ?>
                            <h3 class="empty-title"><?php echo e(__('page.products.empty_search_title')); ?></h3>
                            <p class="empty-hint"><?php echo e(__('page.products.empty_search_hint')); ?></p>
                            <a href="<?php echo e(route('products.index')); ?>" class="btn-primary" style="margin: 0 auto;"><?php echo e(__('page.products.filter_clear')); ?></a>
                        <?php else: ?>
                            <h3 class="empty-title"><?php echo e(__('page.products.empty_title')); ?></h3>
                            <p class="empty-hint"><?php echo e(__('page.products.empty_hint')); ?></p>
                            <a href="<?php echo e(route('products.create')); ?>" class="btn-primary" style="margin: 0 auto;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <?php echo e(__('page.products.cta_new')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div
                        id="products-live-catalog"
                        x-data="{
                            view: localStorage.getItem('productsCatalogLayout') || 'grid',
                            setLayout(v) { this.view = v; localStorage.setItem('productsCatalogLayout', v); }
                        }"
                    >
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
                            <p style="font-size: 13px; color: #a8a29e; margin: 0;"><?php echo e(__('page.products.view_label')); ?></p>
                            <div class="view-toggle">
                                <button type="button" @click="setLayout('grid')" :class="view === 'grid' ? 'view-btn active' : 'view-btn'">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    <?php echo e(__('page.products.view_grid')); ?>

                                </button>
                                <button type="button" @click="setLayout('table')" :class="view === 'table' ? 'view-btn active' : 'view-btn'">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                    <?php echo e(__('page.products.view_table')); ?>

                                </button>
                            </div>
                        </div>

                        
                        <div x-show="view === 'grid'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                            <ul id="products-grid-ul" class="products-grid" style="list-style: none; margin: 0; padding: 0;">
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $initial = mb_strtoupper(mb_substr($product->name ?: '?', 0, 1, 'UTF-8')); ?>
                                    <li>
                                        <article class="product-card">
                                            <div class="card-header">
                                                <div class="card-avatar"><?php echo e($initial); ?></div>
                                                <div style="flex: 1; min-width: 0;">
                                                    <h2 class="card-name"><?php echo e($product->name); ?></h2>
                                                    <p class="card-id">ID <?php echo e($product->id); ?></p>
                                                </div>
                                                <div class="card-price">€<?php echo e(number_format($product->price, 2)); ?></div>
                                            </div>
                                            <div class="card-body">
                                                <?php if($product->category): ?>
                                                    <div class="cat-tag"><?php echo e($product->category); ?></div>
                                                <?php endif; ?>
                                                <p class="card-desc"><?php echo e($product->description ? \Illuminate\Support\Str::limit($product->description, 100) : '—'); ?></p>
                                            </div>
                                            <div class="card-footer">
                                                <a href="<?php echo e(route('products.edit', $product)); ?>" class="icon-btn" title="<?php echo e(__('page.action_edit')); ?>">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <button type="button" class="icon-btn danger product-delete-trigger" title="<?php echo e(__('page.action_delete')); ?>" data-product-id="<?php echo e($product->id); ?>" data-product-name="<?php echo e(e($product->name)); ?>">
                                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </article>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        
                        <div x-show="view === 'table'" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="data-table-wrap">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('page.products.col_name')); ?></th>
                                            <th class="hidden sm:table-cell"><?php echo e(__('page.products.col_category')); ?></th>
                                            <th style="text-align: right;"><?php echo e(__('page.products.col_price')); ?></th>
                                            <th class="hidden lg:table-cell"><?php echo e(__('page.products.col_desc')); ?></th>
                                            <th style="text-align: right;"><?php echo e(__('page.products.col_actions')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-table-tbody">
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $initial = mb_strtoupper(mb_substr($product->name ?: '?', 0, 1, 'UTF-8')); ?>
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
                                                <td style="text-align: right;"><span class="tbl-price">€<?php echo e(number_format($product->price, 2)); ?></span></td>
                                                <td class="hidden lg:table-cell" style="max-width: 260px; color: #78716c; font-size: 13px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo e($product->description ? \Illuminate\Support\Str::limit($product->description, 60) : '—'); ?></td>
                                                <td>
                                                    <div style="display: flex; justify-content: flex-end; gap: 4px;">
                                                        <a href="<?php echo e(route('products.edit', $product)); ?>" class="icon-btn">
                                                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        </a>
                                                        <button type="button" class="icon-btn danger product-delete-trigger" data-product-id="<?php echo e($product->id); ?>" data-product-name="<?php echo e(e($product->name)); ?>">
                                                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
            <p class="modal-desc"><?php echo e(__('page.products.delete_confirm')); ?> <strong id="productName" class="modal-entity-name"></strong>?</p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeDeleteModal()" class="modal-cancel"><?php echo e(__('page.action_cancel')); ?></button>
            <form id="deleteForm" method="POST" style="flex: 1; display: flex;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="modal-delete" style="flex: 1;"><?php echo e(__('page.action_delete')); ?></button>
            </form>
        </div>
    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>

<script>
const productModel = <?php echo json_encode(\App\Models\Product::class, 15, 512) ?>;
const productSearchNone = <?php echo json_encode(__('page.products.empty_search_title'), 15, 512) ?>;
const editLabel = <?php echo json_encode(__('page.action_edit'), 15, 512) ?>;
const deleteLabel = <?php echo json_encode(__('page.action_delete'), 15, 512) ?>;

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
function formatPrice(p) {
    const n = parseFloat(p);
    return (isNaN(n) ? 0 : n).toFixed(2);
}
function strLimit(s, max) {
    if (s == null || s === '') {
        return '';
    }
    s = String(s);
    return s.length <= max ? s : s.slice(0, max) + '…';
}
function displayInitial(name) {
    if (!name || !String(name).length) {
        return '?';
    }
    return String(name).charAt(0).toUpperCase();
}

function openDeleteModal(productId, productName) {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('open');
    document.getElementById('productName').textContent = productName;
    document.getElementById('deleteForm').action = '/products/' + encodeURIComponent(productId);
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
}

function buildProductGridLi(p) {
    const id = p.id;
    const name = p.name || '?';
    const initial = displayInitial(name);
    const price = formatPrice(p.price);
    const cat = p.category
        ? '<div class="cat-tag">' + escHtml(p.category) + '</div>'
        : '';
    const descText = p.description ? strLimit(p.description, 100) : '';
    const desc = p.description
        ? '<p class="card-desc">' + escHtml(descText) + '</p>'
        : '<p class="card-desc">—</p>';
    const li = document.createElement('li');
    li.innerHTML =
        '<article class="product-card">' +
        '<div class="card-header">' +
        '<div class="card-avatar">' + escHtml(initial) + '</div>' +
        '<div style="flex: 1; min-width: 0;">' +
        '<h2 class="card-name">' + escHtml(name) + '</h2>' +
        '<p class="card-id">ID ' + escHtml(String(id)) + '</p>' +
        '</div>' +
        '<div class="card-price">€' + escHtml(price) + '</div>' +
        '</div>' +
        '<div class="card-body">' + cat + desc + '</div>' +
        '<div class="card-footer">' +
        '<a href="/products/' + id + '/edit" class="icon-btn" title="' + escAttr(editLabel) + '">' +
        '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>' +
        '<button type="button" class="icon-btn danger product-delete-trigger" title="' + escAttr(deleteLabel) + '" data-product-id="' + escAttr(String(id)) + '" data-product-name="' + escAttr(name) + '">' +
        '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
        '</div></article>';
    return li;
}

function buildProductTableRow(p) {
    const id = p.id;
    const name = p.name || '?';
    const initial = displayInitial(name);
    const price = formatPrice(p.price);
    const cat = p.category
        ? '<span class="cat-tag">' + escHtml(p.category) + '</span>'
        : '<span style="color: #d6d3d1;">—</span>';
    const descCell = p.description
        ? escHtml(strLimit(p.description, 60))
        : '—';
    const tr = document.createElement('tr');
    tr.innerHTML =
        '<td><div style="display: flex; align-items: center; gap: 12px;">' +
        '<div class="tbl-avatar">' + escHtml(initial) + '</div>' +
        '<div><div class="tbl-name">' + escHtml(name) + '</div><div class="tbl-id">#' + escHtml(String(id)) + '</div></div></div></td>' +
        '<td class="hidden sm:table-cell">' + cat + '</td>' +
        '<td style="text-align: right;"><span class="tbl-price">€' + escHtml(price) + '</span></td>' +
        '<td class="hidden lg:table-cell" style="max-width: 260px; color: #78716c; font-size: 13px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' + descCell + '</td>' +
        '<td><div style="display: flex; justify-content: flex-end; gap: 4px;">' +
        '<a href="/products/' + id + '/edit" class="icon-btn">' +
        '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>' +
        '<button type="button" class="icon-btn danger product-delete-trigger" data-product-id="' + escAttr(String(id)) + '" data-product-name="' + escAttr(name) + '">' +
        '<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>' +
        '</div></td>';
    return tr;
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === e.currentTarget) {
            closeDeleteModal();
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    const catalog = document.getElementById('products-live-catalog');
    const gridUl = document.getElementById('products-grid-ul');
    const tbody = document.getElementById('products-table-tbody');
    const searchInput = document.getElementById('product-search');
    if (!catalog || !gridUl || !tbody || !searchInput) {
        document.querySelectorAll('.product-delete-trigger').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openDeleteModal(btn.dataset.productId, btn.dataset.productName);
            });
        });
        return;
    }

    const gridOriginal = gridUl.innerHTML;
    const tbodyOriginal = tbody.innerHTML;
    let timer;

    catalog.addEventListener('click', function (e) {
        const del = e.target.closest('.product-delete-trigger');
        if (del) {
            openDeleteModal(del.getAttribute('data-product-id'), del.getAttribute('data-product-name'));
        }
    });

    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(async function () {
            const q = searchInput.value.trim();
            if (!q) {
                gridUl.innerHTML = gridOriginal;
                tbody.innerHTML = tbodyOriginal;
                return;
            }
            try {
                const res = await fetch(
                    '/live-search?query=' + encodeURIComponent(q) + '&model=' + encodeURIComponent(productModel),
                    { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }
                );
                const data = await res.json();
                gridUl.innerHTML = '';
                tbody.innerHTML = '';
                if (!Array.isArray(data) || data.length === 0) {
                    gridUl.innerHTML =
                        '<li style="grid-column: 1 / -1;"><div class="empty-state" style="padding: 32px;"><h3 class="empty-title">' +
                        escHtml(productSearchNone) +
                        '</h3></div></li>';
                    tbody.innerHTML =
                        '<tr><td colspan="5" style="padding: 24px; text-align: center; color: #78716c;">' +
                        escHtml(productSearchNone) +
                        '</td></tr>';
                    return;
                }
                data.forEach(function (p) {
                    gridUl.appendChild(buildProductGridLi(p));
                    tbody.appendChild(buildProductTableRow(p));
                });
            } catch (err) {
                console.error('Product search error:', err);
            }
        }, 300);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/products/index.blade.php ENDPATH**/ ?>