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
            <input class="form-control" name="customer_name" value="{{ old('customer_name', $customer->customer_name) }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Contact Information</label>
            <input class="form-control" name="contact_information" value="{{ old('contact_information', $customer->contact_information) }}">
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Address</label>
            <input class="form-control" name="address" value="{{ old('address', $customer->address) }}">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select" name="is_archived">
              <option value="0" {{ (string)old('is_archived', $customer->is_archived) === "0" ? 'selected':'' }}>Active</option>
              <option value="1" {{ (string)old('is_archived', $customer->is_archived) === "1" ? 'selected':'' }}>Archived</option>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn pc-btn-primary" type="submit">Update</button>
          <a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">Back</a>
        </div>
      </form>
    </div>
  </div>
@endsection
