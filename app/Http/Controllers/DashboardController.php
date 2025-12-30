<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Txn;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $LOW_STOCK_THRESHOLD = 5;

    $totalRevenue = Sale::sum('total_amount');
    $totalTransactions = Txn::count();

    // ACTIVE ONLY (not archived/soft-deleted)
    $productsInStock = Product::query()
      ->whereNull('deleted_at')
      ->sum('quantity_available');

    $customersCount = Customer::query()
      ->whereNull('deleted_at')
      ->count();

    // Low stock ACTIVE ONLY
    $lowStock = Product::query()
      ->whereNull('deleted_at')
      ->where('quantity_available', '<=', $LOW_STOCK_THRESHOLD)
      ->orderBy('quantity_available')
      ->get();

    // Sales trend grouped by date (simple)
    $trend = Sale::select(
        DB::raw("DATE(sales_date) as d"),
        DB::raw("SUM(total_amount) as total")
      )
      ->groupBy('d')
      ->orderBy('d')
      ->limit(14)
      ->get();

    return view('dashboard.index', compact(
      'totalRevenue',
      'totalTransactions',
      'productsInStock',
      'customersCount',
      'lowStock',
      'trend'
    ));
  }
}
