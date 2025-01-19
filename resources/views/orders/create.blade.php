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
                    <form action="{{ route('invoice.create') }}" method="POST">
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
                                    <label class="small mb-1" for="customer_id">
                                        {{ __('Customer (Pet Owner)') }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-select form-control-solid @error('customer_id') is-invalid @enderror" 
                                            id="customer_id" 
                                            name="customer_id">
                                        <option selected="" disabled="">
                                            Select a pet owner:
                                        </option>

                                        @foreach ($users->where('role', 'pet_owner') as $user)
                                            <option value="{{ $user->id }}" @selected(old('customer_id') == $user->id)>
                                                {{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('customer_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="small mb-1" for="reference">
                                        {{ __('Order Reference') }}
                                    </label>

                                    <input type="text" class="form-control"
                                           id="reference"
                                           name="reference"
                                           value="{{ 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) }}"
                                           readonly
                                    >

                                    @error('reference')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered card-table table-vcenter text-nowrap" id="cart-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col" class="text-center">{{ __('Quantity') }}</th>
                                            <th scope="col" class="text-center">{{ __('Price') }}</th>
                                            <th scope="col" class="text-center">{{ __('SubTotal') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-items" class="cart-drop-zone">
                                        @forelse ($carts as $item)
                                        <tr class="cart-item" data-id="{{ $item->id }}">
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td style="min-width: 170px;">
                                                <form action="{{ route('pos.updateCartItem', $item->rowId) }}" method="POST">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="qty" required value="{{ old('qty', $item->qty) }}">
                                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-success">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M5 12l5 5l10 -10" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center">€{{ number_format($item->price, 2) }}</td>
                                            <td class="text-center">€{{ number_format($item->subtotal, 2) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('pos.deleteCartItem', $item->rowId) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-icon btn-outline-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="empty-cart-row">
                                            <td colspan="5">
                                                <div class="empty-cart-message">
                                                    <div class="drop-zone-indicator">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-drag-drop-2" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M8 8m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M4 4m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M4 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M12 4m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                            <path d="M8 8v8l8 -8v8" />
                                                        </svg>
                                                        <p>{{ __('Drag and drop products here to add to cart') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Total Product
                                            </td>
                                            <td class="text-center">
                                                {{ Cart::count() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Subtotal</td>
                                            <td class="text-center">
                                                {{ Cart::subtotal() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Tax</td>
                                            <td class="text-center">
                                                {{ Cart::tax() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Total</td>
                                            <td class="text-center">
                                                {{ Cart::total() }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success add-list mx-1 {{ Cart::count() > 0 ? '' : 'disabled' }}">
                                {{ __('Create Invoice') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Products') }}</h3>
                        <div class="ms-2">
                            <input type="text" class="form-control" id="product-search" placeholder="Search products...">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cards" id="products-grid">
                            @foreach($products as $product)
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-sm product-item" 
                                     draggable="true" 
                                     data-product-id="{{ $product->id }}"
                                     data-product-name="{{ $product->name }}"
                                     data-product-price="{{ $product->selling_price }}"
                                     data-product-stock="{{ $product->quantity }}">
                                    <div class="product-image">
                                        @if($product->product_image)
                                            <img src="{{ asset('storage/' . $product->product_image) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/img/products/default.webp') }}"
                                                 class="card-img-top" 
                                                 alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="text-truncate">{{ $product->name }}</div>
                                        <div class="text-muted">€{{ number_format($product->selling_price, 2) }}</div>
                                        <div class="text-muted">Stock: {{ $product->quantity }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-item {
    cursor: move;
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-item:hover, .product-item.dragging {
    transform: translateY(-5px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.product-item.dragging {
    opacity: 0.5;
}

.product-image {
    height: 150px;
    overflow: hidden;
    background-color: #f8f9fa;
    border-radius: 4px 4px 0 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-drop-zone {
    min-height: 200px;
    transition: all 0.3s ease;
    position: relative;
}

.cart-drop-zone.drag-over {
    background-color: rgba(0, 123, 255, 0.1);
}

.cart-drop-zone.drag-over .empty-cart-message {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
}

.empty-cart-message {
    padding: 3rem;
    text-align: center;
    color: #666;
    border: 3px dashed #ccc;
    border-radius: 8px;
    margin: 1rem;
    transition: all 0.3s ease;
}

.drop-zone-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.drop-zone-indicator svg {
    color: #666;
    width: 48px;
    height: 48px;
}

.drop-zone-indicator p {
    margin: 0;
    font-size: 1.1rem;
    color: #666;
}

.empty-cart-row {
    height: 200px;
}
</style>

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productItems = document.querySelectorAll('.product-item');
    const cartDropZone = document.querySelector('.cart-drop-zone');
    const productSearch = document.getElementById('product-search');
    let isDragging = false;
    let debounceTimer;

    // Debounced search function
    const debounceSearch = (func, delay) => {
        return function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(this, arguments), delay);
        }
    };

    // Optimized search
    productSearch?.addEventListener('input', debounceSearch(function(e) {
        const searchTerm = e.target.value.toLowerCase();
        requestAnimationFrame(() => {
            productItems.forEach(item => {
                const productName = item.dataset.productName.toLowerCase();
                item.closest('.col-sm-6').style.display = 
                    productName.includes(searchTerm) ? '' : 'none';
            });
        });
    }, 250));

    // Optimized drag and drop
    productItems.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            isDragging = true;
            e.dataTransfer.setData('text/plain', this.dataset.productId);
            this.classList.add('dragging');
            cartDropZone.classList.add('potential-drop');
        });

        item.addEventListener('dragend', function() {
            isDragging = false;
            this.classList.remove('dragging');
            cartDropZone.classList.remove('potential-drop');
        });
    });

    // Use passive event listeners for better scroll performance
    cartDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        if (isDragging) {
            this.classList.add('drag-over');
        }
    }, { passive: false });

    cartDropZone.addEventListener('drop', async function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const productId = e.dataTransfer.getData('text/plain');
        if (!productId) return;

        // Find the product data from the dragged item
        const draggedItem = document.querySelector(`.product-item[data-product-id="${productId}"]`);
        const productName = draggedItem.dataset.productName;
        const productPrice = draggedItem.dataset.productPrice;

        // Remove empty cart message if it exists
        const emptyMessage = this.querySelector('.empty-cart-row');
        if (emptyMessage) {
            emptyMessage.remove();
        }

        // Optimistically add the row
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${productName}</td>
            <td style="min-width: 170px;">
                <div class="input-group">
                    <input type="number" class="form-control" value="1" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-success" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </button>
                    </div>
                </div>
            </td>
            <td class="text-center">€${parseFloat(productPrice).toFixed(2)}</td>
            <td class="text-center">€${parseFloat(productPrice).toFixed(2)}</td>
            <td class="text-center">
                <button class="btn btn-icon btn-outline-danger" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" />
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                    </svg>
                </button>
            </td>
        `;
        this.appendChild(newRow);

        // Update totals immediately
        updateCartTotals(1, parseFloat(productPrice));

        try {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', productId);

            const response = await fetch('{{ route('pos.addCartItem') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const result = await response.json();
            
            if (!result.success) {
                // If failed, remove the optimistically added row
                newRow.remove();
                alert(result.message || 'Failed to add product to cart');
                // Revert totals
                updateCartTotals(-1, -parseFloat(productPrice));
            } else {
                // Replace optimistic row with actual data
                location.reload();
            }
        } catch (error) {
            // If error, remove the optimistically added row
            newRow.remove();
            console.error('Error:', error);
            alert('Error adding product to cart. Please try again.');
            // Revert totals
            updateCartTotals(-1, -parseFloat(productPrice));
        }
    });

    // Function to update cart totals
    function updateCartTotals(quantityChange, priceChange) {
        const totalProductElement = document.querySelector('tfoot tr:nth-child(1) td:last-child');
        const subtotalElement = document.querySelector('tfoot tr:nth-child(2) td:last-child');
        const taxElement = document.querySelector('tfoot tr:nth-child(3) td:last-child');
        const totalElement = document.querySelector('tfoot tr:nth-child(4) td:last-child');

        // Update total products
        const currentProducts = parseInt(totalProductElement.textContent.trim());
        totalProductElement.textContent = currentProducts + quantityChange;

        // Update subtotal
        const currentSubtotal = parseFloat(subtotalElement.textContent.trim());
        subtotalElement.textContent = (currentSubtotal + priceChange).toFixed(2);

        // Update tax (assuming 10% tax rate - adjust as needed)
        const taxRate = 0.1;
        const newTax = priceChange * taxRate;
        const currentTax = parseFloat(taxElement.textContent.trim());
        taxElement.textContent = (currentTax + newTax).toFixed(2);

        // Update total
        const currentTotal = parseFloat(totalElement.textContent.trim());
        totalElement.textContent = (currentTotal + priceChange + newTax).toFixed(2);
    }
});
</script>
@endpush

@endsection
