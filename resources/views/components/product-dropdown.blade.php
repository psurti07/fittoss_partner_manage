 <label class="form-label" for="product_id">Product</label>
 <select class="form-control" id="product_id" name="product_id">
     <option value="">All</option>
     @foreach($products as $product)
     <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->product_title }}</option>
     @endforeach
 </select>