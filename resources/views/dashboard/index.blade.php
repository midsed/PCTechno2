@extends('layouts.pc')

@section('content')
  <div class="page-title">Dashboard Overview</div>

  <div class="row g-3 mb-3">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="pc-card-icon" style="background:#22c55e;">$</div>
          <div>
            <div class="small muted">Total Revenue</div>
            <div class="h4 mb-0 fw-bold">${{ number_format($totalRevenue, 2) }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="pc-card-icon" style="background:#3b82f6;">🛒</div>
          <div>
            <div class="small muted">Total Transactions</div>
            <div class="h4 mb-0 fw-bold">{{ $totalTransactions }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="pc-card-icon" style="background:#eab308;">📦</div>
          <div>
            <div class="small muted">Products in Stock</div>
            <div class="h4 mb-0 fw-bold">{{ $productsInStock }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="pc-card-icon" style="background:#a855f7;">👥</div>
          <div>
            <div class="small muted">Customers</div>
            <div class="h4 mb-0 fw-bold">{{ $customersCount }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="fw-bold">📈 Sales Trend</span>
          </div>
          <canvas id="salesTrend" height="110"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-bold text-danger">Low Stock Alert</div>
          </div>

          @if($lowStock->count() === 0)
            <div class="alert alert-success mb-0">No low stock items.</div>
          @else
            @foreach($lowStock as $p)
              <div class="p-3 rounded-3 mb-2" style="background:#fff1f2;border:1px solid #fecdd3;">
                <div class="d-flex align-items-start justify-content-between">
                  <div>
                    <div class="fw-bold">{{ $p->product_name }}</div>
                    <div class="small text-danger">Only {{ $p->quantity_available }} left</div>
                  </div>
                  <a href="{{ route('products.edit', $p->product_id) }}" class="btn btn-sm btn-outline-danger">Restock</a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const trendLabels = @json($trend->pluck('d'));
    const trendTotals = @json($trend->pluck('total'));

    const ctx = document.getElementById('salesTrend');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: trendLabels,
        datasets: [{
          label: 'Sales',
          data: trendTotals,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
@endsection
