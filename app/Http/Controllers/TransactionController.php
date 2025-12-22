<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Txn;
use App\Models\Sale;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  public function index()
  {
    $txns = Txn::with(['product','customer'])
      ->orderByDesc('transaction_date')
      ->paginate(10);

    return view('transactions.index', compact('txns'));
  }

  public function create()
  {
    $products = Product::where('is_archived', false)->orderBy('product_name')->get();
    $customers = Customer::where('is_archived', false)->orderBy('customer_name')->get();

    return view('transactions.create', compact('products','customers'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'customer_id' => ['nullable','exists:customers,customer_id'],
      'product_id' => ['required','exists:products,product_id'],
      'quantity_sold' => ['required','integer','min:1'],
      'payment_method' => ['required','in:Cash,Credit Card,GCash,PayMaya'],
    ]);

    DB::transaction(function () use ($validated) {
      $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

      if ($product->quantity_available < $validated['quantity_sold']) {
        abort(422, 'Insufficient stock for this product.');
      }

      // Create transaction
      $txn = Txn::create([
        'product_id' => $product->product_id,
        'customer_id' => $validated['customer_id'] ?? null,
        'quantity_sold' => $validated['quantity_sold'],
        'transaction_date' => now(),
      ]);

      // Compute total + create sale
      $total = bcmul((string)$product->price, (string)$validated['quantity_sold'], 2);

      Sale::create([
        'transaction_id' => $txn->transaction_id,
        'total_amount' => $total,
        'payment_method' => $validated['payment_method'],
        'sales_date' => now(),
      ]);

      // Update stock
      $product->quantity_available -= $validated['quantity_sold'];
      $product->save();

      LogService::add("Created transaction #{$txn->transaction_id} (Product: {$product->product_name}, Qty: {$validated['quantity_sold']})");
    });

    return redirect()->route('transactions.index')->with('success', 'Transaction completed!');
  }
}
