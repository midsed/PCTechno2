<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCTechno</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    /* quick spacing helpers */
    .page-title{ font-size: 1.35rem; font-weight: 800; margin-bottom: 1rem; }
    .muted{ color:#6b7280; }
    .table thead th{ font-size:.82rem; letter-spacing:.02em; color:#6b7280; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    @php $role = auth()->user()->role ?? ''; @endphp

    <!-- Sidebar -->
    <aside class="col-12 col-md-3 col-lg-2 pc-sidebar p-0 d-flex flex-column">
      <div class="pc-brand">
        <div class="pc-badge">PT</div>
        <div>
          <div class="fw-bold">PCTechno</div>
          <div class="small text-white-50">Inventory & Sales</div>
        </div>
      </div>

      <nav class="mt-2">
        <a class="pc-link {{ request()->routeIs('dashboard') ? 'active':'' }}" href="{{ route('dashboard') }}">Dashboard</a>

        {{-- Admin + Employee: Inventory + Customers --}}
        @if(in_array($role, ['admin','employee']))
          <a class="pc-link {{ request()->is('products*') ? 'active':'' }}" href="{{ route('products.index') }}">Inventory</a>
          <a class="pc-link {{ request()->is('customers*') ? 'active':'' }}" href="{{ route('customers.index') }}">Customers</a>
        @endif

        {{-- Everyone who can transact --}}
        <a class="pc-link {{ request()->routeIs('transactions.create') ? 'active':'' }}" href="{{ route('transactions.create') }}">New Transaction</a>

        <a class="pc-link {{ request()->routeIs('sales.index') ? 'active':'' }}" href="{{ route('sales.index') }}">Sales History</a>
        <a class="pc-link {{ request()->routeIs('transactions.index') ? 'active':'' }}" href="{{ route('transactions.index') }}">Transactions</a>

        {{-- Admin only --}}
        @if($role === 'admin')
          <a class="pc-link {{ request()->is('users*') ? 'active':'' }}" href="{{ route('users.index') }}">Manage Users</a>
          <a class="pc-link {{ request()->routeIs('logs.index') ? 'active':'' }}" href="{{ route('logs.index') }}">System Logs</a>
        @endif
      </nav>

      <div class="mt-auto p-3">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
            {{ strtoupper(substr(auth()->user()->full_name ?? 'U', 0, 1)) }}
          </div>
          <div>
            <div class="fw-bold text-white">{{ auth()->user()->full_name ?? '' }}</div>
            <div class="small text-white-50 text-capitalize">{{ $role }}</div>
          </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-sm w-100 pc-btn-primary" type="submit">Sign Out</button>
        </form>
      </div>
    </aside>

    <!-- Content -->
    <main class="col-12 col-md-9 col-lg-10 p-4">
      @include('partials.flash')
      @yield('content')
    </main>
  </div>
</div>
</body>
</html>
