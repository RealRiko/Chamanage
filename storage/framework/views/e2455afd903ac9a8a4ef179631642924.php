<?php
    $client = $client ?? null;
?>


<?php if(session('success')): ?>
    <div class="success-banner" role="status">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        <div><?php echo e(session('success')); ?></div>
    </div>
<?php endif; ?>

<?php
$fields = [
    ['name'=>'name','label'=>'form.client.label_name','required'=>true],
    ['name'=>'email','label'=>'form.client.label_email','type'=>'email'],
    ['name'=>'phone','label'=>'form.client.label_phone'],
    ['name'=>'address','label'=>'form.client.label_address'],
    ['name'=>'city','label'=>'form.client.label_city'],
    ['name'=>'postal_code','label'=>'form.client.label_postal'],
    ['name'=>'registration_number','label'=>'form.client.label_registration','default'=>'N/A'],
    ['name'=>'vat_number','label'=>'form.client.label_vat','default'=>'N/A'],
    ['name'=>'bank','label'=>'form.client.label_bank','default'=>'N/A'],
    ['name'=>'bank_account','label'=>'form.client.label_bank_account','default'=>'N/A'],
];
?>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div style="<?php echo e(in_array($field['name'], ['name','email']) ? 'grid-column: span 2;' : ''); ?>">
        
        
        <label for="<?php echo e($field['name']); ?>" style="
            display:block;
            font-size:11px;
            font-weight:600;
            letter-spacing:.07em;
            text-transform:uppercase;
            color:#78716c;
            margin-bottom:7px;
        ">
            <?php echo e(__($field['label'])); ?>


            <?php if(!empty($field['required'])): ?>
                <span style="display:inline-block;width:5px;height:5px;border-radius:50%;background:#b45309;margin-left:4px;"></span>
            <?php endif; ?>
        </label>

        
        <input
            type="<?php echo e($field['type'] ?? 'text'); ?>"
            name="<?php echo e($field['name']); ?>"
            id="<?php echo e($field['name']); ?>"
            value="<?php echo e(old($field['name'], $client->{$field['name']} ?? ($field['default'] ?? ''))); ?>"
            <?php echo e(!empty($field['required']) ? 'required' : ''); ?>

            autocomplete="off"
            style="
                width:100%;
                height:44px;
                padding:0 14px;
                border-radius:12px;
                border:1px solid <?php echo e($errors->has($field['name']) ? '#dc2626' : '#e7e5e4'); ?>;
                background:#fff;
                color:#1c1917;
                font-size:14px;
                outline:none;
                box-sizing:border-box;
                <?php echo e($errors->has($field['name']) ? 'box-shadow:0 0 0 3px rgba(220,38,38,.1);' : ''); ?>

                transition:border-color .15s, box-shadow .15s;
            "
            onfocus="this.style.borderColor='#d97706'; this.style.boxShadow='0 0 0 3px rgba(217,119,6,.12)'"
            onblur="this.style.borderColor='<?php echo e($errors->has($field['name']) ? '#dc2626' : '#e7e5e4'); ?>'; this.style.boxShadow='<?php echo e($errors->has($field['name']) ? '0 0 0 3px rgba(220,38,38,.1)' : 'none'); ?>'"
        >

        
        <?php $__errorArgs = [$field['name']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p style="margin:6px 0 0;font-size:12px;color:#dc2626;display:flex;align-items:center;gap:4px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                </svg>
                <?php echo e($message); ?>

            </p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>


<style>
@media (max-width: 540px) {
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns:1fr !important;
    }
}
.dark input {
    background:#1c1917 !important;
    color:#fafaf9 !important;
    border-color:#44403c !important;
}
</style><?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/clients/_client_fields.blade.php ENDPATH**/ ?>