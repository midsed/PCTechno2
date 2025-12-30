<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'active');
        $q = trim((string) $request->get('q', ''));

        $query = Customer::query();

        if ($tab === 'archived') {
            $query->onlyTrashed();
        }

        if ($q !== '') {
            $query->where('customer_name', 'like', "%{$q}%");
        }

        $customers = $query->orderByDesc('customer_id')->paginate(10)->withQueryString();

        return view('customers.index', compact('customers', 'tab', 'q'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required','string','max:255'],
            'contact_information' => ['nullable','string','max:255'],
            'address' => ['nullable','string','max:255'],
        ]);

        $data['is_archived'] = 0; // always active on creation

        Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();

        $data = $request->validate([
            'customer_name' => ['required','string','max:255'],
            'contact_information' => ['nullable','string','max:255'],
            'address' => ['nullable','string','max:255'],
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    // "Delete" = archive
    public function destroy($id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer archived.');
    }

    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->restore();

        return redirect()->route('customers.index', ['tab' => 'archived'])
            ->with('success', 'Customer restored to active.');
    }

    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->where('customer_id', $id)->firstOrFail();
        $customer->forceDelete();

        return redirect()->route('customers.index', ['tab' => 'archived'])
            ->with('success', 'Customer permanently deleted.');
    }
}
