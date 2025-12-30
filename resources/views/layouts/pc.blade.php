<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCTechno</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" href="{{ asset('css/pctechno.css') }}">
</head>

<body class="pc-app">
<div class="container-fluid">
  <div class="row g-0">
    @php $role = auth()->user()->role ?? ''; @endphp

    <aside class="col-12 col-md-3 col-lg-2 pc-sidebar p-0 d-flex flex-column">
      <div class="pc-brand">
        <div class="pc-brand-text">
          <div class="pc-brand-name">PCTechno</div>
          <div class="pc-brand-sub">Inventory &amp; Sales</div>
        </div>
      </div>

      <nav class="pc-nav">
        <a class="pc-link {{ request()->routeIs('dashboard') ? 'active':'' }}" href="{{ route('dashboard') }}">
          <span>Dashboard</span>
          <span class="pc-link-glow"></span>
        </a>

        @if(in_array($role, ['admin','employee']))
          <a class="pc-link {{ request()->is('products*') ? 'active':'' }}" href="{{ route('products.index') }}">
            <span>Inventory</span>
            <span class="pc-link-glow"></span>
          </a>

          <a class="pc-link {{ request()->is('customers*') ? 'active':'' }}" href="{{ route('customers.index') }}">
            <span>Customers</span>
            <span class="pc-link-glow"></span>
          </a>
        @endif

        <div class="pc-nav-sep"></div>

        <a class="pc-link {{ request()->routeIs('transactions.create') ? 'active':'' }}" href="{{ route('transactions.create') }}">
          <span>New Transaction</span>
          <span class="pc-link-glow"></span>
        </a>

        <a class="pc-link {{ request()->routeIs('sales.index') ? 'active':'' }}" href="{{ route('sales.index') }}">
          <span>Sales History</span>
          <span class="pc-link-glow"></span>
        </a>

        <a class="pc-link {{ request()->routeIs('transactions.index') ? 'active':'' }}" href="{{ route('transactions.index') }}">
          <span>Transactions</span>
          <span class="pc-link-glow"></span>
        </a>

        {{-- Admin only --}}
        @if($role === 'admin')
          <div class="pc-nav-sep"></div>

          <a class="pc-link {{ request()->is('users*') ? 'active':'' }}" href="{{ route('users.index') }}">
            <span>Manage Users</span>
            <span class="pc-link-glow"></span>
          </a>

          <a class="pc-link {{ request()->routeIs('logs.index') ? 'active':'' }}" href="{{ route('logs.index') }}">
            <span>System Logs</span>
            <span class="pc-link-glow"></span>
          </a>
        @endif
      </nav>

      <div class="pc-user mt-auto">
        <div class="pc-user-card">
          <div class="pc-user-top">
            <div class="pc-avatar">
              {{ strtoupper(substr(auth()->user()->full_name ?? 'U', 0, 1)) }}
            </div>

            <div class="pc-user-meta">
              <div class="pc-user-name">{{ auth()->user()->full_name ?? '' }}</div>
              <div class="pc-user-role text-capitalize">{{ $role }}</div>
            </div>
          </div>

          <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="btn w-100 pc-btn-primary pc-btn-premium pc-btn-logout" type="submit">
              Sign Out
            </button>
          </form>
        </div>
      </div>
    </aside>

    <main class="col-12 col-md-9 col-lg-10 pc-main p-4">
      @include('partials.flash')
      @yield('content')
    </main>
  </div>
</div>
</body>
</html>
