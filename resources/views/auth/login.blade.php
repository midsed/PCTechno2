@extends('layouts.auth')

@section('content')
  <div class="auth-header">
    <div class="auth-logo">🖥️</div>
    <h1 class="auth-title">PCTechno</h1>
    <div class="auth-sub">Inventory & Sales Management</div>
  </div>

  <div class="auth-body">
    @include('partials.flash')

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Username (we will login using username; your backend should authenticate by username) -->
      <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="form-control dark-input" placeholder="Enter username" required autofocus>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control dark-input" placeholder="Enter password" required>
      </div>

      <button class="btn pc-btn-primary w-100 py-2 fw-bold" type="submit">Sign In</button>

      <div class="demo-cred">
        <div class="fw-semibold mb-1">Demo Credentials:</div>
        <div>Admin: <b>admin</b> / <b>password</b></div>
        <div>Employee: <b>employee</b> / <b>password</b></div>
        <div>Cashier: <b>cashier</b> / <b>password</b></div>
      </div>

      <div class="text-center mt-3 small">
        <a href="{{ route('register') }}">Create an account</a>
      </div>
    </form>
  </div>
@endsection
