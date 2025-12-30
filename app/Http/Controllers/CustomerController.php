<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $tab = $request->get('tab', 'active');
    $tab = in_array($tab, ['active', 'archived']) ? $tab : 'active';

    $q = trim((string) $request->get('q', ''));

    $query = Customer::query();

    // Archive filtering (only if column exists)
    // If your table uses a different archive column name, tell me.
    if (Schema::hasColumn('customers', 'is_archived')) {
        $query->where('is_archived', $tab === 'archived');
    }

    // Search (match your blade fields / columns)
    if ($q !== '') {
        $query->where(function ($qq) use ($q) {
            $qq->where('customer_name', 'like', "%{$q}%")
               ->orWhere('contact_information', 'like', "%{$q}%")
               ->orWhere('address', 'like', "%{$q}%");
        });
    }

    // Your blade uses customer_id, so order by that
    $customers = $query->orderByDesc('customer_id')
                       ->paginate(10)
                       ->withQueryString();

    return view('customers.index', compact('customers', 'tab', 'q'));
}

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        abort(501); // implement later
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        abort(501); // implement later
    }

    public function destroy(string $id)
    {
        abort(501); // implement later
    }
}
