<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'active'); // active | archived
        $q = trim((string) $request->get('q', ''));

        $customers = Customer::query()
            ->when($tab === 'archived', fn($qr) => $qr->where('is_archived', 1))
            ->when($tab !== 'archived', fn($qr) => $qr->where('is_archived', 0))
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($qq) use ($q) {
                    $qq->where('customer_name', 'like', "%{$q}%")
                       ->orWhere('contact_information', 'like', "%{$q}%")
                       ->orWhere('address', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('customer_id')
            ->paginate(9)
            ->withQueryString();

        return view('customers.index', compact('customers', 'tab', 'q'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // ✅ validate based on your blade inputs
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'contact_information' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $customer = Customer::create($data + ['is_archived' => 0]);

        // ✅ optional logging
        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Added customer: {$customer->customer_name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('customers.index', ['tab' => 'active'])
            ->with('success', 'Customer added successfully!');
    }

    public function edit(string $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'contact_information' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $customer->update($data);

        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Updated customer: {$customer->customer_name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(string $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        $name = $customer->customer_name;

        // “archive” if column exists, else delete
        if (\Schema::hasColumn('customers', 'is_archived')) {
            $customer->update(['is_archived' => 1]);
        } else {
            $customer->delete();
        }

        if (Auth::check()) {
            Log::create([
                'user_id' => Auth::user()->user_id,
                'action' => "Deleted/Archived customer: {$name}",
                'DateTime' => now(),
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer removed successfully!');
    }
}
