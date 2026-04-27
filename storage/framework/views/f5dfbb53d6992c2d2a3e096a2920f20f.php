<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <?php
        $typeLabel = __('pdf.document.types.' . $document->type);
        $clientName = $document->client?->name ?? ($document->client_name_snapshot ?? '');
    ?>
    <title><?php echo e($typeLabel); ?><?php if($clientName !== ''): ?> — <?php echo e($clientName); ?><?php endif; ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 12px; margin: 0; padding: 26px; }
        .doc { width: 100%; }
        .top { width: 100%; border-bottom: 2px solid #111827; padding-bottom: 14px; margin-bottom: 18px; }
        .logo { max-width: 140px; max-height: 60px; margin-bottom: 8px; }
        .company-name { font-size: 20px; font-weight: 700; margin: 2px 0 6px; }
        .muted { color: #6b7280; }
        .doc-label { font-size: 10px; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; }
        .doc-title { font-size: 22px; font-weight: 700; margin: 2px 0 4px; color: #111827; line-height: 1.2; }
        .doc-client { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .meta td { padding: 2px 0 2px 12px; }
        .meta td:first-child { color: #6b7280; }

        .party-wrap { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 0; }
        .party-wrap td { vertical-align: top; width: 50%; }
        .party-pad-right { padding-right: 14px; }
        .party-divider { border-left: 1px solid #d1d5db; padding-left: 14px; }
        .party-head { margin: 0 0 8px; font-size: 10px; letter-spacing: .07em; text-transform: uppercase; color: #6b7280; font-weight: 600; }
        .party-body .name { font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 5px; }
        .line { margin: 2px 0; color: #374151; }

        .items { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .items th { background: #f3f4f6; color: #374151; text-transform: uppercase; letter-spacing: .04em; font-size: 10px; padding: 8px; border: 1px solid #e5e7eb; text-align: left; }
        .items td { padding: 8px; border: 1px solid #e5e7eb; vertical-align: top; }
        .items tbody tr:nth-child(even) { background: #fafafa; }
        .num { text-align: right; white-space: nowrap; }
        .desc { color: #6b7280; font-size: 11px; }

        .totals { width: 38%; margin-left: auto; margin-top: 14px; border-collapse: collapse; }
        .totals td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; }
        .totals td:first-child { color: #6b7280; }
        .totals td:last-child { text-align: right; font-weight: 600; color: #111827; }
        .totals .grand td { font-size: 14px; font-weight: 700; border-top: 2px solid #111827; border-bottom: 0; color: #111827; }

        .footer { margin-top: 24px; border-top: 1px solid #e5e7eb; padding-top: 10px; font-size: 10px; color: #6b7280; }
        .footer-line { margin-bottom: 4px; }
        .small-note { margin-top: 8px; }
        .footer-legal { margin-top: 12px; padding-top: 10px; border-top: 1px solid #e5e7eb; color: #374151; font-weight: 600; font-size: 10px; }
    </style>
</head>
<body>
<?php
    $subtotal = (float) $document->total;
    $vatRate = \App\Support\Vat::rateForCountry($company->country ?? null);
    $vatPercent = \App\Support\Vat::percentForCountry($company->country ?? null);
    $vatLineLabel = str_replace('21', (string) $vatPercent, __('pdf.document.vat_line'));
    $vatAmount = $subtotal * $vatRate;
    $grandTotal = $subtotal + $vatAmount;
    $paymentDays = (int) ($document->delivery_days ?? 0);
?>

<div class="doc">
    <table class="top" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td width="55%" valign="top">
                <?php if($logoBase64): ?>
                    <img src="<?php echo e($logoBase64); ?>" alt="<?php echo e(__('pdf.document.logo_alt')); ?>" class="logo">
                <?php endif; ?>
                <div class="company-name"><?php echo e($company->name ?? __('pdf.document.company_fallback')); ?></div>
                <div class="muted"><?php echo e($company->address ?? ''); ?><?php echo e($company->address && $company->city ? ', ' : ''); ?><?php echo e($company->city ?? ''); ?> <?php echo e($company->postal_code ?? ''); ?></div>
            </td>
            <td width="45%" valign="top" align="right">
                <div class="doc-label"><?php echo e(__('pdf.document.meta_label')); ?></div>
                <div class="doc-title"><?php echo e($typeLabel); ?></div>
                <?php if($clientName !== ''): ?>
                    <div class="doc-client"><?php echo e($clientName); ?></div>
                <?php endif; ?>
                <table class="meta" align="right">
                    <tr><td><?php echo e(__('pdf.document.issue_date')); ?></td><td><strong><?php echo e($document->invoice_date?->format('d.m.Y') ?? '—'); ?></strong></td></tr>
                    <tr><td><?php echo e(__('pdf.document.due_date')); ?></td><td><strong><?php echo e($document->due_date?->format('d.m.Y') ?? '—'); ?></strong></td></tr>
                    <tr><td><?php echo e(__('pdf.document.payment_term')); ?></td><td><strong><?php echo e(__('pdf.document.payment_days', ['count' => $paymentDays])); ?></strong></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="party-wrap" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="party-pad-right">
                <p class="party-head"><?php echo e(__('pdf.document.sender')); ?></p>
                <div class="party-body">
                    <div class="name"><?php echo e($company->name ?? '—'); ?></div>
                    <div class="line"><?php echo e($company->address ?? '—'); ?></div>
                    <div class="line"><?php echo e($company->city ?? ''); ?> <?php echo e($company->postal_code ?? ''); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.reg_no')); ?>: <?php echo e($company->registration_number ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.vat')); ?>: <?php echo e($company->vat_number ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.bank')); ?>: <?php echo e($company->bank_name ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.iban')); ?>: <?php echo e($company->account_number ?? '—'); ?></div>
                </div>
            </td>
            <td class="party-divider">
                <p class="party-head"><?php echo e(__('pdf.document.recipient')); ?></p>
                <div class="party-body">
                    <div class="name"><?php echo e($document->client?->name ?? $document->client_name_snapshot ?? '—'); ?></div>
                    <div class="line"><?php echo e($document->client?->address ?? '—'); ?></div>
                    <div class="line"><?php echo e($document->client?->city ?? ''); ?> <?php echo e($document->client?->postal_code ?? ''); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.reg_no')); ?>: <?php echo e($document->client?->registration_number ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.vat')); ?>: <?php echo e($document->client?->vat_number ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.bank')); ?>: <?php echo e($document->client?->bank ?? '—'); ?></div>
                    <div class="line"><?php echo e(__('pdf.document.iban')); ?>: <?php echo e($document->client?->bank_account ?? '—'); ?></div>
                </div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 32%;"><?php echo e(__('pdf.document.col_product')); ?></th>
                <th style="width: 28%;"><?php echo e(__('pdf.document.col_description')); ?></th>
                <th class="num" style="width: 10%;"><?php echo e(__('pdf.document.col_qty')); ?></th>
                <th class="num" style="width: 15%;"><?php echo e(__('pdf.document.col_unit_price')); ?></th>
                <th class="num" style="width: 15%;"><?php echo e(__('pdf.document.col_line_total')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $document->lineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($item->product->name ?? '—'); ?></strong></td>
                    <td class="desc"><?php echo e($item->product->description ?? '—'); ?></td>
                    <td class="num"><?php echo e((int) $item->quantity); ?></td>
                    <td class="num">€<?php echo e(number_format((float) $item->price, 2, ',', ' ')); ?></td>
                    <td class="num">€<?php echo e(number_format((float) $item->subtotal, 2, ',', ' ')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="totals">
        <tr><td><?php echo e(__('pdf.document.subtotal')); ?></td><td>€<?php echo e(number_format($subtotal, 2, ',', ' ')); ?></td></tr>
        <tr><td><?php echo e($vatLineLabel); ?></td><td>€<?php echo e(number_format($vatAmount, 2, ',', ' ')); ?></td></tr>
        <tr class="grand"><td><?php echo e(__('pdf.document.total')); ?></td><td>€<?php echo e(number_format($grandTotal, 2, ',', ' ')); ?></td></tr>
    </table>

    <?php
        $docContactName = trim((string) ($company->document_contact_name ?? ''));
        $docContactEmail = trim((string) ($company->document_contact_email ?? ''));
        $preparedParts = array_values(array_filter([$docContactName, $docContactEmail]));
        $footerExtra = trim((string) ($company->footer_contacts ?? ''));
    ?>
    <div class="footer">
        <?php if(count($preparedParts) > 0): ?>
            <div class="footer-line"><?php echo e(__('pdf.document.footer_prepared')); ?> <?php echo e(implode(', ', $preparedParts)); ?></div>
        <?php endif; ?>
        <?php if($document->due_date): ?>
            <div class="footer-line"><?php echo e(__('pdf.document.footer_term')); ?> <?php echo e($document->due_date->format('d.m.Y')); ?></div>
        <?php endif; ?>
        <?php if($footerExtra !== ''): ?>
            <div class="small-note"><?php echo nl2br(e($footerExtra)); ?></div>
        <?php endif; ?>
        <div class="footer-legal"><?php echo e(__('pdf.document.footer_valid')); ?></div>
    </div>
</div>
</body>
</html>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/pdf/document.blade.php ENDPATH**/ ?>