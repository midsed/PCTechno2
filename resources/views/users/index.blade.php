@extends('layouts.pc')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <div class="page-title mb-0">User Management</div>
      <div class="muted small">Admin-only: manage system accounts.</div>
    </div>
    <a href="{{ route('users.create') }}" class="btn pc-btn-primary">+ Add User</a>
  </div>

  <div class="row g-3">
    @forelse($users as $u)
      @php
        $bg = $u->role === 'admin'
              ? '#ef4444'
              : ($u->role === 'employee'
                  ? '#3b82f6'
                  : '#22c55e');
      @endphp

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                   style="width:44px;height:44px;background:{{ $bg }};">
                {{ strtoupper(substr($u->full_name, 0, 1)) }}
              </div>
              <div>
                <div class="fw-bold">{{ $u->full_name }}</div>
                <span class="badge rounded-pill bg-light text-dark border text-capitalize">{{ $u->role }}</span>
              </div>
            </div>

<div class="small text-muted">{{ $u->username }}</div>
            <div class="small text-muted">{{ $u->email }}</div>

            <div class="d-flex justify-content-end gap-2 mt-3">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('users.edit', $u->user_id) }}">Edit</a>

              <form method="POST" action="{{ route('users.destroy', $u->user_id) }}"
                    onsubmit="return confirm('Delete this user?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info">No users found.</div>
      </div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $users->links() }}
  </div>
@endsection
