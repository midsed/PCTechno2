@extends('layouts.pc')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div>
      <div class="page-title mb-0">Inventory Management</div>
      <div class="muted small">Manage your product catalog, stock levels, and archives.</div>
    </div>
    <a href="{{ route('products.create') }}" class="btn pc-btn-primary">+ Add Product</a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex gap-2 mb-3">
        <a class="btn btn-sm {{ $tab === 'active' ? 'pc-btn-primary' : 'btn-outline-secondary' }}"
           href="{{ route('products.index', ['tab'=>'active','q'=>$q]) }}">Active Inventory</a>
        <a class="btn btn-sm {{ $tab === 'archived' ? 'pc-btn-primary' : 'btn-outline-secondary' }}"
           href="{{ route('products.index', ['tab'=>'archived','q'=>$q]) }}">Archived</a>
      </div>

      <form class="mb-3" method="GET" action="{{ route('products.index') }}">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input class="form-control" name="q" value="{{ $q }}" placeholder="Search active products...">
      </form>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:38%;">PRODUCT NAME</th>
              <th>DESCRIPTION</th>
              <th class="text-end" style="width:12%;">PRICE</th>
              <th class="text-center" style="width:10%;">STOCK</th>
              <th class="text-end" style="width:12%;">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $p)
              <tr>
                <td class="fw-semibold">{{ $p->product_name }}</td>
                <td class="text-muted">{{ $p->description }}</td>
                <td class="text-end fw-bold">${{ number_format($p->price, 2) }}</td>
                <td class="text-center">
                  @php
                    $badge = $p->quantity_available <= 5 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success';
                  @endphp
                  <span class="badge rounded-pill {{ $badge }}">{{ $p->quantity_available }}</span>
                </td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('products.edit', $p->product_id) }}">✏️</a>
                  <form method="POST" action="{{ route('products.destroy', $p->product_id) }}" class="d-inline"
                        onsubmit="return confirm('Delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit">🗑️</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted py-4">No products found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $products->links() }}
    </div>
  </div>
@endsection
