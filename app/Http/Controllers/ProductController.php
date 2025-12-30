<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // tabs: active | archived
        $tab = $request->get('tab', 'active');
        $tab = in_array($tab, ['active', 'archived']) ? $tab : 'active';

        $q = trim((string) $request->get('q', ''));

        $query = Product::query();

        // If your table has an "is_archived" flag (recommended)
        if (in_array('is_archived', (new Product)->getFillable()) || \Schema::hasColumn('products', 'is_archived')) {
            $query->where('is_archived', $tab === 'archived');
        }
        // OR if your table uses an "archived_at" column
        elseif (\Schema::hasColumn('products', 'archived_at')) {
            $tab === 'archived'
                ? $query->whereNotNull('archived_at')
                : $query->whereNull('archived_at');
        }

        // Search
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('product_name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Paginate (required for ->links() in blade)
        $products = $query
            ->orderByDesc('product_id')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'tab', 'q'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // leave for later / implement next
        abort(501);
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        // leave for later / implement next
        abort(501);
    }

    public function destroy(string $id)
    {
        // leave for later / implement next
        abort(501);
    }
}
