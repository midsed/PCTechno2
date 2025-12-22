@extends('layouts.pc')

@section('content')
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="px-4 py-3" style="background:var(--pc-blue);color:#fff;border-top-left-radius:.5rem;border-top-right-radius:.5rem;">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:var(--pc-yellow);color:#111;font-weight:900;">🛒</div>
          <div>
            <div class="h5 mb-0 fw-bold">New Transaction</div>
            <div class="small text-white-50">Process sales and update inventory.</div>
          </div>
        </div>
      </div>

      <div class="p-4">
        <form method="POST" action="{{ route('transactions.store') }}" id="txnForm">
          @csrf

          <div class="row g-4">
            <!-- Customer -->
            <div class="col-12 col-lg-6">
              <div class="fw-bold mb-2">Customer Details</div>
              <hr class="mt-1">

              <div class="mb-3">
                <label class="form-label">Select Customer</label>
                <select class="form-select" name="customer_id" id="customerSelect">
                  <option value="">-- Choose Customer --</option>
                  @foreach($customers as $c)
                    <option value="{{ $c->customer_id }}"
                      data-name="{{ $c->customer_name }}"
                      data-contact="{{ $c->contact_information }}"
                      data-address="{{ $c->address }}">
                      {{ $c->customer_name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="border rounded-3 p-3" style="background:#f8fafc;">
                <div class="small text-uppercase text-muted fw-semibold">Customer Info</div>
                <div id="customerInfo" class="text-muted fst-italic mt-1">No customer selected</div>
              </div>
            </div>

            <!-- Order -->
            <div class="col-12 col-lg-6">
              <div class="fw-bold mb-2">Order Details</div>
              <hr class="mt-1">

              <div class="mb-3">
                <label class="form-label">Select Product</label>
                <select class="form-select" name="product_id" id="productSelect" required>
                  <option value="">-- Choose Product --</option>
                  @foreach($products as $p)
                    <option value="{{ $p->product_id }}"
                      data-price="{{ $p->price }}"
                      data-stock="{{ $p->quantity_available }}">
                      {{ $p->product_name }} (Stock: {{ $p->quantity_available }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="row g-3">
                <div class="col-6">
                  <label class="form-label">Quantity</label>
                  <input class="form-control" type="number" min="1" name="quantity_sold" id="qtyInput" value="1" required>
                  <div id="stockHint" class="small text-muted mt-1"></div>
                </div>
                <div class="col-6">
                  <label class="form-label">Payment Method</label>
                  <select class="form-select" name="payment_method" required>
                    <option>Cash</option>
                    <option>Credit Card</option>
                    <option>GCash</option>
                    <option>PayMaya</option>
                  </select>
                </div>
              </div>

              <div class="rounded-4 p-4 mt-3 text-center" style="background:#eef6ff;border:1px solid #dbeafe;">
                <div class="small text-primary fw-semibold">TOTAL AMOUNT</div>
                <div class="display-6 fw-bold" id="totalAmount">$0.00</div>
              </div>

              <button class="btn w-100 mt-3 pc-btn-yellow py-3" type="submit">
                Complete Transaction
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const customerSelect = document.getElementById('customerSelect');
    const customerInfo = document.getElementById('customerInfo');

    const productSelect = document.getElementById('productSelect');
    const qtyInput = document.getElementById('qtyInput');
    const totalAmount = document.getElementById('totalAmount');
    const stockHint = document.getElementById('stockHint');

    function money(n){
      return '$' + (Number(n || 0)).toFixed(2);
    }

    function renderCustomer(){
      const opt = customerSelect.options[customerSelect.selectedIndex];
      if(!opt || !opt.value){
        customerInfo.textContent = 'No customer selected';
        customerInfo.classList.add('fst-italic','text-muted');
        return;
      }
      const name = opt.dataset.name || '';
      const contact = opt.dataset.contact || '';
      const address = opt.dataset.address || '';
      customerInfo.classList.remove('fst-italic','text-muted');
      customerInfo.innerHTML = `
        <div><b>${name}</b></div>
        <div class="small text-muted">${contact || ''}</div>
        <div class="small text-muted">${address || ''}</div>
      `;
    }

    function renderTotal(){
      const opt = productSelect.options[productSelect.selectedIndex];
      const price = Number(opt?.dataset?.price || 0);
      const stock = Number(opt?.dataset?.stock || 0);
      const qty = Number(qtyInput.value || 0);

      if(opt && opt.value){
        stockHint.textContent = `Available stock: ${stock}`;
        if(qty > stock) stockHint.innerHTML = `<span class="text-danger">Available stock: ${stock} (insufficient)</span>`;
      } else {
        stockHint.textContent = '';
      }

      totalAmount.textContent = money(price * qty);
    }

    customerSelect.addEventListener('change', renderCustomer);
    productSelect.addEventListener('change', renderTotal);
    qtyInput.addEventListener('input', renderTotal);

    renderCustomer();
    renderTotal();
  </script>
@endsection
