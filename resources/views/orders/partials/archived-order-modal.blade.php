<div class="modal modal-blur fade" id="viewOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - {{ $order->invoice_no }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4>Order Information</h4>
                        <div class="mb-2">
                            <strong>Customer:</strong> {{ $order->customer_name }}
                        </div>
                        <div class="mb-2">
                            <strong>Order Date:</strong> 
                            @if($order->order_date)
                                {{ $order->order_date->format('M d, Y g:i A') }}
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Archive Date:</strong> 
                            @if($order->archived_at)
                                {{ $order->archived_at->format('M d, Y g:i A') }}
                                <div class="text-muted small">
                                    {{ $order->archived_at->diffForHumans() }}
                                </div>
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $order->archive_reason === 'completed' ? 'success' : 'danger' }}-lt">
                                {{ ucfirst($order->archive_reason) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h4>Payment Details</h4>
                        <div class="mb-2">
                            <strong>Subtotal:</strong> ₱{{ number_format($order->sub_total, 2) }}
                        </div>
                        <div class="mb-2">
                            <strong>VAT:</strong> ₱{{ number_format($order->vat, 2) }}
                        </div>
                        <div class="mb-2">
                            <strong>Total Amount:</strong> ₱{{ number_format($order->total, 2) }}
                        </div>
                    </div>
                </div>

                @if($order->archivedDetails && $order->archivedDetails->count() > 0)
                    <h4>Order Items</h4>
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->archivedDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product_name }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-end">₱{{ number_format($detail->unit_price, 2) }}</td>
                                        <td class="text-end">₱{{ number_format($detail->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($order->note)
                    <div class="mt-3">
                        <strong>Note:</strong>
                        <p class="mb-0">{{ $order->note }}</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 