@extends('layouts.mobile-app')

@section('content')
<div class="min-h-screen bg-white pb-24">
    <!-- Header -->
    <div class="px-4 pt-6 pb-4">
        <h1 class="text-[24px] font-bold text-[#1a237e]">Clinic Supplies</h1>
        <p class="text-sm text-gray-600 mt-1">Browse our available medical supplies and products</p>
    </div>

    <!-- Products Grid -->
    <div class="px-4">
        @if($products->isNotEmpty())
            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                @foreach($products as $product)
                    <div class="flex flex-col">
                        <!-- Product Image -->
                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg mb-3">
                            <img 
                                src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-contain p-2"
                                onerror="this.src='{{ asset('assets/img/products/default.webp') }}'"
                            >
                        </div>

                        <!-- Category Badge -->
                        <span class="text-xs font-medium {{ $product->category->name === 'Medicine' ? 'text-blue-600' : 'text-green-600' }} mb-1">
                            {{ $product->category->name }}
                        </span>

                        <!-- Product Name -->
                        <h3 class="text-[15px] font-medium text-gray-900 leading-tight mb-1">
                            {{ $product->name }}
                        </h3>

                        <!-- Price and Stock -->
                        <div class="flex items-center justify-between mt-auto">
                            <span class="font-bold text-gray-900">
                                ₱{{ number_format($product->selling_price, 2) }}
                            </span>
                            
                            @if($product->quantity > 0)
                                <span class="text-xs text-green-600">
                                    {{ $product->quantity }} {{ $product->unit->short_code }}
                                </span>
                            @else
                                <span class="text-xs text-red-500">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <div class="w-16 h-16 text-gray-400 mb-4">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-gray-500 text-sm">No products available</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .aspect-w-1 {
        position: relative;
        padding-bottom: 100%;
    }
    .aspect-w-1 > img {
        position: absolute;
        height: 100%;
        width: 100%;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
</style>
@endpush
@endsection