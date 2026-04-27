<?php $__env->startSection('title', __('form.document.edit_title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.catalog-ui-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="pg-shell products-page">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px 64px;">

        <header style="margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="pg-eyebrow"><?php echo e(__('page.documents.badge')); ?></span>
                        <span class="count-pill">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            ID <?php echo e($document->id); ?>

                        </span>
                    </div>
                    <h1 class="pg-title" style="font-size: clamp(1.75rem, 3.5vw, 2.75rem);"><?php echo e(__('form.document.edit_title')); ?></h1>
                    <p class="pg-subtitle" style="margin-top: 8px; max-width: 560px;"><?php echo e(__('form.document.edit_sub')); ?></p>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end;">
                    <a href="<?php echo e(route('documents.copy', $document)); ?>" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2h-8a2 2 0 01-2-2V7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 17V5a2 2 0 012-2h8"/></svg>
                        <?php echo e(__('form.document.copy_as_new')); ?>

                    </a>
                    <a href="<?php echo e(route('documents.index')); ?>" class="btn-ghost">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7"/></svg>
                        <?php echo e(__('form.back')); ?>

                    </a>
                </div>
            </div>
        </header>

        <div class="main-card">
            <div style="padding: 28px 24px 32px;">
                <?php echo $__env->make('documents._document_form', ['document' => $document], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/documents/edit.blade.php ENDPATH**/ ?>