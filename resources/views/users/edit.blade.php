@extends('layouts.pc')

@section('content')
  <div class="page-title">Edit User</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('users.update', $user->user_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Full Name</label>
            <input class="form-control" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Role</label>
            <select class="form-select" name="role" required>
              @foreach(['admin','employee','cashier','customer'] as $r)
                <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected':'' }}>{{ $r }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Username</label>
            <input class="form-control" name="username" value="{{ old('username', $user->username) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
          </div>

          <div class="col-12">
            <div class="alert alert-info small mb-0">
              Leave password blank if you don’t want to change it.
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">New Password (optional)</label>
            <input class="form-control" type="password" name="password">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Confirm New Password</label>
            <input class="form-control" type="password" name="password_confirmation">
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn pc-btn-primary" type="submit">Update</button>
          <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
        </div>
      </form>
    </div>
  </div>
@endsection
