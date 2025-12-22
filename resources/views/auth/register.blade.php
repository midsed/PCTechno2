@extends('layouts.auth')

@section('content')
  <div class="auth-header">
    <div class="auth-logo">PT</div>
    <h1 class="auth-title">Create Account</h1>
    <div class="auth-sub">PCTechno</div>
  </div>

  <div class="auth-body">
    @include('partials.flash')

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label fw-semibold">Full Name</label>
        <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <div class="alert alert-warning small">
        Newly registered users default to <b>customer</b>. Only <b>Admin</b> should promote roles via Manage Users.
      </div>

      <button class="btn pc-btn-primary w-100 py-2 fw-bold" type="submit">Register</button>

      <div class="text-center mt-3 small">
        <a href="{{ route('login') }}">Back to login</a>
      </div>
    </form>
  </div>
@endsection
