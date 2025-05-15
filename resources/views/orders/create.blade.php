@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">
                                {{ __('New Order') }}
                            </h3>
                        </div>
                        <div class="card-actions btn-actions">
                            <x-action.close route="{{ route('orders.index') }}"/>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="card-actions btn-list">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                </svg>
                                {{ __('Back to Orders') }}
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST" id="orderForm" onsubmit="return false;">
                    @csrf
                        <div class="card-body">
                            <div class="row gx-3 mb-3">
                                @include('partials.session')
                                <div class="col-md-4">
                                    <label for="purchase_date" class="small my-1">
                                        {{ __('Date') }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input name="purchase_date" id="purchase_date" type="date"
                                           class="form-control example-date-input @error('purchase_date') is-invalid @enderror"
                                           value="{{ old('purchase_date') ?? now()->format('Y-m-d') }}"
                                           required
                                    >

                                    @error('purchase_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="small mb-1" for="id">
                                        {{ __('Pet Owner') }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="id" id="id" class="form-control @error('id') is-invalid @enderror" required>
                                        <option value="">Select Pet Owner</option>
                                        @foreach($petOwners as $owner)
                                            <option value="{{ $owner->id }}" 
                                                    {{ old('id') == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->name }} ({{ $owner->email }})
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="small mb-1" for="reference">
                                        {{ __('Reference') }}
                                    </label>

                                    <input type="text" 
                                           class="form-control" 
                                           id="reference" 
                                           name="reference" 
                                           value="{{ $reference }}" 
                                           readonly>

                                    @error('reference')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Order Note</label>
                                    <textarea class="form-control" 
                                              name="note" 
                                              rows="3" 
                                              placeholder="Add any notes about this order..."></textarea>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <div class="cart-items-container" id="cart-container">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Product Name</th>
                                                <th scope="col" class="text-center">Quantity</th>
                                                <th scope="col" class="text-center">Price</th>
                                                <th scope="col" class="text-center">SubTotal</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($carts as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-center">
                                                    <div class="input-group" style="width: 120px; margin: 0 auto;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary decrease-qty" 
                                                                onclick="updateQuantity('{{ $item->rowId }}', -1, {{ $item->qty }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                                <path d="M5 12h14"/>
                                                            </svg>
                                                        </button>
                                                        <input type="number" class="form-control text-center qty-input" 
                                                               value="{{ $item->qty }}" min="1" readonly 
                                                               data-rowid="{{ $item->rowId }}">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary increase-qty" 
                                                                onclick="updateQuantity('{{ $item->rowId }}', 1, {{ $item->qty }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                                <path d="M12 5v14m-7-7h14"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-center">₱{{ number_format($item->price, 2) }}</td>
                                                <td class="text-center">₱{{ number_format($item->subtotal, 2) }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <button type="button" 
                                                                class="btn btn-icon btn-outline-danger delete-cart-item" 
                                                                data-rowid="{{ $item->rowId }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" 
                                                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                                                 stroke="currentColor" fill="none">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7l16 0"/>
                                                                <path d="M10 11l0 6"/>
                                                                <path d="M14 11l0 6"/>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <p class="text-muted">Drop products here</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Subtotal: ₱</span>
                                    <strong id="cart-subtotal">{{ number_format(Cart::subtotal(), 2) }}</strong>
                                </div>
                                <div>
                                    <span class="text-muted">Total: ₱</span>
                                    <strong id="cart-total">{{ number_format(Cart::total(), 2) }}</strong>
                                    <button type="button" 
                                            class="btn btn-primary ms-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#paymentModal"
                                            id="placeOrderBtn" 
                                            style="display: none;"
                                            onclick="updateModalFields()">
                                        Process Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="col-lg-5">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">
                        <h3 class="card-title">Available Products</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <input type="text" id="productSearch" class="form-control mb-3" placeholder="Search products...">
                                
                                <!-- Add horizontal scrollable categories -->
                                <div class="categories-scroll-container mb-3">
                                    <div class="categories-wrapper">
                                        <button class="category-btn active" data-category="all">All</button>
                                        <button class="category-btn" data-category="food">Food</button>
                                        <button class="category-btn" data-category="medicine">Medicine</button>
                                        <button class="category-btn" data-category="accessories">Accessories</button>
                                        <button class="category-btn" data-category="grooming">Grooming</button>
                                        <button class="category-btn" data-category="toys">Toys</button>
                                    </div>
                                </div>
                                
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-container">
                                        @forelse ($products as $product)
                                        <tr class="product-item" 
                                            draggable="true" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->selling_price }}"
                                            data-category="{{ $product->category->name ?? 'other' }}">
                                            <td class="text-center">{{ $product->name }}</td>
                                            <td class="text-center">{{ $product->quantity }}</td>
                                            <td class="text-center">{{ $product->unit->name }}</td>
                                            <td class="text-center">{{ number_format($product->selling_price, 2) }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-icon btn-outline-primary add-to-cart-btn">
                                                    <x-icon.cart/>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No products found!</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="drag-preview" class="drag-preview">
    <div class="product-info"></div>
</div>

<!-- Update the form for adding products -->
<form id="add-to-cart-form" style="display: none;">
    @csrf
    <input type="hidden" name="id" id="product_id">
    <input type="hidden" name="name" id="product_name">
    <input type="hidden" name="price" id="product_price">
</form>

<!-- Replace the existing payment modal with this updated version -->
<div class="modal modal-blur fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.store') }}" method="POST" id="paymentForm">
                @csrf
                <div id="orderErrors" class="alert alert-danger" style="display: none; margin: 10px;"></div>
                
                <!-- Hidden fields for order data -->
                <input type="hidden" name="uuid" value="{{ Str::uuid() }}">
                <input type="hidden" name="id" id="form_customer_id">
                <input type="hidden" name="order_date" id="form_purchase_date">
                <input type="hidden" name="reference" value="{{ $reference }}">
                <input type="hidden" name="total_products" value="{{ Cart::count() }}">
                <input type="hidden" name="sub_total" value="{{ Cart::subtotal() }}">
                <input type="hidden" name="vat" value="{{ Cart::tax() }}">
                <input type="hidden" name="total" value="{{ Cart::total() }}">
                <input type="hidden" name="invoice_no" value="INV-{{ strtoupper(uniqid()) }}">
                <input type="hidden" name="note" id="form_note">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Total Amount Due</label>
                        <input type="text" class="form-control" value="₱{{ number_format(Cart::total(), 2) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Received</label>
                        <input type="number" 
                               class="form-control" 
                               name="amount_received" 
                               step="0.01" 
                               min="{{ Cart::total() }}"
                               onchange="calculateChange(this.value, {{ Cart::total() }})"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change</label>
                        <input type="text" class="form-control" id="changeAmount" readonly>
                    </div>

                    <div class="alert alert-info">
                        <h4 class="alert-title">Order Summary</h4>
                        <p>Total Items: {{ Cart::count() }}</p>
                        <p class="mb-0">Subtotal: ₱{{ number_format(Cart::subtotal(), 2) }}</p>
                        <p class="mb-0">VAT (12%): ₱{{ number_format(Cart::tax(), 2) }}</p>
                        <p class="mb-0"><strong>Total Amount: ₱{{ number_format(Cart::total(), 2) }}</strong></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmPaymentBtn" disabled>
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update the JavaScript for handling form submission -->
<script>
// Add notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `toast-notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('id');
    const purchaseDateInput = document.getElementById('purchase_date');
    const orderForm = document.getElementById('orderForm');
    const formCustomerId = document.getElementById('form_customer_id');
    const formPurchaseDate = document.getElementById('form_purchase_date');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const paymentForm = document.getElementById('paymentForm');

    // Function to update modal fields
    function updateModalFields() {
        const customerId = document.getElementById('id').value;
        const purchaseDate = document.getElementById('purchase_date').value;

        // Update the hidden fields in the modal form
        document.getElementById('form_customer_id').value = customerId;
        document.getElementById('form_purchase_date').value = purchaseDate;

        // Toggle place order button
        if (placeOrderBtn) {
            placeOrderBtn.style.display = customerId ? 'inline-block' : 'none';
        }

        console.log('Updated modal fields:', {
            id: customerId,
            order_date: purchaseDate
        });
    }

    // Update fields when opening modal
    const modalTrigger = document.querySelector('[data-bs-target="#paymentModal"]');
    if (modalTrigger) {
        modalTrigger.addEventListener('click', updateModalFields);
    }

    // Update fields when customer selection changes
    if (customerSelect) {
        customerSelect.addEventListener('change', function() {
            updateModalFields();
            // Log selected customer details
            const selectedOption = this.options[this.selectedIndex];
            console.log('Selected customer:', {
                id: this.value,
                name: selectedOption.text
            });
        });
    }
    
    // Update fields when purchase date changes
    if (purchaseDateInput) {
        purchaseDateInput.addEventListener('change', updateModalFields);
    }

    // Set initial values
    updateModalFields();

    paymentForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const formDataObj = Object.fromEntries(formData);
        
        // Debug log
        console.log('Sending form data:', formDataObj);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: formDataObj.id,
                    order_date: formDataObj.order_date,
                    reference: formDataObj.reference,
                    total_products: formDataObj.total_products,
                    sub_total: formDataObj.sub_total,
                    vat: formDataObj.vat,
                    total: formDataObj.total,
                    invoice_no: formDataObj.invoice_no
                })
            });

            const data = await response.json();
            console.log('Response:', data);

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('orderErrors').textContent = error.message;
            document.getElementById('orderErrors').style.display = 'block';
        }
    });
});
</script>

@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.getElementById('cart-container');
    const productSearch = document.getElementById('productSearch');
    const productsContainer = document.getElementById('products-container');
    const dragPreview = document.getElementById('drag-preview');
    let draggedProduct = null;

    // Category filter functionality
    const categoryButtons = document.querySelectorAll('.category-btn');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to the clicked button
            this.classList.add('active');
            
            const category = this.dataset.category;
            const products = productsContainer.getElementsByClassName('product-item');
            
            // Filter products based on category
            Array.from(products).forEach(product => {
                if (category === 'all') {
                    product.style.display = '';
                } else {
                    const productCategory = product.dataset.category || '';
                    product.style.display = productCategory.toLowerCase() === category.toLowerCase() ? '' : 'none';
                }
            });
        });
    });

    // Product search functionality
    productSearch?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const products = productsContainer.getElementsByClassName('product-item');
        
        Array.from(products).forEach(product => {
            const productName = product.dataset.productName.toLowerCase();
            product.style.display = productName.includes(searchTerm) ? '' : 'none';
        });
    });

    // Make products draggable
    document.querySelectorAll('.product-item').forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);

        // Add click handler for cart button
        const cartBtn = item.querySelector('.add-to-cart-btn');
        if (cartBtn) {
            cartBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = item.dataset.productId;
                submitAddToCart(productId);
            });
        }
    });

    // Cart container events
    if (cartContainer) {
        cartContainer.addEventListener('dragover', handleDragOver);
        cartContainer.addEventListener('dragenter', handleDragEnter);
        cartContainer.addEventListener('dragleave', handleDragLeave);
        cartContainer.addEventListener('drop', handleDrop);
    }

    function handleDragStart(e) {
        draggedProduct = e.target.closest('.product-item');
        draggedProduct.classList.add('dragging');
        dragPreview.style.display = 'block';
        dragPreview.querySelector('.product-info').textContent = draggedProduct.dataset.productName;
        
        // Set the drag data
        e.dataTransfer.setData('text/plain', JSON.stringify({
            id: draggedProduct.dataset.productId,
            name: draggedProduct.dataset.productName,
            price: draggedProduct.dataset.productPrice
        }));
    }

    function handleDragEnd() {
        if (draggedProduct) {
            draggedProduct.classList.remove('dragging');
            dragPreview.style.display = 'none';
        }
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDragEnter(e) {
        e.preventDefault();
    }

    function handleDragLeave() {
        cartContainer.classList.remove('drag-over');
    }

    function handleDrop(e) {
        e.preventDefault();
        cartContainer.classList.remove('drag-over');
        
        try {
            const data = JSON.parse(e.dataTransfer.getData('text/plain'));
            submitAddToCart(data.id, data.name, data.price);
        } catch (error) {
            console.error('Error adding item to cart:', error);
            showNotification('Failed to add item to cart', 'error');
        }
    }

    function showMessage(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function updateQuantity(rowId, change, currentQty) {
        const newQty = parseInt(currentQty) + parseInt(change);
        if (newQty < 1) return;

        // Send AJAX request to update the cart
        fetch(`/cart/update/${rowId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                qty: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the quantity input
                const qtyInput = document.querySelector(`input[data-rowid="${rowId}"]`);
                qtyInput.value = newQty;
                
                // Update the subtotal and total
                const row = qtyInput.closest('tr');
                const subtotalCell = row.querySelector('td:nth-last-child(2)');
                subtotalCell.textContent = '₱' + (newQty * parseFloat(data.price)).toFixed(2);
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = data.subtotal;
                document.getElementById('cart-total').textContent = data.total;
                
                // Show success notification
                showToast('Quantity updated successfully', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to update quantity', 'error');
        });
    }

    // Add toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Remove the toast after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function updateCartTotals() {
        fetch('/cart/totals')
            .then(response => response.json())
            .then(data => {
                document.querySelector('#cart-subtotal').textContent = '₱' + data.subtotal;
                document.querySelector('#cart-total').textContent = '₱' + data.total;
            });
    }

    // Add this to prevent form submission on enter key
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    });

    // Handle delete cart item
    document.querySelectorAll('.delete-cart-item').forEach(button => {
        button.addEventListener('click', function() {
            const rowId = this.dataset.rowid;
            
            if (confirm('Are you sure you want to remove this item?')) {
                // Send DELETE request
                fetch(`/cart/${rowId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = this.closest('tr');
                        row.remove();
                        
                        // Update totals
                        document.getElementById('cart-subtotal').textContent = data.subtotal;
                        document.getElementById('cart-total').textContent = data.total;
                        document.getElementById('modal-total').textContent = data.total;
                        
                        // Show success message
                        showNotification('Item removed successfully', 'success');
                        
                        // If cart is empty, show empty message
                        const tbody = document.querySelector('tbody');
                        if (tbody.children.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-muted">Drop products here</p>
                                    </td>
                                </tr>
                            `;
                        }
                    } else {
                        showNotification('Failed to remove item', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to remove item', 'error');
                });
            }
        });
    });

    // Notification helper function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `toast-notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Function to add item to cart
    async function submitAddToCart(productId, name, price) {
        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, price })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            // Refresh the cart display
            window.location.reload();
        } catch (error) {
            console.error('Error:', error);
            showNotification('Failed to add item to cart', 'error');
        }
    }

    function calculateChange(amountReceived, total) {
        const change = parseFloat(amountReceived) - parseFloat(total);
        const changeInput = document.getElementById('changeAmount');
        const submitBtn = document.getElementById('confirmPaymentBtn');
        
        if (change >= 0) {
            changeInput.value = '₱' + change.toFixed(2);
            submitBtn.disabled = false;
        } else {
            changeInput.value = 'Insufficient amount';
            submitBtn.disabled = true;
        }
    }

    // Update form note when modal opens
    document.getElementById('paymentModal').addEventListener('show.bs.modal', function () {
        const noteContent = document.getElementById('note').value;
        document.getElementById('form_note').value = noteContent;
    });

    // Remove extra modal backdrop
    document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
        const extraBackdrops = document.querySelectorAll('.modal-backdrop');
        if (extraBackdrops.length > 1) {
            extraBackdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        }
    });
});
</script>

<style>
.drag-preview {
    position: fixed;
    display: none;
    background: #206bc4;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    pointer-events: none;
    z-index: 9999;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.cart-items-container {
    min-height: 150px;
    transition: all 0.2s ease;
    background-color: #fff;
}

.cart-items-container.drag-over {
    background-color: rgba(32, 107, 196, 0.1);
}

.product-item {
    cursor: grab;
    transition: all 0.2s ease;
}

.product-item.dragging {
    opacity: 0.6;
    cursor: grabbing;
    background-color: rgba(32, 107, 196, 0.1);
}

/* Remove the dashed borders */
.cart-items-container {
    border: none;
    border-radius: 0;
}

.cart-items-container.drag-over {
    border: none;
    transform: none;
}

.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 4px;
    color: white;
    z-index: 1000;
    animation: slideIn 0.3s ease-out;
}

.toast-notification.success {
    background-color: #28a745;
}

.toast-notification.error {
    background-color: #dc3545;
}

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

.modal {
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-backdrop {
    display: none !important;
}

.modal-dialog {
    margin: 1.75rem auto;
    max-width: 500px;
}

.modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
}

.modal.show {
    display: block;
    padding-right: 17px;
}

.spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.2em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border .75s linear infinite;
    margin-right: 0.5rem;
}

@keyframes spinner-border {
    to { transform: rotate(360deg); }
}

/* Horizontal scrollable categories */
.categories-scroll-container {
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.categories-scroll-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}

.categories-wrapper {
    display: inline-flex;
    padding: 0 4px;
}

.category-btn {
    display: inline-block;
    padding: 8px 16px;
    margin-right: 8px;
    border: 1px solid #e0e0e0;
    border-radius: 20px;
    background-color: #f9f9f9;
    color: #495057;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-size: 14px;
}

.category-btn.active {
    background-color: #7952b3;
    color: white;
    border-color: #7952b3;
}

.category-btn:hover:not(.active) {
    background-color: #e9ecef;
}
</style>

@push('page-scripts')
<script>
// Function to remove extra modal backdrops
function removeExtraBackdrops() {
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => {
        backdrop.remove();
    });
}

// Add event listener for modal hidden
document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
    removeExtraBackdrops();
});

// Function to calculate change
function calculateChange(amountReceived, total) {
    const change = parseFloat(amountReceived) - parseFloat(total);
    const changeInput = document.getElementById('changeAmount');
    const submitBtn = document.getElementById('confirmPaymentBtn');
    
    if (change >= 0) {
        changeInput.value = '₱' + change.toFixed(2);
        submitBtn.disabled = false;
    } else {
        changeInput.value = 'Insufficient amount';
        submitBtn.disabled = true;
    }
}

// Update form note when modal opens
document.getElementById('paymentModal').addEventListener('show.bs.modal', function () {
    const noteContent = document.getElementById('note').value;
    document.getElementById('form_note').value = noteContent;
    removeExtraBackdrops(); // Remove any existing backdrops before showing new modal
});

// Add this to handle the order modal
document.addEventListener('DOMContentLoaded', function() {
    // Remove any existing modal backdrops on page load
    removeExtraBackdrops();
});
</script>

<style>
/* Add this CSS to ensure proper modal display */
.modal-backdrop {
    display: none !important;
}

.modal {
    background: rgba(0, 0, 0, 0.5);
}
</style>
@endpush
