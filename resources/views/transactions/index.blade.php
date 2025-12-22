@extends('layouts.pc')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div>
      <div class="page-title mb-0">Transaction History</div>
      <div class="muted small">A detailed log of all product movements and customer purchases.</div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:8%;">ID</th>
              <th>PRODUCT</th>
              <th style="width:22%;">CUSTOMER</th>
              <th class="text-center" style="width:10%;">QTY</th>
              <th style="width:22%;">DATE</th>
            </tr>
          </thead>
          <tbody>
            @forelse($txns as $t)
              <tr>
                <td class="text-muted">#{{ $t->transaction_id }}</td>
                <td class="fw-semibold">{{ $t->product->product_name ?? '—' }}</td>
                <td>{{ $t->customer->customer_name ?? 'Walk-in' }}</td>
                <td class="text-center fw-bold">{{ $t->quantity_sold }}</td>
                <td class="text-muted">{{ \Carbon\Carbon::parse($t->transaction_date)->format('m/d/Y, h:i:s A') }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted py-4">No transactions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $txns->links() }}
    </div>
  </div>
@endsection
