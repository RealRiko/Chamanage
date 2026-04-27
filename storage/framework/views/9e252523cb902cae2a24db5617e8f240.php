<?php
    $isEdit = isset($worker);
?>

<form action="<?php echo e($isEdit ? route('workers.update', $worker) : route('workers.store')); ?>" method="POST" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?>
        <?php echo method_field('PATCH'); ?>
    <?php endif; ?>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="name" class="form-label"><?php echo e(__('form.worker.label_name')); ?> <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" required
                value="<?php echo e(old('name', $worker->name ?? '')); ?>"
                class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-1 ring-red-500/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="surname" class="form-label"><?php echo e(__('form.worker.label_surname')); ?> <span class="text-red-500">*</span></label>
            <input type="text" name="surname" id="surname" required
                value="<?php echo e(old('surname', $worker->surname ?? '')); ?>"
                class="form-input <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-1 ring-red-500/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div>
        <label for="email" class="form-label"><?php echo e(__('form.worker.label_email')); ?> <span class="text-red-500">*</span></label>
        <input type="email" name="email" id="email" required
            value="<?php echo e(old('email', $worker->email ?? '')); ?>"
            class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-1 ring-red-500/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="password" class="form-label">
                <?php echo e($isEdit ? __('form.worker.label_password_new') : __('form.worker.label_password')); ?>

                <?php if(! $isEdit): ?><span class="text-red-500">*</span><?php endif; ?>
            </label>
            <input type="password" name="password" id="password"
                placeholder="<?php echo e($isEdit ? __('form.worker.placeholder_password_edit') : ''); ?>"
                class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-1 ring-red-500/30 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                <?php echo e($isEdit ? '' : 'required'); ?>>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="password_confirmation" class="form-label"><?php echo e(__('form.worker.label_password_confirm')); ?> <?php if(! $isEdit): ?><span class="text-red-500">*</span><?php endif; ?></label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                placeholder="<?php echo e($isEdit ? __('form.worker.placeholder_password_edit') : ''); ?>"
                class="form-input"
                <?php echo e($isEdit ? '' : 'required'); ?>>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200/80 pt-8 sm:flex-row sm:items-center sm:justify-between dark:border-white/10">
        <a href="<?php echo e(route('workers.index')); ?>" class="btn-secondary justify-center sm:justify-start">
            ← <?php echo e(__('form.back')); ?>

        </a>
        <button type="submit" class="btn-primary px-8 py-3">
            <?php echo e($isEdit ? __('form.worker.submit_update') : __('form.worker.submit_create')); ?>

        </button>
    </div>
</form>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/workers/_form_workers.blade.php ENDPATH**/ ?>