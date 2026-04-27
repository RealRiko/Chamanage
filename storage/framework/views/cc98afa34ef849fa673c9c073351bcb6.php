<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(__('pdf.report.page_title')); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 11px; margin: 0; padding: 24px; }
        .header { border-bottom: 2px solid #111827; padding-bottom: 10px; margin-bottom: 14px; }
        .title { font-size: 20px; font-weight: 700; margin: 0; }
        .sub { color: #6b7280; margin-top: 4px; font-size: 10px; }
        .filters { margin-top: 8px; border: 1px solid #e5e7eb; background: #f9fafb; border-radius: 8px; padding: 8px 10px; font-size: 10px; color: #374151; }
        .filters-row { margin: 1px 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { background: #f3f4f6; color: #374151; text-transform: uppercase; letter-spacing: .04em; font-size: 9px; border: 1px solid #e5e7eb; padding: 7px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 7px; vertical-align: top; }
        tbody tr:nth-child(even) { background: #fafafa; }
        .num { text-align: right; white-space: nowrap; }

        .totals { margin-top: 14px; width: 46%; margin-left: auto; border-collapse: collapse; }
        .totals td { border-bottom: 1px solid #e5e7eb; padding: 7px 8px; }
        .totals td:first-child { color: #6b7280; }
        .totals td:last-child { text-align: right; font-weight: 600; }
        .note { margin-top: 10px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title"><?php echo e(__('pdf.report.doc_heading', ['company' => $company->name])); ?></p>
        <p class="sub"><?php echo e(__('pdf.report.created_at', ['datetime' => now()->format('Y-m-d H:i')])); ?></p>
        <div class="filters">
            <div class="filters-row"><strong><?php echo e(__('pdf.report.filter_period')); ?>:</strong> <?php echo e($filters['date_from']->format('Y-m-d')); ?> — <?php echo e($filters['date_to']->format('Y-m-d')); ?></div>
            <?php if($filters['client_id']): ?><div class="filters-row"><strong><?php echo e(__('pdf.report.filter_client_id')); ?>:</strong> <?php echo e($filters['client_id']); ?></div><?php endif; ?>
            <?php if($filters['type']): ?><div class="filters-row"><strong><?php echo e(__('pdf.report.filter_type')); ?>:</strong> <?php echo e(__('pdf.document.types.' . $filters['type'])); ?></div><?php endif; ?>
            <?php if($filters['status']): ?><div class="filters-row"><strong><?php echo e(__('pdf.report.filter_status')); ?>:</strong> <?php echo e(__('form.document.status_' . $filters['status'])); ?></div><?php endif; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;"><?php echo e(__('reports.th_id')); ?></th>
                <th style="width: 16%;"><?php echo e(__('reports.th_type')); ?></th>
                <th style="width: 30%;"><?php echo e(__('reports.th_client')); ?></th>
                <th style="width: 16%;"><?php echo e(__('reports.th_invoice_date')); ?></th>
                <th style="width: 15%;"><?php echo e(__('reports.th_status')); ?></th>
                <th class="num" style="width: 15%;"><?php echo e(__('reports.amount')); ?> (EUR)</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>#<?php echo e($doc->id); ?></td>
                    <td><?php echo e(__('pdf.document.types.' . $doc->type)); ?></td>
                    <td><?php echo e($doc->client->name ?? '—'); ?></td>
                    <td><?php echo e($doc->invoice_date?->format('Y-m-d')); ?></td>
                    <td><?php echo e(__('form.document.status_' . $doc->status)); ?></td>
                    <td class="num"><?php echo e(number_format((float) $doc->total, 2, ',', ' ')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="totals">
        <tr><td><?php echo e(__('reports.paid_revenue')); ?></td><td>€<?php echo e(number_format((float) $paidRevenue, 2, ',', ' ')); ?></td></tr>
        <tr><td><?php echo e(__('reports.outstanding')); ?></td><td>€<?php echo e(number_format((float) $outstanding, 2, ',', ' ')); ?></td></tr>
    </table>

    <p class="note"><?php echo e(__('reports.paid_hint')); ?></p>
</body>
</html>
<?php /**PATH /home5/deveralv/chamanage.lat/CRM-main/resources/views/pdf/report.blade.php ENDPATH**/ ?>