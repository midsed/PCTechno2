@extends('layouts.auth')

@section('content')
  <div class="auth-page">
    <div class="auth-blob blob-1"></div>
    <div class="auth-blob blob-2"></div>
    <div class="auth-blob blob-3"></div>

    <div class="auth-card">
      <div class="auth-header">
        <div class="auth-logo" aria-hidden="true">🖥️</div>

        <div class="auth-brand">
          <div class="auth-topline">
            <h1 class="auth-title mb-0">
              <span class="auth-title-gradient">PCTechno</span>
            </h1>
          </div>

          <div class="auth-sub">Inventory &amp; Sales Management</div>
          <div class="auth-divider"></div>
        </div>
      </div>

      <div class="auth-body">
        @include('partials.flash')

        <form method="POST" action="{{ route('login') }}" class="auth-form">
          @csrf

          <div class="mb-3">
            <label class="form-label auth-label">Username</label>
            <input
              type="text"
              name="username"
              value="{{ old('username') }}"
              class="form-control pc-input-glass"
              placeholder="Enter username"
              required
              autofocus
            >
          </div>

          <div class="mb-3">
            <label class="form-label auth-label">Password</label>
            <input
              type="password"
              name="password"
              class="form-control pc-input-glass"
              placeholder="Enter password"
              required
            >
          </div>

          <button class="btn pc-btn-primary pc-btn-premium w-100 py-2 fw-bold" type="submit">
            Sign In
          </button>

          <div class="demo-cred mt-3">
            <div class="demo-head">
              <span class="demo-dot"></span>
              <span class="fw-semibold">Demo Credentials</span>
            </div>

            <div class="demo-lines">
              <div><span class="demo-role">Admin</span> <span class="demo-sep">•</span> <b>admin</b> / <b>password</b></div>
              <div><span class="demo-role">Employee</span> <span class="demo-sep">•</span> <b>employee</b> / <b>password</b></div>
              <div><span class="demo-role">Cashier</span> <span class="demo-sep">•</span> <b>cashier</b> / <b>password</b></div>
            </div>
          </div>

          <div class="text-center mt-3 small">
            <a class="auth-link" href="{{ route('register') }}">Create an account</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
