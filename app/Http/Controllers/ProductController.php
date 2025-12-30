<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'active'); // active | archived
        $q = trim((string) $request->get('q', ''));

        $products = Product::query()
            ->when($tab === 'archived', fn($qr) => $qr->where('is_archived', 1))
            ->when($tab !== 'archived', fn($qr) => $qr->where('is_archived', 0))
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($qq) use ($q) {
                    $qq->where('product_name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('product_id')
            ->paginate(9)
            ->withQueryString();

        return view('products.index', compact('products', 'tab', 'q'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // ✅ validate based on your form fields
        $data = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity_available' => ['required', 'integer', 'min:0'],
        ]);

        // ✅ save
        $product = Product::create($data + ['is_archived' => 0]);

        // ✅ optional logging (if your logs table exists)
        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Added product: {$product->product_name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('products.index', ['tab' => 'active'])
            ->with('success', 'Product added successfully!');
    }

    public function edit(string $id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();

        $data = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity_available' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Updated product: {$product->product_name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();
        $name = $product->product_name;

        // soft “archive” if you prefer
        if (\Schema::hasColumn('products', 'is_archived')) {
            $product->update(['is_archived' => 1]);
        } else {
            $product->delete();
        }

        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Deleted/Archived product: {$name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product removed successfully!');
    }
}
