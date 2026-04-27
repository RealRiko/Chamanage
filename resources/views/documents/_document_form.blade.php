@if (session('success'))
    <div class="alert alert-success mb-6" role="status">
        <div class="alert-icon">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error mb-6" role="alert">
        <div class="alert-icon">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <ul class="list-inside list-disc space-y-1 text-sm" style="margin: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $formDocument = $document ?? $sourceDocument ?? null;

    if (old('line_items')) {
        $lineItems = old('line_items');
    } elseif ($formDocument && $formDocument->lineItems && $formDocument->lineItems->count() > 0) {
        $lineItems = $formDocument->lineItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        })->toArray();
    } else {
        $lineItems = [[]];
    }
@endphp

<form id="documentForm" action="{{ isset($document) ? route('documents.update', $document) : route('documents.store') }}" method="POST" class="space-y-6">
    @csrf
    @if (isset($document))
        @method('PATCH')
    @endif

    @include('documents._document_fields', ['document' => $formDocument])

    <div class="flex flex-col-reverse gap-3 border-t border-zinc-200/80 pt-8 sm:flex-row sm:items-center sm:justify-between dark:border-white/10">
        <a href="{{ route('documents.index') }}" class="btn-secondary justify-center sm:justify-start">
            ← {{ __('form.back') }}
        </a>
        <button type="submit" id="submitBtn" class="btn-primary px-8 py-3">
            {{ isset($document) ? __('form.document.submit_update') : __('form.document.submit_create') }}
        </button>
    </div>
</form>

@push('scripts')
@php
    $companyCountry = auth()->user()?->company?->country;
    $vatRate = \App\Support\Vat::rateForCountry($companyCountry);
    $vatMultiplier = \App\Support\Vat::multiplierForCountry($companyCountry);
    $docStatusLabels = [
        'draft' => __('form.document.status_draft'),
        'sent' => __('form.document.status_sent'),
        'confirmed' => __('form.document.status_confirmed'),
        'cancelled' => __('form.document.status_cancelled'),
        'waiting_payment' => __('form.document.status_waiting_payment'),
        'paid' => __('form.document.status_paid'),
    ];
    $docMsgOutOfStock = __('form.document.msg_out_of_stock');
    $docMsgQtyExceeds = __('form.document.msg_qty_exceeds');
@endphp
<script>
document.addEventListener('DOMContentLoaded', () => {
    const VAT_RATE = @json($vatRate);
    const VAT_MULTIPLIER = @json($vatMultiplier);
    const STATUS_LABELS = @json($docStatusLabels);
    const MSG_OUT_OF_STOCK = @json($docMsgOutOfStock);
    const MSG_QTY_EXCEEDS = @json($docMsgQtyExceeds);

    // --- Status Dropdown ---
    const typeSelect = document.getElementById('type');
    const statusSelect = document.getElementById('status');
    const currentStatus = @json(old('status', $formDocument?->status ?? ''));

    function populateStatusOptions() {
        let options = [];
        const type = typeSelect.value;

        if (type === 'estimate') {
            options = [
                {value: 'draft'},
                {value: 'sent'}
            ];
        } else if (type === 'sales_order') {
            options = [
                {value: 'draft'},
                {value: 'confirmed'},
                {value: 'cancelled'}
            ];
        } else if (type === 'sales_invoice') {
            options = [
                {value: 'waiting_payment'},
                {value: 'paid'}
            ];
        }

        statusSelect.innerHTML = '';
        options.forEach(opt => {
            const optionEl = document.createElement('option');
            optionEl.value = opt.value;
            optionEl.textContent = STATUS_LABELS[opt.value] || opt.value;
            if (opt.value === currentStatus) optionEl.selected = true;
            statusSelect.appendChild(optionEl);
        });
    }

    populateStatusOptions();
    typeSelect.addEventListener('change', populateStatusOptions);

    // --- Line Items ---
    const container = document.getElementById('line-items');
    const addBtn = document.getElementById('add-line-item');
    const stockWarning = document.getElementById('stock-warning');
    const warningMessage = document.getElementById('warning-message');
    const vatToggle = document.getElementById('apply_vat');
    const sumNet = document.getElementById('sum-net');
    const sumVat = document.getElementById('sum-vat');
    const sumGross = document.getElementById('sum-gross');
    const sumCost = document.getElementById('sum-cost');
    const sumProfit = document.getElementById('sum-profit');
    const profitLinesBody = document.getElementById('profit-lines-body');

    let lineIndex = {{ count($lineItems) }};

    function showWarning(message, type = 'error') {
        warningMessage.textContent = message;
        stockWarning.className = 'hidden';
        if (type === 'warning') {
            stockWarning.className = 'mb-4 p-4 rounded-xl border-l-4 shadow-md bg-yellow-50 dark:bg-yellow-900/20 border-yellow-500 text-yellow-700 dark:text-yellow-300';
        } else {
            stockWarning.className = 'mb-4 p-4 rounded-xl border-l-4 shadow-md bg-red-50 dark:bg-red-900/20 border-red-500 text-red-700 dark:text-red-300';
        }
    }

    function hideWarning() {
        stockWarning.classList.add('hidden');
    }

    function validateAllLineItems() {
        const lineItems = container.querySelectorAll('.line-item');
        let warnings = [];

        lineItems.forEach(line => {
            const productSelect = line.querySelector('.product-select');
            const quantityInput = line.querySelector('.quantity-input');
            const selected = productSelect.options[productSelect.selectedIndex];

            line.classList.remove('border-red-400', 'border-yellow-400');

            if (!selected.value) return;

            const currentStock = parseInt(selected.getAttribute('data-stock')) || 0;
            const originalQty = parseInt(quantityInput.getAttribute('data-original-qty')) || 0;
            const newQty = parseInt(quantityInput.value) || 0;
            const productName = selected.textContent.split('(')[0].trim();
            const availableStock = currentStock + originalQty;

            if (availableStock <= 0) {
                warnings.push(MSG_OUT_OF_STOCK.replace(':product', productName).replace(':available', String(availableStock)));
                line.classList.add('border-red-400');
            } else if (newQty > availableStock) {
                warnings.push(MSG_QTY_EXCEEDS.replace(':product', productName).replace(':qty', String(newQty)).replace(':available', String(availableStock)));
                line.classList.add('border-yellow-400');
            }
        });

        if (warnings.length) {
            showWarning('⚠️ ' + warnings.join(' | '), 'warning');
        } else {
            hideWarning();
        }
    }

    function syncBasePriceFromDisplayed(priceInput) {
        if (!priceInput || !vatToggle) return;
        const v = parseFloat(priceInput.value);
        if (!Number.isFinite(v) || v < 0) return;
        priceInput.setAttribute('data-base-price', v.toFixed(6));
    }

    function updatePricesWithVAT() {
        // Cenas ievadā vienmēr paliek neto; PVN ietekmē tikai kopsavilkuma aprēķinus.
        return;
    }

    function formatEur(value) {
        return '€' + (Number(value) || 0).toFixed(2);
    }

    function updateSummary() {
        if (!sumNet || !sumVat || !sumGross || !sumCost || !sumProfit || !profitLinesBody) return;

        const applyVAT = vatToggle.checked;
        let netRevenue = 0;
        let vatAmount = 0;
        let costTotal = 0;
        const rows = [];

        container.querySelectorAll('.line-item').forEach(line => {
            const productSelect = line.querySelector('.product-select');
            const priceInput = line.querySelector('.price-input');
            const quantityInput = line.querySelector('.quantity-input');
            const selected = productSelect.options[productSelect.selectedIndex];
            if (!selected || !selected.value) return;

            const quantity = parseFloat(quantityInput.value) || 0;
            if (quantity <= 0) return;

            const unitNetPrice = parseFloat(priceInput.value) || 0;
            const lineNet = quantity * unitNetPrice;
            const lineCost = quantity * (parseFloat(selected.getAttribute('data-cost')) || 0);
            const lineProfit = lineNet - lineCost;
            const productName = selected.textContent.split('(')[0].trim();

            netRevenue += lineNet;
            vatAmount += applyVAT ? (lineNet * VAT_RATE) : 0;
            costTotal += lineCost;

            rows.push(
                `<tr>
                    <td>${productName}</td>
                    <td class="num">${formatEur(lineNet)}</td>
                    <td class="num">${formatEur(lineCost)}</td>
                    <td class="num">${formatEur(lineProfit)}</td>
                </tr>`
            );
        });

        const grossTotal = netRevenue + vatAmount;
        const profitTotal = netRevenue - costTotal;

        sumNet.textContent = formatEur(netRevenue);
        sumVat.textContent = formatEur(vatAmount);
        sumGross.textContent = formatEur(grossTotal);
        sumCost.textContent = formatEur(costTotal);
        sumProfit.textContent = formatEur(profitTotal);
        sumProfit.style.color = profitTotal < 0 ? '#dc2626' : '#15803d';

        profitLinesBody.innerHTML = rows.length
            ? rows.join('')
            : `<tr><td colspan="4" class="doc-summary-empty">${@json(__('form.document.summary_no_lines'))}</td></tr>`;
    }

    container.addEventListener('change', e => {
        if (e.target.classList.contains('product-select')) {
            const line = e.target.closest('.line-item');
            const priceInput = line.querySelector('.price-input');
            const selected = e.target.options[e.target.selectedIndex];
            const price = parseFloat(selected.getAttribute('data-price')) || 0;

            if (!priceInput.value) priceInput.value = price.toFixed(2);
            priceInput.setAttribute('data-base-price', price);

            validateAllLineItems();
            updatePricesWithVAT();
            updateSummary();
        }
    });

    vatToggle.addEventListener('change', () => {
        updatePricesWithVAT();
        updateSummary();
    });

    let validationTimeout;
    container.addEventListener('input', e => {
        if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
            if (e.target.classList.contains('price-input')) {
                syncBasePriceFromDisplayed(e.target);
            }
            clearTimeout(validationTimeout);
            validationTimeout = setTimeout(() => {
                validateAllLineItems();
                updateSummary();
            }, 300);
        }
    });

    addBtn.addEventListener('click', () => {
        const template = container.querySelector('.line-item');
        const newLine = template.cloneNode(true);

        newLine.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace(/\d+/, lineIndex);
            if (el.tagName === 'INPUT') el.value = '';
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
            el.setAttribute('data-original-qty', '0');
        });

        const oldRemoveBtn = newLine.querySelector('.remove-line-item');
        if (oldRemoveBtn) oldRemoveBtn.remove();

        const actionCell = newLine.querySelector('.doc-line-cell--action');
        if (actionCell) {
            actionCell.querySelector('.doc-line-placeholder')?.remove();
            actionCell.querySelector('.doc-label--muted')?.remove();
            const head = document.createElement('span');
            head.className = 'doc-label doc-label-line doc-label--action';
            head.textContent = container.dataset.deleteLabel || '';
            actionCell.appendChild(head);
        }

        const buttonWrap = document.createElement('div');
        buttonWrap.innerHTML = `
            <button type="button" class="remove-line-item doc-remove-btn" title="">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
        const btn = buttonWrap.firstElementChild;
        btn.title = container.dataset.deleteLabel || '';
        if (actionCell) actionCell.appendChild(btn);

        container.appendChild(newLine);
        lineIndex++;
        updatePricesWithVAT();
        updateSummary();
    });

    container.addEventListener('click', e => {
        if (e.target.closest('.remove-line-item')) {
            if (container.querySelectorAll('.line-item').length > 1) {
                e.target.closest('.line-item').remove();
                validateAllLineItems();
                updatePricesWithVAT();
                updateSummary();
            }
        }
    });

    setTimeout(() => {
        validateAllLineItems();
        updatePricesWithVAT();
        updateSummary();
    }, 100);
});
</script>
@endpush
