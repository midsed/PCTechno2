@extends('layouts.pc')

@section('content')
  <div class="page-title">Edit Customer</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('customers.update', $customer->customer_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Customer Name</label>
            <input class="form-control"
                   name="customer_name"
                   value="{{ old('customer_name', $customer->customer_name) }}"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Contact Information</label>
            <input class="form-control"
                   name="contact_information"
                   value="{{ old('contact_information', $customer->contact_information) }}">
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Address</label>
            <input class="form-control"
                   name="address"
                   value="{{ old('address', $customer->address) }}">
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Update</button>
          <a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">Back</a>
        </div>
      </form>
    </div>
  </div>
@endsection
