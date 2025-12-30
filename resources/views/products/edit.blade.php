@extends('layouts.pc')

@section('content')
  <div class="page-title">Edit Product</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('products.update', $product->product_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Product Name</label>
            <input class="form-control"
                   name="product_name"
                   value="{{ old('product_name', $product->product_name) }}"
                   required>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Price</label>
            <input class="form-control"
                   type="number"
                   step="0.01"
                   min="0"
                   name="price"
                   value="{{ old('price', $product->price) }}"
                   required>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Quantity Available</label>
            <input class="form-control"
                   type="number"
                   min="0"
                   name="quantity_available"
                   value="{{ old('quantity_available', $product->quantity_available) }}"
                   required>
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea class="form-control"
                      name="description"
                      rows="3">{{ old('description', $product->description) }}</textarea>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Update</button>
          <a class="btn btn-outline-secondary" href="{{ route('products.index') }}">Back</a>
        </div>
      </form>
    </div>
  </div>
@endsection
