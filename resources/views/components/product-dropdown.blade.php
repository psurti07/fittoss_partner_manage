 @push('style-css')
<style>
.select2-container--default .select2-selection--single {
    height: calc(2.25rem + 2px) !important;
    border: 1px solid #ced4da;
    border-radius: .375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: calc(1.25rem + 2px) !important;
    padding-left: .75rem;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: calc(1.25rem + 2px) !important;
}
.select2-container {
    width: 100% !important;
}
</style>
@endpush

<label class="form-label" for="product_id">Product</label>
<select class="form-control" id="product_id" name="product_id">
     <option value="">All</option>
     @foreach($products as $product)
     <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->product_title }}</option>
     @endforeach
</select>