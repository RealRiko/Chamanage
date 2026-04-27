<?php
    $document = $document ?? null;
    $companyCountry = auth()->user()?->company?->country;
    $vatRate = \App\Support\Vat::rateForCountry($companyCountry);
    $vatMultiplier = \App\Support\Vat::multiplierForCountry($companyCountry);
    $vatPercent = \App\Support\Vat::percentForCountry($companyCountry);
    $vatLabel = str_replace('21', (string) $vatPercent, __('form.document.vat'));
    $vatSummaryLabel = str_replace('21', (string) $vatPercent, __('form.document.summary_vat'));
?>


<div class="doc-grid doc-field-section">
    <div>
        <label for="type" class="doc-label"><?php echo e(__('form.document.label_type')); ?> <span class="req-dot" aria-hidden="true"></span></label>
        <select name="type" id="type" class="doc-input custom-select" required>
            <option value="estimate" <?php if(old('type', optional($document)->type) === 'estimate'): echo 'selected'; endif; ?>><?php echo e(__('form.document.type_estimate')); ?></option>
            <option value="sales_order" <?php if(old('type', optional($document)->type) === 'sales_order'): echo 'selected'; endif; ?>><?php echo e(__('form.document.type_sales_order')); ?></option>
            <option value="sales_invoice" <?php if(old('type', optional($document)->type) === 'sales_invoice'): echo 'selected'; endif; ?>><?php echo e(__('form.document.type_sales_invoice')); ?></option>
        </select>
        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="doc-field-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="status" class="doc-label"><?php echo e(__('form.document.label_status')); ?> <span class="req-dot" aria-hidden="true"></span></label>
        <select name="status" id="status" class="doc-input custom-select" required></select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="doc-field-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>


<div class="doc-block-mb doc-field-section">
    <label for="client_id" class="doc-label"><?php echo e(__('form.document.label_client')); ?> <span class="req-dot" aria-hidden="true"></span></label>
    <select name="client_id" id="client_id" class="doc-input custom-select" required>
        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($client->id); ?>" <?php if(old('client_id', optional($document)->client_id) == $client->id): echo 'selected'; endif; ?>><?php echo e($client->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="doc-field-error"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="doc-grid doc-field-section">
    <div>
        <label for="invoice_date" class="doc-label"><?php echo e(__('form.document.label_invoice_date')); ?> <span class="req-dot" aria-hidden="true"></span></label>
        <input
            type="date"
            name="invoice_date"
            id="invoice_date"
            class="doc-input <?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> doc-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            required
            value="<?php echo e(old('invoice_date', optional($document)->invoice_date?->format('Y-m-d'))); ?>"
        >
        <?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="doc-field-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label for="delivery_days" class="doc-label"><?php echo e(__('form.document.label_delivery')); ?></label>
        <input
            type="number"
            name="delivery_days"
            id="delivery_days"
            class="doc-input <?php $__errorArgs = ['delivery_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> doc-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            min="0"
            value="<?php echo e(old('delivery_days', optional($document)->delivery_days)); ?>"
            placeholder="<?php echo e(__('form.document.placeholder_delivery')); ?>"
        >
        <?php $__errorArgs = ['delivery_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="doc-field-error"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>


<div class="doc-shell">
    <?php
        $docApplyVat = filter_var(
            old('apply_vat', optional($document)->apply_vat ?? true),
            FILTER_VALIDATE_BOOLEAN
        );
    ?>
    <div class="doc-header">
        <h2 class="doc-line-items-title"><?php echo e(__('form.document.line_items')); ?></h2>
        <div class="doc-vat-wrap">
            <span class="doc-vat-label"><?php echo e($vatLabel); ?></span>
            <div class="doc-vat-control" role="group" aria-label="<?php echo e($vatLabel); ?>">
                <input type="hidden" name="apply_vat" value="0">
                <input type="checkbox" id="apply_vat" name="apply_vat" value="1" class="doc-vat-checkbox" <?php if($docApplyVat): echo 'checked'; endif; ?>>
                <label for="apply_vat" class="doc-vat-switch-ui">
                    <span class="doc-vat-track"></span>
                    <span class="doc-vat-knob"></span>
                </label>
            </div>
        </div>
    </div>

    <div id="stock-warning" class="mb-4 hidden rounded-xl border-l-4 p-4 shadow-sm">
        <p id="warning-message" class="text-sm font-medium"></p>
    </div>

    <div id="line-items" class="doc-line-items-gap" data-delete-label="<?php echo e(e(__('page.action_delete'))); ?>">
        <?php $__currentLoopData = $lineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="line-item">
                <div class="doc-line-row">
                    <div class="doc-line-cell doc-line-cell--product">
                        <label class="doc-label doc-label-line" for="line_product_<?php echo e($index); ?>"><?php echo e(__('form.document.label_product')); ?></label>
                        <select
                            id="line_product_<?php echo e($index); ?>"
                            name="line_items[<?php echo e($index); ?>][product_id]"
                            class="product-select doc-input custom-select text-sm"
                            data-original-qty="<?php echo e($item['quantity'] ?? 0); ?>"
                            required
                        >
                            <option value=""><?php echo e(__('form.document.select_product')); ?></option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($product->id); ?>"
                                    data-price="<?php echo e($product->price); ?>"
                                    data-cost="<?php echo e($product->cost_price ?? 0); ?>"
                                    data-stock="<?php echo e($product->stock); ?>"
                                    <?php if(old("line_items.$index.product_id", $item['product_id'] ?? '') == $product->id): echo 'selected'; endif; ?>
                                >
                                    <?php echo e($product->name); ?> (<?php echo e(__('form.document.stock_prefix')); ?>: <?php echo e($product->stock); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="doc-line-cell doc-line-cell--qty">
                        <label class="doc-label doc-label-line" for="line_qty_<?php echo e($index); ?>"><?php echo e(__('form.document.label_qty')); ?></label>
                        <input
                            id="line_qty_<?php echo e($index); ?>"
                            type="number"
                            name="line_items[<?php echo e($index); ?>][quantity]"
                            value="<?php echo e(old("line_items.$index.quantity", $item['quantity'] ?? '')); ?>"
                            class="quantity-input doc-input text-sm"
                            min="1"
                            placeholder="<?php echo e(__('form.document.placeholder_qty')); ?>"
                            data-original-qty="<?php echo e($item['quantity'] ?? 0); ?>"
                            required
                        >
                    </div>

                    <?php
                        $storedUnit = $item['price'] ?? null;
                        $displayUnit = $storedUnit;
                        if ($storedUnit !== null && $storedUnit !== '' && is_numeric($storedUnit) && $docApplyVat) {
                            $displayUnit = (float) $storedUnit / $vatMultiplier;
                        }
                        $basePriceAttr = '';
                        if ($displayUnit !== null && $displayUnit !== '' && is_numeric($displayUnit)) {
                            $basePriceAttr = number_format((float) $displayUnit, 6, '.', '');
                        }
                    ?>
                    <div class="doc-line-cell doc-line-cell--price">
                        <label class="doc-label doc-label-line" for="line_price_<?php echo e($index); ?>"><?php echo e(__('form.document.label_price')); ?></label>
                        <input
                            id="line_price_<?php echo e($index); ?>"
                            type="number"
                            name="line_items[<?php echo e($index); ?>][price]"
                            value="<?php echo e(old("line_items.$index.price", $displayUnit ?? '')); ?>"
                            class="price-input doc-input text-sm"
                            step="0.01"
                            min="0"
                            placeholder="<?php echo e(__('form.document.placeholder_price')); ?>"
                            data-base-price="<?php echo e($basePriceAttr); ?>"
                            required
                        >
                    </div>

                    <div class="doc-line-cell doc-line-cell--action">
                        <?php if($index > 0): ?>
                            <span class="doc-label doc-label-line doc-label--action"><?php echo e(__('page.action_delete')); ?></span>
                            <button type="button" class="remove-line-item doc-remove-btn" title="<?php echo e(__('page.action_delete')); ?>">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        <?php else: ?>
                            <span class="doc-label doc-label-line doc-label--action doc-label--muted">&nbsp;</span>
                            <span class="doc-line-placeholder" aria-hidden="true"></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="doc-summary-box" id="doc-summary-box">
        <div class="doc-summary-grid">
            <div>
                <h3 class="doc-summary-title"><?php echo e(__('form.document.summary_title')); ?></h3>
                <table class="doc-summary-table">
                    <tr><td><?php echo e(__('form.document.summary_net')); ?></td><td id="sum-net">€0.00</td></tr>
                    <tr><td><?php echo e($vatSummaryLabel); ?></td><td id="sum-vat">€0.00</td></tr>
                    <tr class="doc-summary-total"><td><?php echo e(__('form.document.summary_gross')); ?></td><td id="sum-gross">€0.00</td></tr>
                    <tr><td><?php echo e(__('form.document.summary_cost')); ?></td><td id="sum-cost">€0.00</td></tr>
                    <tr class="doc-summary-profit"><td><?php echo e(__('form.document.summary_profit')); ?></td><td id="sum-profit">€0.00</td></tr>
                </table>
            </div>
            <div>
                <h3 class="doc-summary-title"><?php echo e(__('form.document.summary_profit_table')); ?></h3>
                <table class="doc-profit-table">
                    <thead>
                        <tr>
                            <th><?php echo e(__('form.document.label_product')); ?></th>
                            <th class="num"><?php echo e(__('form.document.summary_revenue')); ?></th>
                            <th class="num"><?php echo e(__('form.document.summary_cost_short')); ?></th>
                            <th class="num"><?php echo e(__('form.document.summary_profit_short')); ?></th>
                        </tr>
                    </thead>
                    <tbody id="profit-lines-body">
                        <tr><td colspan="4" class="doc-summary-empty"><?php echo e(__('form.document.summary_no_lines')); ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <button type="button" id="add-line-item" class="btn-primary mt-4 inline-flex items-center gap-2">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <?php echo e(__('form.document.add_line')); ?>

    </button>
</div>

<style>
/* Bloku atstarpe — lai lauki ne „salīp” */
.doc-field-section { margin-bottom: 24px; }
.doc-field-section:last-of-type { margin-bottom: 0; }

.doc-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}
.doc-grid > div { min-width: 0; }

.doc-block-mb { margin-bottom: 24px; }

.doc-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: #57534e;
    margin-bottom: 7px;
}
.doc-label-inline { margin-bottom: 6px; font-size: 10px; letter-spacing: .08em; }

.req-dot {
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #b45309;
    vertical-align: middle;
    margin-left: 4px;
    margin-bottom: 2px;
}

/* Obligāti atsevišķi background-color un bultiņa — savādāk select zaudē baltu fonu */
.doc-input {
    display: block;
    width: 100%;
    max-width: 100%;
    height: 44px;
    padding: 0 14px;
    border-radius: 12px;
    border: 1px solid #d6d3d1;
    background-color: #ffffff;
    color: #1c1917;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    box-sizing: border-box;
    transition: border-color .15s, box-shadow .15s, background-color .15s;
}
.doc-input.text-sm { font-size: 13px; height: 42px; }

.doc-input:focus {
    border-color: #d97706;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, .15);
}

.doc-input-error {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, .12) !important;
}

.doc-field-error {
    margin: 6px 0 0;
    font-size: 12px;
    color: #b91c1c;
    display: flex;
    align-items: center;
    gap: 4px;
}

select.doc-input.custom-select {
    appearance: none;
    -webkit-appearance: none;
    padding-right: 38px;
    cursor: pointer;
    background-color: #ffffff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%2378716c' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px 14px;
}

.doc-shell {
    border-radius: 16px;
    border: 1px solid #d6d3d1;
    background-color: #fafaf9;
    padding: 20px;
    margin-top: 8px;
}

.doc-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e7e5e4;
}

.doc-line-items-title {
    margin: 0;
    font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
    font-size: 17px;
    font-weight: 700;
    color: #1c1917;
}

.doc-vat-wrap { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.doc-vat-label { font-size: 13px; font-weight: 600; color: #57534e; }

/* PVN slēdzis: pelēks = izsl., dzintars = iesl. */
.doc-vat-control {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.doc-vat-checkbox {
    position: absolute;
    opacity: 0;
    width: 48px;
    height: 26px;
    margin: 0;
    cursor: pointer;
    z-index: 2;
}
.doc-vat-switch-ui {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
    cursor: pointer;
}
.doc-vat-track {
    position: absolute;
    inset: 0;
    border-radius: 999px;
    background: #a8a29e;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, .12);
    transition: background .2s, box-shadow .2s;
}
.doc-vat-knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
    transition: transform .2s;
}
#apply_vat:checked + .doc-vat-switch-ui .doc-vat-track {
    background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
    box-shadow: inset 0 1px 2px rgba(255, 255, 255, .2), 0 0 0 1px rgba(180, 83, 9, .35);
}
#apply_vat:checked + .doc-vat-switch-ui .doc-vat-knob {
    transform: translateX(22px);
}
#apply_vat:focus-visible + .doc-vat-switch-ui .doc-vat-track {
    outline: 2px solid #d97706;
    outline-offset: 2px;
}
.dark .doc-vat-track {
    background: #525252;
}
.dark #apply_vat:checked + .doc-vat-switch-ui .doc-vat-track {
    background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%);
    box-shadow: inset 0 1px 2px rgba(255, 255, 255, .12), 0 0 0 1px rgba(251, 191, 36, .25);
}

.doc-line-items-gap { display: flex; flex-direction: column; gap: 14px; }
.doc-summary-box { margin-top: 16px; border-radius: 12px; border: 1px solid #d6d3d1; background: #fff; padding: 14px; }
.doc-summary-grid { display: grid; grid-template-columns: 280px minmax(0, 1fr); gap: 16px; }
.doc-summary-title { margin: 0 0 8px; font-size: 11px; letter-spacing: .07em; text-transform: uppercase; color: #57534e; }
.doc-summary-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.doc-summary-table td { padding: 6px 0; border-bottom: 1px dashed #e7e5e4; }
.doc-summary-table td:last-child { text-align: right; font-variant-numeric: tabular-nums; font-weight: 600; }
.doc-summary-table .doc-summary-total td { border-top: 2px solid #e7e5e4; border-bottom: 0; font-weight: 700; }
.doc-summary-table .doc-summary-profit td { border-top: 1px solid #e7e5e4; border-bottom: 0; }
.doc-profit-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.doc-profit-table th, .doc-profit-table td { padding: 7px 8px; border: 1px solid #ecebe8; }
.doc-profit-table th { text-align: left; background: #f5f5f4; color: #57534e; font-size: 10px; letter-spacing: .06em; text-transform: uppercase; }
.doc-profit-table .num { text-align: right; font-variant-numeric: tabular-nums; }
.doc-summary-empty { color: #a8a29e; text-align: center; }

/* Rindas: režģis, ne flex items-end — lai etiķetes vienmēr virs laukiem */
.line-item {
    border-radius: 12px;
    border: 1px solid #d6d3d1;
    background-color: #ffffff;
    padding: 16px;
}
.doc-line-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 108px 120px 52px;
    gap: 14px 16px;
    align-items: start;
}
.doc-line-cell { min-width: 0; display: flex; flex-direction: column; }
.doc-label-line {
    margin-bottom: 6px;
    font-size: 10px;
    letter-spacing: .08em;
    line-height: 1.3;
}
.doc-label--action { color: #78716c; }
.doc-label--muted { visibility: hidden; }
.doc-line-placeholder {
    display: block;
    width: 44px;
    height: 42px;
}
.doc-remove-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 42px;
    border: none;
    border-radius: 10px;
    background: #dc2626;
    color: #fff;
    cursor: pointer;
    flex-shrink: 0;
    transition: background .15s;
}
.doc-remove-btn:hover { background: #b91c1c; }

@media (max-width: 768px) {
    .doc-line-row {
        grid-template-columns: 1fr;
    }
    .doc-line-cell--action {
        flex-direction: row;
        align-items: center;
        gap: 12px;
    }
    .doc-line-cell--action .doc-label-line { margin-bottom: 0; }
    .doc-line-placeholder { display: none; }
    .doc-summary-grid { grid-template-columns: 1fr; }
}

@media (max-width: 540px) {
    .doc-grid { grid-template-columns: 1fr !important; }
}

/* Tumšais režīms */
.dark .doc-label { color: #a8a29e; }
.dark .doc-vat-label { color: #a8a29e; }
.dark .doc-line-items-title { color: #fafaf9; }

.dark .doc-shell {
    background-color: rgba(28, 25, 23, 0.92) !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
}
.dark .doc-header { border-bottom-color: rgba(255, 255, 255, 0.1); }

.dark .doc-input,
.dark input.doc-input {
    background-color: #1c1917 !important;
    color: #fafaf9 !important;
    border-color: #57534e !important;
}

.dark select.doc-input.custom-select {
    background-color: #1c1917 !important;
    color: #fafaf9 !important;
    border-color: #57534e !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23a8a29e' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 14px 14px;
}

.dark .line-item {
    background-color: #262626 !important;
    border-color: rgba(255, 255, 255, 0.14) !important;
}
.dark .doc-label--action { color: #a8a29e; }
.dark .doc-remove-btn { background: #b91c1c; }
.dark .doc-remove-btn:hover { background: #991b1b; }
.dark .doc-summary-box { background: #262626; border-color: rgba(255, 255, 255, 0.14); }
.dark .doc-summary-title { color: #d6d3d1; }
.dark .doc-summary-table td { border-bottom-color: rgba(255,255,255,.08); color: #e7e5e4; }
.dark .doc-summary-table .doc-summary-total td,
.dark .doc-summary-table .doc-summary-profit td { border-top-color: rgba(255,255,255,.14); }
.dark .doc-profit-table th { background: #1f1f1f; color: #d6d3d1; border-color: rgba(255,255,255,.14); }
.dark .doc-profit-table td { border-color: rgba(255,255,255,.08); color: #f5f5f4; }
.dark .doc-summary-empty { color: #a8a29e; }
</style>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/documents/_document_fields.blade.php ENDPATH**/ ?>