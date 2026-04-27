
<div class="line-item p-5 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-700/50 shadow-inner">
    <div class="grid md:grid-cols-5 gap-4 items-end">

        <div class="md:col-span-2">
            <label for="line_items[<?php echo e($index); ?>][product_id]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product</label>
            <select name="line_items[<?php echo e($index); ?>][product_id]" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-inner dark:bg-gray-700 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($product->id); ?>" <?php echo e(($item && $item->product_id == $product->id) ? 'selected' : ''); ?>>
                        <?php echo e($product->name); ?> - $<?php echo e($product->price); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="line_items[<?php echo e($index); ?>][quantity]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Qty</label>
            <input type="number" name="line_items[<?php echo e($index); ?>][quantity]" placeholder="Qty" min="1"
                   value="<?php echo e($item->quantity ?? 1); ?>"
                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-inner dark:bg-gray-700 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
        </div>

        <div>
            <label for="line_items[<?php echo e($index); ?>][price]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price</label>
            <input type="number" name="line_items[<?php echo e($index); ?>][price]" placeholder="Price" step="0.01"
                   value="<?php echo e($item->price ?? ''); ?>"
                   class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-inner dark:bg-gray-700 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
        </div>

        <div class="flex items-end h-full">
            <?php if($index > 0 || isset($document)): ?>
                <button type="button" onclick="this.closest('.line-item').remove()" class="
                    flex items-center justify-center h-12 w-12 text-red-500 dark:text-red-400 bg-gray-200 dark:bg-gray-700/50 rounded-xl
                    hover:bg-red-500 hover:text-white transition duration-200 shadow-md flex-shrink-0
                " title="Remove Item">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/documents/partials/_line_item.blade.php ENDPATH**/ ?>