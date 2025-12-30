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
              <span class="auth-title-gradient">Create Account</span>
            </h1>
          </div>

          <div class="auth-sub">PCTechno</div>
          <div class="auth-divider"></div>
        </div>
      </div>

      <div class="auth-body">
        @include('partials.flash')

        <form method="POST" action="{{ route('register') }}" class="auth-form">
          @csrf

          <div class="mb-3">
            <label class="form-label auth-label">Full Name</label>
            <input
              type="text"
              name="full_name"
              value="{{ old('full_name') }}"
              class="form-control pc-input-glass"
              placeholder="Enter your full name"
              required
            >
          </div>

          <div class="mb-3">
            <label class="form-label auth-label">Username</label>
            <input
              type="text"
              name="username"
              value="{{ old('username') }}"
              class="form-control pc-input-glass"
              placeholder="Create a username"
              required
            >
          </div>

          <div class="mb-3">
            <label class="form-label auth-label">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control pc-input-glass"
              placeholder="Enter your email"
              required
            >
          </div>

          <div class="mb-3">
            <label class="form-label auth-label">Password</label>
            <input
              type="password"
              name="password"
              class="form-control pc-input-glass"
              placeholder="Create a password"
              required
            >
          </div>

          <div class="mb-3">
            <label class="form-label auth-label">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              class="form-control pc-input-glass"
              placeholder="Re-enter password"
              required
            >
          </div>

          <div class="auth-note">
            <div class="auth-note-title">Role Notice</div>
            <div class="auth-note-text">
              Newly registered users default to <b>customer</b>. Only <b>Admin</b> can promote roles via Manage Users.
            </div>
          </div>

          <button class="btn pc-btn-primary pc-btn-premium w-100 py-2 fw-bold" type="submit">
            Register
          </button>

          <div class="text-center mt-3 small">
            <a class="auth-link" href="{{ route('login') }}">Back to login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
