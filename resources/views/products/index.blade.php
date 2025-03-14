@extends('layouts.tabler')

@section('content')
    @php
    use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="page">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle text-muted text-uppercase">
                            OVERVIEW
                        </div>
                        <h2 class="page-title">
                            Clinic Supplies
                        </h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 5l0 14" /><path d="M5 12l14 0" />
                            </svg>
                            Add Medical Supply
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Medical Supplies & Inventory</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter table-bordered card-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary">Medical Supply</th>
                                    <th class="text-uppercase text-secondary">Barcode</th>
                                    <th class="text-uppercase text-secondary">Category</th>
                                    <th class="text-uppercase text-secondary">Unit</th>
                                    <th class="text-uppercase text-secondary text-center">Stock Level</th>
                                    <th class="text-uppercase text-secondary text-center">Reorder Point</th>
                                    <th class="text-uppercase text-secondary text-center">Price</th>
                                    <th class="text-uppercase text-secondary text-center">Created</th>
                                    <th class="text-uppercase text-secondary text-center">Updated</th>
                                    <th class="text-uppercase text-secondary text-center w-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img style="width: 90px;"
                                                     src="@if($product->product_image_data)
                                                              data:image/jpeg;base64,{{ base64_encode($product->product_image_data) }}
                                                          @elseif($product->product_image && Storage::disk('public')->exists($product->product_image))
                                                              {{ asset('storage/' . $product->product_image) }}
                                                          @else
                                                              {{ asset('assets/img/products/default.webp') }}
                                                          @endif"
                                                     alt="{{ $product->name }}">
                                                <div class="font-weight-medium">{{ $product->name }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="barcode-container py-1">
                                                <img src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ $product->code }}&scale=2&includetext&textxalign=center" 
                                                     alt="{{ $product->code }}"
                                                     class="barcode-image">
                                                <div class="small text-muted mt-1">{{ $product->code }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-blue-lt text-primary">
                                                {{ $product->category->name }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $product->unit->name }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $product->quantity <= $product->quantity_alert ? 'bg-red text-white' : 'bg-green-lt text-green' }}">
                                                {{ $product->quantity }} {{ $product->unit->short_code }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-yellow-lt text-warning">
                                                {{ $product->quantity_alert }} {{ $product->unit->short_code }}
                                            </span>
                                        </td>
                                        <td class="text-center">₱{{ number_format($product->selling_price, 2) }}</td>
                                        <td class="text-center text-muted">{{ $product->created_at->format('M d, Y') }}</td>
                                        <td class="text-center text-muted">{{ $product->updated_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('products.show', $product->uuid) }}" class="dropdown-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                                        </svg>
                                                        View Details
                                                    </a>
                                                    <a href="{{ route('products.edit', $product->uuid) }}" class="dropdown-item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-warning" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                        </svg>
                                                        Edit Supply
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('products.destroy', $product->uuid) }}" method="POST" class="dropdown-item p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7h16"/>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                                                <path d="M10 12l4 4m0 -4l-4 4"/>
                                                            </svg>
                                                            Delete Supply
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center p-4">
                                            <div class="empty">
                                                <div class="empty-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                        <path d="M9 10l.01 0" />
                                                        <path d="M15 10l.01 0" />
                                                        <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                                                    </svg>
                                                </div>
                                                <p class="empty-title">No medical supplies found</p>
                                                <p class="empty-subtitle text-muted">Start by adding your first medical supply to the inventory.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page-scripts')
    <script>
        // Initialize all dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function(dropdown) {
                new bootstrap.Dropdown(dropdown);
            });
        });
    </script>
    @endpush

    @push('page-styles')
    <style>
        /* Table styles */
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8fafc;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            color: #616876;
            padding: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }
        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        /* Avatar styles */
        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            object-fit: cover;
            border: 1px solid #e9ecef;
        }

        /* Badge styles */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 4px;
        }
        .bg-blue-lt {
            background-color: #e6effd !important;
        }
        .bg-green-lt {
            background-color: #e6f4e6 !important;
        }
        .bg-yellow-lt {
            background-color: #fef3e6 !important;
        }

        /* Button styles */
        .btn-group .btn-icon {
            padding: 0.25rem;
            width: 28px;
            height: 28px;
            border-radius: 4px;
        }
        .btn-icon svg {
            width: 16px;
            height: 16px;
        }

        /* Barcode styles */
        .barcode-container {
            text-align: center;
        }
        .barcode-image {
            max-width: 100px;
            height: 30px;
            display: inline-block;
        }

        /* Dropdown styles */
        .dropdown-menu {
            padding: 0.5rem 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .dropdown-item-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.25rem;
        }

        .dropdown-divider {
            margin: 0.25rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
    </style>
    @endpush
@endsection
