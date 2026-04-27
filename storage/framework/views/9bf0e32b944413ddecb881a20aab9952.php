<?php $__env->startSection('title', __('page.admin.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<div class="app-shell">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('page.admin.title'),'subtitle' => __('page.admin.subtitle'),'badge' => __('page.admin.badge')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.admin.title')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.admin.subtitle')),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.admin.badge'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <div class="space-y-6">

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-green-200/80 bg-green-50/90 p-4 text-green-800 dark:border-green-800/50 dark:bg-green-950/30 dark:text-green-200" role="alert">
                <strong class="font-bold"><?php echo e(__('page.admin.alert_success')); ?></strong>
                <span class="ms-1 sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <div class="app-panel">
            <div class="max-w-xl">
                <h2 class="mb-2 font-display text-2xl font-bold text-zinc-900 dark:text-white"><?php echo e(__('page.admin.goal_title')); ?></h2>
                <p class="mb-6 text-zinc-600 dark:text-zinc-400"><?php echo e(__('page.admin.goal_intro')); ?></p>

                <form method="POST" action="<?php echo e(route('admin.setGoal')); ?>" class="mt-6 space-y-6">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="monthly_goal" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"><?php echo e(__('page.admin.goal_label')); ?></label>
                        <input id="monthly_goal" name="monthly_goal" type="number" step="0.01" min="0"
                               class="input-control mt-1 block w-full"
                               value="<?php echo e(old('monthly_goal', $company->monthly_goal ?? '')); ?>" required autofocus />
                        <?php $__errorArgs = ['monthly_goal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary px-6 py-3 text-sm">
                            <?php echo e(__('page.admin.goal_save')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="app-panel">
            <div class="max-w-3xl">
                <h2 class="mb-2 font-display text-2xl font-bold text-zinc-900 dark:text-white"><?php echo e(__('page.admin.invoice_details_title')); ?></h2>
                <p class="mb-6 text-zinc-600 dark:text-zinc-400"><?php echo e(__('page.admin.invoice_details_intro')); ?></p>

                <form method="POST" action="<?php echo e(route('admin.updateCompanyDetails')); ?>" class="mt-6 space-y-6" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"><?php echo e(__('page.admin.company_name')); ?></label>
                            <input id="company_name" name="company_name" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('company_name', $company->name ?? '')); ?>" required />
                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="reg_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.registration_number')); ?></label>
                            <input id="reg_number" name="reg_number" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('reg_number', $company->registration_number ?? '')); ?>" />
                            <?php $__errorArgs = ['reg_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="vat_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.vat_number')); ?></label>
                            <input id="vat_number" name="vat_number" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('vat_number', $company->vat_number ?? '')); ?>" />
                            <?php $__errorArgs = ['vat_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="bank_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.bank_name')); ?></label>
                            <input id="bank_name" name="bank_name" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('bank_name', $company->bank_name ?? '')); ?>" />
                            <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="account_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.account_number')); ?></label>
                            <input id="account_number" name="account_number" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('account_number', $company->account_number ?? '')); ?>" />
                            <?php $__errorArgs = ['account_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.address')); ?></label>
                            <input id="address" name="address" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('address', $company->address ?? '')); ?>" />
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="city" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.city')); ?></label>
                            <input id="city" name="city" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('city', $company->city ?? '')); ?>" />
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="postal_code" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.postal_code')); ?></label>
                            <input id="postal_code" name="postal_code" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('postal_code', $company->postal_code ?? '')); ?>" />
                            <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="document_contact_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.document_contact_name')); ?></label>
                            <input id="document_contact_name" name="document_contact_name" type="text"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('document_contact_name', $company->document_contact_name ?? '')); ?>" />
                            <?php $__errorArgs = ['document_contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="document_contact_email" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.document_contact_email')); ?></label>
                            <input id="document_contact_email" name="document_contact_email" type="email"
                                   class="input-control mt-1 block w-full"
                                   value="<?php echo e(old('document_contact_email', $company->document_contact_email ?? '')); ?>" />
                            <?php $__errorArgs = ['document_contact_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 -mt-2"><?php echo e(__('page.admin.document_contact_hint')); ?></p>

                    
                    <div>
                        <label for="footer_contacts" class="block font-medium text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('page.admin.footer_contacts_label')); ?></label>
                        <textarea id="footer_contacts" name="footer_contacts" rows="2"
                                  class="input-control mt-1 block w-full"><?php echo e(old('footer_contacts', $company->footer_contacts ?? '')); ?></textarea>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(__('page.admin.footer_contacts_hint')); ?></p>
                        <?php $__errorArgs = ['footer_contacts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2"><?php echo e(__('page.admin.company_logo')); ?></label>

                        <div class="relative w-full">
                            <input id="logo" name="logo" type="file" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   onchange="document.getElementById('file-name').textContent = this.files[0]?.name || '<?php echo e(__('page.admin.file_choose')); ?>';" />
                            
                            <button type="button" 
                                    class="flex w-full items-center justify-between rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-700 shadow-sm hover:bg-zinc-50 dark:border-white/10 dark:bg-white/5 dark:text-zinc-100 dark:hover:bg-white/10">
                                <span id="file-name"><?php echo e(__('page.admin.file_choose')); ?></span>
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm16 0l-8 8-8-8" />
                                </svg>
                            </button>
                        </div>

                        <?php if($company->logo_path): ?>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300"><?php echo e(__('page.admin.current_logo')); ?></p>
                            <img src="<?php echo e(asset('storage/' . $company->logo_path)); ?>" alt="<?php echo e(__('page.admin.current_logo')); ?>" class="mt-2 h-16 rounded-lg border p-1" />
                        <?php endif; ?>

                        <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <button type="submit" class="btn-primary px-6 py-3 text-sm">
                            <?php echo e(__('page.admin.details_save')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="app-panel">
            <div class="max-w-xl">
                <h2 class="mb-2 font-display text-2xl font-bold text-zinc-900 dark:text-white"><?php echo e(__('page.admin.low_stock_title')); ?></h2>
                <p class="mb-6 text-zinc-600 dark:text-zinc-400"><?php echo e(__('page.admin.low_stock_intro')); ?></p>

                <form method="POST" action="<?php echo e(route('admin.updateLowStockNotifications')); ?>" class="mt-6 space-y-6">
                    <?php echo csrf_field(); ?>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="low_stock_notify_enabled" value="0">
                        <input id="low_stock_notify_enabled" name="low_stock_notify_enabled" type="checkbox" value="1"
                               class="h-4 w-4 rounded border-zinc-300 text-amber-600 focus:ring-amber-500 dark:border-zinc-600 dark:bg-zinc-900"
                               <?php if(old('low_stock_notify_enabled', $company->low_stock_notify_enabled ?? false)): echo 'checked'; endif; ?>>
                        <label for="low_stock_notify_enabled" class="text-sm font-medium text-zinc-800 dark:text-zinc-200"><?php echo e(__('page.admin.low_stock_enabled')); ?></label>
                    </div>

                    <div>
                        <label for="low_stock_threshold" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300"><?php echo e(__('page.admin.low_stock_threshold_label')); ?></label>
                        <input id="low_stock_threshold" name="low_stock_threshold" type="number" min="1" max="999999" step="1" required
                               class="input-control mt-1 block w-full max-w-xs"
                               value="<?php echo e(old('low_stock_threshold', $company->low_stock_threshold ?? 10)); ?>" />
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(__('page.admin.low_stock_threshold_help')); ?></p>
                        <?php $__errorArgs = ['low_stock_threshold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary px-6 py-3 text-sm">
                            <?php echo e(__('page.admin.low_stock_save')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/admin/company_settings.blade.php ENDPATH**/ ?>