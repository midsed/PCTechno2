<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderByRaw("CASE 
                WHEN role='admin' THEN 0
                WHEN role='employee' THEN 1
                WHEN role='cashier' THEN 2
                ELSE 3
            END")
            ->orderByDesc('user_id') // IMPORTANT: your PK is user_id, not id
            ->paginate(9);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'role'      => 'required|in:admin,employee,cashier',
            'username'  => 'required|string|max:50|unique:users,username',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        // THIS fixes your error: $user is now defined in the view
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'role'      => 'required|in:admin,employee,cashier',
            'username'  => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
