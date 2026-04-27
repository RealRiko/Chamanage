<?php $__env->startSection('title', __('page.invoices.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<div class="app-shell">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('page.invoices.title'),'subtitle' => __('page.invoices.subtitle'),'badge' => __('page.invoices.badge')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.invoices.title')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.invoices.subtitle')),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.invoices.badge'))]); ?>
         <?php $__env->slot('actions', null, []); ?> 
            <a href="<?php echo e(route('reports.index', ['type' => 'sales_invoice', 'date_from' => now()->startOfMonth()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')])); ?>"
               class="inline-flex items-center rounded-2xl border border-zinc-300/90 bg-white/80 px-5 py-3 text-sm font-semibold text-zinc-800 shadow-sm transition hover:border-amber-400/50 hover:bg-amber-50/90 dark:border-white/15 dark:bg-white/[0.04] dark:text-white/90 dark:hover:border-white/25 dark:hover:bg-white/[0.08]">
                <?php echo e(__('page.invoices.link_reports')); ?>

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

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="stat-card border-emerald-200/60 dark:border-emerald-900/40">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-800 dark:text-emerald-300"><?php echo e(__('page.invoices.paid_sum')); ?></p>
            <p class="font-display mt-2 text-2xl font-bold tabular-nums text-emerald-700 dark:text-emerald-400">€<?php echo e(number_format($paidSum ?? 0, 2, ',', '.')); ?></p>
        </div>
        <div class="stat-card border-amber-200/60 dark:border-amber-900/40">
            <p class="text-xs font-semibold uppercase tracking-wide text-amber-900 dark:text-amber-300"><?php echo e(__('page.invoices.waiting_sum')); ?></p>
            <p class="font-display mt-2 text-2xl font-bold tabular-nums text-sienna">€<?php echo e(number_format($waitingSum ?? 0, 2, ',', '.')); ?></p>
        </div>
        <div class="stat-card sm:col-span-2 lg:col-span-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400"><?php echo e(__('page.invoices.stat_shown')); ?></p>
            <p class="font-display mt-2 text-3xl font-bold tabular-nums text-zinc-900 dark:text-white"><?php echo e($invoices->total()); ?></p>
        </div>
    </div>

    <div class="app-panel">
        <?php if(session('success')): ?>
            <div class="mb-6 rounded-xl border border-green-200/80 bg-green-50/90 p-4 text-green-800 dark:border-green-800/50 dark:bg-green-950/30 dark:text-green-200">
                <p class="font-medium"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <div class="listing-filter-shell mb-8">
            <form method="get" action="<?php echo e(route('invoices.index')); ?>" data-listing-live data-listing-root="invoices-table-live" class="space-y-4">
                <div class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2 xl:grid-cols-6 xl:items-end">
                    <div class="flex min-h-[3.25rem] flex-col justify-end sm:col-span-2 xl:col-span-2">
                        <label for="invoices-filter-search" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('page.invoices.search_label')); ?></label>
                        <div class="relative">
                            <span class="pointer-events-none absolute left-3 top-1/2 z-[1] -translate-y-1/2 text-zinc-400" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input id="invoices-filter-search" type="text" name="search" placeholder="<?php echo e(__('page.invoices.search_placeholder')); ?>" value="<?php echo e(request('search')); ?>"
                                class="input-control relative z-0 w-full pl-10">
                        </div>
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-from" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('page.documents.label_from')); ?></label>
                        <input id="invoices-filter-from" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="input-control w-full">
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-to" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('page.documents.label_to')); ?></label>
                        <input id="invoices-filter-to" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="input-control w-full">
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-client" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('page.documents.label_client')); ?></label>
                        <select id="invoices-filter-client" name="client_id" class="input-control w-full">
                            <option value=""><?php echo e(__('reports.all')); ?></option>
                            <?php $__currentLoopData = $clients ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>" <?php if((string) request('client_id') === (string) $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="flex min-h-[3.25rem] flex-col justify-end">
                        <label for="invoices-filter-status" class="mb-1.5 block text-xs font-semibold text-zinc-600 dark:text-zinc-300"><?php echo e(__('page.documents.label_status')); ?></label>
                        <select id="invoices-filter-status" name="status" class="input-control w-full">
                            <option value=""><?php echo e(__('reports.all')); ?></option>
                            <option value="waiting_payment" <?php if(request('status') === 'waiting_payment'): echo 'selected'; endif; ?>>waiting_payment</option>
                            <option value="paid" <?php if(request('status') === 'paid'): echo 'selected'; endif; ?>>paid</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary py-2.5 text-sm"><?php echo e(__('page.documents.filter_submit')); ?></button>
                    <a href="<?php echo e(route('invoices.index')); ?>" class="btn-secondary py-2.5 text-sm"><?php echo e(__('page.documents.filter_clear')); ?></a>
                </div>
            </form>
        </div>

        <div id="invoices-table-live">
        <?php if($invoices->isEmpty()): ?>
            <?php if (isset($component)) { $__componentOriginal99808a3b646390fca197e013428e6b20 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99808a3b646390fca197e013428e6b20 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-empty','data' => ['title' => __('page.invoices.empty_title'),'hint' => __('page.invoices.empty_hint')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-empty'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.invoices.empty_title')),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.invoices.empty_hint'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99808a3b646390fca197e013428e6b20)): ?>
<?php $attributes = $__attributesOriginal99808a3b646390fca197e013428e6b20; ?>
<?php unset($__attributesOriginal99808a3b646390fca197e013428e6b20); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99808a3b646390fca197e013428e6b20)): ?>
<?php $component = $__componentOriginal99808a3b646390fca197e013428e6b20; ?>
<?php unset($__componentOriginal99808a3b646390fca197e013428e6b20); ?>
<?php endif; ?>
        <?php else: ?>
            <div class="table-wrap overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="table-head-row sm:text-sm">
                            <th class="rounded-tl-xl px-6 py-3 text-left"><?php echo e(__('page.invoices.col_id')); ?></th>
                            <th class="px-6 py-3 text-left"><?php echo e(__('page.documents.col_client')); ?></th>
                            <th class="px-6 py-3 text-left"><?php echo e(__('page.invoices.col_date')); ?></th>
                            <th class="px-6 py-3 text-center"><?php echo e(__('page.documents.col_status')); ?></th>
                            <th class="px-6 py-3 text-center"><?php echo e(__('page.documents.col_total')); ?></th>
                            <th class="rounded-tr-xl px-6 py-3 text-center"><?php echo e(__('page.products.col_actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-row text-zinc-900 dark:text-zinc-200">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">#<?php echo e($invoice->id); ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <?php if($invoice->client_id && $invoice->client): ?>
                                        <a href="<?php echo e(route('clients.edit', $invoice->client_id)); ?>" class="font-semibold text-sienna hover:underline dark:text-amber-400">
                                            <?php echo e($invoice->client->name); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-zinc-500 dark:text-zinc-400"><?php echo e($invoice->client_name_snapshot ?? 'N/A'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400"><?php echo e($invoice->invoice_date->format('Y-m-d')); ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
                                        <?php echo e($invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-200' : 'bg-amber-100 text-amber-900 dark:bg-amber-950/50 dark:text-amber-200'); ?>">
                                        <?php echo e(str_replace('_', ' ', $invoice->status)); ?>

                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-bold text-emerald-600 dark:text-emerald-400">€<?php echo e(number_format($invoice->total, 2, ',', '.')); ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                    <a href="<?php echo e(route('invoices.show', $invoice->id)); ?>" class="rounded-lg px-2 py-1 font-semibold text-sienna transition hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-white/10"><?php echo e(__('page.invoices.view')); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($invoices->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($invoices->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/invoices/index.blade.php ENDPATH**/ ?>