@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Product Image') }}</h3>
                    </div>
                    <div class="card-body">
                        <img class="img-account-profile mb-2" 
                            src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}" 
                            alt="" 
                            id="image-preview" 
                            style="width: 100%; max-width: 200px; display: block; margin: 0 auto;"
                        />

                        <div class="small font-italic text-muted mb-2 text-center">
                            JPG or PNG no larger than 2 MB
                        </div>

                        <input type="file" 
                            accept="image/*" 
                            id="image" 
                            name="product_image" 
                            class="form-control @error('product_image') is-invalid @enderror" 
                            onchange="previewImage();"
                        >
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Product Details') }}</h3>
                        <div class="card-actions">
                            <a href="{{ route('products.index') }}" class="btn-action">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 6l-12 12"></path>
                                    <path d="M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->uuid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name', $product->name) }}" placeholder="Product name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Product category') }} <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="" disabled>Select a category:</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Unit') }} <span class="text-danger">*</span></label>
                                        <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">
                                            <option value="" disabled>Select a unit:</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Buying Price') }}</label>
                                        <input type="number" name="buying_price" class="form-control @error('buying_price') is-invalid @enderror" 
                                            value="{{ old('buying_price', $product->buying_price) }}" placeholder="0">
                                        @error('buying_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Selling Price') }}</label>
                                        <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" 
                                            value="{{ old('selling_price', $product->selling_price) }}" placeholder="0">
                                        @error('selling_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Quantity') }}</label>
                                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                            value="{{ old('quantity', $product->quantity) }}" placeholder="0">
                                        @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Quantity Alert') }}</label>
                                        <input type="number" name="quantity_alert" class="form-control @error('quantity_alert') is-invalid @enderror" 
                                            value="{{ old('quantity_alert', $product->quantity_alert) }}" placeholder="0">
                                        @error('quantity_alert')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Tax') }}</label>
                                        <input type="number" name="tax" class="form-control @error('tax') is-invalid @enderror" 
                                            value="{{ old('tax', $product->tax) }}" placeholder="0">
                                        @error('tax')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Tax Type') }}</label>
                                        <select name="tax_type" class="form-select @error('tax_type') is-invalid @enderror">
                                            @foreach(\App\Enums\TaxType::cases() as $taxType)
                                                <option value="{{ $taxType->value }}" {{ old('tax_type', $product->tax_type?->value) == $taxType->value ? 'selected' : '' }}>
                                                    {{ $taxType->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tax_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Notes') }}</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                    rows="3" placeholder="Product notes">{{ old('notes', $product->notes) }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
function previewImage() {
    const image = document.querySelector('#image');
    const imgPreview = document.querySelector('#image-preview');
    
    if (image.files && image.files[0]) {
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
}
</script>
@endpush
@endsection
