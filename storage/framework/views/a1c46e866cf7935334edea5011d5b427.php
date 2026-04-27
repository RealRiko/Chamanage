<?php $__env->startSection('title', __('page.workers.title') . ' — ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<div class="app-shell">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => __('page.workers.title'),'subtitle' => __('page.workers.subtitle'),'badge' => __('page.workers.badge')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.workers.title')),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.workers.subtitle')),'badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.workers.badge'))]); ?>
         <?php $__env->slot('actions', null, []); ?> 
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('workers.create')); ?>" class="btn-primary inline-flex items-center gap-2 shadow-lg">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <?php echo e(__('page.workers.cta_new')); ?>

                </a>
            <?php endif; ?>
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

    <?php if($workers->isNotEmpty()): ?>
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="stat-card">
                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400"><?php echo e(__('page.workers.stat_members')); ?></p>
                <p class="font-display mt-2 text-3xl font-bold tabular-nums text-zinc-900 dark:text-white"><?php echo e($workers->count()); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="app-panel">
        <?php if(session('success')): ?>
            <div class="mb-6 rounded-xl border border-green-200/80 bg-green-50/90 p-4 text-green-800 dark:border-green-800/50 dark:bg-green-950/30 dark:text-green-200">
                <p class="font-medium"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 rounded-xl border border-red-200/80 bg-red-50/90 p-4 text-red-800 dark:border-red-800/50 dark:bg-red-950/30 dark:text-red-200">
                <p class="font-medium"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($workers->isEmpty()): ?>
            <?php if (isset($component)) { $__componentOriginal99808a3b646390fca197e013428e6b20 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99808a3b646390fca197e013428e6b20 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.listing-empty','data' => ['title' => __('page.workers.empty_title'),'hint' => __('page.workers.empty_hint')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('listing-empty'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.workers.empty_title')),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('page.workers.empty_hint'))]); ?>
                <?php if(auth()->user()->isAdmin()): ?>
                     <?php $__env->slot('action', null, []); ?> 
                        <a href="<?php echo e(route('workers.create')); ?>" class="btn-primary"><?php echo e(__('page.workers.cta_new')); ?></a>
                     <?php $__env->endSlot(); ?>
                <?php endif; ?>
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
                            <th class="rounded-tl-xl px-6 py-3 text-left"><?php echo e(__('page.workers.col_name')); ?></th>
                            <th class="px-6 py-3 text-left"><?php echo e(__('page.workers.col_email')); ?></th>
                            <?php if(auth()->user()->isAdmin()): ?>
                                <th class="rounded-tr-xl px-6 py-3 text-center"><?php echo e(__('page.products.col_actions')); ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="table-row text-zinc-900 dark:text-zinc-200">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium"><?php echo e($worker->name); ?></td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400"><?php echo e($worker->email); ?></td>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                        <a href="<?php echo e(route('workers.edit', $worker->id)); ?>" class="font-semibold text-sienna dark:text-amber-400"><?php echo e(__('page.action_edit')); ?></a>
                                        <?php if(auth()->id() !== $worker->id): ?>
                                            <span class="text-zinc-300 dark:text-zinc-600"> | </span>
                                            <button type="button" onclick="openDeleteModal(<?php echo e($worker->id); ?>, '<?php echo e(addslashes($worker->name)); ?>')" class="cursor-pointer font-semibold text-red-600 dark:text-red-400" style="background:none;border:none;padding:0;">
                                                <?php echo e(__('page.action_delete')); ?>

                                            </button>
                                        <?php else: ?>
                                            <span class="text-zinc-300 dark:text-zinc-600"> | </span>
                                            <span class="cursor-not-allowed font-semibold text-zinc-400" title="<?php echo e(__('page.workers.delete_disabled')); ?>"><?php echo e(__('page.action_delete')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-zinc-950/60 p-4 backdrop-blur-sm flex">
    <div class="modal-surface transform transition-all">
        <div class="p-6">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="mb-2 text-center text-xl font-bold text-zinc-900 dark:text-zinc-100"><?php echo e(__('page.action_delete')); ?></h3>
            <p class="mb-6 text-center text-zinc-600 dark:text-zinc-400"><?php echo e(__('page.workers.delete_confirm')); ?></p>
            <p class="mb-6 text-center font-semibold text-zinc-900 dark:text-zinc-100"><span id="workerName"></span></p>
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-xl border border-zinc-200 bg-zinc-100 px-4 py-2.5 font-semibold text-zinc-800 transition hover:bg-zinc-200 dark:border-white/10 dark:bg-white/10 dark:text-zinc-200 dark:hover:bg-white/15">
                    <?php echo e(__('Cancel')); ?>

                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-2.5 font-semibold text-white transition hover:bg-red-700">
                        <?php echo e(__('page.action_delete')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(workerId, workerName) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('workerName').textContent = workerName;
    document.getElementById('deleteForm').action = `/workers/${workerId}`;
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/workers/index.blade.php ENDPATH**/ ?>