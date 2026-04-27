<?php $__env->startSection('title', __('page.document_show.page_title', ['id' => $document->id, 'name' => config('app.name')])); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('documents.partials.show-body', [
    'document' => $document,
    'documentListRoute' => $documentListRoute,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/invoices/show.blade.php ENDPATH**/ ?>