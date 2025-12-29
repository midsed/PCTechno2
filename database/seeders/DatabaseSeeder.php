<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create( [
            'full_name' => 'Admin User',
            'username'  => 'admin',
            'email'     => 'admin@example.com',
            'role'      => 'admin',
            'password'  => Hash::make( 'password' ),
        ] );

        User::create( [
            'full_name' => 'Employee User',
            'username'  => 'employee',
            'email'     => 'employee@example.com',
            'role'      => 'employee',
            'password'  => Hash::make( 'password' ),
        ] );

        User::create( [
            'full_name' => 'Cashier User',
            'username'  => 'cashier',
            'email'     => 'cashier@example.com',
            'role'      => 'cashier',
            'password'  => Hash::make( 'password' ),
        ] );
    }
}