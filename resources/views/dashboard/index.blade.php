@extends('layouts.pc')

@section('content')
  <div class="pc-pagehead mb-3">
    <div>
      <div class="pc-kicker">Overview</div>
      <div class="pc-pagetitle">Dashboard</div>
      <div class="pc-pagesub">Quick summary of revenue, transactions, stock, and customers.</div>
    </div>

    <div class="pc-pageactions">
      <span class="pc-pill">
        <span class="pc-pill-dot"></span>
        Live Data
      </span>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="pc-stat pc-pop">
        <div class="pc-stat-top">
          <div class="pc-stat-icon pc-grad-green">$</div>
          <div class="pc-stat-meta">
            <div class="pc-stat-label">Total Revenue</div>
            <div class="pc-stat-value">${{ number_format($totalRevenue, 2) }}</div>
          </div>
        </div>
        <div class="pc-stat-foot">Updated from latest sales records</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="pc-stat pc-pop" style="animation-delay:.05s;">
        <div class="pc-stat-top">
          <div class="pc-stat-icon pc-grad-blue">🛒</div>
          <div class="pc-stat-meta">
            <div class="pc-stat-label">Total Transactions</div>
            <div class="pc-stat-value">{{ $totalTransactions }}</div>
          </div>
        </div>
        <div class="pc-stat-foot">Completed transactions count</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="pc-stat pc-pop" style="animation-delay:.10s;">
        <div class="pc-stat-top">
          <div class="pc-stat-icon pc-grad-yellow">📦</div>
          <div class="pc-stat-meta">
            <div class="pc-stat-label">Products in Stock</div>
            <div class="pc-stat-value">{{ $productsInStock }}</div>
          </div>
        </div>
        <div class="pc-stat-foot">Available inventory quantity</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="pc-stat pc-pop" style="animation-delay:.15s;">
        <div class="pc-stat-top">
          <div class="pc-stat-icon pc-grad-purple">👥</div>
          <div class="pc-stat-meta">
            <div class="pc-stat-label">Customers</div>
            <div class="pc-stat-value">{{ $customersCount }}</div>
          </div>
        </div>
        <div class="pc-stat-foot">Registered customer accounts</div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="pc-panel pc-pop" style="animation-delay:.18s;">
        <div class="pc-panel-head">
          <div>
            <div class="pc-panel-title">Sales Trend</div>
            <div class="pc-panel-sub">Daily sales total based on recorded transactions</div>
          </div>
        </div>

        <div class="pc-chart-wrap">
          <canvas id="salesTrend" height="120"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="pc-panel pc-pop" style="animation-delay:.22s;">
        <div class="pc-panel-head">
          <div>
            <div class="pc-panel-title text-danger">Low Stock Alerts</div>
            <div class="pc-panel-sub">Items that need restocking soon</div>
          </div>
          <span class="pc-badge-soft pc-badge-danger"></span>
        </div>

        <div class="pc-alert-list">
          @if($lowStock->count() === 0)
            <div class="pc-empty">
              <div class="pc-empty-title">All good</div>
              <div class="pc-empty-sub">No low stock items right now.</div>
            </div>
          @else
            @foreach($lowStock as $p)
              <div class="pc-alert-item">
                <div class="pc-alert-left">
                  <div class="pc-alert-name">{{ $p->product_name }}</div>
                  <div class="pc-alert-sub">Only <b>{{ $p->quantity_available }}</b> left</div>
                </div>
                <a href="{{ route('products.edit', $p->product_id) }}" class="btn btn-sm btn-outline-danger pc-btn-soft">
                  Restock
                </a>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

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
          borderWidth: 1,
          borderRadius: 10
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true }
        }
      }
    });
  </script>
@endsection
