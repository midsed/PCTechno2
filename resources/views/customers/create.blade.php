@extends('layouts.pc')

@section('content')
  <div class="page-title">Add Customer</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Customer Name</label>
            <input class="form-control" name="customer_name" value="{{ old('customer_name') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Contact Information</label>
            <input class="form-control" name="contact_information" value="{{ old('contact_information') }}">
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Address</label>
            <input class="form-control" name="address" value="{{ old('address') }}">
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn pc-btn-primary" type="submit">Save</button>
          <a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">Cancel</a>
        </div>
      </form>
    </div>
  </div>
@endsection
