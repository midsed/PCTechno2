<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'active');
        $q = trim((string) $request->get('q', ''));

        $query = Product::query();

        if ($tab === 'archived') {
            $query->onlyTrashed();
        }

        if ($q !== '') {
            $query->where('product_name', 'like', "%{$q}%");
        }

        $products = $query->orderByDesc('product_id')->paginate(10)->withQueryString();

        return view('products.index', compact('products', 'tab', 'q'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'quantity_available' => ['required','integer','min:0'],
        ]);

        // Always Active on creation
        $data['is_archived'] = 0;

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        // allow edit for active products only (optional)
        $product = Product::where('product_id', $id)->firstOrFail();
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();

        $data = $request->validate([
            'product_name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'quantity_available' => ['required','integer','min:0'],
        ]);

        // No status field anymore
        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    // "Delete" = archive (soft delete)
    public function destroy($id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product archived.');
    }

    // Restore from archived
    public function restore($id)
    {
        $product = Product::onlyTrashed()->where('product_id', $id)->firstOrFail();
        $product->restore();

        return redirect()->route('products.index', ['tab' => 'archived'])
            ->with('success', 'Product restored to active.');
    }

    // Permanent delete (block if referenced by transactions)
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->where('product_id', $id)->firstOrFail();

        // If your transactions table has product_id FK, this prevents the 1451 error
        $isUsedInTransactions = DB::table('transactions')
            ->where('product_id', $product->product_id)
            ->exists();

        if ($isUsedInTransactions) {
            return redirect()->route('products.index', ['tab' => 'archived'])
                ->with('error', 'Cannot permanently delete: product is referenced by existing transactions.');
        }

        $product->forceDelete();

        return redirect()->route('products.index', ['tab' => 'archived'])
            ->with('success', 'Product permanently deleted.');
    }
}
