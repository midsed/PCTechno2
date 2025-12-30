<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of sales history.
     */
    public function index(Request $request)
    {
        // optional search (if you add a search box later)
        $q = trim((string) $request->query('q', ''));

        $sales = Sale::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('transaction_id', 'like', "%{$q}%")
                      ->orWhere('payment_method', 'like', "%{$q}%");
            })
            ->orderByDesc('sales_date')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'q'));
    }
}
