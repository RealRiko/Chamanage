<?php
    $product = $product ?? null;
?>

<?php if(session('success')): ?>
    <div style="
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        margin-bottom: 24px;
        border-radius: 12px;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        font-size: 13px;
        font-weight: 500;
        color: #166534;
    " role="status">
        <span style="
            width: 28px; height: 28px;
            border-radius: 50%;
            background: #22c55e;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        ">
            <svg width="13" height="13" fill="none" stroke="#fff" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </span>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>


<div style="margin-bottom: 22px;">
    <label for="name" style="
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #78716c;
        margin-bottom: 7px;
    ">
        <?php echo e(__('form.product.name')); ?>

        <span style="display:inline-block; width:5px; height:5px; border-radius:50%; background:#b45309; vertical-align:middle; margin-left:4px; margin-bottom:2px;"></span>
    </label>
    <input
        type="text"
        name="name"
        id="name"
        required
        autocomplete="off"
        value="<?php echo e(old('name', $product->name ?? '')); ?>"
        style="
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid <?php echo e($errors->has('name') ? '#dc2626' : '#e7e5e4'); ?>;
            background: #fff;
            color: #1c1917;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            box-sizing: border-box;
            <?php echo e($errors->has('name') ? 'box-shadow: 0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

            transition: border-color .15s, box-shadow .15s;
        "
        onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
        onblur="this.style.borderColor='<?php echo e($errors->has('name') ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='<?php echo e($errors->has('name') ? '0 0 0 3px rgba(220,38,38,.1)' : 'none'); ?>'"
    >
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p style="margin: 6px 0 0; font-size: 12px; color: #dc2626; display:flex; align-items:center; gap:4px;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
            <?php echo e($message); ?>

        </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div style="margin-bottom: 22px;">
    <label for="category" style="
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #78716c;
        margin-bottom: 7px;
    "><?php echo e(__('form.product.category')); ?></label>
    <input
        type="text"
        name="category"
        id="category"
        autocomplete="off"
        value="<?php echo e(old('category', $product->category ?? '')); ?>"
        style="
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid <?php echo e($errors->has('category') ? '#dc2626' : '#e7e5e4'); ?>;
            background: #fff;
            color: #1c1917;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            box-sizing: border-box;
            <?php echo e($errors->has('category') ? 'box-shadow: 0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

            transition: border-color .15s, box-shadow .15s;
        "
        onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
        onblur="this.style.borderColor='<?php echo e($errors->has('category') ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='none'"
    >
    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p style="margin: 6px 0 0; font-size: 12px; color: #dc2626; display:flex; align-items:center; gap:4px;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
            <?php echo e($message); ?>

        </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div>
    <label for="description" style="
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #78716c;
        margin-bottom: 7px;
    "><?php echo e(__('form.product.description')); ?></label>
    <textarea
        name="description"
        id="description"
        rows="6"
        style="
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid <?php echo e($errors->has('description') ? '#dc2626' : '#e7e5e4'); ?>;
            background: #fff;
            color: #1c1917;
            font-size: 14px;
            font-family: inherit;
            line-height: 1.6;
            resize: vertical;
            outline: none;
            box-sizing: border-box;
            <?php echo e($errors->has('description') ? 'box-shadow: 0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

            transition: border-color .15s, box-shadow .15s;
        "
        onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
        onblur="this.style.borderColor='<?php echo e($errors->has('description') ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='none'"
    ><?php echo e(old('description', $product->description ?? '')); ?></textarea>
    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p style="margin: 4px 0 0; font-size: 12px; color: #dc2626; display:flex; align-items:center; gap:4px;">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
            <?php echo e($message); ?>

        </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 22px;">

    
    <div>
        <label for="price" style="
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #78716c;
            margin-bottom: 7px;
        ">
            <?php echo e(__('form.product.price')); ?>

            <span style="display:inline-block; width:5px; height:5px; border-radius:50%; background:#b45309; vertical-align:middle; margin-left:4px; margin-bottom:2px;"></span>
        </label>
        <div style="position: relative;">
            <span style="
                position: absolute;
                left: 13px;
                top: 50%;
                transform: translateY(-50%);
                font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
                font-size: 16px;
                color: #b45309;
                pointer-events: none;
                line-height: 1;
            ">€</span>
            <input
                type="number"
                name="price"
                id="price"
                step="0.01"
                min="0"
                required
                value="<?php echo e(old('price', $product->price ?? '')); ?>"
                oninput="document.getElementById('cost_price')?.dispatchEvent(new Event('input'))"
                style="
                    width: 100%;
                    height: 44px;
                    padding: 0 14px 0 30px;
                    border-radius: 12px;
                    border: 1px solid <?php echo e($errors->has('price') ? '#dc2626' : '#e7e5e4'); ?>;
                    background: #fff;
                    color: #1c1917;
                    font-size: 14px;
                    font-weight: 500;
                    font-family: inherit;
                    font-variant-numeric: tabular-nums;
                    outline: none;
                    box-sizing: border-box;
                    <?php echo e($errors->has('price') ? 'box-shadow: 0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

                    transition: border-color .15s, box-shadow .15s;
                "
                onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
                onblur="this.style.borderColor='<?php echo e($errors->has('price') ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='<?php echo e($errors->has('price') ? '0 0 0 3px rgba(220,38,38,.1)' : 'none'); ?>'"
            >
        </div>
        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="margin: 6px 0 0; font-size: 12px; color: #dc2626; display:flex; align-items:center; gap:4px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                <?php echo e($message); ?>

            </p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div>
        <label for="cost_price" style="
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #78716c;
            margin-bottom: 7px;
        ">
            <?php echo e(__('form.product.cost_price')); ?>

        </label>
        <div style="position: relative;">
            <span style="
                position: absolute;
                left: 13px;
                top: 50%;
                transform: translateY(-50%);
                font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
                font-size: 16px;
                color: #78716c;
                pointer-events: none;
                line-height: 1;
            ">€</span>
            <input
                type="number"
                name="cost_price"
                id="cost_price"
                step="0.01"
                min="0"
                value="<?php echo e(old('cost_price', $product->cost_price ?? 0)); ?>"
                oninput="
                    const priceVal = parseFloat(document.getElementById('price')?.value || 0);
                    const costVal = parseFloat(this.value || 0);
                    this.setCustomValidity(costVal > priceVal ? '<?php echo e(__('form.product.cost_price_max')); ?>' : '');
                "
                style="
                    width: 100%;
                    height: 44px;
                    padding: 0 14px 0 30px;
                    border-radius: 12px;
                    border: 1px solid <?php echo e($errors->has('cost_price') ? '#dc2626' : '#e7e5e4'); ?>;
                    background: #fff;
                    color: #1c1917;
                    font-size: 14px;
                    font-weight: 500;
                    font-family: inherit;
                    font-variant-numeric: tabular-nums;
                    outline: none;
                    box-sizing: border-box;
                    <?php echo e($errors->has('cost_price') ? 'box-shadow: 0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

                    transition: border-color .15s, box-shadow .15s;
                "
                onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
                onblur="this.style.borderColor='<?php echo e($errors->has('cost_price') ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='<?php echo e($errors->has('cost_price') ? '0 0 0 3px rgba(220,38,38,.1)' : 'none'); ?>'"
            >
        </div>
        <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="margin: 6px 0 0; font-size: 12px; color: #dc2626; display:flex; align-items:center; gap:4px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                <?php echo e($message); ?>

            </p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

</div>

<style>
    @media (max-width: 540px) {
        #price, #category { }
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
    .dark input, .dark textarea {
        background: #1c1917 !important;
        color: #fafaf9 !important;
        border-color: #44403c !important;
    }
</style><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/products/_product_fields.blade.php ENDPATH**/ ?>