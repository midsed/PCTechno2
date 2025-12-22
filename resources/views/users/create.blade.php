@extends('layouts.pc')

@section('content')
  <div class="page-title">Add User</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Full Name</label>
            <input class="form-control" name="full_name" value="{{ old('full_name') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Role</label>
            <select class="form-select" name="role" required>
              <option value="admin">admin</option>
              <option value="employee">employee</option>
              <option value="cashier">cashier</option>
              <option value="customer">customer</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Username</label>
            <input class="form-control" name="username" value="{{ old('username') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Password</label>
            <input class="form-control" type="password" name="password" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" required>
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn pc-btn-primary" type="submit">Save</button>
          <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
