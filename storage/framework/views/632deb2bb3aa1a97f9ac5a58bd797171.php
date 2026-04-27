<?php $__env->startSection('title', __('reports.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-shell">
        <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('reports.title'),'subtitle' => __('reports.tagline'),'badge' => __('reports.page_badge')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('reports.title')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('reports.tagline')),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('reports.page_badge'))]); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('reports.export', request()->query())); ?>"
                   class="btn-primary inline-flex whitespace-nowrap py-2.5 px-5 text-sm shadow-lg">
                    <?php echo e(__('reports.export_pdf')); ?>

                </a>
             <?php $__env->endSlot(); ?>
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

        <?php if($errors->any()): ?>
            <div class="mb-6 rounded-xl border border-red-200/80 bg-red-50/90 p-4 text-sm text-red-800 dark:border-red-800/50 dark:bg-red-950/30 dark:text-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="get" action="<?php echo e(route('reports.index')); ?>" class="listing-filter-shell mb-8 grid grid-cols-1 gap-x-4 gap-y-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 xl:items-end">
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-date-from" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('reports.date_from')); ?></label>
                <input id="reports-date-from" type="date" name="date_from" value="<?php echo e($filters['date_from']->format('Y-m-d')); ?>"
                       class="input-control w-full">
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-date-to" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('reports.date_to')); ?></label>
                <input id="reports-date-to" type="date" name="date_to" value="<?php echo e($filters['date_to']->format('Y-m-d')); ?>"
                       class="input-control w-full">
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-client" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('reports.client')); ?></label>
                <select id="reports-client" name="client_id" class="input-control w-full">
                    <option value=""><?php echo e(__('reports.all')); ?></option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>" <?php if((string) ($filters['client_id'] ?? '') === (string) $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-type" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('reports.doc_type')); ?></label>
                <select id="reports-type" name="type" class="input-control w-full">
                    <option value=""><?php echo e(__('reports.all')); ?></option>
                    <option value="estimate" <?php if($filters['type'] === 'estimate'): echo 'selected'; endif; ?>>estimate</option>
                    <option value="sales_order" <?php if($filters['type'] === 'sales_order'): echo 'selected'; endif; ?>>sales_order</option>
                    <option value="sales_invoice" <?php if($filters['type'] === 'sales_invoice'): echo 'selected'; endif; ?>>sales_invoice</option>
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <label for="reports-status" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('reports.status')); ?></label>
                <select id="reports-status" name="status" class="input-control w-full">
                    <option value=""><?php echo e(__('reports.all')); ?></option>
                    <?php $__currentLoopData = ['draft','sent','confirmed','cancelled','waiting_payment','paid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($st); ?>" <?php if($filters['status'] === $st): echo 'selected'; endif; ?>><?php echo e($st); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex min-h-[3.25rem] flex-col justify-end">
                <div class="mb-1.5 h-4 shrink-0" aria-hidden="true"></div>
                <button type="submit" class="btn-primary w-full py-2.5 text-sm shadow">
                    <?php echo e(__('reports.filter')); ?>

                </button>
            </div>
        </form>

        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400"><?php echo e(__('reports.paid_revenue')); ?></p>
                <p class="mt-1 text-3xl font-bold text-sienna tabular-nums">€<?php echo e(number_format($paidRevenue, 2, ',', '.')); ?></p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(__('reports.paid_hint')); ?></p>
            </div>
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400"><?php echo e(__('reports.outstanding')); ?></p>
                <p class="mt-1 text-3xl font-bold text-zinc-900 tabular-nums dark:text-white">€<?php echo e(number_format($outstanding, 2, ',', '.')); ?></p>
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(__('reports.out_hint')); ?></p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200/80 bg-white/90 shadow-sm backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/50 dark:shadow-glass-dark">
            <div class="border-b border-zinc-200 px-6 py-4 font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                <?php echo e(__('reports.documents_heading', ['count' => $documents->total()])); ?>

            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-zinc-100/90 text-left text-xs uppercase text-zinc-600 dark:bg-zinc-950 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3"><?php echo e(__('reports.th_id')); ?></th>
                            <th class="px-4 py-3"><?php echo e(__('reports.th_type')); ?></th>
                            <th class="px-4 py-3"><?php echo e(__('reports.th_client')); ?></th>
                            <th class="px-4 py-3"><?php echo e(__('reports.th_invoice_date')); ?></th>
                            <th class="px-4 py-3"><?php echo e(__('reports.th_status')); ?></th>
                            <th class="px-4 py-3 text-right"><?php echo e(__('reports.th_amount')); ?></th>
                            <th class="px-4 py-3 text-center"><?php echo e(__('reports.th_pdf')); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 font-mono">#<?php echo e($doc->id); ?></td>
                                <td class="px-4 py-3"><?php echo e($doc->type); ?></td>
                                <td class="px-4 py-3"><?php echo e($doc->client->name ?? '—'); ?></td>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo e($doc->invoice_date?->format('Y-m-d')); ?></td>
                                <td class="px-4 py-3"><?php echo e($doc->status); ?></td>
                                <td class="px-4 py-3 text-right font-semibold">€<?php echo e(number_format($doc->total, 2, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <a href="<?php echo e(route('documents.pdf', $doc)); ?>" class="font-medium text-sienna hover:underline dark:text-amber-400">PDF</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-zinc-500 dark:text-zinc-400"><?php echo e(__('reports.empty')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($documents->hasPages()): ?>
                <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-800">
                    <?php echo e($documents->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/reports/index.blade.php ENDPATH**/ ?>