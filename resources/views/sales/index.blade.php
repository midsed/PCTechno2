@extends('layouts.pc')

@section('content')
  <div class="page-title mb-0">Sales Records</div>
  <div class="muted small mb-3">Financial records of all completed transactions.</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:10%;">SALE ID</th>
              <th style="width:18%;">TRANSACTION ID</th>
              <th class="text-end" style="width:18%;">TOTAL AMOUNT</th>
              <th style="width:18%;">PAYMENT METHOD</th>
              <th>DATE</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sales as $s)
              <tr>
                <td class="text-muted">#{{ $s->sales_id }}</td>
                <td>
                  <span class="text-primary fw-semibold">Ref: #{{ $s->transaction_id }}</span>
                </td>
                <td class="text-end fw-bold">${{ number_format($s->total_amount, 2) }}</td>
                <td>
                  <span class="badge rounded-pill bg-light text-dark border">{{ strtoupper($s->payment_method) }}</span>
                </td>
                <td class="text-muted">{{ \Carbon\Carbon::parse($s->sales_date)->format('m/d/Y, h:i:s A') }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted py-4">No sales yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $sales->links() }}
    </div>
  </div>
@endsection
