<?php $__env->startSection('title', __('form.client.create_title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.edit-form-page-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="edit-page">
    <div style="max-width: 740px; margin: 0 auto; padding: 40px 24px 64px;">

        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="<?php echo e(route('clients.index')); ?>"><?php echo e(__('page.clients.badge')); ?></a>
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span><?php echo e(__('form.client.create_title')); ?></span>
        </nav>

        <header style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:28px; flex-wrap:wrap;">
            <div>
                <span class="ep-eyebrow"><?php echo e(__('page.clients.badge')); ?></span>
                <h1 class="ep-title" style="margin-top:8px;"><?php echo e(__('form.client.create_title')); ?></h1>
                <p class="ep-subtitle" style="margin-top:6px;"><?php echo e(__('form.client.create_sub')); ?></p>
            </div>
            <a href="<?php echo e(route('clients.index')); ?>" class="btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <?php echo e(__('form.back')); ?>

            </a>
        </header>

        <div class="form-panel">
            <div class="form-panel-accent"></div>

            <form action="<?php echo e(route('clients.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <?php if($errors->any()): ?>
                    <div class="error-banner" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div>
                            <strong style="display:block; margin-bottom:4px;"><?php echo e(__('form.errors_found')); ?></strong>
                            <ul style="margin:0; padding-left:16px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-body">
                    <?php if(session('success')): ?>
                        <div class="success-banner" role="status">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <div><?php echo e(session('success')); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->make('clients._client_fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <div class="form-footer">
                    <p style="font-size:12px; color:#a8a29e; margin:0;">
                        <span style="display:inline-block; width:5px; height:5px; border-radius:50%; background:#b45309; vertical-align:middle; margin-right:5px; margin-bottom:1px;"></span>
                        <?php echo e(__('form.required_fields')); ?>

                    </p>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <a href="<?php echo e(route('clients.index')); ?>" class="btn-back"><?php echo e(__('form.back')); ?></a>
                        <button type="submit" class="btn-save">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <?php echo e(__('form.client.submit_create')); ?>

                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/clients/create.blade.php ENDPATH**/ ?>