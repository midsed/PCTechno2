@extends('layouts.pc')

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div>
      <div class="page-title mb-0">Customer Management</div>
      <div class="muted small">Manage customer profiles and contact details.</div>
    </div>
    <a href="{{ route('customers.create') }}" class="btn pc-btn-primary">+ Add Customer</a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="d-flex gap-2 mb-3">
        <a class="btn btn-sm {{ $tab === 'active' ? 'pc-btn-primary' : 'btn-outline-secondary' }}"
           href="{{ route('customers.index', ['tab'=>'active','q'=>$q]) }}">Active Customers</a>
        <a class="btn btn-sm {{ $tab === 'archived' ? 'pc-btn-primary' : 'btn-outline-secondary' }}"
           href="{{ route('customers.index', ['tab'=>'archived','q'=>$q]) }}">Archived</a>
      </div>

      <form class="mb-3" method="GET" action="{{ route('customers.index') }}">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input class="form-control" name="q" value="{{ $q }}" placeholder="Search customers...">
      </form>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:28%;">CUSTOMER NAME</th>
              <th style="width:22%;">CONTACT</th>
              <th>ADDRESS</th>
              <th class="text-end" style="width:14%;">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            @forelse($customers as $c)
              <tr>
                <td class="fw-semibold">{{ $c->customer_name }}</td>
                <td class="text-muted">{{ $c->contact_information }}</td>
                <td class="text-muted">{{ $c->address }}</td>

                <td class="text-end">
                  @if($tab === 'active')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('customers.edit', $c->customer_id) }}">✏️</a>

                    <form method="POST" action="{{ route('customers.destroy', $c->customer_id) }}" class="d-inline"
                          onsubmit="return confirm('Archive this customer?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger" type="submit">🗄️</button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('customers.restore', $c->customer_id) }}" class="d-inline"
                          onsubmit="return confirm('Restore this customer to Active?');">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-sm btn-outline-success" type="submit">↩️</button>
                    </form>

                    <form method="POST" action="{{ route('customers.forceDelete', $c->customer_id) }}" class="d-inline"
                          onsubmit="return confirm('Permanently delete this customer? This cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger" type="submit">🗑️</button>
                    </form>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center text-muted py-4">No customers found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $customers->links() }}
    </div>
  </div>
@endsection
