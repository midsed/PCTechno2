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
    $totalRevenue = Sale::sum('total_amount');
    $totalTransactions = Txn::count();
    $productsInStock = Product::where('is_archived', false)->sum('quantity_available');
    $customersCount = Customer::where('is_archived', false)->count();

    $lowStock = Product::where('is_archived', false)
      ->where('quantity_available', '<=', 5)
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
      'totalRevenue','totalTransactions','productsInStock','customersCount','lowStock','trend'
    ));
  }
}
