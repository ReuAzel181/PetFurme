<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                <div>
                    <h3 class="card-title mb-0">CHARGE SLIP</h3>
                    <div class="text-muted small">No: <span class="text-danger" id="invoiceNumber">0011086</span></div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="printChargeSlip()">
                <i class="fas fa-print me-1"></i> Print
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Patient Information -->
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="mb-2">
                    <label class="form-label text-muted small mb-1">Name of Patient</label>
                    <div id="patient-name" class="form-control-plaintext border-bottom py-1"></div>
                </div>
                <div class="mb-2">
                    <label class="form-label text-muted small mb-1">Attending Physician</label>
                    <input type="text" class="form-control-plaintext border-bottom py-1" name="attending_physician">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <label class="form-label text-muted small mb-1">Address</label>
                    <input type="text" class="form-control-plaintext border-bottom py-1" name="address">
                </div>
                <div class="mb-2">
                    <label class="form-label text-muted small mb-1">Company</label>
                    <input type="text" class="form-control-plaintext border-bottom py-1" name="company">
                </div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="table-responsive">
            <table class="table table-sm table-bordered" id="servicesTable">
                <thead>
                    <tr>
                        <th class="text-uppercase small">Description</th>
                        <th width="30%" class="text-uppercase small">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-select form-select-sm service-select" name="services[]">
                                <option value="">Select Service</option>
                                <option value="UA">Urinalysis (UA)</option>
                                <option value="PA">Physical Assessment (PA)</option>
                                <option value="CBC">Complete Blood Count (CBC)</option>
                                <option value="PE">Physical Examination (PE)</option>
                            </select>
                        </td>
                        <td>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control form-control-sm service-amount" name="amounts[]" step="0.01" onchange="updateTotals()">
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end small">Total:</td>
                        <td><span id="total" class="fw-bold">₱0.00</span></td>
                    </tr>
                    <tr>
                        <td class="text-end small">Discount:</td>
                        <td>
                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <input type="number" class="form-control form-control-sm" id="discountAmount" value="0" min="0" max="100" step="1" onchange="updateTotals()">
                                    <span class="input-group-text">%</span>
                                </div>
                                <span id="discountValue" class="small text-muted">₱0.00</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end fw-bold small">Grand Total:</td>
                        <td><span id="grandTotal" class="fw-bold text-primary">₱0.00</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer Information -->
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Time</label>
                <input type="time" class="form-control-plaintext border-bottom py-1 small" name="time" value="{{ date('H:i') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Date</label>
                <input type="date" class="form-control-plaintext border-bottom py-1 small" name="date" value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Charged by</label>
                <input type="text" class="form-control-plaintext border-bottom py-1 small" name="charged_by" value="{{ auth()->user()->name }}">
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

.table > :not(caption) > * > * {
    padding: 0.5rem;
}

.form-select, .form-control {
    padding: 0.25rem 0.5rem;
}

@media print {
    body * {
        visibility: hidden;
    }
    .card, .card * {
        visibility: visible;
    }
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn-outline-primary {
        display: none;
    }
}
</style>

<script>
function updateTotals() {
    let total = 0;
    
    // Calculate total from services
    document.querySelectorAll('.service-amount').forEach(input => {
        total += parseFloat(input.value || 0);
    });

    // Update total display
    document.getElementById('total').textContent = `₱${total.toFixed(2)}`;

    // Calculate discount
    const discountPercent = parseFloat(document.getElementById('discountAmount').value || 0);
    const discount = total * (discountPercent / 100);
    
    // Update discount value display
    document.getElementById('discountValue').textContent = `₱${discount.toFixed(2)}`;
    
    // Calculate grand total
    const grandTotal = total - discount;
    document.getElementById('grandTotal').textContent = `₱${grandTotal.toFixed(2)}`;
}

// Add row when service is selected
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('service-select') && e.target.value) {
        const lastRow = e.target.closest('tr');
        const isLastRow = lastRow === lastRow.parentElement.lastElementChild;
        
        if (isLastRow) {
            const newRow = lastRow.cloneNode(true);
            newRow.querySelectorAll('input, select').forEach(input => input.value = '');
            lastRow.parentElement.appendChild(newRow);
        }
    }
});

function printChargeSlip() {
    window.print();
}
</script> 